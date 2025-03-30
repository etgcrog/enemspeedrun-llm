<?php

/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion $question */
/** @var \app\models\EnemQuestionAccountAnswerForm $answerForm */

echo $this->render('_question_details', [
    'question' => $question,
    'answerForm' => $answerForm
]);
