<?php

use app\assets\HtmxAsset;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var integer $id */

$favorites = (isset($favorites)) ? $favorites : Yii::$app->session->get('favourite_question', []);
HtmxAsset::register($this);
$popOverId = uniqid();

$checked = in_array($id, $favorites);
$colorChecked = '#e5383b';
$colorUnChecked = '#e5e5e5';
$checkedText = 'Esta questão está entre suas favoritas!';
$uncheckedText = 'Salvar esta questão como favorita.';
?>

<form hx-post="<?= Url::to(['/browse/favorite', 'id' => $id]) ?>"
      data-popover-target="<?= $popOverId ?>"
      data-popper-placement="bottom"
      hx-trigger="submit"
      hx-target="this"
      hx-vals='<?= json_encode([
          Yii::$app->request->csrfParam => Yii::$app->request->csrfToken,
      ]) ?>'
      hx-swap="none"
      class="flex flex-row favorite-form">
    <?php if ($checked): ?>
        <button type="submit" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="<?= $colorChecked ?>" class="w-5 h-5">
                <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z"/>
            </svg>
        </button>
    <?php else: ?>
        <button type="submit" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="<?= $colorUnChecked ?>" class="w-5 h-5">
                <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z"/>
            </svg>
        </button>
    <?php endif; ?>
    <div data-popover id="<?= $popOverId ?>" role="tooltip"
         class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
        <div class="px-3 py-2">
            <?php if ($checked): ?>
                <p class="text-xs"><?= $checkedText ?></p>
            <?php else: ?>
                <p class="text-xs"><?= $uncheckedText ?></p>
            <?php endif; ?>
        </div>
        <div data-popper-arrow></div>
    </div>
</form>


<?php $this->registerJs(<<<JS

    var favoriteColorChecked = '{$colorChecked}';
    var favoriteColorUnChecked = '{$colorUnChecked}';
    $('.favorite-form').find('button').click(function(){
        const color = $(this).find('svg').attr('fill');
        const popOverParagraph = $(this).parent('form').children('div[data-popover]').find('p');
        
        if(color === favoriteColorChecked) {
            $(this).find('svg').attr('fill', favoriteColorUnChecked);
            popOverParagraph.text('{$uncheckedText}');
        }else{
            $(this).find('svg').attr('fill', favoriteColorChecked);
            popOverParagraph.text('{$checkedText}');
        }
    });
JS
); ?>
