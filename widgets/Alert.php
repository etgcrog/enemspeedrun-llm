<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;


class Alert extends Widget
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $session = Yii::$app->session;
        if ($session->hasFlash('success')) {
            $flash = $session->getFlash('success');

            echo Html::tag('div', Html::tag('span', 'Deu certo!', ['class' => 'font-medium']) . " " . $flash, [
                'class' => 'p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400'
            ]);
            $session->removeFlash('success');
            return;
        }


        if ($session->hasFlash('error')) {
            $flash = $session->getFlash('error');
            echo Html::tag('div', Html::tag('span', 'Ocorreu um erro!', ['class' => 'font-medium']) . " " . $flash, [
                'class' => 'p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400'
            ]);
            $session->removeFlash('error');
            return;
        }

    }
}
