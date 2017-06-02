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
    <?php require('manage_banks.php');?>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php require_once('footer.php');?>
<script type="text/javascript">
    var nav = $('#banks-page');
    nav.addClass('active open');

    $('#bank').change(function () {
        getBankBranches($('#bank').val());
    });

    function getBankBranches(bank_code)
    {
        $.ajax({
            'type': 'GET',
            'url': 'banks',
            'cache': false,
            'data': {
                bank_code : bank_code
            },
            'success': function (branches) {
                var converted=JSON.parse(branches);

                $('#branch').append('<option>---Select Branch---</option>');
                for (var i=0;i<Object.keys(converted).length;i++){
                    $('#branch').append($('<option>', {
                        value: converted[i]['id'],
                        text: converted[i]['name']
                    }));
                    $('#banky').val(converted[i]['bank_id']);
                }
            }
        });
    }
</script>
