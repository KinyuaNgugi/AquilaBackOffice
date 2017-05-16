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
                    <span>Banks</span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Banks<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <?php ActiveForm::begin();?>
                        <br>
                        <hr class="divider">
                        <a href="#" data-toggle="collapse" data-target="#product-form" class="text-warning"><i class="fa fa-plus"></i> Add New Bank</a>
                        <div id="product-form" class="collapse row">
                            <br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier">Bank Name<sup>*</sup></label>
                                    <select class="selectpicker form-control" data-live-search="true"  id="bank" required>
                                        <option>---Select Bank---</option>
                                        <?php if(!empty($banks)): foreach($banks as $key):?>
                                            <option value="<?=$key->code?>"><?=$key->bank?></option>
                                        <?php endforeach; endif;?>
                                    </select>
                                </div>
                                <input type="hidden" id="banky" name="bank">
                                <div class="form-group">
                                    <label >Branch<sup>*</sup></label>
                                    <select class=" form-control" data-live-search="true" name="branch"  id="branch" required></select>
                                </div>
                                <div class="form-group">
                                    <label>Account Number<sup>*</sup></label>
                                    <input type="number" class="form-control" name="account" required>
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
                        $searchModel = new \app\models\OrgBanks();
                        $dataProvider = $searchModel->search(Yii::$app->request->get());

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Bank',
                                    'value' => 'banks.bank',
                                ],
                                [
                                    "attribute" => "Branch",
                                    'value' => 'bankbranch.name',
                                ],
                                [
                                    'attribute' => 'Account Number',
                                    'value' => 'account',
                                ],

                                [ 'class' => 'yii\grid\ActionColumn',
                                    'template' => ' {update}',
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
<script>
    $('#bank').change(function () {
        getBankBranches($('#bank').val());
    });

    function getBankBranches(bank_code)
    {
        $.ajax({
            'type': 'GET',
            'url': 'banks',
            'cache': false,
            'data': {
                bank_code : bank_code
            },
            'success': function (branches) {
                var converted=JSON.parse(branches);

                $('#branch').append('<option>---Select Branch---</option>');
                for (var i=0;i<Object.keys(converted).length;i++){
                    $('#branch').append($('<option>', {
                        value: converted[i]['id'],
                        text: converted[i]['name']
                    }));
                    $('#banky').val(converted[i]['bank_id']);
                }
            }
        });
    }
</script>
