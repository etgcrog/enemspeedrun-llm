<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\filters\AjaxFilter;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class WebController extends Controller
{
    public $title = 'Solid Sales Works';
    public $enableCsrfValidation = true;

    /**
     * Actions e seus respectios métodos.
     * @return array
     */
    public function verbs(): array
    {
        return [];
    }

    /**
     * Requests ajax only.
     * @return array
     */
    public function ajaxOnly(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['get'],
            ],
        ];
        $behaviors[] = [
            'class' => AjaxFilter::class,
            'only' => $this->ajaxOnly(),
            'except' => ['*']
        ];
        return $behaviors;
    }

    /**
     * Realiza validação ajax do ActiveForm.
     * @param Model $model
     * @return void|null
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation(Model $model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $validate = ActiveForm::validate($model);
            Yii::$app->response->data = $validate;
            Yii::$app->end();
        }
    }

    /**
     * Obtém se o request é HTMX.
     * @return bool
     */
    protected function getIsHtmxRequest(): bool
    {
        return Yii::$app->request->headers->get('HX-Request', false) !== false;
    }

    /**
     * Envia resposta json.
     * @param int $httpCode
     * @param $data
     * @return mixed|null
     */
    protected function json(int $httpCode, $data = null)
    {
        Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;
        Yii::$app->response->statusCode = $httpCode;
        return $data;
    }


}