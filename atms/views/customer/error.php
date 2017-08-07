<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by PhpStorm.
 * User: dangvo
 * Date: 6/1/17
 * Time: 5:11 PM
 */

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

$this->title = $title;

$bundle  = \atms\assets\CustomerAsset::register($this);

?>

<div class="customer-error">
    <?php
    echo Breadcrumbs::widget([
        'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
        'homeLink'  => [
            'label' => 'Home',
            'url'   => Yii::$app->homeUrl,
            'template'  => "<li><span class='fa fa-home'></span> {link}</li>"
        ],
        'links' => [
            [
                'label' => 'Khách hàng',
                'url'   => Yii::$app->homeUrl . 'customer',
                //'url' => ['post-category/view', 'id' => 10],
                'template' => "<li><b>{link}</b></li>\n", // template for this link only
            ],
            'Lỗi',
        ],
    ]);
    ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <div class="alert alert-danger">
        <?= $message; ?>
    </div>

    <?= Html::a('<span class="fa fa-undo"></span> Quay lại', $return_url , [
            'class' => 'btn btn-default',
            'id' => 'btnBack',
        ]
    ) ?>

</div>
