<?php
$this->title = 'Balance Sheet';
?>
<br>
<h1 class="text-center">BALANCE SHEET | FOR THE PERIOD <?=$start?></h1>
<br><br>
<div class="panel panel-success">
    <div class="panel-body">
        <h3 class="panel-title"><b>Hi <?=$profile->name;?></b></h3>
        <br>
        You have successfully completed your profile and your account approved. Your Partner code can now be used to
        register clients into OpenBusiness.
        <br>
        <h5><b>Profile Summary</b></h5>
        <table class="table table-striped table-hover">

            <tbody>
            <tr>
                <td>Name</td>
                <td><?=$profile->name;?></td>
            </tr>
            <tr>
                <td>Partner Code</td>
                <td><?=$profile->id?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?=$profile->email?></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><?=$profile->phone?></td>
            </tr>
            <tr>
                <td>Partner type</td>
                <td><?=ucfirst($profile->partner_type)?></td>
            </tr>
            <tr>
                <td>National ID</td>
                <td><?=$profile->national_id?></td>
            </tr>
            <tr>
                <td>Payment Schedule</td>
                <td><?=($profile->payment_schedule)? \app\models\Paymentschedules::findOne($profile->payment_schedule)->schedule : '';?></td>
            </tr>
            <tr>
                <td>Profile Picture</td>
                <td><img class="img-responsive pdf-profile-picture" src="<?=Yii::$app->get('s3bucket')->getUrl('PartnerPortal/'.$profile->photo);?>"></td>
            </tr>
            <tr>
                <td>National ID Copy</td>
                <td><img class="img-responsive pdf-profile-picture" src="<?=Yii::$app->get('s3bucket')->getUrl('PartnerPortal/'.$profile->national_id_copy);?>"></td>
            </tr>
            <?php if($profile->partner_type == 'organisation'):?>
                <tr>
                    <td>Business Registration Certificate</td>
                    <td><img class="img-responsive pdf-profile-picture" src="<?=Yii::$app->get('s3bucket')->getUrl('PartnerPortal/'.$profile->business_reg_copy);?>"></td>
                </tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
</div>
