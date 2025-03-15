<?php

use app\assets\HtmxAsset;
use app\widgets\Lottie;
use yii\helpers\Url;

$searchForm = $this->params['searchForm'];
$years = $searchForm::getAvailableYears();
$difficulties = $searchForm::getAvailableDifficulties();
$areas = $searchForm::getAvailableAreas();

HtmxAsset::register($this);

/** @var yii\web\View $this */
/** @var \app\models\SearchForm $searchForm */
?>

<section class="flex flex-row items-center justify-between w-full bg-white border px-4 py-2">
    <button hx-get="<?= Url::to(['/browse']) ?>"
            hx-target="#content"
            hx-trigger="click"
            role="button"
            class="flex flex-row flex-1 gap-1 items-center">
        <div class="border rounded p-1">
            <?= Lottie::widget(['name' => 'dancing-dog.json', 'options' => [
                'class' => 'w-7 h-7'
            ]]) ?>
        </div>
        <h1 class="text-md font-black">
            Enem Speed Run!!
        </h1>
    </button>
    <form hx-get="<?= Url::to(['/browse']) ?>"
          hx-target="#content"
          hx-trigger="submit"
          hx-push-url="true"
          class="flex flex-col flex-3">
        <div class="flex flex-row items-center justify-center h-full w-full gap-1">
            <div class="flex flex-row items-center">
                <button id="dropdown-button" data-dropdown-toggle="dropdown"
                        class="flex flex-row gap-1 text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700"
                        type="button">
                    Filtrar
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
            </div>
            <div class="flex flex-row items-center gap-1">
                <input type="text"
                       name="term"
                       class="rounded bg-gray-100 border-gray-200 h-10"
                       placeholder="Pesquisar..."
                       value="<?= $searchForm->term ?>"
                />
                <button type="submit"
                        class="flex flex-row gap-1 text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="black" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                    Buscar questão
                </button>
            </div>
            <div id="dropdown"
                 class="flex flex-col gap-1 z-10 hidden bg-white divide-y divide-gray-100 rounded shadow min-w-44 dark:bg-gray-700 border px-4 py-4">
                <div class="flex flex-col p-1 rounded-sm w-full">
                    <h5 class="text-xs font-normal">
                        Ano:
                    </h5>
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                        <?php foreach ($years as $i => $year): ?>
                            <div class="flex items-center mb-4">
                                <input name="year[]"
                                       hx-trigger="change"
                                       type="checkbox"
                                       value="<?= $year ?>"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    <?php if (in_array($year, $searchForm->year)): ?>
                                        checked
                                    <?php endif; ?>
                                />
                                <label for="year[<?= $i ?>]"
                                       class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    <?= $year ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="flex flex-col p-1 rounded-sm w-full">
                    <h5 class="text-xs font-normal">
                        Dificuldade:
                    </h5>
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                        <?php foreach ($difficulties as $difficulty): ?>
                            <div class="flex items-center mb-4">
                                <input name="difficulty[]"
                                       hx-trigger="change"
                                       type="checkbox"
                                       value="<?= $difficulty ?>"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    <?php if (in_array($difficulty, $searchForm->difficulty)): ?>
                                        checked
                                    <?php endif; ?>
                                />
                                <label for="difficulty[]"
                                       class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    <?= $searchForm::getAvailableDifficultyLabel($difficulty) ?>
                                    <?php if ($difficulty === 'hard'): ?>
                                        😮
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="flex flex-col p-1 rounded-sm w-full">
                    <h5 class="text-xs font-normal">
                        Área:
                    </h5>
                    <ul class="flex flex-row flex-wrap items-center gap-1 py-1 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdown-button">
                        <li>
                            <?php foreach ($areas as $i => $area): ?>
                                <?php $isAreaChecked = in_array($area, $searchForm->area); ?>
                                <div class="flex items-center mb-4">
                                    <input name="area[<?= $i ?>]"
                                           hx-trigger="change"
                                           type="checkbox" value="<?= $area ?>"
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        <?php if ($isAreaChecked): ?>
                                            checked
                                        <?php endif; ?>
                                    />
                                    <label for="area[<?= $i ?>]"
                                           class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        <?= $area ?>
                                    </label>
                                </div>
                                <?php $skills = $searchForm::getAvailableAreaSkills($area); ?>
                                <?php if (count($skills) > 0): ?>

                                    <div data-area="<?= $area ?>"
                                         class="inline-flex rounded-md mb-1<?php if (!$isAreaChecked): ?> hidden<?php endif; ?>"
                                         role="group">
                                        <button type="button"
                                                data-uncheck='div[data-area="<?= $area ?>"]'
                                                class="px-2 py-1 text-xs font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                            Desmarcar
                                        </button>
                                        <button type="button"
                                                data-check='div[data-area="<?= $area ?>"]'
                                                class="px-2 py-1 text-xs font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                            Marcar
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-4 gap-4 text-sm text-gray-700 dark:text-gray-200 mb-2"
                                         role="list"
                                         aria-labelledby="dropdown-button">
                                        <?php foreach ($skills as $skill): ?>
                                            <?php
                                            $popoverId = uniqid();
                                            $isSkillChecked = $isAreaChecked && in_array($skill['id'], $searchForm->skill);
                                            ?>

                                            <div class="flex flex-row items-center pl-2 <?php if (!$isAreaChecked): ?> hidden<?php endif; ?>"
                                                 data-popover-target="<?= $popoverId ?>"
                                                 data-popover-trigger="click"
                                                 data-area="<?= $area ?>"
                                                 role="button">
                                                <input name="skill[]"
                                                       hx-trigger="change"
                                                       type="checkbox"
                                                       value="<?= $skill['id'] ?>"
                                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                       data-popover-target="<?= $popoverId ?>"

                                                    <?php if ($isSkillChecked): ?>
                                                        checked
                                                    <?php endif; ?>
                                                />
                                                <div class="flex flex-row gap-1">
                                                    <label for="skill[]"
                                                           class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                           data-popover-target="<?= $popoverId ?>">
                                                        <small class="text-xs">
                                                            <?= $skill['name'] ?> (área <?= $skill['competence_name'] ?>
                                                            )
                                                        </small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div data-popover id="<?= $popoverId ?>" role="tooltip"
                                                 class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                                        Habilidade <?= $skill['code'] ?></h3>
                                                </div>
                                                <?php $areaPopOverId = uniqid() ?>

                                                <div class="px-3 py-2">
                                                    <p class="text-sm"><?= $skill['description'] ?></p>
                                                    <div data-popover-target="<?= $areaPopOverId ?>"
                                                         data-popover-placement="bottom"
                                                         data-popover-trigger="click"
                                                         role="button"
                                                         class="text-xs bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 mt-2">
                                                        Competência de área <?= $skill['competence_name'] ?>
                                                    </div>
                                                </div>
                                                <div data-popover data-popper-arrow></div>
                                            </div>
                                            <div data-popover id="<?= $areaPopOverId ?>" role="tooltip"
                                                 class="absolute z-11 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                                        Competência de área <?= $skill['competence_name'] ?>
                                                    </h3>
                                                </div>
                                                <div class="px-3 py-2">
                                                    <p class="text-sm">
                                                        <?= $skill['competence_description'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </li>
                        <?php $this->registerJs(<<<JS
                        const areaInputs = $('input[name^="area"]');
                        const uncheckButtons = $('button[data-uncheck]');
                        const checkButtons = $('button[data-check]');
                        
                        uncheckButtons.click(function(){
                           $($(this).attr('data-uncheck')).find('input[type="checkbox"]').prop('checked', false);
                        });
                        checkButtons.click(function(){
                           $($(this).attr('data-check')).find('input[type="checkbox"]').prop('checked', true);
                        });
                        
                        areaInputs.change(function(){
                            
                            areaInputs.each(function(){
                                const value = $(this).val();
                                const container = $('div[data-area="'+value+'"]');
                                
                                if(!$(this).is(':checked')){
                                    container.addClass('hidden');
                                    container.find('input[type="checkbox"]').prop('checked', false);
                                } else {
                                    container.removeClass('hidden');
                                    container.find('input[type="checkbox"]').prop('checked', true);
                                }
                            });
                        });
                    JS
                        ); ?>
                    </ul>
                </div>
            </div>
        </div>
    </form>
    <div class="flex flex-1">

    </div>
</section>
