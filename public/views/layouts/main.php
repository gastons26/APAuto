<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <span class="navbar-brand">APAuto Admin v1.0</span>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="glyphicon glyphicon-user  gi-1_5x"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?=Url::to(['site/change-password']); ?>"><i class="glyphicon glyphicon-sunglasses"></i> Mainīt paroli</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?=Url::to(['site/logout'])?>"><i class="fa fa-sign-out fa-fw"></i> Beigt darbu</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>

            <li class="dropdown">
                <a  class="" data-toggle="dropdown" href="#">
                    <i  class="flag-icon flag-icon-background flag-icon-lv  gi-1_5x"></i>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu" style="min-width: 0px !important;">
                    <li><a href="#"><i class="flag-icon flag-icon-background flag-icon-ru  gi-1_5x"></i></a>
                    </li>
                    <li><a href="#"><i class="flag-icon flag-icon-background flag-icon-gb  gi-1_5x"></i></a>
                    </li>
                </ul>
            </li>

        </ul>

        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="<?=Url::to(['site/index'])?>"><i class="fa fa-car fa-fw"></i> Automašīnas</a>
                    </li>
                    <li class="<?=in_array(Yii::$app->controller->id, ['models', 'features']) ? 'active': ''?>">
                        <a href="#"><i class="fa fa-wrench fa-fw"> </i> Uzstādījumi<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?=Url::to(['site/index'])?>">Sistēmas mainīgie</a>
                            </li>
                            <li>
                                <a href="<?=Url::to(['models/index']);?>" class="<?=Yii::$app->controller->id == 'models' ? 'active' : ''; ?>">Auto markas</a>
                            </li>
                            <li>
                                <a href="<?=Url::to(['features/index']);?>">Auto uzstādījumi</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-files-o fa-fw"></i> Parastās lapas<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?=Url::to(['site/leasing'])?>">Līzina lapa</a>
                            </li>
                            <li>
                                <a href="<?=Url::to(['site/contact'])?>">Kontaktu lapa</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?= $content ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->


</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
