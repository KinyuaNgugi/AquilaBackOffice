 <?php 
 use yii\helpers\Url;
 $page = Yii::$app->controller->action->id;
?>
 <div class="header">
      <div class="container">
        <a class="site-logo" href="<?=Yii::$app->homeUrl;?>">
          <img src="<?=Yii::$app->homeUrl;?>themes/frontend/assets/corporate/img/logos/logo-corp-red.png" alt="Metronic FrontEnd">
        </a>
        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation pull-right font-transform-inherit">
          <ul>
            <li class = "<?=($page == 'index') ? 'active': '';?>">
              <a href="<?=Yii::$app->homeurl;?>">
                Home 
              </a>               
            </li> 
            <li>
                <a href="<?=Yii::$app->homeurl;?>admin/login">Admin</a>
            </li>
            <li class = "<?=($page == 'about') ? 'active': '';?>">
                <a href="<?=Yii::$app->homeurl;?>portal/about">About</a>
            </li>
            <li class = "<?=($page == 'login') ? 'active': '';?>">
                <a href="<?=Yii::$app->homeurl;?>portal/login">Login</a>
            </li>
            <li class = "<?=($page == 'signup') ? 'active': '';?>">            
                <a href="<?=Yii::$app->homeurl;?>portal/signup">Signup</a>
            </li>
          </ul>
        </div>
        <!-- END NAVIGATION -->
      </div>
    </div>