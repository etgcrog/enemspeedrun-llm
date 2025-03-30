<!-- views/enem-question/quiz.php -->
<?php
use app\assets\HtmxAsset;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\models\EnemQuestion[] $questions */

HtmxAsset::register($this);
?>

<div class="max-w-3xl mx-auto p-4" x-data="quizData()">
    <div class="text-lg font-semibold mb-4" x-show="!finished">
        Questão <span x-text="currentIndex + 1"></span> de <?= count($questions) ?>
    </div>

    <div id="quiz-container"
         hx-get="<?= Url::to(['/browse/view', 'id' => $questions[0]->id]) ?>"
         hx-trigger="load"
         hx-swap="innerHTML"
         class="bg-gray-100 p-4 rounded shadow">
        Carregando primeira questão...
    </div>

    <div class="flex justify-between gap-2 mt-4" x-show="!finished">
        <button class="py-2 px-4 bg-gray-300 rounded disabled:opacity-50"
                :disabled="currentIndex === 0"
                @click="prevQuestion()">
            Anterior
        </button>
        <button class="py-2 px-4 bg-gray-300 rounded disabled:opacity-50"
                @click="nextQuestion()">
            <span x-text="currentIndex < questions.length - 1 ? 'Próxima' : 'Finalizar Quiz'"></span>
        </button>
    </div>

    <div x-show="finished" class="mt-6 bg-green-200 p-4 rounded shadow text-center">
        🎉 Você acertou <strong x-text="correctAnswers"></strong> de <strong><?= count($questions) ?></strong> questões!
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
                    this.finished = true;
                }
            },

            prevQuestion() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                    this.loadQuestion(this.currentIndex);
                }
            },

            attachAnswerListener() {
                document.querySelectorAll('#quiz-container form').forEach(form => {
                    form.addEventListener('submit', event => {
                        event.preventDefault();
                        const formData = new FormData(form);
                        fetch(form.getAttribute('hx-post'), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-Token': formData.get('_csrf'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'HX-Request': 'true',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            const questionId = this.questions[this.currentIndex];

                            if (!(questionId in this.answers)) {
                                this.answers[questionId] = data.is_correct;
                                if (data.is_correct) this.correctAnswers++;
                            }

                            if (data.is_correct) {
                                alert('🎉 Resposta correta!');
                            } else {
                                alert(`😢 Incorreto! Resposta certa: ${data.correct_answer}`);
                            }
                        });
                    });
                });
            },
        };
    }
</script>
