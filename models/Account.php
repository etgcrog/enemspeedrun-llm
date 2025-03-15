<?php

namespace app\models;

use Google\Client;
use Google\Service;
use yii\helpers\Url;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $google_auth_uid
 * @property string|null $google_oauth_access_token
 * @property string|null $auth_key
 * @property string $email
 * @property string $password
 * @property string $created_date
 * @property string $updated_date
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['google_auth_uid'], 'string', 'max' => 1600],
            [['email'], 'string', 'max' => 250],
            [['password'], 'string', 'max' => 40],
            [['email'], 'unique'],
            [['google_auth_uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'google_auth_uid' => 'Google Auth Uid',
            'email' => 'Email',
            'password' => 'Password',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
}
