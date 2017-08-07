<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

namespace  atms\themes\admin;

use yii\web\AssetBundle;

class TooltipsterAsset extends AssetBundle
{
    //public $sourcePath = '@vendor/bower/gentelella/build/';
    public $sourcePath = '@app/themes/admin/';

    //public $basePath = '@webroot';
    //public $baseUrl = '@web';

    public $css = [
         'plugins/tooltipster/tooltipster.bundle.min.css',
         'plugins/tooltipster/plugins/sideTip/themes/tooltipster-sideTip-borderless.min.css',
         'plugins/tooltipster/plugins/sideTip/themes/tooltipster-sideTip-light.min.css',
         'plugins/tooltipster/plugins/sideTip/themes/tooltipster-sideTip-noir.min.css',
         'plugins/tooltipster/plugins/sideTip/themes/tooltipster-sideTip-punk.min.css',
         'plugins/tooltipster/plugins/sideTip/themes/tooltipster-sideTip-shadow.min.css',

    ];
    public $js = [
        'plugins/tooltipster/tooltipster.bundle.min.js'
    ];
    public $depends = [
        'atms\themes\admin\ThemeAsset'
    ];
}
