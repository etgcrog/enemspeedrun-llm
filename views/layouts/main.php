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

<?php //if (Yii::$app->user->identity): ?>
<!--    <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"-->
<!--           aria-label="Sidebar">-->
<!--        <div class="bg-white border h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">-->
<!--            <div class="flex flex-col gap-2">-->
<!--                <div class="flex flex-row gap-1 items-center">-->
<!--                    <div class="border rounded p-1">-->
<!--                        --><?php //= LottieAlias::widget(['name' => 'dancing-dog.json', 'options' => [
//                            'class' => 'w-7 h-7'
//                        ]]) ?>
<!--                    </div>-->
<!--                    <h1 class="text-md font-black">-->
<!--                        Enem Speed Run!!-->
<!--                    </h1>-->
<!--                </div>-->
<!--                <div class="flex flex-col">-->
<!--                    <h2 class="text-md font-bold">-->
<!--                        --><?php //= Yii::$app->user->identity->first_name ?>
<!--                    </h2>-->
<!--                    <h3 class="text-sx font-normal">-->
<!--                        --><?php //= Yii::$app->user->identity->email ?>
<!--                    </h3>-->
<!--                </div>-->
<!--            </div>-->
<!--            <h4 class="text-sm font-normal mt-4">-->
<!--                Menu-->
<!--            </h4>-->
<!--            <ul class="space-y-2 font-medium">-->
<!--                <li>-->
<!--                    <a href="#"-->
<!--                       class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">-->
<!--                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"-->
<!--                             aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"-->
<!--                             viewBox="0 0 22 21">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round"-->
<!--                                  d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z"/>-->
<!--                        </svg>-->
<!--                        <span class="ms-3">Meus simulados</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </aside>-->
<?php //endif; ?>

<?= $this->render('_search') ?>
<main id="content" class="flex flex-col min-h-full w-full m-3 bg-gray-50">
    <?= $content ?>
</main>

<footer class="text-xs text-center">Witchery: The Software Laboratory&reg;, 2024</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
