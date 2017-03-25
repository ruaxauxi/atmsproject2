<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập hệ thống';
// $this->params['breadcrumbs'][] = $this->title;
?>

   <!-- <h1><?= Html::encode($this->title) ?></h1> -->



<div class="login-wrapper"  >         
    <section class="login_content">
        <div class="clearfix"></div>
        <div id="loginForm">
            <div class="login-form">
                <div id="logo"></div>
                <?php
                $form = ActiveForm::begin([
                            'id' => 'login-form',
                            //'options' => ['class' => 'form-horizontal'],
                            'enableClientValidation' => true,
                            'enableAjaxValidation' => false,
                            'validateOnSubmit' => true,
                            'validateOnChange' => true,
                            'validateOnType' => true,
                            'action' => '/login',
                                //'validationUrl' => 'yourvalidationurl'
                ]);
                ?>
                <h1 id="login_title"> <span class="login-icon"></span> HỆ THỐNG QUẢN LÝ </h1>

                <?=
                $form->field($model, 'username', [
                    'template' => '<div>{input}{error}</div>',
                    'inputOptions' => [
                        'id' => 'username',
                        'maxlength' => 20,
                        'class' => '',
                        'placeholder' => "Tên đăng nhập"
                    ],
                ])->textInput(['autofocus' => false])->label(false)
                ?>

                <?=
                $form->field($model, 'password', [
                    'template' => '<div>{input}{error}</div>',
                    'inputOptions' => [
                        'id' => 'password',
                        'class' => '',
                        'placeholder' => "Mật khẩu"
                    ],
                ])->passwordInput(['autofocus' => false])->label(false)
                ?>
                <div class="checkbox" id="rememberme">
                    <?=
                    $form->field($model, 'rememberMe')->checkbox(
                            [
                                'id' => 'rememberMe',
                                'class' => '',
                                'checked' => '',
                                'value' => 0
                    ])->label('Đăng nhập tự động lần sau');
                    ?>
                </div>
                <?= Html::submitButton('<span class="fa fa-unlock-alt"></span> Đăng nhập', ['class' => 'btn btn-danger submit', 'id' => 'btn-submit', 'name' => 'login-button']) ?>
                <div class="clearfix"></div>
                <br/>                                
                <br/>

                <?= Html::a("Quên mật khẩu đăng nhập?", "/forgot-password", ['id' => 'reset-pass']) ?>

                    <?php if ($model->loginFailedMsg) { ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                    <?= $model->loginFailedMsg ?>
                    </div>
                <?php } ?>
        <?php ActiveForm::end(); ?></form>
            </div>
        </div>
    </section>
    <div>
        <div class="separator"></div>
        <p>©<?php echo date("Y", time()); ?> All Rights Reserved.</p>
    </div>



</div>
