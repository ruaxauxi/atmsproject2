<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
// $this->params['breadcrumbs'][] = $this->title;
?>

   <!-- <h1><?= Html::encode($this->title) ?></h1> -->


<div>
   

    <div class="login_wrapper" id="admin-login">
        <div class="">
            <section class="login_content">
                
                <div id="logo"></div>
                    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => true]); ?>


                            <h1> &nbsp &nbsp <span class="fa fa-users"></span> Đăng nhập hệ thống &nbsp &nbsp</h1>
                            <div>
                                 
                                <?= $form->field($model, 'username', [
                                    'template' => '<div class="row"><div>{input}{error}</div></div>'
                                ])->textInput(['autofocus' => true])
                                ?>

                            </div>
                            <div>
                                 
                                 <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
                            </div>
                            <div>
                                <a class="reset_pass"   href="#">Quên mật khẩu?</a>
                                
                                <div class="form-group">
                                    <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>
                                </div>
                                
                            </div>



                    <?php ActiveForm::end(); ?>
                    <div class="clearfix"></div>

                    <div class="separator">


                        <div class="clearfix"></div>
                        <br />

                        <div>
                            
                            <p>©2016 All Rights Reserved.</p>
                        </div>
                    </div>
                </form>
            </section>
    </div>

</div>


