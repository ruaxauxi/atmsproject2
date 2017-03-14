<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/login.css'
    ];
    public $js = [
        'js/login.js'
    ];

    /*
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];*/

    public $depends = [
        'yiister\gentelella\assets\ThemeAsset',
        'yiister\gentelella\assets\ExtensionAsset',
    ];


}
