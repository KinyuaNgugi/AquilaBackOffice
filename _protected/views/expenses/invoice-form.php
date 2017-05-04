<?php
use app\models\Partnercodeuse;
use yii\widgets\ActiveForm;
?>
<style>
    .tablee{
        width:350%;
        display:table;
    }
</style>
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
                    <span>New invoice</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN DASHBOARD STATS 1-->
        <?php require_once('feedback.php');?>
        <div class="">
            <div class="partner-tabs" role="tabpanel">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <?php ActiveForm::begin();?>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="selectpicker form-control" data-live-search="true"
                                        <?php if (isset($invoice) && $invoice->approved != 0 || $pk != 'new' ):?>disabled<?php endif;?>
                                        name="supplier"  id="supplier" required>
                                    <?php if(empty($supplier)):?>
                                        <option>---Select Supplier---</option>
                                    <?php endif;?>
                                    <?php if(!empty($supplier)):?>
                                        <option value="<?=$supplier->supplierId?>"><?=$supplier->supplierName?></option>
                                    <?php $supplier_to_exclude=$supplier->supplierId; endif;?>
                                    <?php if(!empty($suppliers)): foreach($suppliers as $key):?>
                                        <?php if(!empty($supplier_to_exclude) && $supplier_to_exclude!=$key->supplierId):?>
                                            <option value="<?=$key->supplierId?>"><?=$key->supplierName?></option>
                                            <?php else: ?>
                                            <option value="<?=$key->supplierId?>"><?=$key->supplierName?></option>
                                        <?php endif;?>
                                    <?php endforeach; endif;?>
                                </select>
                                <label for="date">Invoice Number*</label>
                                <input type="text" name="inv-number" value="<?=$inv?>" class="form-control"
                                       <?php if (isset($invoice) && $invoice->approved != 0 || $pk != 'new' ):?>readonly<?php endif;?>>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="date">Date<sup>*</sup></label>
                                    <input type="date" name="date" class="form-control" required
                                        <?php if(!empty($invoice)):?>
                                            value="<?=$invoice->date?>"
                                        <?php endif;?>
                                           <?php if (isset($invoice) && $invoice->approved != 0 || $pk != 'new' ):?>readonly<?php endif;?>>

                                    <label for="date">Date Due</label>
                                    <input type="date" name="date-due" class="form-control" required
                                        <?php if(!empty($invoice)):?>
                                            value="<?=$invoice->date_due?>"
                                        <?php endif;?>
                                           <?php if (isset($invoice) && $invoice->approved != 0 || $pk != 'new' ):?>readonly<?php endif;?>>
                                </div>
                            </div>
                        </div>

                        <hr class="divider">
                        <?php if (isset($invoice) && $invoice->approved == 0 || $pk == 'new' ):?>
                        <div class="row">
                            <div class="col-md-3 ">
                                <table class="tablee" id="prods">
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
                                    <tr>
                                        <td>
                                            <input type="text" list="product-list" id="product-name"  placeholder="Search Product---" class="product-search form-control">
                                            <datalist id="product-list" class="product-list">
                                                <option value="">
                                            </datalist>
                                        </td>
                                        <td><input type="text" class="buying-price form-control"  id="price"  ></td>
                                        <td><input type="text" class="quantity form-control"  id="quantity" ></td>
                                        <td >
                                            <select id="tax-bracket" class="tax-rate form-control" >
                                            </select>
                                        </td>
                                        <td><input type="text" class="tax-amount form-control"  id="tax" readonly></td>
                                        <td><input type="text" class="total-amount form-control"  id="total" readonly></td>
                                        <td><button id="add-item" type="button" class="btn btn-info">Add item</button></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif;?>
                        <div class="row">
                            <input type="hidden" id="pk" value="<?=$pk?>">
                            <hr class="divider">
                            <table id="prod">
                                <thead id="hide-table-header">
                                <tr>
                                    <th style="width:25%">Product</th>
                                    <th style="width:10%">Unit Cost</th>
                                    <th style="width:10%">Quantity</th>
                                    <th style="width:20%">Tax</th>
                                    <th style="width:15%">Total Tax</th>
                                    <th style="width:10%">Total</th>
                                    <th style="width:10%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $subtotal=0;
                                $t_tax=0;
                                $grand_total=0;
                                ?>
                                <?php if(!empty($items)): foreach($items as $key):?>
                                    <tr>
                                        <?php $product = \app\models\Stock::find()->where(array('stockId' => $key->item_id))->one();?>
                                        <td ><?=$product->productName?></td>
                                        <td ><?=$key->unit_cost?></td>
                                        <td ><?=$key->qty?></td>
                                        <?php $tax=\app\models\CountryTaxRates::find()->where(array('id'=>$key->tax_id))->one();?>
                                        <td ><?=$tax->tax_rate_name?></td>
                                        <td ><center><?=$key->t_tax?></center></td>
                                        <td ><?=$key->total?></td>
                                        <td ></td>
                                    </tr>
                                    <?php
                                    $subtotal+=$key->unit_cost*$key->qty;
                                    $t_tax+=$key->t_tax;
                                    $grand_total+=$key->total;
                                    ?>
                                <?php endforeach; endif;?>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" id="subtotal" value="<?=$subtotal?>">
                        <input type="hidden" id="ttax" value="<?=$t_tax?>">
                        <input type="hidden" id="grandtotal" value="<?=$grand_total?>">
                        <hr class="divider">
                        <div class="row">
                            <div class="pull-right">
                                <table class="table" style="font-size:14px">
                                    <tr><td><strong>Sub-Total</strong></td><td class="table-money"><span class="sub-totals"></span></td></tr>
                                    <tr id="orig-tax"><td><strong>Total Tax</strong></td><td class="table-money"><span class="tax-final"></span></td></tr>
                                    <tr><td><strong>Total</strong></td><td class="table-money"><span class="totals-final"></span></td></tr>
                                </table>
                            </div>
                        </div>
                        <hr class="divider">
                        <div class="row">
                            <center>
                                <?php if($pk == 'new' || !empty($supplier_to_exclude) && $invoice->approved  != 1 && $invoice->approved  != 3):?>
                                    <button type="submit" class="btn btn-success">Save</button></a>
                                <?php endif;?>
                                <?php if (isset($invoice) && $invoice->approved !=3):?>
                                    <?php if($pk !== 'new' && $invoice->approved  != 1):?>
                                        <button onclick="window.location='<?=Yii::$app->homeUrl;?>expenses/approve?id=<?=$pk;?>'"
                                                type="button" class="btn btn-info">Approve</button></a>
                                        <button onclick="window.location='<?=Yii::$app->homeUrl;?>expenses/void?id=<?=$pk;?>'"
                                                type="button" class="btn btn-danger">Void</button></a>
                                    <?php endif;?>
                                    <?php if($invoice->approved  == 1):?>
                                        <a data-toggle="modal" href="#modal-pay"><button class="btn btn-success">Mark As Payment Received</button></a
                                    <?php endif;?>
                                <?php endif;?>
                            </center>
                        </div>
                        <?php ActiveForm::end();?>
                    </div>
                    <div class="modal fade" id="modal-pay">
                        <div class="modal-dialog modal-lger">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title"><b>Payment for <?=(isset($invoice)) ? $invoice->po_number: ''?></b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="supplier">Amount<sup>*</sup></label>
                                        <input class="form-control" type="text" readonly value="<?=$grand_total?>">
                                    </div>
                                    <div class="form-group">
                                        <label ><sup>Account to withdraw from*</sup></label>
                                        <select class="selectpicker form-control" data-live-search="true"  id="account" required>
                                            <option>---Select Account---</option>
                                            <?php
                                            $banks = \app\models\OrgChart::find()->where(array('main_acc_id'=>1,
                                                'level_one_id'=>1,'level_two_id'=>1))->all();
                                            if(!empty($banks)): foreach($banks as $key):?>
                                                <option value="<?=$key->id?>"><?=$key->level_three?></option>
                                            <?php endforeach; endif;?>
                                        </select>
                                    </div>
                                    <hr class="divider">
                                    <div class="btn-group" role="group" aria-label="...">
                                        <input id="home_url" type="hidden"
                                               <?php if (isset($invoice)):?>value="<?=Yii::$app->homeUrl.'expenses/pay?id='.$invoice->id.'&amount='.$grand_total;?>"
                                        <?php endif;?>>
                                        <button onclick="submitForPayment()" type="button" class="btn green">Make Payment</button>
                                    </input>
                                </div>
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
    $("#prods tbody").on('input', '.product-search', function()
    {
        $('.tax-rate').empty();
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
                'success': function (bprice) {
                    $('.buying-price').val(bprice);
                    $('.quantity').val(1);

                    $('.total-amount').val('');
                    $('.tax-amount').val('');
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
                    $('.tax-rate').append('<option>---Select Tax Type---</option>');
                    for (var i=0;i<Object.keys(converted).length;i++){
                        $('.tax-rate').append('<option value="' + converted[i] + '">'+converted[i]+'</option>');
                    }
                }
            });
        }
    });
