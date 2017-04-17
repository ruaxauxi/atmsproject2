<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model atms\models\Customer */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-request-view">

    <h1 >MSKH: <?= Html::encode( ArrayHelper::getValue($model, "customer_id")) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => ArrayHelper::getValue($model, "id")], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => ArrayHelper::getValue($model, "id")], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php if ($model) { ?>

        <?= DetailView::widget([
            'model' => $model,
            'options'  => [
                    'class' => 'table table-striped table-bordered detail-view mytable'
            ],
            'attributes' => [
                [
                    'label' => "Họ tên",
                    'value' => $model->customerFullname
                ],
                [
                    'label' => 'SĐT',
                    'value' =>  $model->customerInfo->phone_number
                ],
                [
                    'label' => 'Phái',
                    'value' => "<span class='fa fa-male " . ($model->customerGenderIcon=="fa-male"?"":"icon-grey")  ." fa-md' ></span>"
                        . " <span class='fa fa-female " . ($model->customerGenderIcon=="fa-female"?"":"icon-grey")  ." fa-md' ></span>",
                    'format'    => 'raw'
                ],
                [
                    'label' => 'ĐV công tác',
                    'value' => $model->customerCompanyName
                ],
                [
                        'label' => 'Chặn',
                        'value' => $model->from_airport . "-" . $model->to_airport . " (" . $model->fromAirport->name . " - " .
                            $model->toAirport->name. ")",
                ],

                [
                    'label' => 'Ngày đi',
                    'value' => $model->departure,
                    'format'    => ['date', 'dd-M-Y h:i:s']
                ],
                [
                    'label' => 'Ngày về',
                    'value' => $model->return,
                    'format'    => ['date', 'dd-M-Y']
                ],
                [
                    'label' => 'Số lượng vé',
                    'format'    => 'raw',
                    'value' =>  "<span class='badge bg-green'>$model->adult</span>".  " - người lớn" .
                                (empty($model->children)?"":"; " . "<span class='badge bg-green'>$model->children</span>" . " - trẻ em") .
                                    (empty($model->infant)?"":"; " ."<span class='badge bg-green'>$model->infant</span>" . " - em bé"),
                ],

                [
                    'label' => 'Ghi chú',
                    'value' => $model->note,
                ],
                [
                    'label' => 'Người nhập',
                    'value' => $model->creatorFullname . " (". $model->creator->username .")",
                ],
                [
                    'label' => 'Yêu cầu xử lý',
                    'value' => $model->assignedTo->username,
                ],
                [
                    'label' => 'Người xử lý',
                    'value' =>  isset($model->handlerFullname)? $model->handlerFullname .  " (". $model->processedBy->username .")" : "Chưa xử lý",
                ],

                [
                    'label' => 'Ngày nhập',
                    'value' => $model->departure,
                    'format'    => ['date', 'dd-M-Y h:i:s']
                ],
                [
                    'label' => 'Ngày xử lý',
                    'value' => $model->departure,
                    'format'    => ['date', 'dd-M-Y h:i:s']
                ],


            ],
        ]) ?>


    <?php } else { ?>

        <h4>Không tìm thấy thông tin khách hàng.</h4>

    <?php  } ?>

</div>
