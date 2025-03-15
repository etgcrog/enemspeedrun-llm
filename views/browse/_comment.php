<?php


/** @var \yii\web\View $this */

/** @var array $comment */

use yii\helpers\Url;

$createdDate = DateTime::createFromFormat('Y-m-d H:i:s', $comment['created_date'], new DateTimeZone('UTC'));
$isTodayComment = $createdDate->format('Ymd') === date('Ymd', strtotime($createdDate->getTimestamp()));

$createdDate->setTimezone(new DateTimeZone('America/Sao_Paulo'));
?>

<div class="flex items-start gap-2.5">
    <img class="w-10 h-10 rounded-full" src="<?= Url::base(true) . '/imgs/avatar.png' ?>"
         alt="<?= $comment['first_name'] ?>">
    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
        <div class="flex items-center space-x-2 rtl:space-x-reverse">
            <p class="text-sm font-semibold text-gray-900 dark:text-white"><?= $comment['first_name'] ?> <?= $comment['last_name'] ?></p>
            <span class="text-xs font-normal text-gray-500 dark:text-gray-400">
                <?php if ($isTodayComment): ?>
                    <?= $createdDate->format('H:i') ?>
                <?php else: ?>
                    <?= $createdDate->format('d/m/Y H:i') ?>
                <?php endif; ?>
            </span>
        </div>
        <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">
            <?= $comment['text'] ?>
        </p>
    </div>
</div>
