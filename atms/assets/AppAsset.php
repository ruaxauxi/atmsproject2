<?php

namespace atms\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/home.css',
        
    ];
    public $js = [
       'js/home.js',
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
        
    ];

    

}
