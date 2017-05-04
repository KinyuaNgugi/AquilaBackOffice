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
                    <span>Account Postings</span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Banks And Cash<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">Inventory<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab3" aria-controls="tab" role="tab" data-toggle="tab">Creditors<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab4" aria-controls="tab" role="tab" data-toggle="tab">Debtors<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab5" aria-controls="tab" role="tab" data-toggle="tab">Expenses<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab6" aria-controls="tab" role="tab" data-toggle="tab">Incomes <span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab7" aria-controls="tab" role="tab" data-toggle="tab">Fixed Assets <span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab8" aria-controls="tab" role="tab" data-toggle="tab">Short Term Liabilities <span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab9" aria-controls="tab" role="tab" data-toggle="tab">Long Term Liabilities <span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <?php ActiveForm::begin();?>
                        <br>
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
                        <?php ActiveForm::end();?>
                        <?php
                        $searchModel = new OrgChart();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"banks");

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Main Account',
                                    'value' => 'account_base.account_base_name',
                                ],
                                [
                                    "attribute" => "Level One",
                                    'value' => 'level_one.name',
                                ],
                                [
                                    'attribute' => 'Level Two',
                                    'value' => 'level_two.level_name',
                                ],
                                [
                                    'attribute' => 'Level Three',
                                    'value' => 'level_three',
                                ],

                                [ 'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view}',
                                    'buttons' =>
                                        [

                                        ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="tab2">
                        <?php
                        $searchModel = new OrgChart();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"inventory");

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Main Account',
                                    'value' => 'account_base.account_base_name',
                                ],
                                [
                                    "attribute" => "Level One",
                                    'value' => 'level_one.name',
                                ],
                                [
                                    'attribute' => 'Level Two',
                                    'value' => 'level_two.level_name',
                                ],
                                [
                                    'attribute' => 'Level Three',
                                    'value' => 'level_three',
                                ],

                                [ 'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view}',
                                    'buttons' =>
                                        [

                                        ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="tab3">
                        <?php
                        $searchModel = new OrgChart();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"creditors");

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Main Account',
                                    'value' => 'account_base.account_base_name',
                                ],
                                [
                                    "attribute" => "Level One",
                                    'value' => 'level_one.name',
                                ],
                                [
                                    'attribute' => 'Level Two',
                                    'value' => 'level_two.level_name',
                                ],
                                [
                                    'attribute' => 'Level Three',
                                    'value' => 'level_three',
                                ],

                                [ 'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view}',
                                    'buttons' =>
                                        [

                                        ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab2">
                        <br>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Phone</th>
                                <th>Expiry Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count=0;?>
                            <?php if(!empty($subscriptions)):for($i=0;$i<count($subscriptions); $i++):?>
                                <?php if($subscriptions[$i]):?>
                                    <tr>
                                        <?php
                                        $client = Partnercodeuse::getClient($key->org);
                                        $contact = Partnercodeuse::getContacts($subscriptions[$i]->org_id);
                                        $contact_person = Partnercodeuse::getContactPerson($subscriptions[$i]->org_id);
                                        ?>
                                        <td><b><?=++$count;?></b></td>
                                        <td><?=$client->name?></td>
                                        <td><?=(!empty($contact->phone))? $contact->phone : '';?></td>
                                        <td><?=Partnercodeuse::addDays($subscriptions[$i]->cdate,$subscriptions[$i]->duration*30);?>
                                    </tr>
                                <?php endif;?>
                            <?php endfor; endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>