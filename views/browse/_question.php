<?php

use app\assets\HtmxAsset;
use yii\helpers\Url;

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
            <?php if ($model->title): ?>
                <?= $model->title ?>
            <?php else: ?>
                Sem título
            <?php endif; ?>
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
        <p class="text-xs text-normal max-lines-4 ">
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
            Pellentesque commodo, neque in fermentum malesuada, odio purus varius ex, ac vulputate purus lacus id nulla.
            Vivamus pretium vitae ex vitae varius. Morbi sollicitudin, lacus non placerat placerat, orci odio rutrum
            arcu, vel euismod dui mauris id tortor. Ut nec orci est. Cras luctus quam non dolor placerat ultricies. Sed
            congue mauris vel ligula laoreet, vitae dictum leo tempor. Aenean vestibulum arcu ac ipsum lobortis, quis
            cursus metus dapibus. Vivamus nec elit in odio ultrices accumsan nec vel lectus. Vivamus pulvinar sodales
            massa, eget gravida nisi vestibulum non. Aenean vel felis sed nulla tristique venenatis. Vestibulum ante
            ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer ac libero tortor. Sed vitae
            tortor neque. Vestibulum at varius nisi, ac fermentum urna.
            Aliquam erat volutpat. Pellentesque placerat nunc a est dictum, vel efficitur dui suscipit. Vestibulum vel
            ipsum in purus consectetur tristique nec sit amet eros. Cras vestibulum tincidunt nisl, vitae tincidunt
            nulla varius sed. Sed tempus turpis sit amet nunc finibus, eu auctor velit egestas. Mauris vitae felis eget
            ante rhoncus egestas a vitae ex. Sed
        </p>
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
?>
