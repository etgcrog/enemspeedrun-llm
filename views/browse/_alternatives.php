<?php

use app\assets\HtmxAsset;
use app\models\EnemQuestionAccountAnswerForm;
use app\widgets\Lottie;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion $question */
/** @var EnemQuestionAccountAnswerForm $answerForm */

HtmxAsset::register($this);
$submitIndicatorId = 'alternative-submit-indicator';

$questionAlternatives = json_decode($question->alternatives, true);
ksort($questionAlternatives);
?>

    <section id="alternatives" class="flex flex-col gap-1 w-full">
        <div class="flex flex-row justify-between items-center w-full mb-2 px-2">
            <h6 class="text-xs font-normal">
                Pressione uma questão para responder.
            </h6>
            <button data-show-answer="false"
                    role="button"
                    type="button"
                    class="flex flex-row gap-1 items-center text-gray-900 bg-white hover:bg-gray-100 border border-gray-600 font-medium rounded text-sm px-2 py-1 text-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3"/>
                </svg>
                Mostrar resposta
            </button>
            <template>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                Resposta: Alternativa <?= $question->answer ?>
            </template>
        </div>
        <ul class="px-2 list-inside dark:text-gray-400">
            <?php foreach ($questionAlternatives as $letter => $alternativeText): ?>
                <li class="flex items-start gap-4 py-2 px-1 my-2 rounded cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700"
                    data-question-alternative="<?= $letter ?>">
                    <div class="flex flex-row gap-1">
                        <button class="opacity-0 flex flex-row gap-1 items-center text-gray-600 px-2 py-1" role="button">
                            <!-- botão de riscar, se aplicável -->
                        </button>
                        <button type="button"
                                role="button"
                                class="text-lg inline-flex items-center justify-center w-6 h-6 p-4 rounded-full text-sm font-semibold text-gray-800 bg-gray-100 border-gray-300 border dark:bg-gray-700 dark:text-gray-300">
                            <?= $letter ?>
                        </button>
                    </div>
                    <div class="text-sm font-semibold text-gray-600 tracking-tighter w-full overflow-hidden">
                        <?php
                        $decodedAlt = base64_decode($alternativeText, true);
                        if ($decodedAlt && (str_starts_with($decodedAlt, '<svg') || str_starts_with($decodedAlt, '<?xml'))) {
                            echo '<div class="w-full overflow-x-auto max-h-48 border rounded p-1 bg-white dark:bg-gray-800">'
                                . $decodedAlt . '</div>';
                        } elseif ($decodedAlt && str_starts_with($decodedAlt, "\x89PNG")) {
                            echo '<img class="w-full max-h-48 object-contain border rounded p-1 bg-white dark:bg-gray-800" 
                                src="data:image/png;base64,' . \yii\helpers\Html::encode($alternativeText) . '" 
                                alt="Alternative Image"/>';
                        } else {
                            echo '<p>' . \yii\helpers\Html::encode($alternativeText) . '</p>';
                        }
                        ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>


        <?php if (Yii::$app->user->identity): ?>
            <?php if ($answerForm->answer !== null): ?>
                <?php if ($answerForm->is_correct === true): ?>
                    <div class="flex flex-col gap-1 items-center justify-center w-full py-2">
                        <h1 class="text-lg font-bold text-gray-900 text-center">
                            Resposta correta!
                        </h1>
                        <?= Lottie::widget([
                            'name' => 'party.json',
                            'options' => [
                                'class' => 'w-60 h-60'
                            ]
                        ]) ?>
                    </div>
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 text-center"
                         role="alert">
                        <span class="font-medium">Você acertou 🥳!</span> a alternativa
                        <strong><?= $question->answer ?></strong> está corretíssima.
                    </div>
                    <?php $this->registerJs(<<<JS
                        var alternativeList = $('li[data-question-alternative]').parent();
                        alternativeList.hide();
                        var incorrectLi = $('li[data-question-alternative]')
                        incorrectLi.removeClass('bg-green-100');
                        
                        var correctLi = $('li[data-question-alternative="{$question->answer}"]');
                        
                        correctLi.removeClass('bg-red-100');
                        correctLi.addClass('bg-green-100');
                    JS
                    );
                    ?>
                <?php elseif ($answerForm->is_correct === false): ?>
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 text-center"
                         role="alert">
                        <span class="font-medium">Resposta incorreta 😢</span>. A alternativa correta
                        era <strong><?= $question->answer ?></strong>.
                    </div>
                    <?php $this->registerJs(<<<JS
                        var incorrectLi = $('li[data-question-alternative]')
                        incorrectLi.removeClass('bg-green-100');
                        incorrectLi.addClass('bg-red-100');
                        
                        var correctLi = $('li[data-question-alternative="{$question->answer}"]');
                        
                        correctLi.removeClass('bg-red-100');
                        correctLi.addClass('bg-green-100');
                    JS
                    );
                    ?>
                <?php endif; ?>
            <?php endif; ?>
            <form hx-post="<?= Url::to(['/browse/answer', 'id' => $question->getPrimaryKey()]) ?>"
                  hx-indicator="#<?= $submitIndicatorId ?>"
                  hx-trigger="submit"
                  hx-target="#alternatives"
                  hx-swap="outerHTML"
                  class="flex flex-row gap-2 items-center justify-start hidden mt-2">
                <input name="<?= Yii::$app->request->csrfParam ?>"
                       value="<?= Yii::$app->request->csrfToken ?>"
                       type="hidden"
                />
                <input name="answer" value="" type="hidden"/>
                <div id="<?= $submitIndicatorId ?>"
                     role="status"
                     class="hidden htmx-indicator">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600"
                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                              fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                              fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Carregando...</span>
                </div>
                <button data-chosen-alternative=""
                        role="button"
                        type="submit"
                        class="flex flex-row text-white bg-gray-900 border-gray-900 border-gray-900 font-medium rounded text-sm px-3 py-1.5 text-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                    Responder
                </button>
            </form>
        <?php else: ?>
            <?= $this->render('/sign-in/_oauth_buttons', ['message' => 'Para responder você deve estar logado']) ?>
        <?php endif; ?>
    </section>

