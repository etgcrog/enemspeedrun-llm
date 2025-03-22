<?php

use app\assets\HtmxAsset;
use yii\helpers\Url;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion $model */

HtmxAsset::register($this);
?>

<div class="flex flex-col flex-1 bg-white border border-gray-200 rounded dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-row items-center justify-between px-2 w-full">
        <h2 class="text-sm font-bold px-2 py-2 flex flex-row gap-1 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/>
            </svg>
            <?= $model->title ?: 'Sem título' ?>
        </h2>
        <div class="flex flex-row items-center justify-end">
            <?= $this->render('_difficulty', ['difficulty' => $model->difficulty]) ?>
            <?= $this->render('_position', [
                'id' => $model->getPrimaryKey(),
                'position' => $model->position,
                'pdfPath' => $model->getPdfUrl()
            ]) ?>
            <small class="text-xs font-light"><?= $model->year ?></small>
            <div class="ml-3">
                <?= $this->render('_favorite', ['id' => $model->getPrimaryKey()]) ?>
            </div>
        </div>
    </div>
    <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700"/>

    <div class="flex flex-col px-4 py-2">
        <?php
        $decodedStatement = base64_decode($model->statement, true);

        // Verifica explicitamente o conteúdo inicial dos dados decodificados
        if ($decodedStatement && (str_starts_with($decodedStatement, '<svg') || str_starts_with($decodedStatement, '<?xml'))) {
            // SVG embutido
            echo '<div class="w-full overflow-auto">' . $decodedStatement . '</div>';
        } elseif ($decodedStatement && str_starts_with($decodedStatement, "\x89PNG")) {
            // PNG embutido
            echo '<img class="w-full max-h-80 object-contain" src="data:image/png;base64,' . Html::encode($model->statement) . '" alt="Statement Image"/>';
        } else {
            // Texto puro
            echo '<p class="text-xs text-normal max-lines-4">' . nl2br(Html::encode($model->statement)) . '</p>';
        }
        ?>
    </div>

    <div class="px-2 py-2">
        <a href="<?= Url::to(['/browse/view', 'id' => $model->getPrimaryKey()]) ?>"
           hx-boost="true"
           hx-trigger="click"
           hx-target="#content"
           role="button"
           class="flex flex-row gap-1 text-white bg-gray-900 border border-gray-900 focus:outline-none font-medium rounded text-xs px-2 py-1 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
            Ver completa
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-3 h-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"/>
            </svg>
        </a>
    </div>
</div>
<?php
$this->registerCss(<<<CSS
.max-lines-4 {
  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
CSS, [], '_question');
