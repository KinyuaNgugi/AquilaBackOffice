<?php
use yii\widgets\ActiveForm;
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
                        <hr class="divider">
                        <div class="form-group row">
                            <table>
                                <tr>
                                    <td><label><b>Filter By Date:</b></label><br></td>
                                </tr>
                                <?php ActiveForm::begin();?>
                                <tr>
                                    <td><input type="text" class="form-control" name="daterange" value="<?=$daterange?>" placeholder="Filter" ></td>
                                    <td><button type="submit" class="btn btn-black">Filter</button></td>
                                </tr>
                                <?php ActiveForm::end();?>
                            </table>
                        </div>
                        <hr class="divider">
                        <h3>Total Sales</h3>
                        <?php
                        $searchModel = new Income();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"paid",$start,$end);
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'showFooter'=>TRUE,
                            'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: italics;'],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

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
                                ],
                                [
                                    'attribute' => 'Amount',
                                    'value' => 'total',
                                    'footer' => 'Total Amount: '.number_format($searchModel->getTotalPaid($start,$end))
                                ],
                                [
                                    'attribute' => 'Tax',
                                    'value' => 'tax',
                                    'footer' => 'Total Sales Tax: '.number_format($searchModel->getTotalPaidTax($start,$end))
                                ]
                            ]
                        ]);
                        ?>
                        <h3>Total Purchases</h3>
                        <?php
                        $searchModel1 = new Expense();
                        $dataProvider = $searchModel1->search(Yii::$app->request->get(),"paid",$start,$end);
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel1,
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
                                    'footer' => 'Total Amount: '.number_format($searchModel1->getTotalPaid($start,$end))
                                ],
                                [
                                    'attribute' => 'Tax',
                                    'value' => 'tax',
                                    'footer' => 'Total Purchases Tax: '.number_format($searchModel1->getTotalPaidTax($start,$end))
                                ]
                            ]
                        ]);
                        ?>
                        <hr class="divider">
                        <table class="table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th width="80%">Total Sales Tax</th>
                                <th width="50%"><?=number_format($searchModel->getTotalPaidTax($start,$end))?></th>
                            </tr>
                            <tr>
                                <th width="80%">Total Purchases Tax</th>
                                <th width="50%"><?=number_format($searchModel1->getTotalPaidTax($start,$end))?></th>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="80%">Total Payable Tax</th>
                                <th width="50%">KSH <?=number_format($searchModel->getTotalPaidTax($start,$end)-$searchModel1->getTotalPaidTax($start,$end))?></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>