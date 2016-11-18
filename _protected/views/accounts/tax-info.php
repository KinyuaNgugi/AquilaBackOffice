<?php
use app\models\Partnercodeuse;
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
                    <span>Dashboard</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Summary Company Info</span>
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
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">All Products<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab3" aria-controls="home" role="tab" data-toggle="tab">Products Below Reorder Level<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="tab" role="tab" data-toggle="tab">VAT Inclusive Products <span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="tab" role="tab" data-toggle="tab">VAT Exclusive Products <span class="badge badge-danger"></span></a>
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
                                    <label for="productCode">Product Code:</label>
                                    <input type="text" class="form-control" name="productCode" id="productCode" required >
                                </div>
                                <div class="form-group">
                                    <label for="productName">Product Name:</label>
                                    <input type="text" class="form-control" name="productName" id="productName" required>
                                </div>
                                <div class="form-group">
                                    <label for="vat">VAT:</label>
                                    <select class="form-control" name="vatable"  id="vat" required>
                                        <option value="vatable">16% VAT</option>
                                        <option value="unvatable">VAT Excluded</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="buyingPrice">Buying Price:</label>
                                    <input type="text" value="1" class="form-control" name="buyingPrice" id="buyingPrice" required>
                                </div>
                                <div class="form-group">
                                    <label for="sellingPrice">Selling Price:</label>
                                    <input type="text"  class="form-control" name="sellingPrice" id="sellingPrice" required>
                                </div>
                                <div class="form-group">
                                    <label for="packing">Packing Units:</label>
                                    <input type="text" value="1" class="form-control" name="packing" id="packing">
                                </div>
                                <div class="form-group">
                                    <label for="reorderlevel">Reorder Level:</label><span class="text-warning" id="unitsToPack"></span>
                                    <input type="text" class="form-control"  name="reorderLevel" id="reorderLevel" required>
                                </div>
                                <hr class="divider">
                                <div class="form-group pull-right">
                                    <button type="submit" class="btn btn-success">Add</button>
                                </div>
                            </div>
                            <span class="clearfix"></span>
                        </div>
                        <hr class="divider">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Buying Price</th>
                                <th>Selling Price</th>
                                <th>Action</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($unvatable)): foreach($unvatable as $key):?>
                                    <tr>
                                        <td><?=$key->productCode;?></td>
                                        <td><?=$key->productName;?></td>
                                        <td><?=$key->buyingPricePerUnit;?></td>
                                        <td><?=$key->sellingPricePerUnit;?></td>
                                        <td><a data-toggle="modal" href="#modal-<?=$key->stockId;?>" href="#"><button class="btn btn-success">More</button></a></td>
                                        <td><a data-toggle="modal" href="#modal-<?=$key->stockId;?>" href="#"><button class="btn btn-danger">Edit</i></button></a></td>
                                    </tr>
                                    <div class="modal fade" id="modal-<?=$key->stockId;?>">
                                        <div class="modal-dialog modal-lger">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title"><b><?=$key->productName;?></b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div role="tabpanel">
                                                        <!-- Nav tabs -->
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active">
                                                                <a href="#tab-30" aria-controls="tab" role="tab" data-toggle="tab">Product Summary</a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a href="#tab-31" aria-controls="tab" role="tab" data-toggle="tab">Product Analysis</a>
                                                            </li>
                                                        </ul>
                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane active" id="tab-30">
                                                                <div class="col-md-8 col-md-offset-0">

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
                            <?php endforeach; endif;?>
                            </tbody>
                        </table>
                        <hr class="divider">
                        <?php ActiveForm::end();?>
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