<?php

use app\models\EnemQuestionAccountAnswerForm;
use app\models\EnemQuestionCommentForm;

/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion $question */
/** @var EnemQuestionCommentForm $commentForm */
/** @var \yii\data\ActiveDataProvider $commentsDataProvider */
/** @var EnemQuestionAccountAnswerForm $answerForm */

?>


<div class="flex flex-col gap-1 w-full h-full px-2 py-2 mx-auto max-w-screen-xl">
    <div class="flex flex-col lg:flex-row xl:flex-row flex-1 gap-1">
        <?= $this->render('_question_details', [
            'question' => $question,
            'answerForm' => $answerForm
        ]) ?>
        <?= $this->render('_question_comments', [
            'question' => $question,
            'commentForm' => $commentForm,
            'commentsDataProvider' => $commentsDataProvider
        ]) ?>
    </div>
</div>
