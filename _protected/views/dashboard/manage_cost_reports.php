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
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <table class="">
                            <tr>
                                <td class="col-md-3"><label><b>Filter By Date:</b></label><br></td>
                                <td class="col-md-3"><label><b>Filter By Period:</b></label><br></td>
                            </tr>
                            <tr>
                                <?php ActiveForm::begin();?>
                                <td class="col-md-3">
                                    <input class="form-control" type="text" name="daterange" <?php if (isset($daterange)):?>value="<?=$daterange?>"<?php endif;?> placeholder="Filter" >
                                </td>
                                <td class="col-md-3">
                                    <select  class="form-control" name="period" required>
                                        <?php if ($period != null):?>
                                            <option value="<?=$period?>"><?=$period?></option>
                                        <?php endif; ?>
                                        <?php if ($period != 'month'):?>
                                            <option value="month">month</option>
                                        <?php endif; ?>
                                        <?php if ($period != 'day'):?>
                                            <option value="day">day</option>
                                        <?php endif; ?>
                                        <?php if ($period != 'week'):?>
                                            <option value="week">week</option>
                                        <?php endif; ?>
                                        <?php if ($period != 'quarter'):?>
                                            <option value="quarter">quarter</option>
                                        <?php endif; ?>
                                        <?php if ($period != 'year'):?>
                                            <option value="year">year</option>
                                        <?php endif; ?>
                                    </select>
                                </td>
                                <td class="col-md-3">
                                    <button type="submit" class="btn btn-black">Filter</button>
                                </td>
                                <?php ActiveForm::end();?>
                            </tr>

                        </table>

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
                                <?php echo \app\models\ReportCosts::buildTotalCostsChart(2,$start,$end,$period)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab6">
                                <?php echo \app\models\ReportCosts::buildTotalCostsTable(2,$start,$end,$period)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab7">
                                <button onclick="" type="button" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab2">
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
                                <?php echo \app\models\ReportProduct::buildProductCostAnalysisChart(2,$start,$end,$account_id)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab9">
                                <?php echo \app\models\ReportProduct::buildProductCostAnalysisTable(2,$start,$end,$account_id)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab10">
                                <button onclick="" type="button" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab3">
                        <table id="suppliers">
                            <tbody>
                            <tr>
                                <td class="col-md-3"><label><b>Filter By Supplier:</b></label><br></td>
                                <td class="col-md-3"><label><b>Filter By Date:</b></label><br></td>
                            </tr>
                            <tr>
                                <?php ActiveForm::begin();?>
                                <td>
                                    <input type="text" required value="<?=$supplier_name?>" list="supplier-list" name="supplier"  placeholder="Search Supplier---" class="supplier-search form-control">
                                    <datalist id="supplier-list" class="supplier-list">
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
                                <?php echo \app\models\ReportCosts::buildSupplierAnalysisChart(2,$start,$end,$supplier_account_id)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab12">
                                <?php echo \app\models\ReportCosts::buildSupplierCostAnalysisTable(2,$start,$end,$supplier_account_id)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab13">
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