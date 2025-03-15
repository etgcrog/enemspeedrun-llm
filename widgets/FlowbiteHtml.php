<?php

namespace app\widgets;

use yii\helpers\Html;

class FlowbiteHtml extends Html
{
    public static function activeHiddenInput($model, $attribute, $options = [])
    {
        return parent::activeHiddenInput($model, $attribute, $options);
    }
}