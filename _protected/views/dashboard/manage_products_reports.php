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
                    <span>Product Reports</span>
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
                        <a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">Product Sales Analysis<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation" >
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Inventory Stock List By Product<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="tab1">
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
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab5">
                                <?php echo \app\models\ReportProduct::buildProductInventoryChart(2)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab6">
                                <?php echo \app\models\ReportProduct::buildProductInventoryTable(2)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab7">
                                <button onclick="" type="button" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="tab2">
                        <table id="products">
                            <tbody>
                            <tr>
                                <td class="col-md-3"><label><b>Filter By Product:</b></label><br></td>
                                <td class="col-md-3"><label><b>Filter By Date:</b></label><br></td>
                            </tr>
                            <tr>
                                <?php ActiveForm::begin();?>
                                <td>
                                    <input type="text" required value="<?=$product_name?>" list="product-list" name="product"  placeholder="Search Product---" class="product-search form-control">
                                    <datalist id="product-list" class="product-list">
                                        <option value="">
                                    </datalist>
                                </td>
                                <td class="col-md-3">
                                    <input class="form-control" type="text" name="daterange" value="<?=$daterange?>" placeholder="Filter" >
                                </td>
                                <td class="col-md-3">
                                    <button type="submit" class="btn btn-black">Filter</button>
                                </td>
                                <?php ActiveForm::end();?>
                            </tr>
                            </tbody>
                        </table>
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
                                <?php echo \app\models\ReportProduct::buildProductSalesAnalysisChart(2,$start,$end,$account_id)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab9">
                                <?php echo \app\models\ReportProduct::buildProductSalesAnalysisTable(2,$start,$end,$account_id)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab10">
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