</script>
<script>
    function changeProductForm()
    {
        var tax_type=$('#tax-bracket').val();
        //get tax rate and calculate tax
        $.ajax({
            'type': 'GET',
            'url': '../expenses/purchase',
            'cache': false,
            'data': {
                taxtype:tax_type
            },
            'success': function (tax_rate) {
                var qty=$('.quantity').val();
                var bprice=$('.buying-price').val();
                var tax_amount=parseFloat(bprice)*parseFloat(tax_rate)*parseFloat(qty);
                var total_amount=parseFloat(tax_amount)+parseFloat(bprice)*parseFloat(qty);
                $('.tax-amount').val(tax_amount);
                $('.total-amount').val(total_amount);
            }
        })
    }
    $("#prods tbody").on('change', '.tax-rate', function(){
        changeProductForm();
    });
    $("#prods tbody").on('keyup', '.quantity', function(){
        changeProductForm();
    });
    $("#prods tbody").on('blur', '.quantity', function(){
        changeProductForm();
    });
    $("#prods tbody").on('keyup', '.buying-price', function(){
        changeProductForm();
    });
    $("#prods tbody").on('blur', '.buying-price', function(){
        changeProductForm();
    });
</script>


<script type="text/javascript">
    function isEmpty(str)
    {
        return (!str || /^\s*$/.test(str));
    }
    $(document).ready(function() {
        $('#hide-table-header').hide();
        if ($('#pk').val() !== 'new')
        {
            $('#hide-table-header').show();
            $('.sub-totals').html($('#subtotal').val());
            $('.tax-final').html($('#ttax').val());
            $('.totals-final').html($('#grandtotal').val());

        }
        $('#add-item').click(function() {
            var bprice=$('#price').val();
            var qty=$('#quantity').val();
            var taxi=$('#tax').val();
            var totali=$('#total').val();
            if (!isEmpty($('#product-name').val()) && !isEmpty($('#price').val()) && !isEmpty($('#quantity').val())
                && !isEmpty($('#tax-bracket').val()) && !isEmpty($('#tax').val()) && !isEmpty($('#total').val()))
            {
                $('#hide-table-header').show();
                $('#prod tbody').append('<tr class="child">' +
                    '<td>' + $('#product-name').val()+  '</td>'+
                    '<td>'+$('#price').val()+'</td>' +
                    '<td>'+$('#quantity').val()+'</td>' +
                    '<td>' +$('#tax-bracket').val()+ '</td>' +
                    '<td><center>'+$('#tax').val()+'</center></td>' +
                    '<td>'+$('#total').val()+'</td>' +
                    '<td><button type="button" class="btn btn-danger">Remove</button></a></td>'+
                    '</tr>'+
                        '<tr><td>'+
                    '<input type="hidden" name="product[]" value="'+ $('#product-name').val()+'">'+
                    '<input type="hidden" name="price[]" value="'+ $('#price').val()+'">'+
                    '<input type="hidden" name="qty[]" value="'+ $('#quantity').val()+'">'+
                    '<input type="hidden" name="tax-rate[]" value="'+ $('#tax-bracket').val()+'">'+
                    '<input type="hidden" name="tax[]" value="'+ $('#tax').val()+'">'+
                    '<input type="hidden" name="total[]" value="'+ $('#total').val()+'">'+
                        '</td></tr>'
                );
                
                //calculate bottom totals
                if (isEmpty($('.sub-totals').html()) && isEmpty($('.tax-final').html()) && isEmpty($('.totals-final').html()))
                {
                    $('.sub-totals').html(parseFloat(bprice)*parseFloat(qty));
                    $('.tax-final').html(taxi);
                    $('.totals-final').html(totali);
                }
                else
                {
                    var subtotal=parseFloat($('.sub-totals').html())+parseFloat(bprice)*parseFloat(qty);
                    var temp_tax=parseFloat($('.tax-final').html())+parseFloat(taxi);
                    var temp_total=parseFloat($('.totals-final').html())+parseFloat(totali);

                    $('.sub-totals').html(subtotal);
                    $('.tax-final').html(temp_tax);
                    $('.totals-final').html(temp_total);
                }
                $('#product-name').val('');
                $('#price').val('');
                $('#quantity').val('');
                $('#tax').val('');
                $('#total').val('');
                $('.tax-rate').empty();
            }
        });
    });

    function submitForPayment() {
        window.location=$('#home_url').val()+'&account='+$('#account').val();
    }
</script>
