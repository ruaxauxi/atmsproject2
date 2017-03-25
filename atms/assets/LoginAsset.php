<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

namespace atms\assets;

use yii\web\AssetBundle;
use atms\themes\admin\ThemeAsset;
 
/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
     
    public $css = [
        //'css/main.css',
        "css/login.css",
        //'css/pnotify.custom.min.css',
         
    ];
    public $js = [
        //'js/main.js',
        'js/login.js',
        //'js/pnotify.custom.min.js',
      
        //"@vendor/bower/gentelella/pnotify/pnotify.js"
    ];

    /*
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];*/

    public $depends = [
        'atms\themes\admin\ThemeAsset',
        'atms\themes\admin\PNotifyAsset',
        'atms\themes\admin\ExtensionAsset',
        
        //'atms\themes\default\assets\ExpressionAsset'
    ];

}
