<?php
	/* @var $this yii\web\View */
    $this->title = 'Welcome to Accounts';
 ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/aquila/_protected/views/dashboard/nav.php');?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/aquila/_protected/views/dashboard/accounts-sidebar.php');?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <?php require('manage-suppliers.php');?>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/aquila/_protected/views/dashboard/footer.php');?>
<script type="text/javascript">
    var nav = $('#suppliers-page');
    nav.addClass('active open');
</script>
