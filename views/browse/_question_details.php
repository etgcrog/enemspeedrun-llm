<?php

use app\assets\HtmxAsset;
use app\models\EnemQuestionAccountAnswerForm;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion $question */
/** @var EnemQuestionAccountAnswerForm $answerForm */

HtmxAsset::register($this);

// Substitui [imagem] pelo HTML da imagem
$statement = Html::encode($question->statement);
if (!empty($question->images)) {
    foreach (json_decode($question->images, true) as $image) {
        $imgTag = '<div class="my-2"><img src="' . Yii::getAlias('@web/imgs/') . basename(Html::encode($image)) . '" alt="Imagem da questão" class="rounded w-full"/></div>';
        $statement = preg_replace('/\\[imagem\\]/', $imgTag, $statement, 1);
    }
}
?>

<div class="flex flex-col flex-1.5 bg-white border border-gray-200 rounded dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-row items-center justify-between px-2 w-full">
        <h1 class="text-sm font-bold px-2 py-2 flex flex-row gap-1 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/>
            </svg>
            <?= Html::encode($question->title ?: 'Sem título') ?>
        </h1>
        <div class="flex flex-row items-center justify-end">
            <?= $this->render('_skills', ['skillId' => $question->enem_area_competence_skill_id]) ?>
            <?= $this->render('_difficulty', ['difficulty' => $question->difficulty]) ?>
            <?= $this->render('_position', [
                'id' => $question->getPrimaryKey(),
                'position' => $question->position,
                'pdfPath' => $question->getPdfUrl()
            ]) ?>
            <small class="text-xs font-light"><?= $question->year ?></small>
            <div class="ml-3">
                <?= $this->render('_favorite', ['id' => $question->getPrimaryKey()]) ?>
            </div>
        </div>
    </div>
    <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700"/>
    <div class="flex flex-col gap-2 px-4 py-1">
        <!-- Statement com imagem inserida -->
        <p class="text-sm text-gray-700 tracking-tight dark:text-white">
            <?= $statement ?>
        </p>

        <!-- Bibliography -->
        <?php if (!empty($question->bibliography)): ?>
            <p class="text-xs italic text-gray-500 dark:text-gray-400">
                <?= Html::encode($question->bibliography) ?>
            </p>
        <?php endif; ?>

        <!-- Question -->
        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
            <?= Html::encode($question->question) ?>
        </p>
    </div>
    <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700"/>
    <div class="flex flex-col w-full px-2 py-2">
        <?= $this->render('_alternatives', [
            'question' => $question,
            'answerForm' => $answerForm
        ]) ?>
    </div>
</div>
