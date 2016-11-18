<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search  " action="" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search ...">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="icon-magnifier"></i>
                            </a>
                        </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li id="start-page" class="nav-item start">
                <a href="<?=Yii::$app->homeUrl;?>accounts/index" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Summary Information</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>
            </li>
            <li id="accounts-page" class="nav-item  ">
                <a href="<?=Yii::$app->homeUrl;?>accounts/accounting-info" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">Accounts Information</span>
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>                   
            </li>
             <li id="taxes-page" class="nav-item  ">
                <a href="<?=Yii::$app->homeUrl;?>accounts/tax-info" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">Tax Information</span>
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
            </li>
            <li id="banks-page" class="nav-item  ">
                <a href="<?=Yii::$app->homeUrl;?>accounts/banks" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">Bank Accounts</span>
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
            </li>
            <li id="charts-page" class="nav-item  ">
                <a href="<?=Yii::$app->homeUrl;?>accounts/chart" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">Chart of Accounts</span>
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
            </li>
            <li id="ledgers-page" class="nav-item  ">
                <a href="<?=Yii::$app->homeUrl;?>dashboard/settings" class="nav-link nav-toggle">
                    <i class="fa fa-cogs"></i>
                    <span class="title">Ledger Information</span>
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
            </li>        
            </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
