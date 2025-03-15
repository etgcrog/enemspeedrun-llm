<?php

namespace app\assets;

use yii\web\AssetBundle;

class HtmxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'https://unpkg.com/htmx.org@1.9.10',
        'js/htmx.js'
    ];

    public $jsOptions = [
        'crossorigin' => 'anonymous'
    ];
}