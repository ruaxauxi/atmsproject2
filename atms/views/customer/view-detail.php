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
<div class="customer-view">

    <h1 >MSKH: <?= Html::encode( ArrayHelper::getValue($model, "id")) ?></h1>

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
        'attributes' => [
            [
                    'label' => "Họ tên",
                     'value' => $model->personFullName
            ],
            [
                    'label' => 'SĐT',
                    'value' =>  $model->personPhoneNumber
            ],
            [
                'label' => 'Phái',
                'value' => "<span class='fa fa-male " . ($model->personGenderIcon=="fa-male"?"":"icon-grey")  ." fa-md' ></span>"
                    . " <span class='fa fa-female " . ($model->personGenderIcon=="fa-female"?"":"icon-grey")  ." fa-md' ></span>",
                'format'    => 'raw'
            ],
            [
                    'label' => 'ĐV công tác',
                    'value' => $model->companyName
            ],
            [
                'label' => 'Ngày sinh',
                'value' => $model->personBirthdate,
                'format'    => ['date', 'dd-M-Y'],
            ],
            [
                'label' => 'Email',
                'value' => $model->personEmail
            ],

            [
                'label' => 'Khu vực',
                'value' => $model->addressArea
            ],
            [
                'label' => 'Địa chỉ',
                'value' => $model->addressFullAddress
            ],
            [
                    'label' => 'Ngày tạo',
                    'value' => $model->personCreatedAt,
                    'format'    => ['date', 'dd-M-Y h:i:s']
            ],
            [
                    'label' => 'Ngày cập nhật',
                    'value' => $model->personUpdatedAt,
                    'format'    => ['date', 'dd-M-Y']
            ],


        ],
    ]) ?>

    <?php $i = 1; if ($model->addresses){  ?>
        <table class="table table-striped mytable">
            <thead>
                <th>#</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th>Tỉnh/TP</th>
                <th>Ngày cập nhật</th>
            </thead>
                <?php foreach($model->addresses as $add) { ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $add->phone; ?></td>
                    <td>
                        <?php
                        $a = [];
                        $a[] = $add->house_number;
                        $a[] = $add->street;
                        $a[] = $add->ward;
                        $a[] = $add->district;

                        echo implode(", ", array_filter($a));

                        ?>
                    </td>
                    <td><?= $add->city; ?></td>
                    <td><?= \DateTime::createFromFormat("Y-m-d H:i:s", $add->created_at)->format("d-m-Y H:i:s"); ?></td>
                </tr>
              <?php  } ?>
            <tbody>

            </tbody>
        </table>


    <?php } ?>
    <?php } else { ?>

        <h4>Không tìm thấy thông tin khách hàng.</h4>

   <?php  } ?>

</div>
