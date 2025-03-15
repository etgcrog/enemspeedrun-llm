<?php

namespace app\models;

use yii\base\Model;

class AccountDependentForm extends Model
{
    protected $_account;

    public function __construct(Account $account)
    {
        $this->_account = $account;
    }

    public function getAccount(): Account
    {
        return $this->_account;
    }
}