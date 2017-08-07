<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model atms\models\CustomerInfo */
/* @var $form ActiveForm */
?>
<div class="customer-customer-info">

    <div class="container-fluid">
         <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <?= $form->field($model, 'id', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>

            </div>
            <div class="row">
                <?= $form->field($model, 'user_id', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'person_id', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>

            </div>
        <div class="row">
        <?= $form->field($model, 'address_id', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>

        </div>
        <div class="row">
        <?= $form->field($model, 'deleted', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'status', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'usertype', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'gender', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'firstname', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'lastname', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'middlename', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'ssn', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'created_at', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'updated_at', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'last_login', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'last_updated', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'user_created_at', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'address_updated_at', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'username', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'email', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
        <div class="row">
        <?= $form->field($model, 'avatar', [
                    'template' => '<div class="col-md-2">{label}</div><div class="col-md-4">{input}{error}</div>',
                ]) ?>
        </div>
         

        <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>

    </div>

</div><!-- customer-customer-info -->
