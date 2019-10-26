<?php

namespace frontend\assets;

use frontend\assets\vendor\VueAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
    ];
    public $js = [
        'js/app.js',
    ];
    public $depends = [
        YiiAsset::class,
        VueAsset::class
    ];
}
