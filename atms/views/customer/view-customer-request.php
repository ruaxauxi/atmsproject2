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

use yii\bootstrap\ActiveForm;

use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;

use atms\components\LinkPager;
use yii\bootstrap\Modal;
use atms\widgets\depdrop\DepDrop;
use atms\widgets\select2\Select2;
use atms\widgets\datepicker\DatePicker;
use atms\widgets\switchinput;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$bundle  = \atms\assets\CustomerRequestAsset::register($this);

$this->title = 'Yêu cầu đặt vé';
//$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index', 'id' => 1]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-request-index">

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

    <div class="modal fade" id="customerReqDeleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalTitle">Xoá yêu cầu</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="id" data-url="" value="" >
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnDelete" class="btn btn-primary" value="" > <span class="fa fa-trash"></span> Xoá</button>
                    <button type="button" id="btnClose" class="btn btn-success" data-dismiss="modal"><span class="fa fa-power-off"></span> Close</button>
                </div>
            </div>
        </div>
    </div>


    <div id="divCustomerRequestSection"  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    <?= Html::encode($this->title) ?>
                    | <i>MSKH:</i>  <strong><?= $customer->id; ?>
                    | </strong><i><?= $customer->personTitle . ' :</i> <strong>' . $customer->personFullName . '</strong>'; ?>
                    |  <strong><?= $customer->addressProvince; ?></strong>

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

                <div id="customerRequestList">

                    <?php Pjax::begin(['id' => 'customer_req_list',
                        'timeout' => false,
                        'enablePushState' => true,
                        'clientOptions' => ['method' => 'POST'],

                    ]); ?>

                    <?php $form = ActiveForm::begin([
                        'action' => Url::to([Yii::$app->controller->id .  "/customer-request?id=" . $customer->id]),
                        'options'   => [
                            'id' => 'frmCustomerRequest',
                            'data-pjax' => true ,
                            'data-url'  => Url::to([Yii::$app->controller->action->id])
                        ],
                        'enableClientValidation'    => true,
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

                    <div class="well well-sm">
                        <i>Liên hệ: </i>
                        <span class="fa fa-phone-square"></span> <?=
                          $customer->personPhoneNumber
                        .';  <span class="fa  fa-envelope"></span>: ' . $customer->personEmail
                        .";  <span class=\"fa  fa-home\"></span> " . $customer->addressFullAddress . '<br/>';
                        ?>
                    </div>

                    <br/>
                    <?= Html::hiddenInput("request_id", $request_id); ?>
                    <div class="form-group">
                        <div id="divFromAirport">
                            <?=  $form->field($model, 'from_airport')->widget(Select2::classname(),
                                [
                                    'data' => $model->airportList,
                                    'theme' => Select2::THEME_BOOTSTRAP,

                                    'options' => [
                                        'placeholder' => 'Sân bay đi - đến',
                                        'multiple' => true,
                                        'id'    => 'ddlFromAirport',
                                        'name'  => 'from_airport',
                                        'tabindex'  => 1

                                    ],
                                   'maintainOrder' => true,
                                    'showToggleAll' => false,
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        //'tags' => true,
                                       // 'maximumInputLength' => 2,
                                        'maximumSelectionLength'  => 2,
                                        'hideSearch' => false,

                                    ],

                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="divTicketClass">
                            <?=  $form->field($model, 'ticket_class_id')->widget(Select2::classname(),
                                [
                                    'data' => $model->ticketClassList,
                                    'theme' => Select2::THEME_BOOTSTRAP,

                                    'options' => [
                                        'placeholder' => 'Hạng vé',
                                        'id'    => 'ddlTicketClass',
                                        'name'  => 'ticket_class_id',
                                        'tabindex'  => 2

                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],

                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group  field-customerrequestform-departure required">
                        <label class="control-label col-sm-3 col-md-3" for="customerrequestform-departure">Ngày khởi hành</label>
                        <div class="col-sm-6 col-md-6">
                            <div class="controls form-inline">

                                <?= $form->field($model,'departure',[
                                    'options'   => [
                                        'tag'   => false,
                                    ],
                                    'template' => '{input}{error}'
                                ])->widget(DatePicker::className(),
                                    [
                                        'model' => $model,
                                        'attribute' => 'departure',
                                        'language' => 'vi',

                                        //'dateFormat' => 'php:Y-m-d',
                                        'options' => [
                                            'placeholder' => 'ngày đi',
                                            'tabindex'  => 3,
                                            'id'    => 'departureDate',
                                            'value' => Date("d-m-Y"),
                                        ],

                                        'pluginOptions' => [
                                            'format' => 'dd-mm-yyyy',
                                            'todayHighlight' => true,
                                            'autoclose'=>true,
                                            'daysOfWeekHighlighted' => [0,6],
                                            'weekStart' => 1,
                                            'startDate'   => date('d-m-Y', strtotime('-1 weeks')),
                                            'endDate'   =>  date('d-m-Y', strtotime('+1 years')),
                                        ],

                                    ]);

                                ?>
                                <?= $form->field($model,'return',[
                                    'options'   => [
                                        'tag'   => false,
                                    ],
                                    'template' => '{input}{error}'
                                ])->widget(DatePicker::className(),
                                    [
                                        'model' => $model,
                                        'attribute' => 'return',
                                        'language' => 'vi',
                                        //'dateFormat' => 'php:Y-m-d',
                                        'options' => [
                                            'placeholder' => 'ngày về',
                                            'tabindex'  => 4,
                                            'id'    => 'returnDate'
                                        ],
                                        'pluginOptions' => [
                                            'format' => 'dd-mm-yyyy',
                                            'todayHighlight' => true,
                                            'autoclose'=>true,
                                            'daysOfWeekHighlighted' => [0,6],
                                            'weekStart' => 1,
                                            'startDate'   => '0d',
                                            'endDate'   =>  date('d-m-Y', strtotime('+1 years')),

                                        ],

                                    ]);

                                ?>

                            </div>

                        </div>
                    </div>

                    <div class="form-group  field-customerrequestform-adult required">
                        <label class="control-label  col-sm-3 col-md-3" for="adult">Số lượng vé</label>
                        <div class="col-sm-6 col-md-6">
                            <div class="controls form-inline" id="divTickets">

                                <?= \atms\widgets\touchspin\TouchSpin::widget([
                                    'model' => $model,
                                    'attribute' => 'adult',
                                    'pluginOptions' => [
                                        'buttonup_class' => 'form-control btn-default',
                                        'buttondown_class' => 'form-control btn-default',
                                        'buttonup_txt' => '<i class="fa fa-chevron-circle-up"></i>',
                                        'buttondown_txt' => '<i class="fa fa-chevron-circle-down"></i>',
                                        'initval' => 1,
                                        'min'   => 1

                                    ],
                                    'options'   => [
                                        'name' => 'adult',
                                        'id'    => 'adult',
                                        'tabindex'  => 5,
                                        'class' => 'tickets'
                                    ]
                                ]);
                                ?>
                                <div class="help-block help-block-error " style="display: none;"></div>
                                <label class="control-label no-asterisk" for="adult">Người lớn</label>

                                <?= \atms\widgets\touchspin\TouchSpin::widget([
                                    'model' => $model,
                                    'attribute' => 'children',
                                    'pluginOptions' => [
                                        'buttonup_class' => 'form-control btn-default',
                                        'buttondown_class' => 'form-control btn-default',
                                        'buttonup_txt' => '<i class="fa fa-chevron-circle-up"></i>',
                                        'buttondown_txt' => '<i class="fa fa-chevron-circle-down"></i>',
                                        'initval' => 0,

                                    ],
                                    'options'   => [
                                        'name' => 'children',
                                        'id'    => 'children',
                                        'tabindex'  => 6,
                                        'class' => 'tickets'
                                    ]
                                ]);
                                ?>
                                <label class="control-label no-asterisk" for="children">Trẻ em</label>
                                <?= \atms\widgets\touchspin\TouchSpin::widget([
                                    'model' => $model,
                                    'attribute' => 'infant',
                                    'pluginOptions' => [
                                        'buttonup_class' => 'form-control btn-default',
                                        'buttondown_class' => 'form-control btn-default',
                                        'buttonup_txt' => '<i class="fa fa-chevron-circle-up"></i>',
                                        'buttondown_txt' => '<i class="fa fa-chevron-circle-down"></i>',
                                        'initval' => 0,

                                    ],
                                    'options'   => [
                                        'name' => 'infant',
                                        'id'    => 'infant',
                                        'tabindex'  => 7,
                                        'class' => 'tickets'
                                    ]
                                ]);
                                ?>
                                <label class="control-label no-asterisk" for="infant">Em bé</label>

                                <div class="help-block help-block-error " style="display: none;"></div>
                            </div>
                        </div>

                    </div>



                    <?= $form->field($model, 'note')->textarea([

                        'rows'  => 2,
                        'id'    => 'txCustomerRequesttNote',
                        'name'  => 'note',
                        'tabindex'  => 8



                    ]) ?>



                    <div class="form-group ">
                        <label class="control-label col-sm-3 col-md-3" for=""></label>
                        <div class="col-sm-6 col-md-6">
                            <?php
                                $return = Yii::$app->request->getQueryParam("return");
                                $return_url = "";
                                $return_url = urldecode($return);
                            ?>

                            <?php if ($return_url) { ?>
                            <?= Html::a('<span class="fa fa-undo"></span> Quay lại ', '/customer/customer-request-create?' . $return_url, ['class' => 'btn btn-default ']) ?>
                            <?php } else { ?>
                                <?= Html::a('<span class="fa fa-undo"></span> Quay lại ', '/customer/customer-requests', ['class' => 'btn btn-default ']) ?>

                            <?php } ?>
                            <?= Html::submitButton('<span class="fa '. ($request_id?"fa-floppy-o":"fa-plus-circle") .' "></span> ' . ($request_id?' Lưu':' Thêm'),
                                [
                                    'class' => 'btn btn-'. ($request_id?"success":"primary") .' pull-right',
                                    'id'    => $request_id?'btnUpdateRequest':'btnAddNewRequest',
                                    'data-pjax' => true,
                                ]) ?>

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
                                    'id'    => 'paginator',
                                    'data-pjax' => true ,
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
                                        'target'    => '#customerReqDetailModal',
                                        'url' => Yii::$app->getUrlManager()->createUrl(['customer/customer-request-view', 'id' => $model->id ])
                                    ],
                                    'class' => 'customer  parent',
                                    'title' => ''
                                ];
                            },
                            'afterRow'  => function ($model, $key, $index, $grid){
                                //return "<tr role='row' class='child' > <td  class='child' colspan='7' >" . $model->street ."</td></tr>";
                            },
                            'options' => [
                                'class' => 'table-responsive',
                                'id'    => 'customer-req-gridview'
                            ],

                            'tableOptions' => [
                                'id' => 'customer-req-table-id',
                                'class' => 'table table-striped mytable '
                            ],
                            'pjax'  => true,


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
                                [
                                    'header'    => 'Ngày đi - về',
                                    'value'     => function($model){
                                        return     \common\utils\StringUtils::DateFormatConverter($model->departure, "Y-m-d", "d/m/y")
                                            . (empty($model->return)?"":" - ") . \common\utils\StringUtils::DateFormatConverter($model->return, "Y-m-d", "d/m/y");
                                    },
                                ],
                                [
                                    'header' => 'Hành trình',
                                    'format'    => 'raw',
                                    'value' => function($model){
                                        return $model->from_airport . "-" . $model->to_airport;
                                    }
                                ],

                                [
                                    'header'  => 'SL',
                                    'value'     => function($mode){
                                        return $mode->adult + $mode->children  + $mode->infant;
                                    }
                                ],

                                [
                                    'header'    => 'NV xử lý',
                                    'format'    => 'raw',
                                    'value'     => function($model){
                                        return "<span class='tooltipster-borderless pointer processed-by' title='". $model->handlerFullname  . "'>". (!empty($model->handlerInfo)? $model->handlerInfo->username:'') ."</span>" ;
                                    },
                                ],
                                [
                                    'header'    => 'Ngày nhập',
                                    'value'     => function($model){
                                        return     \common\utils\StringUtils::DateFormatConverter($model->created_at, "Y-m-d H:i:s", "d-m-Y H:I:s");
                                    },
                                ],
                                [
                                    'header'    => 'Trạng thái',
                                    'contentOptions'   => [
                                        'class' => 'request-statuses',
                                    ],
                                    'value'     => function($model){

                                        if ((int) $model->status == \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_WAITING || $model->status == null )
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

                                    'class' => 'yii\grid\DataColumn',
                                    'format' => 'raw' ,         // format use to display data
                                    'header' => 'Đã xử lý',        // header of column
                                    'value' => function($model, $key, $index, $column){

                                        $input =  '<input type="checkbox" class="chkRequestStatus" '
                                            .  (($model->checked == 1)?"checked":'')
                                            . ' data-toggle="toggle" data-size="small" data-onstyle="success"
                                               data-url="'. Yii::$app->getUrlManager()->createUrl(['customer/update-customer-request-status']) .'"
                                               data-id="' . $model->id .  '" 
                                               data-width="48" data-height="22" data-on="Yes" data-off="No" >';
                                        return $input;
                                    },
                                    'contentOptions' => [
                                        'style' => 'width:65px;',
                                        'text-align' => 'center',

                                    ],
                                ],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{edit}{delete}',
                                    'buttons' => [
                                       /* 'view' => function ($url, $model) {
                                            return Html::a('<i class ="fa fa-eye"></i> Xem ', $url, [
                                                //'title' => Yii::t('app', 'lead-view'),
                                                'title' => 'Xem chi tiết',
                                                'class' => ' actions action-view',
                                                'data-customer_fullname' => "",
                                            ]);
                                        },*/
                                        'delete'    => function($url, $model)
                                        {
                                            return Html::a('<i class ="fa fa-trash"></i> Xoá ', $url, [
                                                //'title' => Yii::t('app', 'lead-view'),
                                                'title' => 'Xoá yêu cầu',
                                                'class' => ' actions action-delete',
                                                'data-pjax' => true,
                                                'data-confirm-text' => 'Có chắc bạn muốn xoá yêu cầu có hành trình <b>' .
                                                    $model->from_airport . "-" . $model->to_airport
                                                    . "</b> khởi hành ngày <b>" . \common\utils\StringUtils::DateFormatConverter($model->departure, "Y-m-d", "d/m/Y") . "</b>?",
                                                'data-customer_fullname' => "",
                                                'data-request_id'   => $model->id,

                                            ]);
                                        },

                                        'edit'  => function($url, $model)
                                        {
                                            return Html::a('<i class ="fa fa-edit"></i> Sửa ', $url, [

                                                'title' => 'Sửa yêu cầu',
                                                'class' => 'actions action-edit',
                                                'data-pjax' => 0,
                                             ]);


                                        }


                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'view') {
                                            $url =Yii::$app->getUrlManager()->createUrl(['customer/view-customer-request', 'id' => $model->id ]);
                                            return $url;
                                        }

                                        if ($action === 'edit') {
                                            $url =Yii::$app->getUrlManager()->createUrl(['customer/edit-customer-request', 'id' => $model->customer_id, 'edit' => $model->id ]);
                                            return $url;
                                        }
                                        if ($action === 'delete') {
                                            $url =Yii::$app->getUrlManager()->createUrl(['customer/delete-customer-request', 'id' => $model->id ]);
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
