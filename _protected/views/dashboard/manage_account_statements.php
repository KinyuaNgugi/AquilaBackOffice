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
                    <span><?=$name?></span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab"><?=$name?><span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <?php

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'showFooter'=>TRUE,
                            'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: italics;'],

                            'columns' => [

                                [
                                    'attribute' => 'Date',
                                    'value' => 'date',
                                ],
                                [
                                    "attribute" => "Description",
                                    'value' => 'description',
                                ],
                                [
                                    'attribute' => 'Credit',
                                    'value' => 'credit',
                                    'footer' => 'Total Credit: '.$total_credit
                                ],
                                [
                                    'attribute' => 'Debit',
                                    'value' => 'debit',
                                    'footer' => 'Total Debit: '.$total_debit
                                ],
                                [
                                    'attribute' => 'Balance',
                                    'value' => 'balance',
                                    'footer' => 'Balance: '. $balance
                                ],
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
