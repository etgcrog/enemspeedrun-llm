<!-- views/enem-question/quiz.php -->
<?php
use app\assets\HtmxAsset;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion[] $questions */

HtmxAsset::register($this);
?>

<div class="max-w-3xl mx-auto p-4" x-data="quizData()">
    <div class="text-lg font-semibold mb-4">
        Quiz - Questão <span x-text="currentIndex + 1"></span> de <?= count($questions) ?>
    </div>

    <div id="quiz-container"
         hx-get="<?= Url::to(['/browse/view', 'id' => $questions[0]->id]) ?>"
         hx-trigger="load"
         hx-swap="innerHTML"
         class="bg-gray-100 p-4 rounded shadow">
        Carregando primeira questão...
    </div>

    <div class="flex justify-between gap-2 mt-4">
        <button id="prev-btn"
                class="py-2 px-4 bg-gray-300 rounded disabled:opacity-50"
                :disabled="currentIndex === 0"
                @click="prevQuestion()">
            Anterior
        </button>
        <button id="next-btn"
                class="py-2 px-4 bg-gray-300 rounded disabled:opacity-50"
                :disabled="currentIndex >= questions.length - 1"
                @click="nextQuestion()">
            Próxima
        </button>
    </div>

    <div x-show="finished" class="mt-6 bg-green-200 p-4 rounded shadow text-center">
        Você acertou <strong x-text="correctAnswers"></strong> de <strong><?= count($questions) ?></strong> questões.
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function quizData() {
        return {
            questions: <?= json_encode(array_map(fn($q) => $q->id, $questions)) ?>,
            currentIndex: 0,
            correctAnswers: 0,
            answers: {},
            finished: false,

            init() {
                this.loadQuestion(this.currentIndex);
                document.body.addEventListener('htmx:afterSwap', () => {
                    this.attachAnswerListener();
                });
            },

            loadQuestion(index) {
                this.finished = false;
                const container = document.getElementById('quiz-container');
                container.setAttribute('hx-get', '<?= Url::to(['/browse/view']) ?>?id=' + this.questions[index]);
                htmx.process(container);
                container.dispatchEvent(new Event('load'));
            },

            nextQuestion() {
                if (this.currentIndex < this.questions.length - 1) {
                    this.currentIndex++;
                    this.loadQuestion(this.currentIndex);
                } else {
                    this.showResults();
                }
            },

            prevQuestion() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                    this.loadQuestion(this.currentIndex);
                }
            },

            attachAnswerListener() {
                const quizContainer = document.getElementById('quiz-container');
                quizContainer.querySelectorAll('form').forEach(form => {
                    form.addEventListener('htmx:afterSwap', (event) => {
                        const isCorrect = event.detail.xhr.response.includes('Resposta correta');
                        const questionId = this.questions[this.currentIndex];
                        if (!(questionId in this.answers)) {
                            this.answers[questionId] = isCorrect;
                            if (isCorrect) this.correctAnswers++;
                        }
                    });
                });
            },

            showResults() {
                this.finished = true;
            }
        };
    }
</script>
