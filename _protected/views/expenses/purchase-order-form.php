<?php
use app\models\Partnercodeuse;
use yii\widgets\ActiveForm;
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
                    <span><a href="<?=Yii::$app->homeUrl;?>expenses/index">Expenses</a></span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>New Purchase Order</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN DASHBOARD STATS 1-->
        <div class="">
            <div class="partner-tabs" role="tabpanel">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <?php ActiveForm::begin();?>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="selectpicker form-control" data-live-search="true" name="supplier"  id="supplier" required>
                                    <option>---Select Supplier---</option>
                                    <?php if(!empty($suppliers)): foreach($suppliers as $key):?>
                                        <option value="<?=$key->supplierId?>"><?=$key->supplierName?></option>
                                    <?php endforeach; endif;?>
                                </select>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="date">Date*</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-6">
                                <div class="form-group">
                                    <label for="date">Date Due*</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <hr class="divider">

                        <div class="row">
                            <div class="col-md-3 ">
                                <a href="#"  class="text-warning"><i class="fa fa-plus"></i> Add item</a>
                            </div>
                        </div>

                        <div class="row">
                            <hr class="divider">
                            <table id="prods">
                                <thead>
                                <tr>
                                    <th style="width:25%">Product*</th>
                                    <th style="width:10%">Unit Cost*</th>
                                    <th style="width:10%">Quantity*</th>
                                    <th style="width:20%">Tax*</th>
                                    <th style="width:15%">Total Tax*</th>
                                    <th style="width:10%">Total*</th>
                                    <th style="width:10%"></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <hr class="divider">
                        <div class="row">
                            <div class="pull-right">
                                <table class="table" style="font-size:14px">
                                    <tr><td><strong>Sub-Total</strong></td><td class="table-money"><span class="sub-totals"></span></td></tr>
                                    <tr id="orig-tax"><td><strong>Total Tax</strong></td><td class="table-money"><span class="tax"></span></td></tr>
                                    <tr><td><strong>Total</strong></td><td class="table-money"><span class="totals"></span></td></tr>
                                </table>
                            </div>
                        </div>
                        <hr class="divider">
                        <div class="row">
                            <center>
                                <button type="submit" class="btn btn-success">Save</button></a>
                                <button class="btn btn-info">Approve</button></a>
                                <button class="btn btn-danger">Void</button></a>
                            </center>
                        </div>
                        <?php ActiveForm::end();?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('a').click(function() {

            $('#prods tbody').append('<tr class="child">' +
                '<td>' +
                '<input type="text" list="product-list"  placeholder="Search Product---" class="product-search form-control">'+
                '<datalist id="product-list" class="product-list">'+
                    '<option value="">'+
                '</datalist>'+
                '</td>'+
                '<td><input type="text" class="buying-price form-control" name="price" id="price" required ></td>' +
                '<td><input type="text" class="quantity form-control" name="quantity" id="quantity" required ></td>' +
                '<td>' +
                '<select class="tax-rate form-control" >' +
                '<option>---Select Tax Type---</option>'+
                '</select>'+
                '</td>' +
                '<td><input type="text" class="form-control" name="tax" id="tax" required ></td>' +
                '<td><input type="text" class="form-control" name="total" id="total" required ></td>' +
                    '<td><button class="btn btn-danger">Remove</button></a></td>'+
                '</tr>');
        });
    });

</script>
<script>
    $("#prods tbody").on('keyup', '.product-search', function(){
        $('.product-list').empty();
        var product=$('.product-search').val();
        //ajax action to get the products
        if (product.length>=2)
        {
            $.ajax({
                'type': 'GET',
                'url': '../expenses/purchase',
                'cache': false,
                'data': {
                    search:product
                },
                'success': function (prods) {
                    var converted=JSON.parse(prods);
                    for (var i=0;i<Object.keys(converted).length;i++){
                        $('.product-list').append('<option value="' + converted[i] + '">');
                    }
                }
            });
        }
    });
</script>
<script>
    $("#prods tbody").on('input', '.product-search', function(){

        var val = this.value;
        if($('.product-list').find('option').filter(function(){
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            //send ajax request
            $.ajax({
                'type': 'GET',
                'url': '../expenses/purchase',
                'cache': false,
                'data': {
                    product:val
                },
                'success': function (product_info) {
                    $('.buying-price').val(product_info);
                    $('.quantity').val(1);
                }
            });
            //ajax to get tax rates
            $.ajax({
                'type': 'GET',
                'url': '../expenses/purchase',
                'cache': false,
                'data': {
                    action:"tax_rates"
                },
                'success': function (prods) {
                    var converted=JSON.parse(prods);
                    for (var i=0;i<Object.keys(converted).length;i++){
                        $('.tax-rate').append('<option value="' + converted[i] + '">'+converted[i]+'</option>');
                    }
                }
            });
        }
    });
</script>
