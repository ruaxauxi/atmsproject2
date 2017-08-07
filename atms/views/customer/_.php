<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by PhpStorm.
 * User: dangvo
 * Date: 6/3/17
 * Time: 3:21 PM
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use atms\widgets\select2\Select2;
use atms\widgets\depdrop\DepDrop;
use yii\widgets\Breadcrumbs;


/* @var $this yii\web\View */
/* @var $model atms\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$bundle  = \atms\assets\CustomerRequestAsset::register($this);

?>

<div class="customer-request-form">

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
                'label' => 'Yêu cầu đặt vé',
                'url'   => Yii::$app->homeUrl . 'customer/customer-request',
                //'url' => ['post-category/view', 'id' => 10],
                'template' => "<li><b>{link}</b></li>\n", // template for this link only
            ],
            //['label' => 'Sample Post', 'url' => ['post/edit', 'id' => 1]],
            'Thêm yêu cầu',
        ],
    ]);
    ?>
    <br/>
    <?php \yii\widgets\Pjax::begin() ?>
    <?php $form = ActiveForm::begin([
            'action' => Url::to([Yii::$app->controller->id .  "/customer/customer-request-create"]),
            'options'   => [
                'id' => 'frmCustomerRequestCreate',
            ],
            'method'    => 'post',
            'layout' => 'horizontal',
            'requiredCssClass' => "required",
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}{input}{error}\n{endWrapper}",
                // 'template'  => "<div class='col-sm-4 col-md-4'>{label}</div><div class='col-sm-4 col-md-4 '>{input}</div><div class='col-sm-4 col-md-4 '>{error}</div>",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3 col-md-3',
                    'offset' => 'col-sm-offset-3 col-md-offset-3',
                    'wrapper' => 'col-sm-6 col-md-6',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]); ?>

        <?= $form->field($model, 'creator_id') ?>
        <?= $form->field($model, 'customer_id') ?>

        <div class="form-group">
            <div id="divFromAirport">
                <?=  $form->field($model, 'from_airport')->widget(Select2::classname(),
                    [
                        'data' => $model->airportList,
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'placeholder' => 'Khởi hành',
                            'id'    => 'ddlFromAirport',
                            'name'  => 'from_airport',
                            //'data-url'  => Url::to([Yii::$app->controller->action->id])
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        /*'pluginEvents' => [
                            "select2:select" => "function() {selectdata();}",
                        ]*/
                    ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <div id="divToirport">
                <?=  $form->field($model, 'to_airport')->widget(Select2::classname(),
                    [
                        'data' => $model->airportList,
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'placeholder' => 'Điểm đến',
                            'id'    => 'ddlToAirport',
                            'name'  => 'to_airport',
                            //'data-url'  => Url::to([Yii::$app->controller->action->id])
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        /*'pluginEvents' => [
                            "select2:select" => "function() {selectdata();}",
                        ]*/
                    ]);
                ?>
            </div>
        </div>

    <?= $form->field($model, 'departure') ?>
    <?= $form->field($model, 'return') ?>
    <?= $form->field($model, 'ticket_class_id') ?>
    <?= $form->field($model, 'adult') ?>
    <?= $form->field($model, 'children') ?>
    <?= $form->field($model, 'infant') ?>
    <?= $form->field($model, 'note') ?>
    <?= $form->field($model, 'status') ?>
    <?= $form->field($model, 'processed_by') ?>
    <?= $form->field($model, 'assigned_to') ?>
    <?= $form->field($model, 'checked') ?>
    <?= $form->field($model, 'deleted') ?>
    <?= $form->field($model, 'created_at') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <?php \yii\widgets\Pjax::end() ?>

</div>

