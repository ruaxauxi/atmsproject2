<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model atms\models\CustomerForm */
/* @var $form ActiveForm */
?>
<div class="customer-customercreate">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'password') ?>
        <?= $form->field($model, 'gender') ?>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'middlename') ?>
        <?= $form->field($model, 'birthdate') ?>
        <?= $form->field($model, 'ssn') ?>
        <?= $form->field($model, 'phone_number') ?>
        <?= $form->field($model, 'street') ?>
        <?= $form->field($model, 'ward') ?>
        <?= $form->field($model, 'district') ?>
        <?= $form->field($model, 'city') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'house_number') ?>
        <?= $form->field($model, 'person_created_at') ?>
        <?= $form->field($model, 'person_updated_at') ?>
        <?= $form->field($model, 'address_created_at') ?>
        <?= $form->field($model, 'is_current') ?>
        <?= $form->field($model, 'address_deleted') ?>
        <?= $form->field($model, 'company_id') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('admin', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- customer-customercreate -->
