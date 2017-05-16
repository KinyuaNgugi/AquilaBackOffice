<?php
	/* @var $this yii\web\View */
    $this->title = 'Welcome to Products Page';
 ?>
<?php require_once('nav.php');?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php require_once('accounts-sidebar.php');?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <?php require('manage_creditor_reports.php');?>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php require_once('footer.php');?>
<script type="text/javascript">
    var nav = $('#creditors-reports-page');
    nav.addClass('active open');
</script>

