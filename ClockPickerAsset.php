<?php

namespace ofilin\clockpicker;

use yii\web\AssetBundle;

class ClockPickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/clockpicker/dist';

    public $js = [
        'jquery-clockpicker.min.js',
    ];

    public $css = [
        'jquery-clockpicker.min.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
