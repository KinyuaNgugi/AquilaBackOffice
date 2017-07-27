<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
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
                    <span>HRM</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Employees</span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Current employees<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab3" aria-controls="home" role="tab" data-toggle="tab">Terminated Employees<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <?php ActiveForm::begin();?>
                        <br>
                        <hr class="divider">
                        <a href="#" data-toggle="modal" data-target="#employee-form" class="text-warning"><i class="fa fa-plus"></i> Add New Employee</a>
                        <div class="modal fade" id="employee-form">
                            <div class="modal-dialog modal-lger">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"><b>New Employee</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div role="tabpanel">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active">
                                                    <a href="#tab-30" aria-controls="tab" role="tab" data-toggle="tab">Personal Information</a>
                                                </li>
                                                <li role="presentation">
                                                    <a href="#tab-31" aria-controls="tab" role="tab" data-toggle="tab">Basic Pay</a>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="tab-30">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>First Name*</label>
                                                            <input type="text" class="form-control" name="firstname" required >
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input type="text" class="form-control" name="middlename" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Last Name*</label>
                                                            <input type="text" class="form-control" name="lastname" required>
                                                        </div>
                                                        <hr class="divider">
                                                        <div class="form-group pull-right">
                                                            <a href="#tab-31"><button  type="button" class="btn btn-success">Next</button></a>
                                                        </div>
                                                    </div>
                                                    <span class="clearfix"></span>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tab-31">
                                                    <div class="col-md-8 col-md-offset-0">

                                                    </div>
                                                    <span class="clearfix"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="divider">
                        <?php
                        $searchModel = new app\models\EmpInfo();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"active");

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Name',
                                    'value' => 'firstname',
                                ],
                                [
                                    "attribute" => "National Id",
                                    'value' => 'id_no',
                                ],
                                [
                                    'attribute' => 'Phone',
                                    'value' => 'cellphone',
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
                        <hr class="divider">
                        <?php ActiveForm::end();?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab3">
                        <?php
                        $searchModel = new app\models\EmpInfo();
                        $dataProvider = $searchModel->search(Yii::$app->request->get(),"terminated");

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Name',
                                    'value' => 'firstname',
                                ],
                                [
                                    "attribute" => "National Id",
                                    'value' => 'id_no',
                                ],
                                [
                                    'attribute' => 'Phone',
                                    'value' => 'cellphone',
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