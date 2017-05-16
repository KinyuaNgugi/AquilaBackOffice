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
                    <span>Cost Reports</span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Total Cost Reports<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">Cost Reports By product<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab3" aria-controls="home" role="tab" data-toggle="tab">Cost Reports By Supplier<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab4" aria-controls="home" role="tab" data-toggle="tab">Cost Reports By category<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab5" aria-controls="home" role="tab" data-toggle="tab">Chart<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab6" aria-controls="home" role="tab" data-toggle="tab">Table<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab7" aria-controls="home" role="tab" data-toggle="tab">Download<span class="badge badge-danger"></span></a>
                            </li>
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab8" aria-controls="home" role="tab" data-toggle="tab">Chart<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab9" aria-controls="home" role="tab" data-toggle="tab">Table<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab10" aria-controls="home" role="tab" data-toggle="tab">Download<span class="badge badge-danger"></span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab8">
                                <?php echo \app\models\ReportCosts::buildCostByProductChart(2,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab9">
                                <?php echo \app\models\ReportCosts::buildCostByProductTable(2,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab10">
                                <button onclick="" type="button" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab11" aria-controls="home" role="tab" data-toggle="tab">Chart<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab12" aria-controls="home" role="tab" data-toggle="tab">Table<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab13" aria-controls="home" role="tab" data-toggle="tab">Download<span class="badge badge-danger"></span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab11">
                                <?php echo \app\models\ReportCosts::buildCostBySupplierChart(2,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab12">
                                <?php echo \app\models\ReportCosts::buildCostBySupplierTable(2,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab13">
                                <button onclick="" type="button" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab4">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab14" aria-controls="home" role="tab" data-toggle="tab">Chart<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab15" aria-controls="home" role="tab" data-toggle="tab">Table<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab16" aria-controls="home" role="tab" data-toggle="tab">Download<span class="badge badge-danger"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>