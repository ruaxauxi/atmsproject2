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
<div class="_customer-request-view" id="_customer-request-view">
    <span class="fa fa-th" ></span> Thông tin chi tiết

            <hr class="space5" />
            <div class="row">
                <div class="col-sm-12 col-md-12">

                    <div class="label-group label-group-first-item">
                        <label class="control-label " ><span class="fa  fa-angle-double-right"></span> Hạng vé: </label>
                        <span class="label-group-value">
                                <?= $model->ticketClass->class; ?>
                            </span>
                    </div>

                    <div class="label-group label-group-first-item">
                        <label class="control-label " > Hành trình: </label>
                        <span class="label-group-value">
                            <?= $model->from_airport . " (" . $model->fromAirport->name . ")"  . " - " .
                                $model->to_airport. " (" . $model->toAirport->name .  ")"
                            ?>
                        </span>
                    </div>

                    <div class="label-group">
                        <label class="control-label" > Ngày khởi hành: </label>
                        <span class="label-group-value">
                            <?php
                            $formatter = \Yii::$app->formatter;

                            echo  " đi <b>" . $formatter->asDate($model->departure, "dd-MM-yyyy")
                                . "</b> - về <b>" .
                                ($model->return?$formatter->asDate($model->return, "dd-MM-yyyy") .
                                    "</b>":"không đặt</b>");
                            ?>
                        </span>
                    </div>

                    <div class="label-group">
                        <label class="control-label " > Số lượng vé: </label>
                        <span class="label-group-value">
                            <?php
                            echo  ($model->adult + $model->children + $model->infant) ."</span>  (". $model->adult  .  "  - người lớn" .
                            (empty($model->children)?"":"; " . "$model->children " .
                                " - trẻ em") .
                            (empty($model->infant)?")":"; "
                                ."$model->infant  - em bé)");
                            ?>
                        </span>
                    </div>

                    <div class="label-group">
                        <label class="control-label " > Trạng thái: </label>
                        <span class="label-group-value">
                            <?php
                                $status = "Không xác định";
                            if ((int) $model->status == \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_WAITING )
                            {
                                $status =     "<span class='fa fa-clock-o request-status '></span> Chờ xử lý";
                            }else if ((int) $model->status == \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_CHECKED )
                            {
                                $status =     "<span class='fa fa-check request-status-success ' ></span> Đã xử lý";

                            }else if( (int) $model->status ==  \atms\models\CustomerRequests::CUSTOMER_REQUEST_STATUS_CANCELlED)
                            {
                                $status  =    "<span class='fa fa-remove request-status-primary' ></span> Đã huỷ yêu cầu ";
                            }

                            echo $status;

                            ?>
                        </span>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="label-group label-group-first-item">
                        <label class="control-label  " ><span class="fa  fa-angle-double-right"></span> <i> Ghi chú:</i> </label>
                        <span class="label-group-value">
                            <?= $model->note; ?>
                        </span>
                    </div>

                </div>
            </div>

            <!--<div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="label-group label-group-first-item">
                        <label class="control-label  " ><span class="fa  fa-angle-double-right"></span> <i>Liên hệ</i></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="label-group">
                        <label class="control-label " > SĐT: </label>
                        <span class="label-group-value">
                            <?/*= $model->customerInfo->phone_number; */?>
                        </span>
                    </div>
                    <div class="label-group">
                        <label class="control-label " > Email: </label>
                        <span class="label-group-value">
                                <?/*= $model->customerInfo->email; */?>
                            </span>
                    </div>

                    <div class="label-group">
                        <label class="control-label " > Ngày sinh: </label>
                        <span class="label-group-value">
                           <?php
/*                           $formatter = \Yii::$app->formatter;
                           echo  $formatter->asDate($model->customerInfo->birthdate, "dd-MM-yyyy");
                           */?>
                        </span>
                    </div>

                    <div class="label-group">
                        <label class="control-label " > ĐV công tác: </label>
                        <span class="label-group-value">
                           <?/*=  $model->customerCompanyName->company; */?>
                        </span>
                    </div>


                </div>
            </div>-->

           <!-- <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="label-group">
                        <label class="control-label  " > Địa chỉ: </label>
                        <span class="label-group-value">
                            <?/*= $model->customerInfo->addressFullAddress; */?>
                        </span>
                    </div>

                </div>
            </div>-->

            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="label-group label-group-first-item ">
                        <label class="control-label " ><span class="fa  fa-angle-double-right"></span> Ngày nhập : </label>
                        <span class="label-group-value">
                            <?php
                            $formatter = \Yii::$app->formatter;
                            echo  $formatter->asDate($model->created_at, "dd-MM-yyyy H:I:s");
                            ?>
                        </span>
                    </div>

                    <div class="label-group">
                        <label class="control-label  " > Ngày xử lý : </label>
                        <span class="label-group-value">
                            <?php

                            if ($model->processed_at)
                            {
                                $formatter = \Yii::$app->formatter;
                                echo  $formatter->asDate($model->processed_at, "dd-MM-yyyy");
                            }else{
                                echo " ";
                            }

                            ?>
                        </span>
                    </div>

                    <div class="label-group">
                        <label class="control-label  " > NV nhập: </label>
                        <span class="label-group-value">
                            <?= $model->creatorFullname . " (". $model->creator->username .")"; ?>
                        </span>
                    </div>

                    <div class="label-group">
                        <label class="control-label  " > NV xử lý: </label>
                        <span class="label-group-value">
                            <?= $model->examinerFullname . " (" . $model->assignedTo->username . ")"; ?>
                        </span>
                    </div>

                    <div class="label-group">
                        <label class="control-label  " > Xử lý bởi: </label>
                        <span class="label-group-value">
                            <?= isset($model->handlerFullname)? $model->handlerFullname .  " (".
                                $model->processedBy->username .")" : "Chưa xử lý"; ?>
                        </span>
                    </div>

                </div>
            </div>

        <hr class="space5"/>

</div>
