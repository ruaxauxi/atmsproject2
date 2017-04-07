<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

namespace  atms\themes\admin;

use yii\web\AssetBundle;

class DataTablesAsset extends AssetBundle
{
    //public $sourcePath = '@vendor/bower/gentelella/build/';
    public $sourcePath = '@app/themes/admin';

    //public $basePath = '@webroot';
    //public $baseUrl = '@web';

    public $css = [
        'plugins/DataTables/datatables.css',
        'plugins/DataTables/css/dataTables.bootstrap.css',


    ];
    public $js = [
        'plugins/DataTables/datatables.js',
        'plugins/DataTables/js/dataTables.bootstrap.js'

    ];
    public $depends = [

    ];
}
