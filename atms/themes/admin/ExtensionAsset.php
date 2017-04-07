<?php
/**
 * @copyright Copyright (c) 2015 Yiister
 * @license https://github.com/yiister/yii2-gentelella/blob/master/LICENSE
 * @link http://gentelella.yiister.ru
 */

namespace  atms\themes\admin;

use yii\web\AssetBundle;

class ExtensionAsset extends AssetBundle
{
    //public $sourcePath = '@vendor/bower/gentelella/build/';
    public $sourcePath = '@app/themes/admin';

    //public $basePath = '@webroot';
    //public $baseUrl = '@web';

    public $css = [
         
    ];
    public $js = [
        'js/main.extension.js',
    ];
    public $depends = [
        'atms\themes\admin\ThemeAsset'
    ];
}
