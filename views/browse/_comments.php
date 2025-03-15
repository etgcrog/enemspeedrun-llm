<?php

use app\assets\HtmxAsset;
use app\widgets\Lottie;
use yii\helpers\Url;


/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion $question */
/** @var \yii\data\ActiveDataProvider $commentsDataProvider */
/** @var bool $isInfiniteScrollRequest */
HtmxAsset::register($this);
?>

<?php if (isset($isInfiniteScrollRequest) && $isInfiniteScrollRequest): ?>
    <?php
    /** @var \app\models\EnemQuestionComment $model */
    foreach ($commentsDataProvider->getModels() as $model): ?>
        <?= $this->render('_comment', ['comment' => $model]) ?>
    <?php endforeach; ?>
<?php else: ?>
    <?php if ($commentsDataProvider->totalCount > 0): ?>
        <section hx-get="<?= Url::to([
            '/browse/comments',
            'id' => $question->getPrimaryKey(),
            'comments-page' => $commentsDataProvider->pagination->page + 1,
            'isInfiniteScroll' => true
        ]) ?>"
                 hx-trigger="intersect once"
                 hx-swap="afterend"
                 hx-target="this"
                 class="flex flex-col gap-1 flex-1 px-2 py-2 overflow-y-scroll" style="max-height: 70vh;">
            <?php
            /** @var \app\models\EnemQuestionComment $model */
            foreach ($commentsDataProvider->getModels() as $model): ?>
                <?= $this->render('_comment', ['comment' => $model]) ?>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <section class="flex flex-col gap-1 flex-1 px-2 py-2">
            <div class="flex justify-center">
                <?= Lottie::widget(['name' => 'empty.json', 'options' => [
                    'class' => 'w-32 h-32'
                ]]) ?>
            </div>
            <h6 class="text-xs font-bold text-center">
                Sem comentários
            </h6>
            <p class="text-xs text-gray-600 font-normal text-center">
                Nenhum comentário encontrado para esta questão.
            </p>
        </section>
    <?php endif; ?>

<?php endif; ?>

