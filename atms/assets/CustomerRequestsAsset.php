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
class CustomerRequestsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
     
    public $css = [
        "css/customer_requests.css",

    ];
    public $js = [
        'js/customer_requests.js',
        'js/moment.2.18.1.min.js',


    ];

    public $depends = [
        'atms\assets\AppAsset',

    ];


}
