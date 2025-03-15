<?php

namespace app\models;

use Google\Client;
use Google\Http\REST;
use Google\Service\AndroidPublisher\RecurringExternalTransaction;
use Google\Service\Exception;
use Google\Service\PeopleService;
use Google_Service_PeopleService;
use Yii;
use yii\base\ErrorException;
use yii\base\Model;
use yii\helpers\Url;

class SignInOAuthForm extends Model
{
    public array $credentials = [];

    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_repeat;
    const MUST_SIGN_UP = 'MUST_SIGN_UP';
    const SIGN_IN_SUCCESS = 'SIGN_IN_SUCCESS';
    const CANT_SIGN_IN = 'CANT_SIGN_IN';

    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'trim'],
            [['password'], 'string', 'min' => 8, 'max' => 40],
            [['password', 'password'], 'match', 'pattern' => '/^(?=.*\d).{8,}$/', 'message' => 'Precisa ser uma senha com ao menos um número'],
            [['password'], 'compare', 'compareAttribute' => 'password_repeat']
        ];
    }

    public static function createInstanceFromCode(string $code): self
    {
        $client = self::getGoogleOAUthClient();

        $instance = new self();
        $credentials = $client->fetchAccessTokenWithAuthCode($code);
        if (!isset($credentials['access_token']) || empty($credentials['access_token'])) {
            throw new ErrorException("Credênciais inválidas.");
        }
        $service = new Google_Service_PeopleService($client);
        $me = $service->people->get('people/me', ['personFields' => 'names,emailAddresses']);

        foreach ($me->getNames() as $name) {
            if ($name->metadata->primary) {
                $instance->first_name = $name->getGivenName();
                $instance->last_name = $name->getFamilyName();
                break;
            }
        }
        $instance->email = $me->getEmailAddresses()[0]->getValue();
        $instance->credentials = $credentials;
        return $instance;
    }


    public function attributeLabels()
    {
        return [
            'first_name' => 'Primeiro nome',
            'last_name' => 'Segundo nome',
            'email' => 'Email',
            'password' => 'Senha',
            'password_repeat' => 'Repita a senha'
        ];
    }

    /**
     * Realiza login.
     * @return void
     * @throws ErrorException
     * @throws Exception
     * @throws \Google\Exception
     * @throws \yii\db\Exception
     */
    public function login(): string
    {
        if ($this->credentials && $this->credentials['access_token'] && $this->credentials['id_token']) {

            /** @var Account|null $identity */
            $identity = WebUserIdentity::find()->andWhere(['=', 'email', $this->email])->one();
            if ($identity instanceof WebUserIdentity) {
                $transaction = Yii::$app->db->beginTransaction();
                $identity->google_oauth_access_token = $this->credentials['access_token'];
                $identity->google_auth_uid = $this->credentials['id_token'];
                if (!$identity->save()) {
                    throw new ErrorException("Não foi possível salvar este token.");
                }

                if (!Yii::$app->user->login($identity, 1.578e+8)) {
                    $transaction->rollBack();
                    throw new ErrorException("Não foi possível efetuar este login oauth.");
                }
                $transaction->commit();

                return self::SIGN_IN_SUCCESS;
            }

            return self::MUST_SIGN_UP;
        }
        return self::CANT_SIGN_IN;
    }

    /**
     * Cria conta e realiza o login.
     * @return \app\models\Account|null
     * @throws \yii\base\Exception
     */
    public function signUpAndSignIn(): ?Account
    {
        if ($this->validate()) {
            $account = new Account();
            $account->first_name = $this->first_name;
            $account->last_name = $this->last_name;
            $account->email = $this->email;
            $account->password = $this->password;
            $account->google_oauth_access_token = $this->credentials['access_token'];
            $account->google_auth_uid = $this->credentials['id_token'];
            $account->auth_key = Yii::$app->security->generateRandomString(60);
            if ($account->save()) {
                if ($this->login() === self::SIGN_IN_SUCCESS) {
                    return $account;
                }
                $account->delete();
            }
        }
        return null;
    }

    /**
     * Obtém cliente oauth configurado.
     * @return Client
     * @throws \Google\Exception
     */
    public static function getGoogleOAUthClient(): Client
    {
        $client = new Client();
        $client->setAuthConfig([
            'client_id' => $_ENV['GOOGLE_OAUTH_CLIENT_ID'],
            'client_secret' => $_ENV['GOOGLE_OAUTH_CLIENT_SECRET'],
        ]);
        $client->addScope([
            PeopleService::USERINFO_EMAIL,
            PeopleService::USERINFO_PROFILE
        ]);
        $client->setRedirectUri(Url::to(['/sign-in/oauth'], true));
        $client->setAccessType('offline');
        $client->setIncludeGrantedScopes(true);

        return $client;
    }
}