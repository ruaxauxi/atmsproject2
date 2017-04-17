<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use atms\components\LinkPager;
use yii\bootstrap\Modal;
use atms\widgets\depdrop\DepDrop;
use atms\widgets\select2\Select2;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$bundle  = \atms\assets\CustomerRequestAsset::register($this);

$this->title = 'Yêu cầu đặt vé';
//$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index', 'id' => 1]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>
    <h1><?= Html::encode($this->title) ?></h1>



    <?php Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'custReqModal',
        //'size' => 'modal-lg',
        'options'   => [
            'tabindex' => false, // important for Select2 to work properly
            'data-url' => Url::to([Yii::$app->controller->id . "/customer-request-new"]),
            ],
        //keeps from closing modal with esc key or by clicking out of the modal.
        // user must click cancel or X to close
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]); ?>

        <div id='custReqModalContent'>
            <?php //echo $this->render('_customer-create', ['model' => $customerReqForm]); ?>

        </div>

    <?php Modal::end(); ?>

    <button type="button" id="btnCustomerReqNew"
            data-url="<?= Url::to([Yii::$app->controller->id . "/customer-request-new"] ) ;?>"
            class="btn btn-primary" data-toggle="modal">
            <span class="fa fa-plus-circle"></span> Thêm
    </button>

    <!-- Customer detail Modal -->
    <div class="modal fade" id="mdCustomerReqCreate" tabindex="false" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">
                    <div id="divCustReqForm">

                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <!-- Customer Request detail Modal -->
    <div class="modal fade" id="customerReqDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <p>
        <?= ""//Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div id="customerReqList">

        <?php Pjax::begin(['id' => 'customer_req_list',
            'timeout' => false,
            'enablePushState' => true,
            'clientOptions' => ['method' => 'POST'],

        ]); ?>

        <?php $form = ActiveForm::begin([
            'id'    => 'frmCustomerRequests',

            'options' => [
                    'data-pjax' => true ,
                    'class' => 'form-inline',
                    'data-url'  => Url::to([Yii::$app->controller->action->id])
            ]
        ]); ?>

        <hr class="space5"/>
        <?= GridView::widget(
            [
                    'dataProvider' => $dataProvider,
                    'summary' => "Hiển thị {begin}-{end} trong tổng số <b>{totalCount}</b> yêu cầu",
                    //'layout'=>"{sorter}\n{pager}\n{summary}\n{items}",
                    'layout'=>"<p>{summary}</p>{items}<p>{summary}</p>{pager}<hr class='space5'/>",
                    'pager'  => [
                        'class' => 'atms\components\LinkPager',
                        'pageSizeOptions' => [
                            'class' => 'form-control per-page',
                            'id'    => 'per-page'
                        ],

                        'options'=>[
                                'class'=>'pagination',
                                'id'    => 'paginator'
                        ],   // set clas name used in ui list of pagination
                        'prevPageLabel' => '<span class="fa fa-angle-double-left"></span>',   // Set the label for the "previous" page button
                        'nextPageLabel' => '<span class="fa fa-angle-double-right"></span>',   // Set the label for the "next" page button
                        'firstPageLabel'=> '<span class="fa fa-step-backward"></span>',    // Set the label for the "first" page button
                        'lastPageLabel'=>'<span class="fa fa-step-forward"></span>',    // Set the label for the "last" page button
                        'nextPageCssClass'=>'next',    // Set CSS class for the "next" page button
                        'prevPageCssClass'=>'prev',    // Set CSS class for the "previous" page button
                        'firstPageCssClass'=>'first',    // Set CSS class for the "first" page button
                        'lastPageCssClass'=>'last',    // Set CSS class for the "last" page button
                        'maxButtonCount'=>10,    // Set max
                    ],
                    'rowOptions' => function($model, $key, $index, $grid){
                        return [
                            'id' => $model->id,
                            'data'  => [
                                'customer_req_id' => $model->id,
                                //'toggle'   => 'modal',
                                'target'    => '#customerReqDetailModal',
                               // 'customer_fullname' => $model->personFullName,
                                //'url'   => Url::to(['/customer/view-details', 'id' => $model->id])
                                'url' => Yii::$app->getUrlManager()->createUrl(['customer/customer-request-view', 'id' => $model->id ])
                            ],
                            //'class' => ($index +1 ) % 2 == 0? 'customers even pointer parent' : 'customers odd pointer parent',
                            'class' => 'customer  parent',
                            'title' => 'Nhấp đúp để xem thông tin chi tiết.'
                        ];
                    },
                    'afterRow'  => function ($model, $key, $index, $grid){
                        //return "<tr role='row' class='child' > <td  class='child' colspan='7' >" . $model->street ."</td></tr>";
                    },
                    'options' => [
                        'class' => 'table-responsive',
                        'id'    => 'customer-req-table'
                    ],

                    'tableOptions' => [
                        'id' => 'customer-req-table-id',
                        'class' => 'table table-striped mytable '
                    ],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',

                        ],
                        [   'label' => 'ID KH',
                            'attribute' => 'customer.id',

                            'contentOptions' => [
                                'class' => 'text-left',
                                'tabindex' => '0',
                            ],
                            'headerOptions' => ['style' => 'max-width:60px'],
                        ],
                        [
                            'label' => 'Khách hàng',
                            'format' => 'html',
                            'value' => function($model)
                            {
                                return   "<span class='fa " . $model->customerGenderIcon . "'></span> " . $model->customerFullname;
                            },


                            'contentOptions' => [
                                'class' => 'text-left',

                            ],
                        ],
                        [
                            'header'    => 'SĐT',
                            'format'    => 'raw',
                            'value' => function($model){
                                return $model->customerInfo->phone_number;
                            }
                        ],
                        [
                            'header' => 'Chặn',
                            'format'    => 'raw',
                            'value' => function($model){
                                return $model->from_airport . "-" . $model->to_airport;
                            }
                        ],
                        [
                                'header'    => 'Ngày đi',
                                'format'    => ['date', 'dd-mm-Y'],
                                'attribute' => 'departure'
                        ],
                        [
                            'header'    => 'Ngày về',
                            'format'    => ['date', 'dd-mm-Y'],
                            'attribute' => 'return'
                        ],
                        [
                                'header'    => 'Người nhập',
                                'value' => $model->creator //->firstname // . " (" . $model->creator->username . ")",
                        ],
                        [
                            'header'    => 'Yêu cầu xử lý',
                            'attribute' => 'assignedTo.username'
                        ],
                        [
                            'header'    => 'Xử lý bởi',
                            'attribute' => 'processedBy.username'
                        ],
                        [
                            'header'    => 'Ngày nhập',
                            'format'    => ['date', 'dd-mm-Y'],
                            'attribute' => 'created_at'
                        ],
                        [
                            'header'    => 'Ngày xử lý',
                            'format'    => ['date', 'dd-mm-Y'],
                            'attribute' => 'processed_at'
                        ],

                        [
                             'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                            'buttons' => [
                             'view' => function ($url, $model) {
                                 return Html::a('<i class ="fa fa-th"></i>', $url, [
                                     //'title' => Yii::t('app', 'lead-view'),
                                     'title' => 'Xem chi tiết',
                                     'class' => ' view-customer',
                                     'data-customer_fullname' => "",
                                 ]);
                             },


                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                 if ($action === 'view') {
                                     $url =Yii::$app->getUrlManager()->createUrl(['customer/customer-request-view', 'id' => $model->id ]);
                                     return $url;
                                 }

                                 if ($action === 'update') {
                                     $url ='index.php?r=client-login/lead-update&id='.$model->id;
                                     return $url;
                                 }
                                 if ($action === 'delete') {
                                     $url ='index.php?r=client-login/lead-delete&id='.$model->id;
                                     return $url;
                                 }

                              }
                        ],
                    ]
        ]); ?>

        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
