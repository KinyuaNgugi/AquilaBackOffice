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

                <!-- END NOTIFICATION DROPDOWN -->
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <span class="username username-hide-on-mobile"> <?=Yii::$app->session->get('name');?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?=Yii::$app->homeUrl;?>accounts/index">
                                <i class="icon-user"></i> Accounts
                            </a>
                        </li>
                        <li>
                            <a href="<?=Yii::$app->homeUrl;?>hrm/index">
                                <i class="icon-user"></i> HRM
                            </a>
                        </li>
                        <li class="divider"> </li>
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