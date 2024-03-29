<?php
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\Stock;
use yii\grid\ActionColumn;
?>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?=Yii::$app->homeUrl;?>dashboard/welcome"> Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Products</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN DASHBOARD STATS 1-->
        <?php require_once('feedback.php');?>
        <div class="">
            <div class="partner-tabs" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">All Products<span class="badge badge-danger"></span></a>
                    </li>
                    <!--<li role="presentation">
                        <a href="#tab3" aria-controls="home" role="tab" data-toggle="tab">Products Below Reorder Level<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="tab" role="tab" data-toggle="tab">VAT Inclusive Products <span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab4" aria-controls="tab" role="tab" data-toggle="tab">VAT Exclusive Products <span class="badge badge-danger"></span></a>
                    </li>-->
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <?php ActiveForm::begin();?>
                        <br>
                        <hr class="divider">
                        <a href="#" data-toggle="collapse" data-target="#product-form" class="text-warning"><i class="fa fa-plus"></i> Add New Product</a>
                        <div id="product-form" class="collapse row">
                            <br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product-code">Product Code:</label>
                                    <input type="text" class="form-control" name="productCode" id="product-code" required >
                                </div>
                                <span class="text-info" id="code-error"></span>
                                <div class="form-group">
                                    <label for="product-name">Product Name:</label>
                                    <input type="text" class="form-control" name="productName" id="product-name" required>
                                </div>
                                <span class="text-info" id="name-error"></span>
                                <div class="form-group">
                                    <label for="vat">VAT:</label>
                                    <select class="form-control" name="vat"  id="vat" required>
                                        <?php if(!empty($taxes)): foreach($taxes as $key):?>
                                            <option value="<?=$key->id?>"><?=$key->tax_rate_name?></option>
                                        <?php endforeach; endif;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="buyingPrice">Buying Price:</label>
                                    <input type="text" value="1" class="form-control" name="buyingPricePerUnit" id="buying-price" required>
                                </div>
                                <div class="form-group">
                                    <label for="sellingPrice">Selling Price:</label>
                                    <input type="text"  class="form-control" name="sellingPricePerUnit" id="selling-price" required>
                                </div>
                                <div class="form-group">
                                    <label for="packing">Packing Units:</label>
                                    <input type="text" value="1" class="form-control" name="packing" id="packing">
                                </div>
                                <div class="form-group">
                                    <label for="reorderlevel">Reorder Level:</label><span class="text-warning" id="unitsToPack"></span>
                                    <input type="text" class="form-control"  name="reorderLevel" id="reorderLevel" required>
                                </div>
                                <div class="form-group">
                                    <label for="supplier">Supplier:</label>
                                    <select class="selectpicker form-control" data-live-search="true" name="supplierId"  id="supplier" required>
                                        <option>---Select Supplier---</option>
                                        <?php if(!empty($suppliers)): foreach($suppliers as $key):?>
                                            <option value="<?=$key->supplierId?>"><?=$key->supplierName?></option>
                                        <?php endforeach; endif;?>
                                    </select>
                                </div>
                                <hr class="divider">
                                <div class="form-group pull-right">
                                    <button type="submit" class="btn btn-success">Add</button>
                                </div>
                            </div>
                            <span class="clearfix"></span>
                        </div>
                        <hr class="divider">
                        <table id="all-products-table" class="display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Buying Price </th>
                                <th>Selling Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Buying Price </th>
                                <th>Selling Price</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                        <?php ActiveForm::end();?>
                        <?php
                        /*$searchModel = new Stock();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"all");

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'code',
                                    'value' => 'productCode',
                                ],
                                [
                                    "attribute" => "name",
                                    'value' => 'productName',
                                ],
                                [
                                    'attribute' => 'buying price',
                                    'value' => 'buyingPricePerUnit',
                                ],
                                [
                                    'attribute' => 'selling price',
                                    'value' => 'sellingPricePerUnit',
                                ],

                                [ 'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {update}',
                                    'buttons' =>
                                        [

                                        ]
                                ]
                        ]
                        ]);
                        */?>
                    </div>
                    <!--<div role="tabpanel" class="tab-pane" id="tab3">
                        <?php /*ActiveForm::begin();*/?>
                        <br>
                        <?php
