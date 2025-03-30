<?php

use yii\helpers\Url;
use yii\widgets\ListView;

/** @var \yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */

?>

<div class="max-w-xl mx-auto py-6 px-4 flex flex-col gap-4">
    <h1 class="text-3xl font-bold text-gray-800 text-center mb-4">Escolha seu Quiz</h1>

    <!-- Formulário para Quiz sequencial -->
    <form method="get" action="<?= Url::to(['enem-question/quiz']) ?>"
          class="flex flex-col sm:flex-row gap-3 items-center bg-white shadow-md rounded-lg p-4">
        <input type="number" name="limit" placeholder="Número de questões"
               value="10" min="1" max="100"
               class="flex-grow border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit"
                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-200 ease-in-out">
            Começar Quiz Sequencial
        </button>
    </form>

    <!-- Formulário para Quiz aleatório (CORREÇÃO FINAL E COMPLETA) -->
    <form method="get" action="<?= Url::to(['enem-question/quiz']) ?>"
        class="flex flex-col sm:flex-row gap-3 items-center bg-white shadow-md rounded-lg p-4">
        <input type="hidden" name="random" value="1">
        <input type="number" name="limit" placeholder="Número de questões"
            value="10" min="1" max="100"
            class="flex-grow border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-400">
        <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-200 ease-in-out">
            Começar Quiz Aleatório
        </button>
    </form>


    <div class="mt-6">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_question',
            'summary' => '',
            'itemOptions' => ['class' => 'w-full'],
            'options' => ['class' => 'flex flex-col gap-2']
        ]); ?>
    </div>
</div>
