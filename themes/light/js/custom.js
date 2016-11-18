
$('.table').DataTable({ "language": {
      "emptyTable": "No records found for now"
    }});
 $('input[name="validity"]').daterangepicker();
 $('input[name="daterange"]').daterangepicker();

$(function(){
	$('#partner_type').change(function(){
		value = $('#partner_type').val();
		business_type = $('#business_type');
		national_id = $('#national_id');
		b_reg = $('#b_reg');
		if(value == 'individual')
		{
			national_id.fadeIn('fast');
			b_reg.fadeOut('fast');
			business_type.attr('disabled', 'true');
			business_type.val(null);
			business_type.removeAttr('data-validation');
		}
		else
		{
			b_reg.fadeIn('fast');
			business_type.removeAttr('disabled');
			business_type.attr('data-validation', 'required');
		}
	})
})
//change user profile pic
 $('#uploadform-imagefile').change(function(e){
    e.preventDefault();
    var formdata = new FormData($('#w0')[0]);
    var preview = $('#uploadform-imagefile-preview');
    preview.show('fast');
    preview.html("<img src='/themes/light/images/icons/loader.gif'>");
    $.ajax({
        url : '/uploads/updatepic',
        type : 'post',
        cache : false,
        processData : false,
        contentType : false,
        data : formdata,
        success :function(response){
            preview.fadeIn('slow');
            preview.html(response);
        }
    });
});

 //Upload scanned copy of ID
 $('#iduploadform-imagefile').change(function(e){
    e.preventDefault();
    var formdata = new FormData($('#w0')[0]);
    var preview = $('#iduploadform-imagefile-preview');
    preview.html("<img src='/themes/light/images/icons/loader.gif'>");
    $.ajax({
        url : '/uploads/uploadid',
        type : 'post',
        cache : false,
        processData : false,
        contentType : false,
        data : formdata,
        success :function(response){
            preview.fadeIn('slow');
            preview.html(response);
        }
    });
});

 //Upload scanned business registration form
 $('#reguploadform-imagefile').change(function(e){
    e.preventDefault();
    var formdata = new FormData($('#w0')[0]);
    var preview = $('#reguploadform-imagefile-preview');
    preview.html("<img src='/themes/light/images/icons/loader.gif'>");
    $.ajax({
        url : '/uploads/uploadbs',
        type : 'post',
        cache : false,
        processData : false,
        contentType : false,
        data : formdata,
        success :function(response){
            preview.fadeIn('slow');
            preview.html(response);
        }
    });
});

$("a.fancy").fancybox();

function commisionCalc()
{
	var formdata = new FormData($('#w0')[0]);
	$.ajax({
		url : '/payments/calculator',
		type : 'post',
		cache : false,
		processData : false,
		contentType : false,
		data : formdata,
		success :function(response){
            var res = JSON.parse(response);
			$('#amount').text(res.year);
            $('#amount_month').text(res.month);
		}
	});
}


