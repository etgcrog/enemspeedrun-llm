<?php

use app\models\EnemQuestion;

/** @var \yii\web\View $this */
/** @var float $difficulty */

$color = '#028391';
if ($difficulty <= EnemQuestion::DIFFICULTY_VERY_EASY) {
    $color = '#74c69d';
} else if ($difficulty <= EnemQuestion::DIFFICULTY_EASY) {
    $color = '#52b788';
} else if ($difficulty <= EnemQuestion::DIFFICULTY_MEDIUM) {
    $color = '#f6dcac';
} else {
    $color = '#f85525';
}
?>

<div class="flex flex-row gap-1 items-center justify-center">
    <div class="w-24 flex flex-row gap-1 items-center justify-center bg-gray-50 text-gray-800 text-xs font-normal inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-400 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="<?= $color ?>" class="w-3 h-3">
            <path fill-rule="evenodd"
                  d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z"
                  clip-rule="evenodd"/>
        </svg>
        <div class="text-xs text-center">
            <?php if ($difficulty < EnemQuestion::DIFFICULTY_VERY_EASY): ?>
                Muito fácil
            <?php elseif ($difficulty < EnemQuestion::DIFFICULTY_EASY): ?>
                Fácil
            <?php elseif ($difficulty < EnemQuestion::DIFFICULTY_MEDIUM): ?>
                Médio
            <?php else: ?>
                Difícil
            <?php endif; ?>
            (<?= $difficulty ?>)
        </div>
    </div>
</div>

