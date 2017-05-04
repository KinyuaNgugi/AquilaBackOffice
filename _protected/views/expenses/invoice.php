<?php
	/* @var $this yii\web\View */
    $this->title = 'Welcome to Accounts';
 ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/aquila/_protected/views/accounts/nav.php');?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/aquila/_protected/views/accounts/accounts-sidebar.php');?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <?php require('invoice-form.php');?>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/aquila/_protected/views/accounts/footer.php');?>
<script type="text/javascript">
    var nav = $('#grn-page');
    nav.addClass('active open');
</script>
