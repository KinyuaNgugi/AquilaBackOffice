<?php
use app\models\Partnercodeuse;
use yii\widgets\ActiveForm;
use \app\models\OrgChart;
use yii\grid\GridView;
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
                    <span>Revenue Reports</span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Total Revenue Reports<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">Revenue Reports By product<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab3" aria-controls="home" role="tab" data-toggle="tab">Chart<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab4" aria-controls="home" role="tab" data-toggle="tab">Table<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab5" aria-controls="home" role="tab" data-toggle="tab">Download<span class="badge badge-danger"></span></a>
                            </li>
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab6" aria-controls="home" role="tab" data-toggle="tab">Chart<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab7" aria-controls="home" role="tab" data-toggle="tab">Table<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab8" aria-controls="home" role="tab" data-toggle="tab">Download<span class="badge badge-danger"></span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab6">
                                <?php echo \app\models\ReportRevenue::buildRevenueByProductChart(2,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab7">
                                <?php echo \app\models\ReportRevenue::buildRevenueByProductTable(2,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab8">
                                <button onclick="" type="button" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>