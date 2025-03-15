<?php

namespace app\models;

use yii\base\Model;
use yii\db\Query;

class EnemQuestionDependentForm extends AccountDependentForm
{
    private $_question;

    public function __construct(EnemQuestion $question, Account $account)
    {
        $this->_question = $question;
        $this->_account = $account;
    }

    public function getQuestion(): EnemQuestion
    {
        return $this->_question;
    }
}