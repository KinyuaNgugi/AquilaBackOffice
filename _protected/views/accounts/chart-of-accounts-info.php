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
        <div class="">
            <div class="partner-tabs" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">All Accounts<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">Banks and Cash<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab3" aria-controls="tab" role="tab" data-toggle="tab">Assets<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab4" aria-controls="tab" role="tab" data-toggle="tab">Liabilities <span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab5" aria-controls="tab" role="tab" data-toggle="tab">Expenses<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab6" aria-controls="tab" role="tab" data-toggle="tab">Incomes <span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <?php ActiveForm::begin();?>
                        <br>
                        <hr class="divider">
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
                    <div role="tabpanel" class="tab-pane" id="tab3">
                        <?php ActiveForm::begin();?>
                        <br>
                        <div id="contact-form1" class="collapse row">
                            <br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <ul class="list-unstyled list-inline">
                                        <li>
                                            <label>Select all or select each below</label><br>
                                            <input onclick="$('.client-checkbox').click()" type="checkbox" name="user[]" value="all">
                                        </li>
                                    </ul>
                                </div>
                                <hr class="divider">
                                <div role="tabpanel">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#home-email" aria-controls="home" role="tab" data-toggle="tab">Email</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#tab-sms" aria-controls="tab" role="tab" data-toggle="tab">SMS</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home-email">
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input type="text" data-validation="required" name="subject" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea data-validation="required" class="form-control" name="message-email" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tab-sms">
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea data-validation="required" class="form-control" name="message-sms" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pull-right">
                                    <button type="submit" class="btn btn-success">Send bulk</button>
                                </div>
                            </div>
                            <span class="clearfix"></span>
                        </div>
                        <hr class="divider">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Select client</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Package</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Expiry Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($clients)): foreach($clients as $key):?>
                                <?php
                                $client = Partnercodeuse::getClient($key->org,'INACTIVE');

                                if($client):

                                    $contact = Partnercodeuse::getContacts($key->org);
                                    $contact_person = Partnercodeuse::getContactPerson($key->org);
                                    $subscription = Partnercodeuse::getSubscription($key->org);
                                    ?>
                                    <tr>
                                        <td><input class="client-checkbox" type="checkbox" name="client[]" value="<?=$key->id;?>"> <?=$client->name; ?></td>
                                        <td><?=(!empty($contact_person->email)) ? $contact_person->email:'';?></td>
                                        <td><?=(!empty($contact->phone)) ? $contact->phone:'';?></td>
                                        <td><?=$key->cost;?></td>
                                        <td><?=($subscription->duration > 1) ? $subscription->duration.' months': $subscription->duration.' month';?></td>
                                        <td><?=ucfirst(strtolower($client->status));?></td>
                                        <td><?=Partnercodeuse::addDays($subscription->cdate,$subscription->duration*30);?></td>
                                        <td><a data-toggle="modal" href="#modal-<?=$key->id;?>" href="#"><button class="btn btn-success"><i class="fa fa-envelope-o"></i></button></a></td>
                                    </tr>
                                    <div class="modal fade" id="modal-<?=$key->id;?>">
                                        <div class="modal-dialog modal-lger">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title"><b>Contact <?=$client->name;?></b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div role="tabpanel">
                                                        <!-- Nav tabs -->
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active">
                                                                <a href="#tab-30" aria-controls="tab" role="tab" data-toggle="tab">SMS client</a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a href="#tab-31" aria-controls="tab" role="tab" data-toggle="tab">Email client</a>
                                                            </li>
                                                        </ul>
                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane active" id="tab-30">
                                                                <div class="col-md-8 col-md-offset-0">
                                                                    <div class="form-group">
                                                                        <label>Message</label>
                                                                        <textarea data-validation="required" name="message" class="form-control" rows="3" placeholder="Type message here 135 character left"></textarea>
                                                                    </div>
                                                                    <hr class="divider">
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-success">Send message</button>
                                                                    </div>
                                                                </div>
                                                                <span class="clearfix"></span>
                                                            </div>
                                                            <div role="tabpanel" class="tab-pane" id="tab-31">
                                                                <div class="col-md-8 col-md-offset-0">
                                                                    <div class="form-group">
                                                                        <label>Subject</label>
                                                                        <input autofocus="" type="text" name="subject" class="form-control" data-validation="required">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Message</label>
                                                                        <textarea data-validation="required" name="message" class="form-control" rows="3" placeholder="Type message here 135 character left"></textarea>
                                                                    </div>
                                                                    <hr class="divider">
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-success">Send message</button>
                                                                    </div>
                                                                </div>
                                                                <span class="clearfix"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach; endif;?>
                            </tbody>
                        </table>
                        <hr class="divider">
                        <?php ActiveForm::end();?>
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