<?php

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

$bundle  = \atms\assets\CustomerAsset::register($this);

$this->title = 'Khách hàng';
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
            [
                'label' => 'Khách hàng',
                'url'   => Yii::$app->homeUrl . 'customer',
                //'url' => ['post-category/view', 'id' => 10],
                'template' => "<li><b>{link}</b></li>\n", // template for this link only
            ],
            //['label' => 'Sample Post', 'url' => ['post/edit', 'id' => 1]],
            'Danh sách Khách hàng',
        ],
    ]);
    ?>

    <!-- Customer create Modal -->
    <div class="modal modalBackground" id="mdCustomerCreate"  role="dialog"
         data-backdrop="false"
         data-easein="bounce"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="mdCustCreateContent">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">
                    <div id="divCustForm">
                        <div id='custModalContent'>
                            <?php//= $this->render('_customer-create', ['model' => $customerForm]); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <!-- Customer detail Modal -->
    <div class="modal" id="customerDetailModal"   role="dialog"
         data-easein="fadeIn"
         aria-labelledby="myModalLabel">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-close"></span> Đóng</button>
                </div>
            </div>
        </div>
    </div>


    <div id="divCustomerSection"  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    <?= Html::encode($this->title) ?>
                </h2>
                <span class="span5"></span>
                <?= Html::a('<span class="fa fa-plus-circle"></span> Thêm', ['customer/create'], ['class' => 'btn btn-primary']) ?>



                <ul class="nav navbar-right panel_toolbox pull-right">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    <li>
                        <a class="expand-link" data-target="#divCustomerSection"
                           data-reload="#pjaxCustomerList" ><i class="fa fa-expand"></i></a>
                    </li>
                    <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>-->
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div id="customerList">


                    <?php Pjax::begin(['id' => 'pjaxCustomerList',
                        'timeout' => false,
                        'enablePushState' => true,
                        'clientOptions' => ['method' => 'POST'],

                    ]); ?>
                    <?php $form = ActiveForm::begin([
                        'id'    => 'frmCustomers',

                        'options' => [
                            'data-pjax' => true ,
                            'class' => 'form-inline',
                            'data-url'  => Url::to([Yii::$app->controller->action->id])
                        ]
                    ]); ?>


                    <div class="form-group">
                        <?= Html::input("text", "id", $params['id'], [
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
                            <?=  $form->field($searchModel, 'district_id')->widget(Select2::classname(),
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
                            <?=  $form->field($searchModel, 'province_id')->widget(Select2::classname(),
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
                                        //'dropdownParent' => "$('#divCustomerSection')"

                                    ],
                                    /*'pluginEvents' => [
                                        "select2:select" => "function() {selectdata();}",
                                    ]*/
                                ])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="search" id="btnSearch" class="form-control bg-primary" data-pjax = '1' ><span class="fa fa-search"></span></button>
                    </div>

                    <div class="form-group pull-right">
                        <div id="divSortBy">
                            <?=  $form->field($searchModel, 'sort_by')->widget(Select2::classname(),
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

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "Hiển thị {begin}-{end} trong tổng số <b>{totalCount}</b> khách hàng",
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
                                    'customer_id' => $model->id,
                                    //'toggle'   => 'modal',
                                    'target'    => '#customerDetailModal',
                                    'customer_fullname' => $model->personFullName,
                                    //'url'   => Url::to(['/customer/view-details', 'id' => $model->id])
                                    'url' => Yii::$app->getUrlManager()->createUrl(['customer/view', 'id' => $model->id ])
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
                            'id'    => 'customer-table'
                        ],

                        'tableOptions' => [
                            'id' => 'customer-table-id',
                            'class' => 'table table-striped mytable '
                        ],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                //'headerOptions' => ['style' => 'width:2%'],
                                //'contentOptions' => ['style' => 'width:2%'],

                            ],
                            //'fullName',
                            //'addressprovince',
                            //'id',
                            [   'label' => 'ID',
                                'attribute' => 'id',
                                //'headerOptions' => ['style' => 'width:2%'],

                                //'format' => ['date',"d-m-Y"],
                                'contentOptions' => [
                                    'class' => 'text-left',
                                    'tabindex' => '0',
                                    //'style' => 'width: 2%',
                                ],
                                'headerOptions' => ['style' => 'max-width:60px'],
                                //'headerOptions' => ['class' => 'text-center']
                            ],
                            [
                                'label' => 'Họ',
                                'format' => 'html',
                                'value' => function($model)
                                {
                                    return  "<span class='fa " . $model->personGenderIcon . "'></span> " . $model->personLastnameAndMiddlename;
                                },


                                'contentOptions' => [
                                    'class' => 'text-left',

                                ],
                                'headerOptions' => ['style' => 'min-width:120px'],
                            ],
                            [
                                'label' => 'Tên',
                                //'format' => 'html',
                                'value' => function($mode)
                                {
                                    return $mode->personFirstname;
                                },
                                'contentOptions' => [
                                    'class' => 'text-left',

                                ],

                            ],

                            //"firstName",

                            [
                                'header'    => 'SĐT',
                                'format'    => 'raw',
                                'value' => function($model){
                                    //return "<span class=\"badge\">" .$model->contact_number . "</span>" . ($model->phone != null? "<span class=\"badge\">". $model->phone:"</span>");
                                    return $model->person->phone_number;
                                }
                            ],
                            "addressDistrict",
                            "addressProvince",
                            [
                                'header'   => "Email",
                                'attribute' => 'person.email'
                            ],


                            [
                                'header' => 'Ngày sinh',
                                'attribute' => 'person.birthdate',
                                'format'    => ['date', 'dd-mm-Y'],
                                'headerOptions' => ['style' => 'width:90px'],
                            ],

                            //['class' => CheckboxColumn::className()],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                //'context' => $this->context,
                                // 'header' => 'Actions',
                                //'headerOptions' => ['style' => 'color:#337ab7'],
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<i class ="fa fa-th"></i>', $url, [
                                            //'title' => Yii::t('app', 'lead-view'),
                                            'title' => 'Xem chi tiết',
                                            'class' => ' view-customer',
                                            'data-customer_fullname' => $model->personFullName,
                                        ]);
                                    },

                                    /*'update' => function ($url, $model) {
                                        return Html::a('<i class ="fa fa-edit"></i>', $url, [
                                            //'title' => Yii::t('app', 'lead-view'),
                                            'title' => 'Sửa',
                                            'class' => 'btn btn-primary btn-xs',
                                        ]);
                                    },*/
                                    /* 'delete' => function ($url, $model) {
                                         return Html::a('<i class ="fa fa-trash"></i>', $url, [
                                             //'title' => Yii::t('app', 'lead-view'),
                                             'title' => 'Xoá',
                                             'class' => 'btn btn-primary btn-xs',
                                         ]);
                                     }*/

                                ],
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    if ($action === 'view') {
                                        $url =Yii::$app->getUrlManager()->createUrl(['customer/view', 'id' => $model->id ]);
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
                        ],
                    ]); ?>

                    <?php ActiveForm::end(); ?>
                    <?php Pjax::end(); ?>
                </div>

            </div>
        </div>
    </div>


</div>
