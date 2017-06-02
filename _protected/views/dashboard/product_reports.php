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
    <?php require('manage_products_reports.php');?>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php require_once('footer.php');?>
<script type="text/javascript">
    var nav = $('#inventory-reports-page');
    nav.addClass('active open');
    $("#products tbody").on('keyup', '.product-search', function(){
        $('.product-list').empty();
        var product=$('.product-search').val();
        //ajax action to get the products
        if (product.length > 3)
        {
            $.ajax({
                'type': 'GET',
                'url': 'getinventoryfromchart',
                'cache': false,
                'data': {
                    search:product
                },
                'success': function (prods) {
                    var converted=JSON.parse(prods);
                    for (var i=0;i<Object.keys(converted).length;i++){
                        $('.product-list').append($('<option>', {
                            value: converted[i]['name'] + '=>' +converted[i]['id'],
                            text: converted[i]['name']
                        }));
                    }
                }
            });
        }
    });
</script>

