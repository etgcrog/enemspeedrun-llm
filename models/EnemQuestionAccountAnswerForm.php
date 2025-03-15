<?php

namespace app\models;

use yii\base\Model;
use yii\validators\RangeValidator;

class EnemQuestionAccountAnswerForm extends EnemQuestionDependentForm
{
    public $answer;

    const ALTERNATIVES = ['A', 'B', 'C', 'D', 'E'];


    public $is_correct = null;

    public function rules()
    {
        return [
            [['answer'], 'required'],
            [['answer'], RangeValidator::class, 'range' => self::ALTERNATIVES]
        ];
    }

    /**
     * Realiza resposta.
     * @return \app\models\EnemQuestionAccountAnswer|null
     * @throws \Exception
     */
    public function answer(): ?EnemQuestionAccountAnswer
    {
        if ($this->validate()) {
            $date = (new \DateTime('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');

            $answer = new  EnemQuestionAccountAnswer();

            $question = $this->getQuestion();
            $answer->answer = $this->answer;
            $answer->enem_question_id = $question->getPrimaryKey();
            $answer->account_id = $this->getAccount()->getPrimaryKey();
            $answer->created_date = $date;
            $answer->updated_date = $date;
            if ($answer->save()) {
                $this->is_correct = $this->answer === $question->answer;
                return $answer;
            }
            $this->is_correct = null;
        }
        return null;
    }
}