<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\helpers\Url;

use atms\assets\AppAsset;
$bundle = AppAsset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-md">
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar  " style="border: 0;">
                    <a href="/" id="site_title">
                        <span id="site-logo" class="site_logo site_logo_normal" ></span>
                        <span id="site_name"><?= \Yii::getAlias("@sitename"); ?></span>
                    </a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <?php 
                                $url =  Url::base() . \Yii::getAlias("@avatar_url") . "/" . \Yii::$app->user->getAvatar();
                                echo  Html::img($url, [ 'class' => 'img-circle profile_img', 'alt'   => '' ]);
                         ?>
                    </div>
                    <div class="profile_info">
                        <span>Hello, </span> 
                        <h2><?php 
                            
                            echo Yii::$app->user->getUsername();
                            
                            ?></h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

                    <div class="menu_section">
                         
                        <h3>&nbsp;</h3>
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    ["label" => "Home", "url" => "/", "icon" => "home"],
                                  //  ["label" => "Layout", "url" => ["/layout"], "icon" => "files-o"],
                                  //  ["label" => "Error page", "url" => ["/error"], "icon" => "close"],
                                    [
                                        "label" => "Khách hàng",
                                        "icon" => "users",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Thêm KH", "url" => ["customer/create"]],
                                            ["label" => "DS Khách hàng", "url" => ["customer/index"]],
                                            ["label" => "DS Gởi thông báo", "url" => ["site/panel"]],
                                            ["label" => "Cập nhật KH", "url" => ["site/panel"]],
                                            ["label" => "DS Yêu cầu đặt vé", "url" => ["customer-request"]],
                                          
                                        ],
                                    ],
                                    [
                                        "label" => "Đặt vé",
                                        "url" => "#",
                                        "icon" => "plane",
                                        "items" => [
                                            [
                                                "label" => "Nhập yêu cầu đặt vé",
                                                "url" => "#",
                                                //"badge" => "123",
                                            ],
                                            [
                                                "label" => "DS yêu cầu",
                                                "url" => "#",
                                                "//badge" => "new",
                                               // "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            [
                                                "label" => "Yêu cầu chờ xử lý ",
                                                "url" => "#",
                                                //"badge" => "!",
                                                "badge" => "123",
                                                "badgeOptions" => ["class" => "label-danger"],
                                            ],
                                             [
                                                "label" => "Xuất vé",
                                                "url" => "#",
                                                //"badge" => "!",
                                               
                                            ],
                                              [
                                                "label" => "DS vé đã xuất",
                                                "url" => "#",
                                                //"badge" => "!",
                                               
                                            ],
                                              [
                                                "label" => "Cập nhật vé",
                                                "url" => "#",
                                                //"badge" => "!",
                                            ],
                                              [
                                                "label" => "Thanh toán vé",
                                                "url" => "#",
                                                //"badge" => "!",
                                               
                                            ],
                                              [
                                                "label" => "Huỷ vé",
                                                "url" => "#",
                                                //"badge" => "!",
                                               
                                            ],
                                              [
                                                "label" => "Đổi vé",
                                                "url" => "#",
                                                //"badge" => "!",
                                            ],
                                              [
                                                "label" => "Hoàn vé",
                                                "url" => "#",
                                                //"badge" => "!",
                                            ],
                                              [
                                                "label" => "Xuất vé",
                                                "url" => "#",
                                                //"badge" => "!",
                                            ],
                                              [
                                                "label" => "DS vé huỷ ",
                                                "url" => "#",
                                                //"badge" => "!",
                                            ],
                                              [
                                                "label" => "DS vé hoàn",
                                                "url" => "#",
                                                //"badge" => "!",
                                            ],
                                              [
                                                "label" => "Chi tiết vé xuất",
                                                "url" => "#",
                                                //"badge" => "!",
                                            ],
                                        ],
                                    ],
                                    
                                    
                                    [
                                        "label" => "Nhân viên",
                                        "url" => "#",
                                        "icon" => "user",
                                        "items" => [
                                            [
                                                "label" => "Thêm nhân viên",
                                                "url" => "#",
                                                //"badge" => "123",
                                            ],
                                            [
                                                "label" => "Cập nhật nhân viên",
                                                "url" => "#",
                                                "//badge" => "new",
                                               // "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            [
                                                "label" => "Danh sách nhân viên",
                                                "url" => "#",
                                                //"badge" => "!",
                                                //"badge" => "123",
                                               // "badgeOptions" => ["class" => "label-danger"],
                                            ],
                                              [
                                                "label" => "Cấp quyền",
                                                "url" => "#",
                                                //"badge" => "!",
                                            ],
                                              [
                                                "label" => "Xem nhật ký",
                                                "url" => "#",
                                                //"badge" => "!",
                                            ],
                                              [
                                                "label" => "Reset mật khẩu",
                                                "url" => "#",
                                                //"badge" => "!",
                                               
                                            ],
                                        ],
                                    ],
                                    
                                    [
                                        "label" => "Hệ thống",
                                        "url" => "#",
                                        "icon" => "cogs",
                                        "items" => [
                                            [
                                                "label" => "QL Hãng bay",
                                                "url" => "#",
                                                //"badge" => "123",
                                            ],
                                            [
                                                "label" => "QL sân bay",
                                                "url" => "#",
                                                "//badge" => "new",
                                               // "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            [
                                                "label" => "QL nguồn cung cấp vé ",
                                                "url" => "#",
                                            ],
                                        ],
                                    ],
                                    
                                    
                                ],
                            ]
                        )
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu ">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-angle-double-left"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <?php 
                                        $url =  Url::base() . \Yii::getAlias("@avatar_url") . "/" . \Yii::$app->user->getAvatar();
                                        echo  Html::img($url, [ 'class' => '', 'alt'   => '' ]);
                                    ?>
                                    <?php echo Yii::$app->user->getFullname();?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="javascript:;">  Profile</a>
                                </li>
<!--                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>-->
                                <li>
                                    <a href="javascript:;">Help</a>
                                </li>
                                <li><a href="/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="" alt="Profile Image" />
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="" alt="Profile Image" />
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="" alt="Profile Image" />
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="" alt="Profile Image" />
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a href="/">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" id="main-content">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>

            <?= $content ?>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-left">
                Copyright &copy 2017



                <div class="panel panel-primary" id="loading"  style="display: none;">
                    <div class="panel-heading">
                        <h4 class="panel-title">Loading...</h4>
                    </div>
                    <div class="panel-body">
                        <span id="loadingMsg">Đang tải dữ liệu vui lòng chờ giây lát.</span>
                        <div id="imgLoading" ><img  src="<?=  Yii::getAlias('@web'). '/images/loading_red.gif' ; ?>"/></div>
                    </div>
                </div>


            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>



<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
