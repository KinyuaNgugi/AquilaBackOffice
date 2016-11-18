<?php
	/* @var $this yii\web\View */
    $this->title = 'Welcome to Accounts';
 ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/aquila/_protected/views/accounts/nav.php');?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php require_once('expenses-sidebar.php');?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <?php require('purchase-order-info.php');?>
    <!-- END CONTENT -->
      <!-- BEGIN QUICK SIDEBAR -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/aquila/_protected/views/accounts/quick-sidebar.php');?>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/aquila/_protected/views/accounts/footer.php');?>
<script type="text/javascript">
    var nav = $('#start-page');
    nav.addClass('active open');
</script>
