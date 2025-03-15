<?php

use yii\widgets\ListView;

/** @var \yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */

?>

<div class="flex flex-col gap-1 w-full h-full px-2 py-2 mx-auto max-w-xl">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_question',
        'summary' => '',
        'itemOptions' => [
            'class' => 'w-full',
        ],
        'options' => [
            'class' => 'flex flex-col flex-wrap gap-1 w-full'
        ]
    ]); ?>
</div>
