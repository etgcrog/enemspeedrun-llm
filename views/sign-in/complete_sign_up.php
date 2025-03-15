<?php

use app\assets\HtmxAsset;
use app\models\SignInOAuthForm;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var SignInOAuthForm $form */
HtmxAsset::register($this);
?>

<div class="flex align-items-center max-w-lg">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl text-centerfont-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Bem vindo a plataforma de questões do enem.
                </h1>
                <p class="text-sm font-normal leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    😊 Bem-vindo(a) a bordo! 😊<br>
                    Para continuar precisamos de mais algumas informações.
                </p>

                <?php $aForm = ActiveForm::begin([
                    'action' => ['/sign-in/complete-sign-up'],
                    'options' => [
                        'class' => 'flex flex-col gap-1'
                    ]
                ]) ?>

                <?= Alert::widget() ?>

                <div class="flex flex-row gap-1">
                    <?= $aForm->field($form, 'first_name')->textInput(['readonly' => true]) ?>
                    <?= $aForm->field($form, 'last_name')->textInput(['readonly' => true]) ?>
                </div>
                <?= $aForm->field($form, 'email')->textInput(['readonly' => true]) ?>
                <p class="mt-2 text-sm font-bold">
                    Defina a senha da sua conta abaixo:
                </p>
                <div class="flex flex-row gap-1">
                    <?= $aForm->field($form, 'password')->passwordInput() ?>
                    <?= $aForm->field($form, 'password_repeat')->passwordInput() ?>
                </div>
                <div class="flex flex-col justify-center items-end">
                    <button type="button" role="button"
                            class="flex flex-row gap-1 justify-center items-center password-toggle mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="text-xs">Mostrar</span>
                    </button>
                    <button type="button" role="button"
                            class="flex flex-row gap-1 justify-center items-center password-toggle mt-2 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                        <span class="text-xs">Esconder</span>
                    </button>
                </div>
                <?php
                $inputId = Html::getInputId($form, 'password');
                $secondInputId = Html::getInputId($form, 'password_repeat');
                $this->registerJs(<<<JS

                    let showPassword = false;
                    const passwordButtons = $('.password-toggle');
                    const passwordInput = $('#{$inputId}');
                    const secondPasswordInput = $('#{$secondInputId}');
                    
                    passwordInput.focus();
                    passwordButtons.click(function() {
                        showPassword = !showPassword;
                        if(showPassword){
                            passwordButtons.eq(0).addClass('hidden');
                            passwordButtons.eq(1).removeClass('hidden');
                            
                            passwordButtons.eq(2).addClass('hidden');
                            passwordButtons.eq(3).removeClass('hidden');
                            
                            passwordInput.attr('type', 'text');
                            secondPasswordInput.attr('type', 'text');
                        }else{
                            passwordButtons.eq(0).removeClass('hidden');
                            passwordButtons.eq(1).addClass('hidden');
                            
                            passwordButtons.eq(2).removeClass('hidden');
                            passwordButtons.eq(3).addClass('hidden');
                            
                            passwordInput.attr('type', 'password');
                            secondPasswordInput.attr('type', 'password');
                        }                
                    });
               JS
                ); ?>
                <div class="flex flex-row justify-center w-full mt-4">
                    <button type="submit"
                            class="text-white w-full text-center items-center justify-center bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                        Entrar
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </button>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>