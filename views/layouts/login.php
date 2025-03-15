<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\FlowbiteAsset;
use app\widgets\Lottie as LottieAlias;
use yii\helpers\Html;

FlowbiteAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-full">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-full bg-gray-100">
<?php $this->beginBody() ?>

<main class="flex flex-col justify-center items-center sm:justify-start md:justify-start lg:justify-center xl:justify-center h-full w-full m-3 bg-gray-50">
    <section class="flex flex-col items-center justify-center sm:w-full md:w-1/2 lg:w-1/3">
        <?= LottieAlias::widget(['name' => 'dancing-dog.json', 'options' => [
            'class' => 'w-24 h-24'
        ]]) ?>
        <h1 class="text-center text-3xl md:text-6xl lg:text-6xl font-bold mb-4">Enem Speedrun!!&nbsp;😎</h1>
        <?= $content ?>
    </section>
    <small class="text-xs text-center">Beta Version(-1.0)</small>
    <small class="text-xs text-center">Witchery: The Software Laboratory&reg;, 2024</small>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
