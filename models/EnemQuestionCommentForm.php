<?php

namespace app\models;

use yii\base\ErrorException;
use yii\helpers\HtmlPurifier;

class EnemQuestionCommentForm extends EnemQuestionDependentForm
{
    public $text;

    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string', 'min' => 1, 'max' => 5000],
            [['text'], 'trim']
        ];
    }

    /**
     * Adiciona comentário.
     * @return \app\models\EnemQuestionComment|null
     * @throws \yii\base\ErrorException
     */
    public function add(): ?EnemQuestionComment
    {
        if ($this->validate()) {
            $comment = new EnemQuestionComment();
            $comment->text = HtmlPurifier::process($this->text);
            $comment->account_id = $this->getAccount()->getPrimaryKey();
            $comment->enem_question_id = $this->getQuestion()->getPrimaryKey();
            $date = (new \DateTime('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
            $comment->created_date = $date;
            $comment->updated_date = $date;

            if (!$comment->save()) {
                throw new ErrorException("Não foi possível adicionar este comentário");
            }
        }
        return null;
    }
}