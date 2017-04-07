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
class CustomerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
     
    public $css = [
        "css/customer.css",

    ];
    public $js = [
        'js/customer.js',

    ];

    public $depends = [
        'atms\assets\AppAsset',

    ];


}
