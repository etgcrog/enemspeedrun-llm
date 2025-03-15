<?php

use app\assets\HtmxAsset;
use app\models\EnemQuestionAccountAnswerForm;

/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion $question */
/** @var EnemQuestionAccountAnswerForm $answerForm */


HtmxAsset::register($this);
?>

<div class="flex flex-col flex-1.5 bg-white border border-gray-200 rounded dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-row items-center justify-between px-2 w-full">
        <h1 class="text-sm font-bold px-2 py-2 flex flex-row gap-1 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/>
            </svg>
            <?php if ($question->title): ?>
                <?= $question->title ?>
            <?php else: ?>
                Sem título
            <?php endif; ?>
        </h1>
        <div class="flex flex-row items-center justify-end">
            <?= $this->render('_skills', ['skillId' => $question->enem_area_competence_skill_id]) ?>
            <?= $this->render('_difficulty', ['difficulty' => $question->difficulty]) ?>
            <?= $this->render('_position', [
                'id' => $question->getPrimaryKey(),
                'position' => $question->position,
                'pdfPath' => $question->getPdfUrl()
            ]) ?>
            <small class="text-xs font-light"><?= $question->year ?></small>
            <div class="ml-3">
                <?= $this->render('_favorite', ['id' => $question->getPrimaryKey()]) ?>
            </div>
        </div>
    </div>
    <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700"/>
    <div class="flex flex-col gap-1 px-4 py-1">
        <p class="text-sm text-gray-700 tracking-tight dark:text-white">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec est eu justo mollis commodo. Donec at
            metus eget velit feugiat malesuada nec et nulla. Sed nec nisi id sem blandit rutrum. Ut interdum tincidunt
            ex, sit amet lacinia leo feugiat id. Vestibulum non luctus purus. Nullam nec erat ut dui interdum rutrum.
            Vivamus id risus id orci convallis bibendum. Nulla facilisi. Quisque eget lorem scelerisque, vestibulum nisl
            ut, interdum risus. Curabitur lobortis, augue eget vestibulum suscipit, metus enim tincidunt ipsum, eget
            suscipit purus metus ac lectus. Ut tempus, ex a dapibus posuere, velit eros finibus enim, nec convallis leo
            ligula non ex. Suspendisse lacinia enim sit amet leo iaculis, eget sodales justo gravida. Donec quis leo
            vehicula, dignissim ante sit amet, ultricies odio. Nullam lacinia orci non purus malesuada tempus.
            Phasellus vestibulum erat id felis malesuada, a ultrices leo ultricies. Cras ullamcorper, elit quis
            fringilla elementum, mauris ipsum tristique nisl, vel commodo quam nulla ac ipsum. Nulla facilisi. Mauris
            placerat malesuada metus, ut aliquam arcu lobortis nec. Nam suscipit nec arcu nec ullamcorper. Sed eget
            nulla nec sapien facilisis tempus. Pellentesque habitant morbi tristique senectus et netus et malesuada
            fames ac turpis egestas. Ut suscipit lacinia tortor. Nullam id efficitur tortor, a euismod lectus. Sed
            dapibus ipsum nec mauris lacinia, vel egestas odio posuere. Cras accumsan sapien vitae elit tempus, eget
            vehicula nunc blandit.
        </p>
    </div>
    <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700"/>
    <div class="flex flex-col w-full px-2 py-2">
        <?= $this->render('_alternatives', [
            'question' => $question,
            'answerForm' => $answerForm
        ]) ?>
    </div>
</div>
