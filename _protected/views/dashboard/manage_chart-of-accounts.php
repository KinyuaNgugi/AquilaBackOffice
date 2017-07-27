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
                    <a href="<?=Yii::$app->homeUrl;?>accounts/index"> Accounts Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Chart Of Accounts</span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">All Accounts<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <?php ActiveForm::begin();?>
                        <br>
                        <a href="#" data-toggle="collapse" data-target="#product-form" class="text-warning"><i class="fa fa-plus"></i> Add New Account</a>
                        <div id="product-form" class="collapse row">
                            <br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier">Main Account<sup>*</sup></label>
                                    <select class=" form-control" id="main" name="main" required>
                                        <option>---Select Main Account---</option>
                                        <?php if(!empty($mains)): foreach($mains as $key):?>
                                            <option value="<?=$key->id?>"><?=$key->account_base_name?></option>
                                        <?php endforeach; endif;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label >Level One<sup>*</sup></label>
                                    <select class=" form-control" name="l1"  id="l1" required></select>
                                </div>
                                <div class="form-group">
                                    <label >Level Two<sup>*</sup></label>
                                    <select class=" form-control"  name="l2"  id="l2" required></select>
                                </div>
                                <div class="form-group">
                                    <label>Level Three<sup>*</sup></label>
                                    <input type="text" class="form-control" id="l3" name="l3" required>
                                </div>
                                <span id="l3_error" class="text-danger"></span>
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
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"all");

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
                                    'template' => '{view} {update}',
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