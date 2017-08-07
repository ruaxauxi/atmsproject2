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
use yii\widgets\Breadcrumbs;


/* @var $this yii\web\View */
/* @var $model atms\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$bundle  = \atms\assets\CustomerRequestAsset::register($this);

?>


<div id="customer-request-create-new-customer-form">

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
            //['label' => 'Sample Post', 'url' => ['post/edit', 'id' => 1]],
            'Thêm Khách hàng mới',
        ],
    ]);
    ?>
    <br/>

    <?php \yii\widgets\Pjax::begin(['id' => 'customer_create_new',
        'timeout' => false,
        'enablePushState' => true,
        'clientOptions' => ['method' => 'POST'],

    ]); ?>
    <?php $form = ActiveForm::begin([
        'action' => Url::to([Yii::$app->controller->id .  "/customer-request-create-step1"]),
        'options'   => [
            'id' => 'frmCustomerRequestCreateNewCustomer',
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
        'placeholder'   => 'Nguyễn Văn A',
        'class' => 'form-control',
        'autofocus' => 'autofocus',
        'tabindex'  => 1
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
            'name'  => 'phone_number',
            'autofocus' => 'autofocus',
            'tabindex'  => 2
        ]
    ]) ?>


    <?= $form->field($model, 'gender', [
        // 'radioTemplate' => '<label class="gender-head">{label}</label><label class="signup-radio">{input}</label>'
    ])->inline()->radioList([\atms\models\Person::PERSON_FEMALE => ' Nữ ', \atms\models\Person::PERSON_MALE => " Nam "],
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

                $return = '<label class="btn btn-default no-asterisk genderLabel" autofocus tabindex="'. ($index +3) .'" data-toggle-class="btn-default" data-toggle-passive-class="btn-default" >';
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
            'name' => 'email',
            'autofocus' => 'autofocus',
            'tabindex'  => 5
        ]
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
            'placeholder'   => '1/1/19xx',
            'autofocus' => 'autofocus',
            'tabindex'  => 6
        ]
    ]) ?>
    <?= $form->field($model, 'ssn')->textInput([
        'id'    => 'txtSsn',
        'class' => 'form-control',
        'name'  => 'ssn',
        'autofocus' => 'autofocus',
        'tabindex'  => 7
    ]) ?>

    <div class="row">
        <div class="col-sm-3 col-md-3"></div>
        <div class="col-sm-6 col-md-6">
            <p>Địa chỉ liên hệ</p>
        </div>
    </div>
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
                        'autofocus' => 'autofocus',
                        'tabindex'  => 8
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
                    'placeholder'=>'Chọn phường/xã',
                    'id'=>'ddlCustWard',
                    'name'  => 'ward_id',
                    'autofocus' => 'autofocus',
                    'tabindex'  => 9

                ],
                'pluginOptions'=>[
                    'depends'=>['ddlCustArea'],

                    'url'=>Url::to(['/customer/load-ward']),

                    //'params'=>['city' => 'ddlCustCity'],
                ],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>[
                    'theme' => Select2::THEME_BOOTSTRAP,

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
        'autofocus' => 'autofocus',
        'tabindex'  => 10
    ]) ?>
    <?= $form->field($model, 'house_number')->textInput([
        'id'    => 'txtHouseNumber',
        'class' => 'form-control',
        'name'  => 'house_number',
        'autofocus' => 'autofocus',
        'tabindex'  => 11
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
                        'autofocus' => 'autofocus',
                        'tabindex'  => 12
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
        <div class="col-sm-3 col-md-3"></div>
        <div class="col-sm-6 col-md-6">

            <?= Html::a('<span class="fa fa-undo"></span> Quay lại ', ['customer/customer-request-create'], ['class' => 'btn btn-default ']) ?>

            <?= Html::submitButton('<span class="fa  fa-chevron-circle-right"></span> Tiếp tục ',
                [
                    'class' =>  ($model->isNewRecord() ? 'btn btn-success' : 'btn btn-primary') . ' pull-right ' ,
                    'id'    => 'btnCustomerSave'
                ]
            ) ?>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

    <?php \yii\widgets\Pjax::end() ?>

</div>
