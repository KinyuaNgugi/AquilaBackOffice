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
    <?php require('manage_chart-of-accounts.php');?>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php require_once('footer.php');?>
<script type="text/javascript">
    var nav = $('#charts-page');
    nav.addClass('active open');

    $('#main').change(function () {
        getLevelOnes($('#main').val());
    });

    $('#l1').change(function () {
        getLevelTwos($('#l1').val());
    });

    $('#l3').blur(function () {
        validateLevelThree($('#l3').val());
    });

    function getLevelOnes(main)
    {
        $('#l1').empty();
        $.ajax({
            'type': 'GET',
            'url': 'chart',
            'cache': false,
            'data': {
                main : main
            },
            'success': function (l1s) {
                var converted=JSON.parse(l1s);

                $('#l1').append('<option>---Select Level One---</option>');
                for (var i=0;i<Object.keys(converted).length;i++){
                    $('#l1').append($('<option>', {
                        value: converted[i]['id'],
                        text: converted[i]['name']
                    }));
                }
            }
        });
    }

    function getLevelTwos(l1)
    {
        $('#l2').empty();
        $.ajax({
            'type': 'GET',
            'url': 'chart',
            'cache': false,
            'data': {
                l1 : l1
            },
            'success': function (l2s) {
                var converted=JSON.parse(l2s);

                $('#l2').append('<option>---Select Level Two---</option>');
                for (var i=0;i<Object.keys(converted).length;i++){
                    $('#l2').append($('<option>', {
                        value: converted[i]['id'],
                        text: converted[i]['name']
                    }));
                }
            }
        });
    }
    function validateLevelThree(l3)
    {
        $.ajax({
            'type': 'GET',
            'url': 'chart',
            'cache': false,
            'data': {
                l3 : l3
            },
            'success': function (exists) {
                if (exists)
                {
                    $('#l3').val('');
                    $('#l3_error').html('Name already taken');
                }
                else
                {
                    $('#l3_error').html('');
                }
            }
        });
    }
</script>
