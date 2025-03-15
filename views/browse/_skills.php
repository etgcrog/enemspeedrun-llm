<?php

use app\models\EnemAreaCompetenceSkill;

/** @var \yii\web\View $this */
/** @var integer $skillId */

$dropdownId = uniqid();
$dropdownButtonId = uniqid();
$skillInformation = EnemAreaCompetenceSkill::getSkillInformation($skillId);
?>

<button id="<?= $dropdownButtonId ?>"
        data-dropdown-toggle="<?= $dropdownId ?>" data-dropdown-delay="500" data-dropdown-trigger="click"
        role="button"
        class="w-24 flex flex-row gap-1 text-xs items-center justify-center bg-gray-50 text-gray-800 text-xs font-normal inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-400 border border-gray-200">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#4361ee"
         class="w-3 h-3">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
    </svg>
    <?= $skillInformation['skill']['name'] ?>
</button>
<div id="<?= $dropdownId ?>"
     class="border border-gray-200 z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
    <div class="flex flex-col px-2 py-2 text-sm text-gray-700 dark:text-gray-200"
         aria-labelledby="<?= $dropdownButtonId ?>">
        <h5 class="text-xs w-full font-bold">Habilidade <?= $skillInformation['skill']['code'] ?></h5>
    </div>
    <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700"/>
    <div class="flex flex-col px-2 py-2 text-sm text-gray-700 dark:text-gray-200 w-full">
        <h6 class="flex gap-1 items-center justify-between text-xs font-bold">
            Área <?= $skillInformation['area']['name'] ?>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4 text-gray-700">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.5 8.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v8.25A2.25 2.25 0 0 0 6 16.5h2.25m8.25-8.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-7.5A2.25 2.25 0 0 1 8.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 0 0-2.25 2.25v6"/>
            </svg>
        </h6>
        <p class="text-xs text-justify font-normal tracking-tighter text-gray-700 pl-2 pt-2">
            <?= $skillInformation['skill']['description'] ?>
        </p>
        <h6 class="flex gap-1 items-center justify-between text-xs font-bold mt-2">
            Competência <?= $skillInformation['competence']['name'] ?>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4 text-gray-700">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.5 8.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v8.25A2.25 2.25 0 0 0 6 16.5h2.25m8.25-8.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-7.5A2.25 2.25 0 0 1 8.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 0 0-2.25 2.25v6"/>
            </svg>
        </h6>
        <p class="text-xs text-justify font-normal tracking-tighter text-gray-700 pl-2 pt-2">
            <?= $skillInformation['competence']['description'] ?>
        </p>
    </div>
</div>
