<?php
use app\models\ReportFinancialStatements;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\models\OrgChart;
use kartik\grid\GridView;
?>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?=Yii::$app->homeUrl;?>accounts/index">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Reports</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Financial Statements</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN DASHBOARD STATS 1-->
        <div class="">
            <div class="partner-tabs" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Balance Sheet<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">Profit & Loss Statement<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab3" aria-controls="tab" role="tab" data-toggle="tab">Cash Flow Statement<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">

                    </div>
                    <div role="tabpanel" class="tab-pane active" id="tab2">
                        balance sheet
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="tab3">
                        p&l
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>