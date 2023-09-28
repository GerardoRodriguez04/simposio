$(document).ready(function() {
    $(".form-registro").on("submit", function(e) {
    	$('.btn-form').prop('disabled', true);
    	e.preventDefault();
    	$.ajax({
    		url: base_url+'forms/form_registro',
    		type: 'POST',
    		dataType: 'JSON',
			data: $('.form-registro').serialize(),
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				setTimeout(function(){ window.location.replace(base_url+'forms'); }, 2000);
			}
    	});
    });
});

function validar_form(){
    $.ajax({
        type: "POST",
        url: base_url + "forms/validar_form",
        data: $('.form-registro').serialize(),
        dataType: 'JSON',
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-registro').submit();
			}
        }
    });
}