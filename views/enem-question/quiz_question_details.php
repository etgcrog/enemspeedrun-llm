<?php

use app\assets\HtmxAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion $question */
/** @var \app\models\EnemQuestionAccountAnswerForm $answerForm */
/** @var int $currentIndex */
/** @var int $totalQuestions */

HtmxAsset::register($this);
?>

<div class="max-w-3xl mx-auto flex flex-col gap-2">
    <h2 class="font-bold text-lg">Questão <?= $currentIndex ?> de <?= $totalQuestions ?></h2>

    <!-- Renderiza a questão existente -->
    <?= $this->render('/browse/_question_details', [
        'question' => $question,
        'answerForm' => $answerForm,
    ]) ?>

    <div class="flex justify-between my-4">
        <a href="<?= Url::to(['quiz-question', 'direction' => 'prev']) ?>"
           class="bg-gray-300 hover:bg-gray-400 py-2 px-4 rounded <?= $currentIndex == 1 ? 'invisible' : '' ?>">
            Anterior
        </a>

        <a href="<?= Url::to(['quiz-question', 'direction' => 'next']) ?>"
           class="bg-gray-300 hover:bg-gray-400 py-2 px-4 rounded <?= $currentIndex == $totalQuestions ? 'invisible' : '' ?>">
            Próxima
        </a>
    </div>
</div>
