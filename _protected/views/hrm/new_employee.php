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
            <form id="msform">
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active">Account Setup</li>
                    <li>Social Profiles</li>
                    <li>Personal Details</li>
                </ul>
                <!-- fieldsets -->
                <fieldset>
                    <h2 class="fs-title">Create Employee</h2>
                    <h3 class="fs-subtitle">Basic Details</h3>
                    <input type="text" name="fname" placeholder="First Name" />
                    <input type="text" name="lname" placeholder="Last Name" />
                    <input type="text" name="phone" placeholder="Phone" />
                    <input type="text" name="phone" placeholder="National ID" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Basic Pay</h2>
                    <h3 class="fs-subtitle">Employee Basic Pay</h3>
                    <input type="text" name="pay" placeholder="Basic Pay" />
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Create Login Account</h2>
                    <h3 class="fs-subtitle">Leave this section blank if you do not wish to create a login account for the employee</h3>
                    <input type="email" name="email" placeholder="email" autocomplete="off" />
                    <input type="password" name="password" placeholder="Password" autocomplete="off"/>
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="submit" name="submit" class="submit action-button" value="Submit" />
                </fieldset>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>