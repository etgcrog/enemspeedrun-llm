<?php

use app\assets\HtmxAsset;
use app\models\EnemQuestionCommentForm;
use yii\helpers\Url;


/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion $question */
/** @var \yii\data\ActiveDataProvider $commentsDataProvider */
/** @var EnemQuestionCommentForm $commentForm */
$isInfiniteScrollRequest = (isset($isInfiniteScrollRequest)) ? $isInfiniteScrollRequest : false;

HtmxAsset::register($this);
?>

<div id="comments"
     class="flex flex-col flex-1 bg-white border border-gray-200 rounded dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-row items-center justify-between px-2 w-full">
        <h1 class="text-sm font-bold px-2 py-2 flex flex-row gap-1 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
            </svg>
            Comentários
        </h1>
        <div class="flex flex-row items-center justify-end">

        </div>
    </div>
    <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700"/>
    <div class="flex flex-col gap-1 justify-start w-full h-full">
        <?= $this->render('_comments', [
            'question' => $question,
            'commentsDataProvider' => $commentsDataProvider,
            'isInfiniteScrollRequest' => $isInfiniteScrollRequest
        ]) ?>
        <?php if ($commentForm): ?>
            <hr class="mt-1 bg-gray-200 border-0 dark:bg-gray-700"/>
            <div class="flex flex-col w-full justify-center bg-gray-100 px-2 py-4">
                <form hx-post="<?= Url::to(['/browse/comments', 'id' => $question->getPrimaryKey()]) ?>"
                      hx-target="#comments"
                      hx-swap="outerHTML"
                      hx-trigger="submit"
                      class="flex flex-row justify-between items-center">
                    <input name="<?= Yii::$app->request->csrfParam ?>"
                           value="<?= Yii::$app->request->csrfToken ?>"
                           type="hidden"
                    />
                    <input name="text"
                           type="text"
                           placeholder="Adicione um comentário..."
                           value=""
                           class="text-md text-left font-normal flex-1 bg-gray-200 border-gray-200 rounded focus:outline-none"/>
                    <button type="submit"
                            class="flex flex-row gap-1 items-center justify-center ml-1 h-full text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-gray-100 font-medium rounded text-sm px-4 py-1 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Enviar
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                        </svg>
                    </button>
                </form>
            </div>
        <?php else: ?>
            <hr class="mt-1 bg-gray-200 border-0 dark:bg-gray-700"/>
            <div class="flex flex-col w-full justify-center px-2 py-4">
                <?= $this->render('/sign-in/_oauth_buttons', ['message' => 'Para responder você deve estar logado']) ?>
            </div>
        <?php endif; ?>
    </div>
</div>

