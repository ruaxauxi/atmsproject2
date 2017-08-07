<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $title;
?>
<div class="site-error">


    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Vui lòng liên hệ với Quản trị viên để được cấp quyền truy cập hoặc để biết thêm thông tin. <br/>
        <b>
            <?= Html::mailto("Liên hệ quản trị viên",\Yii::$app->params["adminEmail"]); ?>
        </b>
    </p>


</div>
