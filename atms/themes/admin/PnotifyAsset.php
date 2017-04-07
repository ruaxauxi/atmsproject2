<?php
/**
 * @copyright Copyright (c) 2015 Yiister
 * @license https://github.com/yiister/yii2-gentelella/blob/master/LICENSE
 * @link http://gentelella.yiister.ru
 */

namespace  atms\themes\admin;

use yii\web\AssetBundle;

class PNotifyAsset extends AssetBundle
{
    //public $sourcePath = '@vendor/bower/gentelella/build/';
    public $sourcePath = '@app/themes/admin/';

    //public $basePath = '@webroot';
    //public $baseUrl = '@web';

    public $css = [
         'plugins/pnotify/pnotify.custom.min.css'
    ];
    public $js = [
        'plugins/pnotify/pnotify.custom.min.js',
    ];
    public $depends = [
        'atms\themes\admin\ThemeAsset'
    ];
}
