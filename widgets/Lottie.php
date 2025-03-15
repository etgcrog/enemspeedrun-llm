<?php

namespace app\widgets;

use app\assets\LottieAsset;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class Lottie extends Widget
{
    public string $name = '';
    public $options = [];
    public bool $loop = true;
    public bool $autoPlay = true;

    public function run()
    {
        LottieAsset::register($this->view);
        $id = uniqid();
        echo Html::tag('div', '', ['id' => $id, ...$this->options]);
        $basePath = Url::base(true);

        $autoPlay = json_encode($this->autoPlay);
        $loop = json_encode($this->loop);
        $this->view->registerJs(<<<JS
            lottie.loadAnimation({
              container: document.getElementById('{$id}'),
              renderer: 'svg',
              loop: {$loop},
              autoplay: {$autoPlay},
              path: '{$basePath}/lotties/{$this->name}'
            });
        JS
        );
    }
}