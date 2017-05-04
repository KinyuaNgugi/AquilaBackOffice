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
                    <span>Suppliers</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN DASHBOARD STATS 1-->
        <?php require_once('feedback.php'); ?>
        <div class="">
            <div class="partner-tabs" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab-all-suppliers" aria-controls="home" role="tab" data-toggle="tab">All Suppliers<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-inactive-suppliers" aria-controls="home" role="tab" data-toggle="tab">Inactive Suppliers<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab-all-suppliers">
                        <?php ActiveForm::begin();?>
                        <br>
                        <hr class="divider">
                        <a href="#" data-toggle="collapse" data-target="#product-form" class="text-warning"><i class="fa fa-plus"></i> Add New Supplier</a>
                        <div id="product-form" class="collapse row">
                            <br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Supplier Name<sup>*</sup></label>
                                    <input type="text" class="form-control" name="name" id="supplier" required >
                                </div>
                                <span class="text-info" id="name-error"></span>
                                <div class="form-group">
                                    <label>KRA PIN<sup>*</sup></label>
                                    <input type="text" class="form-control" name="pin" id="pin" required>
                                </div>
                                <span class="text-info" id="pin-error"></span>
                                <div class="form-group">
                                    <label>Phone Number<sup>*</sup></label>
                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="email" >
                                </div>
                                <div class="form-group">
                                    <label for="vat">Method Of Payment<sup>*</sup></label>
                                    <select class="form-control" name="payment"  id="payment" required>
                                        <?php if(!empty($payment_methods)): foreach($payment_methods as $key):?>
                                            <option value="<?=$key->id?>"><?=$key->name?></option>
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
                        $searchModel = new \app\models\Supplier();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),1);

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Supplier',
                                    'value' => 'supplierName',
                                ],
                                [
                                    "attribute" => "kra pin",
                                    'value' => 'kraPin',
                                ],
                                [
                                    'attribute' => 'Payment Method',
                                    'value' => 'payment_methods.name',
                                ],

                                [ 'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {update}',
                                    'buttons' =>
                                        [

                                        ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab-inactive-suppliers">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>