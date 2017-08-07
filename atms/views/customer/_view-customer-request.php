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
        <?= Html::a('<span class="fa fa-edit"></span> Sửa ', ['update', 'id' => ArrayHelper::getValue($model, "id")], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="fa fa-trash"></span> Xoá ', ['delete', 'id' => ArrayHelper::getValue($model, "id")], [
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
                    'label' => "Họ tên khách hàng",
                    'value' => "<i><b>" .$model->customerGenderTextTitle . "</b></i>:  ".  $model->customerFullname,
                    'format' => 'raw'
                ],
                [
                    'label' => 'SĐT',
                    'value' =>  $model->customerInfo->phone_number
                ],
                [
                    'label' => 'ĐV công tác',
                    'value' => $model->customerCompanyName->company
                ],
                [
                    'label' => 'Chặn',
                    'value' => $model->fromAirport->name . " (" . $model->from_airport . ")"  . " - " .
                        $model->toAirport->name. " (" . $model->to_airport .  ")",
                ],

                [
                    'label' => 'Ngày khởi hành',
                    'value' => function($model){
                        $formatter = \Yii::$app->formatter;

                        return "Đi ngày <b>" . $formatter->asDate($model->departure, "dd-MM-yyyy") . "</b> - Về ngày <b>" .
                            ($model->return?$formatter->asDate($model->return, "dd-MM-yyyy") . "</b>":"không đặt</b>");

                    },
                    'format'    => 'raw'

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
                    'value' => $model->examinerFullname . " (" . $model->assignedTo->username . ")",
                ],
                [
                    'label' => 'Người xử lý',
                    'value' =>  isset($model->handlerFullname)? $model->handlerFullname .  " (". $model->processedBy->username .")" : "Chưa xử lý",
                ],

                [
                    'label' => 'Ngày nhập',
                    'value' => $model->departure,
                    'format'    => ['date', 'dd-M-Y H:i:s']
                ],
                [
                    'label' => 'Ngày xử lý',
                    'value' => $model->processed_at,
                    'format'    => ['date', 'dd-M-Y H:i:s']
                ]

            ]
        ]) ?>


    <?php } else { ?>

        <h4>Không tìm thấy thông tin khách hàng.</h4>

    <?php  } ?>

</div>