<?php
$this->registerJs(<<<JS
     var alternativeButtons = $("li[data-question-alternative]");
     var alternativeUl = alternativeButtons.parent();
     
     alternativeUl.mouseenter(function() {
          const scissor = $(this).find('button:first-child');
    
          scissor.removeClass('opacity-0');
          scissor.removeClass('fade-out-left');
          scissor.addClass('fade-in-left');
     });

    alternativeUl.mouseleave(function() {
         const scissor = $(this).find('button:first-child');
         scissor.removeClass('opacity-0');
         
         const buttons = alternativeUl.find('li button:first-child');
         buttons.removeClass('fade-in-left');
         buttons.addClass('fade-out-left');
    });
    
    var lastLiSkipped = null;
    $('li[data-question-alternative] button:first-child').click(function() {
        if($(this).closest('li').find('p').hasClass('line-through')) {
            $(this).closest('li').find('p').removeClass('line-through');
        } else {
            const count = $('li[data-question-alternative] p.line-through').length;
            if(count < 4){
                $(this).closest('li').find('p').addClass('line-through');
                $(this).closest('li[data-question-alternative]').removeClass('bg-green-100');
                if(count === 3) {
                    lastLiSkipped = $(this).closest('li[data-question-alternative]');
                    console.log(lastLiSkipped)
                }else {
                    lastLiSkipped = null;
                }
            }
        }
    });
    
    var alternativeButton = $('[data-chosen-alternative]').removeClass('hidden');
    var alternativeLetterButtons = $('li[data-question-alternative] button:nth-child(2)');
    var alternativeButtonInitialText = alternativeButton.text();
    var lis = $('li[data-question-alternative]');
    lis.children('button:nth-child(2), p, div, img').click(function() {
       lis.removeClass('bg-green-100 bg-red-100');  
        const li = $(this).closest('li[data-question-alternative]');
        const alternativeLetterButton = li.find('button:nth-child(2)');
        
        alternativeLetterButtons.removeClass('bg-green-200 border-green-300');
        alternativeLetterButtons.addClass('bg-gray-100 border-gray-300');
        
        if(li.hasClass('bg-green-100')) {

          li.removeClass('bg-green-100');
          alternativeButton.parent().addClass('hidden');
        } else {
          alternativeLetterButton.addClass('bg-green-200 border-green-300');
          
          li.addClass('bg-green-100');
          li.children('p').removeClass('line-through');
          
          alternativeButton.parent().removeClass('hidden');
          
          const alternative = li.attr('data-question-alternative');
          alternativeButton.attr('data-chosen-alternative', alternative);
          $('input[name="answer"]').val(alternative);
          alternativeButton.html(alternativeButtonInitialText + ' ' + alternative);
        }
    });
    
    $('button[data-show-answer="false"]').click(function () {
        $(this).html($(this).siblings('template').html());
        $(this).removeClass('bg-white border-gray-600 hover:bg-gray-100');
        $(this).addClass('bg-green-300 border-green-600 hover:bg-green-400');
        
        $('li[data-question-alternative="{$question->answer}"] p').click();
    });
JS
);

$this->registerCss(<<<CSS

    #alternatives img,
    #alternatives svg {
        max-height: 10rem;
        max-width: 50%;
        object-fit: contain;
        display: block;
    }

    #alternatives li {
        transition: background-color 0.2s ease;
        position: relative;
    }

  .fade-in-left {
    opacity: 0;
    position: relative;
    left: -100px;
    animation: fadeInLeft 0.25s forwards;
  }

  .fade-out-left {
    opacity: 1;
    position: relative;
    left: 0; 
    animation: fadeOutLeft 0.25s forwards;
  }

  @keyframes fadeInLeft {
    0% {
      opacity: 0;
      left: -2rem;
    }
    100% {
      opacity: 1;
      left: 0;
    }
  }

  @keyframes fadeOutLeft {
    0% {
      opacity: 1;
      left: 0;
    }
    100% {
      opacity: 0;
      left: -2rem;
    }
  }

  .htmx-indicator {
        opacity: 0;
        transition: opacity 500ms ease-in;
  }
  
  #{$submitIndicatorId}.htmx-request.htmx-indicator{
        opacity: 1;
        display: inline !important;
  }
CSS
);
?>