/*                        $searchModel = new Stock();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"reorder");

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'code',
                                    'value' => 'productCode',
                                ],
                                [
                                    "attribute" => "name",
                                    'value' => 'productName',
                                ],
                                [
                                    'attribute' => 'buying price',
                                    'value' => 'buyingPricePerUnit',
                                ],
                                [
                                    'attribute' => 'selling price',
                                    'value' => 'sellingPricePerUnit',
                                ],

                                [ 'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {update}',
                                    'buttons' =>
                                        [

                                        ]
                                ]
                            ]
                        ]);
                        */?>
                        <hr class="divider">
                        <?php /*ActiveForm::end();*/?>
                    </div>-->
                    <!--<div role="tabpanel" class="tab-pane" id="tab2">
                        <br>
                        <?php
/*                        $searchModel = new Stock();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"vat");

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'code',
                                    'value' => 'productCode',
                                ],
                                [
                                    "attribute" => "name",
                                    'value' => 'productName',
                                ],
                                [
                                    'attribute' => 'buying price',
                                    'value' => 'buyingPricePerUnit',
                                ],
                                [
                                    'attribute' => 'selling price',
                                    'value' => 'sellingPricePerUnit',
                                ],

                                [ 'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {update}',
                                    'buttons' =>
                                        [

                                        ]
                                ]
                            ]
                        ]);
                        */?>
                    </div>-->
                    <!--<div role="tabpanel" class="tab-pane" id="tab4">
                        <br>
                        <?php
/*                        $searchModel = new Stock();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"exempt");

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'code',
                                    'value' => 'productCode',
                                ],
                                [
                                    "attribute" => "name",
                                    'value' => 'productName',
                                ],
                                [
                                    'attribute' => 'buying price',
                                    'value' => 'buyingPricePerUnit',
                                ],
                                [
                                    'attribute' => 'selling price',
                                    'value' => 'sellingPricePerUnit',
                                ],

                                [ 'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {update}',
                                    'buttons' =>
                                        [

                                        ]
                                ]
                            ]
                        ]);
                        */?>
                    </div>-->
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
    <?php if(!empty($products)): foreach($products as $key):?>
        <!--<div class="modal fade" id="active-modal-<?/*=$key->stockId;*/?>">
            <div class="modal-dialog modal-lger">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><b><?/*=$key->productName;*/?>(<?/*=$key->productCode*/?>)</b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product-code">Product Code:</label>
                            <input type="text" class="form-control" value="<?/*=$key->productCode*/?>" name="productCode" id="product-code" required >
                        </div>
                        <span class="text-info" id="code-error"></span>
                        <div class="form-group">
                            <label for="product-name">Product Name:</label>
                            <input type="text" class="form-control" value="<?/*=$key->productName*/?>" name="productName" id="product-name" required>
                        </div>
                        <div class="form-group">
                            <label for="vat">VAT:</label>
                            <select class="form-control" name="vat"  id="vat" required>
                                <option value="<?/*=$key->vat*/?>"><?/*=\app\models\CountryTaxRates::findOne($key->vat)->tax_rate_name*/?></option>
                                <?php /*if(!empty($taxes)): foreach($taxes as $tax):if ($tax->id != $key->vat):*/?>
                                    <option value="<?/*=$tax->id*/?>"><?/*=$tax->tax_rate_name*/?></option>
                                <?php /*endif;endforeach; endif;*/?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="buyingPrice">Buying Price:</label>
                            <input type="text" class="form-control" value="<?/*=$key->buyingPricePerUnit*/?>" name="buyingPricePerUnit" id="buying-price" required>
                        </div>
                        <div class="form-group">
                            <label for="sellingPrice">Selling Price:</label>
                            <input type="text"  class="form-control" value="<?/*=$key->sellingPricePerUnit*/?>" name="sellingPricePerUnit" id="selling-price" required>
                        </div>

                    </div>
                </div>
            </div>
        </div>-->
    <?php endforeach;endif;?>
</div>
<script  type="text/javascript">
    $(document).ready(function() {
        $('#all-products-table').DataTable( {
            "columns": [
                {"data": "productCode"},
                {"data": "productName"},
                {"data": "buyingPricePerUnit"},
                {"data": "sellingPricePerUnit"},
                {"data": "btn"}
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: 'test',
                type: 'POST'
            }
        } );
    } );
</script>