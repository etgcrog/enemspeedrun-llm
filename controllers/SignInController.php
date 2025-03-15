<?php

namespace app\controllers;

use app\models\Account;
use app\models\SignInOAuthForm;
use Google\Exception;

use Yii;
use yii\base\ErrorException;
use yii\helpers\Url;

/**
 * Controller de login.
 */
class SignInController extends WebController
{
    public $layout = 'login';
    public $defaultAction = 'login';

    public function verbs(): array
    {
        return [
            'login' => ['get'],
            'oauth' => ['get']
        ];
    }

    /**
     * Página de login.
     * @return string
     * @throws Exception
     * @throws Exception
     */
    public function actionLogin(): string
    {
        return $this->render('login', [
            'oAuthUrl' => filter_var(SignInOAuthForm::getGoogleOAUthClient()->createAuthUrl(), FILTER_SANITIZE_URL)
        ]);
    }

    /**
     * Página de OAUth da Google após redirecionamento.
     * @return void
     * @throws Exception
     * @throws \Google\Service\Exception
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public function actionOauth()
    {
        $code = Yii::$app->request->get('code', false);
        $error = Yii::$app->request->get('error', false);
        if ($error || !$code) {
            return $this->render('oauth_failure');
        }
        try {
            $form = SignInOAuthForm::createInstanceFromCode($code);
        } catch (ErrorException$errorException) {
            Yii::$app->session->setFlash('error', "Ops! Pedido inválido, tente novamente.");
            return $this->redirect(Url::to(['/sign-in']));
        }

        $login = $form->login();
        if ($login === $form::SIGN_IN_SUCCESS) {
            Yii::$app->session->setFlash('success', "Bem vindo {$form->first_name}, é muito bom te ter de volta, vamos começar os estudos!");
            return $this->redirect(Url::to(['/browse']));
        } else if ($login === $form::MUST_SIGN_UP) {
            Yii::$app->session->setFlash('success', "Perfeito! Porém precisamos de algumas informações adicionais para continuar.");
            Yii::$app->session->set('google_oauth_credentials', $form->credentials);
            return $this->render('complete_sign_up', ['form' => $form]);
        }
        return $this->render('oauth_failure');
    }

    /**
     * Página de criação de conta.
     * @return string|void
     * @throws \yii\base\Exception
     * @throws \yii\base\ExitException
     */
    public function actionCompleteSignUp()
    {
        $form = new SignInOAuthForm();
        $data = Yii::$app->request->post('SignInOAuthForm', false);
        if ($data === false) {
            return $this->render('oauth_failure');
        }
        $form->first_name = $data['first_name'];
        $form->last_name = $data['last_name'];
        $form->email = $data['email'];
        $form->password = $data['password'];
        $form->password_repeat = $data['password_repeat'];
        $form->credentials = Yii::$app->session->get('google_oauth_credentials', []);

        $this->performAjaxValidation($form);
        $account = $form->signUpAndSignIn();
        if ($account instanceof Account) {
            Yii::$app->session->setFlash('success', "Bem vindo, sua conta foi criada com sucesso!");
            return $this->redirect(Url::to(['/browse']));
        }

        Yii::$app->session->setFlash('error', "Ocorreu um erro durante a criação da sua conta.");
        return $this->render('complete_sign_up', ['form' => $form]);
    }
}