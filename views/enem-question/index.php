<!-- views/enem-question/index.php -->
<?php
use yii\helpers\Url;

/** @var yii\web\View $this */
?>

<div class="max-w-xl mx-auto py-4 px-2 flex flex-col gap-4">
    <h1 class="text-2xl font-semibold">Resolver Questões</h1>

    <div class="flex flex-col gap-4">
        <!-- Formulário para questões em ordem -->
        <form method="get" action="<?= Url::to(['enem-question/quiz']) ?>" class="flex gap-2 items-center">
            <input type="number" name="limit" placeholder="Número de questões" value="10" min="1" max="100"
                   class="border rounded py-2 px-3">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Resolver Questões em Ordem
            </button>
        </form>

        <!-- Formulário para questões aleatórias -->
        <form method="get" action="<?= Url::to(['enem-question/quiz']) ?>" class="flex gap-2 items-center">
            <input type="number" name="limit" placeholder="Número de questões" value="10" min="1" max="100"
                   class="border rounded py-2 px-3">
            <input type="hidden" name="random" value="1">
            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                Resolver Questões Aleatórias
            </button>
        </form>
    </div>
</div>
