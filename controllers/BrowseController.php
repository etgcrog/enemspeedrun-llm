<?php

namespace app\controllers;

use app\models\EnemQuestion;
use app\models\EnemQuestionAccountAnswerForm;
use app\models\EnemQuestionComment;
use app\models\EnemQuestionCommentForm;
use app\models\SearchForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

/**
 * Responsável pela browse.
 */
class BrowseController extends WebController
{
    public $layout = 'main';
    public $defaultAction = 'index';

    public function verbs(): array
    {
        return [
            'index' => ['get'],
            'view' => ['get'],
            'favorite' => ['post'],
            'answer' => ['post'],
            'comments' => ['get', 'post']
        ];
    }

    private function setupSearchForm(): SearchForm
    {
        $searchForm = new SearchForm();

        $searchForm->year = Yii::$app->request->get('year', []);
        $searchForm->difficulty = Yii::$app->request->get('difficulty', []);
        $searchForm->area = Yii::$app->request->get('area', []);
        $searchForm->skill = Yii::$app->request->get('skill', []);
        $searchForm->term = Yii::$app->request->get('term', '');
        $this->view->params['searchForm'] = $searchForm;
        return $searchForm;
    }

    private function getCommentsDataProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => EnemQuestionComment::find()
                ->innerJoin('enem_question', 'enem_question.id = enem_question_comment.enem_question_id')
                ->innerJoin('account', 'account.id = enem_question_comment.account_id')
                ->select(['enem_question_comment.id', 'text', 'account.first_name', 'account.last_name', 'enem_question_comment.created_date'])
                ->orderBy(['enem_question_comment.created_date' => SORT_ASC])
                ->asArray(),
            'pagination' => [
                'page' => Yii::$app->request->get('comments-page', 0),
                'pageSize' => 20,
            ],
        ]);
    }

    private function getAnswerForm(EnemQuestion $question): ?EnemQuestionAccountAnswerForm
    {
        $answerForm = null;
        if (Yii::$app->user->identity) {
            $answerForm = new EnemQuestionAccountAnswerForm($question, Yii::$app->user->identity);
            if (Yii::$app->request->getIsPost()) {
                $answerForm->answer = Yii::$app->request->post('answer', '');

            }
        }
        return $answerForm;
    }

    private function getCommentForm(EnemQuestion $question): ?EnemQuestionCommentForm
    {
        $commentForm = null;
        if (Yii::$app->user->identity) {
            $commentForm = new EnemQuestionCommentForm($question, Yii::$app->user->identity);
        }
        return $commentForm;
    }

    /**
     * Página padrão da browse.
     * @return string
     */
    public function actionIndex()
    {
        $searchForm = $this->setupSearchForm();
        $this->view->params['searchForm'] = $searchForm;

        $dataProvider = new ActiveDataProvider([
            'query' => $searchForm->search(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        if ($this->getIsHtmxRequest()) {
            return $this->renderAjax('index', ['dataProvider' => $dataProvider]);
        }

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Salva uma questão como favorito.
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionFavorite(int $id)
    {
        $question = EnemQuestion::getEnemQuestionById($id);

        $favorites = Yii::$app->session->get('favourite_question', []);
        if (!in_array($id, $favorites)) {
            $favorites[] = $id;
            sort($favorites);
        } else {
            $keys = array_keys($favorites, $id);
            if (count($keys) > 0) {
                foreach ($keys as $key) {
                    unset($favorites[$key]);
                }
                sort($favorites);
            }
        }
        Yii::$app->session->set('favourite_question', $favorites);

        return $this->renderAjax('_favorite', ['id' => $question->getPrimaryKey(), 'favorites' => $favorites]);
    }


    /**
     * Página de view da questão.
     * @param int $id
     * @return string|void
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $this->setupSearchForm();
        $question = EnemQuestion::getEnemQuestionById($id);

        $commentsDataProvider = $this->getCommentsDataProvider();

        if ($this->getIsHtmxRequest()) {
            return $this->renderAjax('view', [
                'answerForm' => $this->getAnswerForm($question),
                'question' => $question,
                'commentForm' => $this->getCommentForm($question),
                'commentsDataProvider' => $commentsDataProvider
            ]);
        }

        return $this->render('view', [
            'answerForm' => $this->getAnswerForm($question),
            'question' => $question,
            'commentForm' => $this->getCommentForm($question),
            'commentsDataProvider' => $commentsDataProvider
        ]);
    }

    /**
     * Página de resposta.
     * @param int $id
     * @return string
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAnswer(int $id)
    {
        if (!$this->getIsHtmxRequest()) {
            throw new BadRequestHttpException("Request inválido.");
        }

        $question = EnemQuestion::getEnemQuestionById($id);
        $this->setupSearchForm();
        $answerForm = $this->getAnswerForm($question);
        $answerForm->answer();

        return $this->renderAjax('_alternatives', [
            'question' => $question,
            'answerForm' => $answerForm
        ]);
    }

    /**
     * Página parcial de comentários.
     * @param int $id
     * @param bool $isInfiniteScroll
     * @return string
     * @throws \yii\base\ErrorException
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionComments(int $id, bool $isInfiniteScroll = false)
    {
        if (!$this->getIsHtmxRequest()) {
            throw new BadRequestHttpException("Request inválido.");
        }
        $question = EnemQuestion::getEnemQuestionById($id);
        $commentsDataProvider = $this->getCommentsDataProvider();

        $commentForm = $this->getCommentForm($question);
        if ($commentForm instanceof EnemQuestionCommentForm && Yii::$app->request->getIsPost()) {
            $commentForm->text = Yii::$app->request->post('text', '');
            $commentForm->add();
        }

        if (Yii::$app->request->getIsPost()) {
            return $this->renderAjax('_question_comments', [
                'question' => $question,
                'commentForm' => $commentForm,
                'commentsDataProvider' => $commentsDataProvider,
                'isInfiniteScrollRequest' => $isInfiniteScroll
            ]);
        }
        return $this->renderAjax('_comments', [
            'question' => $question,
            'commentForm' => $commentForm,
            'commentsDataProvider' => $commentsDataProvider,
            'isInfiniteScrollRequest' => $isInfiniteScroll
        ]);
    }
}