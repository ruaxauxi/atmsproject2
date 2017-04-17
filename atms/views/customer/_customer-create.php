<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use atms\widgets\select2\Select2;
use atms\widgets\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model atms\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">


    <?php \yii\widgets\Pjax::begin() ?>
    <?php $form = ActiveForm::begin([
        'action' => Url::to([Yii::$app->controller->id .  "/create"]),
        'options'   => [
                'id' => 'frmCustomerCreate',
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

    <?= $form->field($model, 'fullname')->textInput([
        'id'    => 'txtFullname',
        'name'  => 'fullname',
        'placeholder'   => 'Nguyễn Văn A'
    ]) ?>

    <?= $form->field($model, 'phone_number')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '9{4} 9{3} 9{3,4}',
            'clientOptions' => [
                    'greedy' => false
            ],
            'options'   => [
                    'id'    => 'txtPhoneNumber',
                    'class' => 'form-control',
                    'placeholder'   => '0939109xxx',
                    'name'  => 'phone_number'
            ]
    ]) ?>


    <?= $form->field($model, 'gender', [
           // 'radioTemplate' => '<label class="gender-head">{label}</label><label class="signup-radio">{input}</label>'
        ])->inline()->radioList([\atms\models\Person::PERSON_FEMALE => 'Nữ', \atms\models\Person::PERSON_MALE => "Nam"],
                [
                    'options' => [
                        'id'    => 'txtStreet',
                       // 'class' => 'form-control',
                        'name'  => 'gender',
                    ],
                    'separator' => '',
                    'class' => 'btn-group',
                    'data-toggle' => 'buttons',
                    'item' => function($index, $label, $name, $checked, $value) {

                        $return = '<label class="btn btn-default no-asterisk genderLabel" data-toggle-class="btn-default" data-toggle-passive-class="btn-default" >';
                        $return .= '<input type="radio" name="gender" value="' . $value . '">';
                        $return .= ' &nbsp; ' . ucwords($label) . ' &nbsp;';
                        $return .= '</label>';

                        return $return;
                    },

                ]
    ) ?>

    <?= $form->field($model, 'email')->widget(\yii\widgets\MaskedInput::className(), [

        'clientOptions' => [
            'greedy' => false,
            'alias' =>  'email'
        ],
        'options'   => [
            'id'    => 'txtEmail',
            'class' => 'form-control',
            'placeholder'   => 'vhdang.xyz@gmail.com',
            'name' => 'email'
        ]
    ]) ?>

    <div class="form-group">
        <div id="divCustProvince">
            <?=  $form->field($model, 'area')->widget(Select2::classname(),
                [
                    'data' => $model->area,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => 'Khu vực',
                        'id'    => 'ddlCustArea',
                        'name'  => 'area',
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
        <div id="divCustWard">
            <?= $form->field($model, 'ward_id')->widget(DepDrop::classname(), [
                'options'=>[
                    'id'=>'ddlCustWard',
                    'name'  => 'ward_id'
                ],
                'pluginOptions'=>[
                    'depends'=>['ddlCustArea'],
                    'placeholder'=>'Chọn phường/xã',
                    'url'=>Url::to(['/customer/load-ward']),
                    //'params'=>['city' => 'ddlCustCity'],
                ],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>[
                    'pluginOptions'=>[
                        'allowClear'=>true
                    ]
                ],

            ]);
            ?>
        </div>
    </div>

    <?= $form->field($model, 'street')->textInput([
            'id'    => 'txtStreet',
            'class' => 'form-control',
            'name'  => 'street',
    ]) ?>
    <?= $form->field($model, 'house_number')->textInput([
        'id'    => 'txtHouseNumber',
        'class' => 'form-control',
        'name'  => 'house_number',
    ]) ?>
    <?= $form->field($model, 'birthdate')->widget(\yii\widgets\MaskedInput::className(), [
        'mask'  => '9{1,2}/9{1,2}/9999',
        'clientOptions' => [
            'greedy' => false,

        ],
        'options'   => [
            'id'    => 'txtBirthdate',
            'name'  => 'birthdate',
            'class' => 'form-control',
            'placeholder'   => '1/1/19xx'
        ]
    ]) ?>
    <?= $form->field($model, 'ssn')->textInput([
        'id'    => 'txtSsn',
        'class' => 'form-control',
        'name'  => 'ssn',
    ]) ?>


    <div class="form-group">
        <div id="divCustProvince">
            <?=  $form->field($model, 'company_id')->widget(Select2::classname(),
                [
                    'data' => $model->companyList,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => 'Đơn vị công tác',
                        'id'    => 'ddlCustCompany',
                        'name'  => 'company_id',
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

        <?= Html::button('<span class="fa fa-power-off"></span> Đóng', [
                'class' => 'btn btn-primary pull-right',
                'id' => 'btnCustomerCreateClose',
                'data-dismiss'  =>'modal',
            ]
        ) ?>
        <?= Html::submitButton($model->isNewRecord() ? '<span class="fa fa-floppy-o"></span> Lưu' : '<span class="fa fa-floppy-o"></span> Cập nhật',
            [
                'class' =>  ($model->isNewRecord() ? 'btn btn-success' : 'btn btn-primary') . ' pull-right ' ,
                'id'    => 'btnCustomerSave'
            ]
        ) ?>

    </div>



    <?php ActiveForm::end(); ?>

<?php \yii\widgets\Pjax::end() ?>

</div>
