<?php

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
                <p class="text-sm font-normal leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Aqui a gente juntou um monte de desafios, <b>todos organizadinhos por nível de dificuldade e
                        habilidades necessárias 🥰</b>. Então, bora encarar e mostrar do que a gente é capaz?
                </p>
                <a href="<?= $oAuthUrl ?>"
                   role="button"
                   class=" flex flex-row gap-2 w-full align-center justify-center text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 me-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" class="w-6 h-6">
                        <path fill="#4caf50" d="M45,16.2l-5,2.75l-5,4.75L35,40h7c1.657,0,3-1.343,3-3V16.2z"></path>
                        <path fill="#1e88e5" d="M3,16.2l3.614,1.71L13,23.7V40H6c-1.657,0-3-1.343-3-3V16.2z"></path>
                        <polygon fill="#e53935"
                                 points="35,11.2 24,19.45 13,11.2 12,17 13,23.7 24,31.95 35,23.7 36,17"></polygon>
                        <path fill="#c62828"
                              d="M3,12.298V16.2l10,7.5V11.2L9.876,8.859C9.132,8.301,8.228,8,7.298,8h0C4.924,8,3,9.924,3,12.298z"></path>
                        <path fill="#fbc02d"
                              d="M45,12.298V16.2l-10,7.5V11.2l3.124-2.341C38.868,8.301,39.772,8,40.702,8h0 C43.076,8,45,9.924,45,12.298z"></path>
                    </svg>
                    Entrar com Google
                </a>
            </div>
        </div>
    </div>
</div>