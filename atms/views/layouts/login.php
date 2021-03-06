<?php
/**
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use atms\assets\LoginAsset;

//$bundle = yiister\gentelella\assets\Asset::register($this);

$bundle  = LoginAsset::register($this);

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
<body class="nav-md custom-bgcolor">
<?php $this->beginBody(); ?>
    <div class="container body">

        <div class="main_container">
            <div class="row">
                <div   role="main">
                    <!-- page content -->
                    <?= $content ?>
                    <!-- /page content -->

                </div>
            </div>
        </div>
    </div>

<?php $this->endBody(); ?>

</body>
</html>
<?php $this->endPage(); ?>
