<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class WebUserIdentity extends Account implements IdentityInterface
{
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * @param $token
     * @param null $type
     * @return array|ActiveRecord|IdentityInterface|null
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException("Não suportado.");
    }

    /**
     * @return string|null
     * @throws \yii\base\NotSupportedException
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param $authKey
     * @return bool|null
     * @throws \yii\base\NotSupportedException
     */
    public function validateAuthKey($authKey)
    {
        return Yii::$app->security->compareString($authKey, $this->getAuthKey());
    }
}