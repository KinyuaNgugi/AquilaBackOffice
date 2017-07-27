<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?=Yii::$app->homeUrl;?>dashboard/index">
                <img src="<?=Yii::$app->homeUrl;?>themes/light/images/logos/aquilalogo.png" alt="logo" class="logo-default" />
            </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <?php if(Yii::$app->session->get('admin')):?>
               <!--  <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-default"> 7 </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3>
                                <span class="bold">12 pending</span> notifications</h3>
                            <a href="#">view all</a>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                               <?php for($i=0;$i<10;$i++):?>
                                <li>
                                    <a href="javascript:;">
                                        <span class="time">just now</span>
                                        <span class="details">
                                            <span class="label label-sm label-icon label-success">
                                                <i class="fa fa-plus"></i>
                                            </span> New partner registered. </span>
                                    </a>
                                </li>
                                <?php endfor;?>
                            </ul>
                        </li>
                    </ul>
                </li> -->
                <?php endif;?>
                <!-- END NOTIFICATION DROPDOWN -->
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <?php if(Yii::$app->session->get('fbid') && !Yii::$app->session->get('photo')):?>
                            <img class="img-responsive img-circle" src="http://graph.facebook.com/<?=Yii::$app->session->get('fbid');?>/picture?type=large">
                        <?php endif;?>
                        <?php if(Yii::$app->session->get('photo')):?>
                             <img class="img-responsive img-circle" src="<?=Yii::$app->get('s3bucket')->getUrl('PartnerPortal/'.Yii::$app->session->get('photo'));?>">   
                        <?php endif;?>
                        <span class="username username-hide-on-mobile"> <?=Yii::$app->session->get('name');?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                    <?php if(!Yii::$app->session->get('admin')):?>
                        <li>
                            <a href="<?=Yii::$app->homeUrl;?>accounts/index">
                                <i class="icon-user"></i> Accounts
                            </a>
                        </li>
                        <li class="divider"> </li>
                      <?php endif;?> 
                        <li>
                            <a href="<?=Yii::$app->homeUrl;?>dashboard/logout">
                                <i class="icon-key"></i> Log Out 
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->