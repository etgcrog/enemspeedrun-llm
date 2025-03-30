<?php

namespace app\controllers;

use app\models\EnemQuestion;
use app\models\EnemQuestionAccountAnswerForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Expression;

class EnemQuestionController extends Controller
{
    /**
     * Página inicial para listar opções de quizzes.
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Exibe uma lista simples de questões em ordem ou aleatória (sem navegação).
     */

    public function actionQuiz($random = false, $limit = 10)
    {
        $query = \app\models\EnemQuestion::find();
        if ($random) {
            $query->orderBy(new \yii\db\Expression('RANDOM()'));
        }
        $questions = $query->limit((int)$limit)->all();

        return $this->render('quiz', ['questions' => $questions]);
    }



    /**
     * Inicia o quiz aleatório com navegação sequencial.
     */
    public function actionRandomQuiz($limit = 10)
    {
        $questions = EnemQuestion::find()
            ->orderBy(new Expression('RANDOM()'))
            ->limit((int)$limit)
            ->asArray()
            ->all();

        if (empty($questions)) {
            throw new NotFoundHttpException("Nenhuma questão encontrada para o quiz.");
        }

        Yii::$app->session->set('quiz_questions', $questions);
        Yii::$app->session->set('quiz_current_index', 0);

        return $this->redirect(['quiz-question']);
    }

    /**
     * Exibe questão individual do quiz, com navegação (anterior e próxima).
     */
    public function actionQuizQuestion($direction = null)
    {
        $questions = Yii::$app->session->get('quiz_questions', []);
        if (empty($questions)) {
            return $this->redirect(['index']);
        }

        $currentIndex = Yii::$app->session->get('quiz_current_index', 0);

        if ($direction === 'next' && isset($questions[$currentIndex + 1])) {
            $currentIndex++;
        } elseif ($direction === 'prev' && $currentIndex > 0) {
            $currentIndex--;
        }

        Yii::$app->session->set('quiz_current_index', $currentIndex);

        $questionId = $questions[$currentIndex]['id'] ?? null;

        if (!$questionId) {
            throw new NotFoundHttpException("Questão não encontrada no quiz atual.");
        }

        $question = EnemQuestion::findOne($questionId);
        if (!$question) {
            throw new NotFoundHttpException("Questão não existe.");
        }

        $answerForm = new EnemQuestionAccountAnswerForm(['question_id' => $questionId]);

        return $this->render('quiz_question_details', [
            'question' => $question,
            'answerForm' => $answerForm,
            'currentIndex' => $currentIndex + 1,
            'totalQuestions' => count($questions),
        ]);
    }

    public function actionRenderQuestion($id)
    {
    $question = EnemQuestion::findOne($id);
    if (!$question) {
        throw new NotFoundHttpException('Questão não encontrada.');
    }

    $answerForm = new EnemQuestionAccountAnswerForm(['question_id' => $id]);

    return $this->renderPartial('/browse/_question_details', [
        'question' => $question,
        'answerForm' => $answerForm
    ]);
}
}
