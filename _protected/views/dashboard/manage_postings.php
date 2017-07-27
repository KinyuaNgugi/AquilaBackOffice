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
                        <!--<a href="#" data-toggle="collapse" data-target="#product-form" class="text-warning"><i class="fa fa-plus"></i> Journal Posting</a>-->
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
                    <div role="tabpanel" class="tab-pane " id="tab2">
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
                    <div role="tabpanel" class="tab-pane " id="tab3">
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
                    <div role="tabpanel" class="tab-pane " id="tab4">
                        <?php
                        $searchModel = new OrgChart();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"debtors");

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
                    <div role="tabpanel" class="tab-pane " id="tab5">
                        <?php
                        $searchModel = new OrgChart();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"expenses");

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
                    <div role="tabpanel" class="tab-pane " id="tab6">
                        <?php
                        $searchModel = new OrgChart();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"income");

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
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>