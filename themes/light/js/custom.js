$('.table').DataTable({ "language": {
      "emptyTable": "No records found for now"
    }});
 $('input[name="validity"]').daterangepicker();
 $('input[name="daterange"]').daterangepicker();

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






