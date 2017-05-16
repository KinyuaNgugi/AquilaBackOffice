<?php
use kartik\grid\GridView;
use app\models\Expense;
use \app\models\Income;
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
                    <span>VAT Report</span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">VAT Reports<span class="badge badge-danger"></span></a>
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
                        <h3>Total Purchases</h3>
                        <?php
                        $searchModel = new Expense();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"paid");
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'showFooter'=>TRUE,
                            'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: italics;'],

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    "attribute" => "Supplier",
                                    'value' => 'supplier.supplierName',
                                ],
                                [
                                    'attribute' => 'Invoice Number',
                                    'value' => 'po_number',
                                ],
                                [
                                    'attribute' => 'Date',
                                    'value' => 'date',
                                ],
                                [
                                    'attribute' => 'Amount',
                                    'value' => 'total',
                                    'footer' => 'Total Amount: '.number_format($searchModel->getTotalPaid())
                                ],
                                [
                                    'attribute' => 'Tax',
                                    'value' => 'tax',
                                    'footer' => 'Total Tax: '.number_format($searchModel->getTotalPaidTax())
                                ]
                            ]
                        ]);
                        ?>
                        <h3>Total Sales</h3>
                        <?php
                        $searchModel = new Income();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"paid");
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    "attribute" => "Client",
                                    'value' => 'client.client_name',
                                ],
                                [
                                    'attribute' => 'Receipt Number',
                                    'value' => 'receiptNumber',
                                ],
                                [
                                    'attribute' => 'Date',
                                    'value' => 'actualDate',
                                ],
                                [
                                    'attribute' => 'Amount',
                                    'value' => 'total',
                                ],
                                [
                                    'attribute' => 'Tax',
                                    'value' => 'tax',
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