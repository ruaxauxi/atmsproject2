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
        'js/fullscreen.js',
        'js/autosize.min.js',
        'js/jquery.slimscroll.min.js',
        'js/js.cookie.js',
        'js/home.js',
    ];

    /*
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];*/

    public $depends = [
        'atms\themes\admin\ThemeAsset',
        'atms\themes\admin\VelocityAsset',
        'atms\themes\admin\PNotifyAsset',
        'atms\themes\admin\BootstrapToggleAsset',
        'atms\themes\admin\ExtensionAsset',
        'atms\themes\admin\DataTablesAsset',
        'atms\themes\admin\TooltipsterAsset',
        
    ];

    

}
