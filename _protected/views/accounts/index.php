<?php
	/* @var $this yii\web\View */
    $this->title = 'Welcome to Accounts';
 ?>
<?php require_once('nav.php');?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php require_once('accounts-sidebar.php');?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <?php require('general-info.php');?>
    <!-- END CONTENT -->
      <!-- BEGIN QUICK SIDEBAR -->
    <?php require_once('quick-sidebar.php');?>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<?php require_once('footer.php');?>
<script type="text/javascript">
    var nav = $('#start-page');
    nav.addClass('active open');
</script>
