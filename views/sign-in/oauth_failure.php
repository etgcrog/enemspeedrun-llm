<?php

use app\widgets\Alert;
use yii\web\View;

/** @var View $this */
/** @var string $oAuthUrl */
?>

<div class="flex align-items-center max-w-lg">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl text-centerfont-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Bem vindo a plataforma de questões do enem.
                </h1>
                <?= Alert::widget() ?>
            </div>
        </div>
    </div>
</div>