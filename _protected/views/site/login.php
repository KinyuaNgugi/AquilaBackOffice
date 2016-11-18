<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\base\Controller;

$this->title = 'Welcome Aquila';
?>
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="<?=Yii::$app->homeUrl;?>">
        <img src="<?=Yii::$app->homeUrl;?>themes/light/images/logos/aquilalogo.png" alt="logo" class="logo-default" />
    </a>
</div>
<!-- END LOGO -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php $form = ActiveForm::Begin(['id' => 'login-form','options' => ['class' => 'login-form','role' => 'form']]) ?>
    <h3 class="form-title font-green">Sign In</h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span> Enter email and password. </span>
    </div>
    <?php if(Yii::$app->session->getflash('msg')):?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span> <?=Yii::$app->session->getflash('msg');?> </span>
        </div>
    <?php endif;?>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Your email" name="email" /> </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
    <div class="form-actions">
        <button type="submit" class="btn green uppercase">Login</button>
        <label class="rememberme check mt-checkbox mt-checkbox-outline">
            <input type="checkbox" name="remember" value="1" />Remember
            <span></span>
        </label>
    </div>
    <div class="create-account">
        <p>
            <a href="<?=Yii::$app->homeUrl;?>admin/create" id="register-btn0" class="uppercase">Request account creation</a>
        </p>
    </div>
    <?php ActiveForm::end() ?>
    <!-- END LOGIN FORM -->
</div>
<div class="copyright"> <?=date('Y');?> © AQUILA. User login. </div>
