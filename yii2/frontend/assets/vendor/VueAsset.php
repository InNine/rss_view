<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 21:06
 */

namespace frontend\assets\vendor;

use yii\web\AssetBundle;

class VueAsset extends AssetBundle
{
    public $sourcePath = '@npm/vue/dist';

    public $css = [
    ];
    public $js = [
        'vue.min.js',
    ];
    public $depends = [
    ];
}