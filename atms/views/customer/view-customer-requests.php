<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
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

$bundle  = \atms\assets\CustomerRequestsAsset::register($this);

$this->title = 'Yêu cầu đặt vé';
//$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index', 'id' => 1]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <?php
    echo Breadcrumbs::widget([
        'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
        'homeLink'  => [
            'label' => 'Home',
            'url'   => Yii::$app->homeUrl,
            'template'  => "<li><span class='fa fa-home'></span> {link}</li>"
        ],
        'links' => [
           // [
              //  'label' => 'Yêu cầu đặt vé',
              //  'url'   => Yii::$app->homeUrl . 'customer',
                //'url' => ['post-category/view', 'id' => 10],
             //   'template' => "<li><b>{link}</b></li>\n", // template for this link only
           // ],
            'Danh sách yêu cầu đặt vé',
        ],
    ]);
    ?>


    <?php Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'custReqModal',
        //'size' => 'modal-lg',
        'options'   => [
            'tabindex' => false, // important for Select2 to work properly
            'data-url' => Url::to([Yii::$app->controller->id . "/customer-request-create"]),
            ],
        //keeps from closing modal with esc key or by clicking out of the modal.
        // user must click cancel or X to close
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]); ?>

        <div id='custReqModalContent'>
            <?php //echo $this->render('_customer-create', ['model' => $customerReqForm]); ?>

        </div>

    <?php Modal::end(); ?>


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


    <div id="divCustomerRequestSection"  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    <?= Html::encode($this->title) ?>
                </h2>
                <span class="span5"></span>
                <?php // Html::a('<span class="fa fa-plus-circle"></span> Thêm', ['customer/customer-request-create'], ['class' => 'btn btn-primary']) ?>



                <ul class="nav navbar-right panel_toolbox pull-right">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    <li>
                        <a class="expand-link" data-target="#divCustomerRequestSection"
                           data-reload="#pjaxCustomerRequestList" ><i class="fa fa-expand"></i></a>
                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div id="CustomerRequestList">

                    <?php Pjax::begin(['id' => 'pjaxCustomerRequests',
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

                    <div class="form-group">
                        <?= Html::input("text", "customer_id", $params['customer_id'], [
                            'class' => 'form-control',
                            'id'    => 'txtCustomerID',
                            'placeholder'   => 'Mã KH',
                            'maxlength' => 20,
                            'data-url'  => Url::to([Yii::$app->controller->action->id])

                        ] ); ?>
                    </div><div class="form-group">
                        <?= Html::input("text", "name", $params['name'], [
                            'class' => 'form-control',
                            'id'    => 'txtCustomerName',
                            'placeholder'   => 'Họ tên khách hàng',
                            'data-url'  => Url::to([Yii::$app->controller->action->id])

                        ] ); ?>
                    </div>
                    <div class="form-group">
                        <?= Html::input("text", "phone_number", $params['phone_number'], [
                            'class' => 'form-control',
                            'id'    => 'txtPhoneNumber',
                            'placeholder'   => 'Số điện thoại',
                            'data-url'  => Url::to([Yii::$app->controller->action->id])

                        ] ); ?>
                    </div>

                    <div class="form-group">
                        <div id="divDistrict">
                            <?=  $form->field($model, 'district_id')->widget(Select2::classname(),
                                [
                                    'data' => $districtList,
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    'options' => [
                                        'placeholder' => 'Khu vực',
                                        'id'    => 'ddlDistrict',
                                        'name'  => 'district_id',
                                        'data-url'  => Url::to([Yii::$app->controller->action->id])
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        // 'dropdownParent' => "#divDistrict"
                                    ],
                                ])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="divProvince">
                            <?=  $form->field($model, 'province_id')->widget(Select2::classname(),
                                [
                                    'data' => $provinceList,
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    'options' => [
                                        'placeholder' => 'Tỉnh/TP',
                                        'id'    => 'ddlProvince',
                                        'name'  => 'province_id',
                                        'data-url'  => Url::to([Yii::$app->controller->action->id])
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],

                                ])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="search" id="btnSearch" class="form-control bg-primary" data-pjax = '1' ><span class="fa fa-search"></span></button>
                    </div>

                    <div class="form-group pull-right">
                        <div id="divSortBy">
                            <?=  $form->field($model, 'sort_by')->widget(Select2::classname(),
                                [
                                    'data' => ['created_at' => 'Ngày tạo', 'updated_at' => 'Ngày cập nhật'],
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    'hideSearch' => true,
                                    'options' => [
                                        'placeholder' => 'Sắp xếp',
                                        'id'    => 'ddlSortBy',
                                        'name'  => 'sort_by',
                                        'data-url'  => Url::to([Yii::$app->controller->action->id])
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    /*'pluginEvents' => [
                                        "select2:select" => "function() {selectdata();}",
                                    ]*/
                                ])->label(false);
                            ?>
                        </div>
                    </div>

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
                                'id' => 'customer-reqs-table-id',
                                'class' => 'table table-striped mytable '
                            ],

                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',

                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function($model, $key, $index, $column){
                                        return GridView::ROW_COLLAPSED;
                                    },
                                    'detail'    => function($model, $key, $index, $column){
                                        $customer = \atms\models\CustomerRequests::findRequestInfo($model->id)->one();

                                        return  Yii::$app->controller->renderPartial("_customer-request-view", [
                                            'model' => $customer
                                        ]);

                                    },
                                    'expandIcon'    => '<span class="fa  fa-chevron-circle-right"></span>',
                                    'collapseIcon'  => '<span class="fa  fa-chevron-circle-down"></span>'

                                ],
                                [   'label' => 'ID KH',
                                    'format' => 'raw',
                                    'value' => function($model)
                                    {
                                        $url = Yii::$app->getUrlManager()->createUrl(['customer/edit-customer-request', 'id' => $model->customer_id ]);

                                        return  Html::a($model->customer_id, $url, ['data-pjax' => 0,
                                            'title' => 'Xem tất cả các yêu cầu', 'class' => 'view_all']);
                                    },

                                    'contentOptions' => [
                                        'class' => 'text-left',
                                        'tabindex' => '0',
                                    ],
                                    'headerOptions' => ['style' => 'max-width:60px'],
                                ],
                                [
                                    'label' => 'Khách hàng',
                                    'format' => 'raw',
                                    'value' => function($model)
                                    {
                                        $url = Yii::$app->getUrlManager()->createUrl(['customer/edit-customer-request', 'id' => $model->customer_id ]);

                                        return  Html::a("<span class='fa " . $model->customerGenderIcon . "'></span> "
                                            . $model->customerFullname, $url, ['data-pjax' => 0,
                                            'title' => 'Xem tất cả các yêu cầu', 'class' => 'view_all']);
                                    },

                                    'contentOptions' => [
                                        'class' => 'text-left',

                                    ],
                                ],
                                [
                                    'header'  => 'SL',
                                    'value'     => function($mode){
                                        return $mode->adult + $mode->children  + $mode->infant;
                                    }
                                ],
                                [
                                    'header' => 'Hành trình',
                                    'format'    => 'raw',
                                    'value' => function($model){
                                        return $model->from_airport . "-" . $model->to_airport;
                                    }
                                ],
                                [
                                    'header'    => 'Ngày đi - về',
                                    'value'     => function($model){
                                        return     \common\utils\StringUtils::DateFormatConverter($model->departure, "Y-m-d", "d/m/y")
                                            . (empty($model->return)?"":" - ") . \common\utils\StringUtils::DateFormatConverter($model->return, "Y-m-d", "d/m/y");
                                    },
                                ],
                                [
                                    'header'    => 'Khu vực',
                                    'value' =>  function($mode){
                                        return $mode->customerInfo->addressProvince;
                                    }

                                ],
                                [
                                    'header'    => 'SĐT',
                                    'format'    => 'raw',
                                    'value' => function($model){
                                        return $model->customerInfo->phone_number;
                                    }
                                ],

                                [
                                    'header'    => 'NV nhập',
                                    'format'    => 'raw',
                                    'value'     => function($model){
                                        return "<span class='tooltipster-borderless pointer' title='". $model->creatorFullname  . "'>". $model->creatorInfo->username ."</span>" ;
                                    },

                                ],

                                [
                                    'header'    => 'NV xử lý',
                                    'format'    => 'raw',
                                    'value'     => function($model){
                                        return "<span class='tooltipster-borderless pointer' title='". $model->handlerFullname  . "'>". (!empty($model->handlerInfo)? $model->handlerInfo->username:'') ."</span>" ;
                                    },
                                ],
                                [
                                    'header'    => 'Ngày nhập',
                                    'value'     => function($model){
                                        return     \common\utils\StringUtils::DateFormatConverter($model->created_at, "Y-m-d H:i:s", "d-m-Y");
                                    },
                                ],
                                [
                                    'header'    => 'Trạng thái',
                                    'contentOptions'   => [
                                        'class' => 'request-statuses',
                                    ],
                                    'value'     => function($model){

                                        if ((int) $model->status == \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_WAITING )
                                        {
                                            return    "<i class='fa fa-clock-o request-status tooltipster-borderless pointer' title='Chờ xử lý'></i>";
                                        }else if ((int) $model->status == \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_CHECKED )
                                        {
                                            return    "<i class='fa fa-check request-status-success tooltipster-borderless pointer' title='Đã xử lý'></i>";

                                        }else if( (int) $model->status ==  \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_CANCELlED)
                                        {
                                            return    "<i class='fa fa-remove request-status-primary tooltipster-borderless pointer' title='Đã huỷ'></i> ";
                                        }else{
                                            return    "";
                                        }



                                    },
                                    'format'    => 'raw'
                                ],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view_all}',
                                    'contentOptions'   => [

                                    ],
                                    'buttons' => [

                                        'view_all' => function($url, $model){
                                            return Html::a(' <i class ="fa fa-list-ul"></i> Tất cả', $url, [
                                                //'title' => Yii::t('app', 'lead-view'),
                                                'title' => 'Xem tất cả yêu cầu',
                                                'class' => ' actions',
                                                'data-pjax' => 0

                                            ]);
                                        }


                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {

                                        if ($action === 'view_all') {
                                            $url =Yii::$app->getUrlManager()->createUrl(['customer/edit-customer-request',
                                                'id' => $model->customer_id]);
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
        </div>
    </div>


</div>
