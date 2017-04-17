<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

namespace  atms\themes\admin;

use yii\web\AssetBundle;

class VelocityAsset extends AssetBundle
{
    //public $sourcePath = '@vendor/bower/gentelella/build/';
    public $sourcePath = '@app/themes/admin/';

    //public $basePath = '@webroot';
    //public $baseUrl = '@web';

    public $css = [
         //'plugins/pnotify/pnotify.custom.min.css'
    ];
    public $js = [
        'plugins/velocity/velocity.min.js',
        'plugins/velocity/velocity.ui.min.js',
    ];
    public $depends = [
        'atms\themes\admin\ThemeAsset'
    ];
}
