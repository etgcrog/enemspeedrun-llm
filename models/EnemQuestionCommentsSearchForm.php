<?php

namespace app\models;

use yii\db\Query;

class EnemQuestionCommentsSearchForm extends EnemQuestionDependentForm
{
    public function search(): Query
    {
        return EnemQuestionComment::find()
            ->innerJoin('enem_question', 'enem_question.id = enem_question_comment.enem_question_id');
    }
}