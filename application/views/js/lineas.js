$(document).ready(function() {
    $(".form-linea").on("submit", function(e) {
    	$('.btn-success').prop('disabled', true);
    	e.preventDefault();
    	$.ajax({
    		url: base_url+'lineas/form_linea',
    		type: 'POST',
    		dataType: 'JSON',
			data: $('.form-linea').serialize(),
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				setTimeout(function(){ window.location.replace(base_url+'lineas'); }, 2000);
			}
    	});
    });
});

function validar_form(){
    $.ajax({
        type: "POST",
        url: base_url + "lineas/validar_form",
        data: $('.form-linea').serialize(),      
        dataType: 'JSON',
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-linea').submit();
			}
        }
    });
}

function eliminar_registro(linea_id){
	$.ajax({
		url: base_url+'/lineas/eliminar_registro',
		type: 'POST',
		dataType: 'JSON',
		data: {linea_id: linea_id},
		success: function(res){
			location.reload();
		}
	});
}

function actualizar_registro(linea_id, año, descripcion){
	$('.linea_id').val(linea_id);
	$('.año').val(año);
	$('.descripcion').val(descripcion);
}
