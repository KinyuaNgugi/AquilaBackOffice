<?php
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\Stock;
use app\models\Expense;
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
                    <span><a href="<?=Yii::$app->homeUrl;?>expenses/index">Expenses</a></span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Purchase Orders</span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Invoices<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab3" aria-controls="home" role="tab" data-toggle="tab">Approved Invoices<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab4" aria-controls="home" role="tab" data-toggle="tab">Paid Invoices<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">Voided Invoices<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <br>
                        <hr class="divider">
                        <a href="<?=Yii::$app->homeUrl;?>expenses/purchase?pk=new" class="text-warning"><i class="fa fa-plus"></i> New Invoice</a>
                        <hr class="divider">
                        <?php
                        $searchModel = new Expense();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"all");
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Invoice Number',
                                    'value' => 'po_number',
                                ],
                                [
                                    "attribute" => "Supplier",
                                    'value' => 'supplier.supplierName',
                                ],
                                [
                                    'attribute' => 'Invoice Amount',
                                    'value' => 'total',
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
                    <div role="tabpanel" class="tab-pane" id="tab3">
                        <hr class="divider">
                        <?php
                        $searchModel = new Expense();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"approved");
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Invoice Number',
                                    'value' => 'po_number',
                                ],
                                [
                                    "attribute" => "Supplier",
                                    'value' => 'supplier.supplierName',
                                ],
                                [
                                    'attribute' => 'Invoice Amount',
                                    'value' => 'supplier_id',
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
                    <div role="tabpanel" class="tab-pane" id="tab4">
                        <hr class="divider">
                        <?php
                        $searchModel = new Expense();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"paid");
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Invoice Number',
                                    'value' => 'po_number',
                                ],
                                [
                                    "attribute" => "Supplier",
                                    'value' => 'supplier.supplierName',
                                ],
                                [
                                    'attribute' => 'Invoice Amount',
                                    'value' => 'supplier_id',
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
                        <hr class="divider">
                        <?php
                        $searchModel = new Expense();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"void");
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Invoice Number',
                                    'value' => 'po_number',
                                ],
                                [
                                    "attribute" => "Supplier",
                                    'value' => 'supplier.supplierName',
                                ],
                                [
                                    'attribute' => 'Invoice Amount',
                                    'value' => 'supplier_id',
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
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>