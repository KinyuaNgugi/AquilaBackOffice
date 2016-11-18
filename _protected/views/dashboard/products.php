<?php
	/* @var $this yii\web\View */
    $this->title = 'Welcome to Products Page';
 ?>
<?php require_once('nav.php');?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php require_once('user-sidebar.php');?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <?php require('manage_products.php');?>
    <!-- END CONTENT -->
      <!-- BEGIN QUICK SIDEBAR -->
    <?php require_once('quick-sidebar.php');?>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<?php require_once('footer.php');?>
<script type="text/javascript">
    var nav = $('#products-page');
    nav.addClass('active open');
</script>
<script>
    $("#product-form").on('blur', '#product-code', function(){
        var code=$('#product-code').val();
        //ajax action to get the products
        $.ajax({
            'type': 'GET',
            'url': '../dashboard/validate',
            'cache': false,
            'data': {
                prodcode:code
            },
            'success': function (prods) {
                if (prods>0)
                {
                    $('#product-code').val('');
                    $('#code-error').html('Code '+ code +' Already In Use');
                }
                else
                    $('#code-error').html('');
            }
        });
    });

    $("#product-form").on('blur', '#product-name', function(){
        var name=$('#product-name').val();
        //ajax action to get the products
        $.ajax({
            'type': 'GET',
            'url': '../dashboard/validate',
            'cache': false,
            'data': {
                prodname:name
            },
            'success': function (prods) {
                if (prods>0)
                {
                    $('#product-name').val('');
                    $('#name-error').html('Name ' + name+ ' Already Taken');
                }
                else
                    $('#name-error').html('');
            }
        });
    });
</script>
