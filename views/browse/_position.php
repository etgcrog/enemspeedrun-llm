<?php

use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var integer $position */
/** @var string $pdfPath */
/** @var integer $id */

$dropdownId = uniqid();
$dropdownButtonId = uniqid();
?>

<button id="<?= $dropdownButtonId ?>"
    <?php if (is_string($pdfPath)): ?>
        data-dropdown-toggle="<?= $dropdownId ?>" data-dropdown-delay="500" data-dropdown-trigger="click"
    <?php endif; ?>
        role="button"
        class="w-24 flex flex-row gap-1 text-xs items-center justify-center bg-gray-50 text-gray-800 text-xs font-normal inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-400 border border-gray-200">
    Q(<?= $position ?>)
</button>
<?php if (is_string($pdfPath)): ?>
    <div id="<?= $dropdownId ?>"
         class="border border-gray-200 z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
        <div class="flex flex-col px-2 py-2 text-sm text-gray-700 dark:text-gray-200"
             aria-labelledby="<?= $dropdownButtonId ?>">
            <div class="text-xs w-full font-bold">Questão Número <?= $position ?></div>
        </div>
        <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700"/>
        <div class="flex flex-col px-2 py-2 text-sm text-gray-700 dark:text-gray-200">
            <a href="<?= $pdfPath ?>"
               target="_blank"
               class="text-xs flex flex-row gap-1 items-center justify-start text-black mt-2">
                Abrir prova da questão
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                    <path fill-rule="evenodd"
                          d="M8.25 3.75H19.5a.75.75 0 0 1 .75.75v11.25a.75.75 0 0 1-1.5 0V6.31L5.03 20.03a.75.75 0 0 1-1.06-1.06L17.69 5.25H8.25a.75.75 0 0 1 0-1.5Z"
                          clip-rule="evenodd"/>
                </svg>
            </a>
        </div>
    </div>
<?php endif; ?>


