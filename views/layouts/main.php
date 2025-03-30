<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\FlowbiteAsset;
use app\widgets\Lottie as LottieAlias;
use yii\helpers\Html;
use app\models\SearchForm;

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

<?php
if (!isset($this->params['searchForm'])) {
    $this->params['searchForm'] = new SearchForm();
}
?>

<?= $this->render('_search') ?>
<main id="content" class="flex flex-col min-h-full w-full m-3 bg-gray-50">
    <?= $content ?>
</main>

<footer class="text-xs text-center">Witchery: The Software Laboratory&reg;, 2024</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
