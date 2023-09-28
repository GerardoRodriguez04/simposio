$(document).ready(function() {
    $(".form-cliente").on("submit", function(e) {
    	$('.btn-success').prop('disabled', true);
    	e.preventDefault();

		var files = $('.imagen')[0].files;
		var data = new FormData();
		data.append('cliente_id', $('.cliente_id').val());
		data.append('principal_id', $('.principal_id').val());
		data.append('imagen',files[0]);
		data.append('nombre', $('.nombre').val());
		data.append('direccion', $('.direccion').val());
		data.append('nombre_imagen', $('.nombre_imagen').val());

    	$.ajax({
    		url: base_url+'clientes/form_cliente',
			method: 'POST',
			data: data,
			contentType: false,
			processData: false,
			dataType: 'JSON',
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				setTimeout(function(){ window.location.replace(base_url+'clientes'); }, 2000);
			}
    	});
    });
});

function validar_form(){
	var files = $('.imagen')[0].files;
	var data = new FormData();
	data.append('cliente_id', $('.cliente_id').val());
	data.append('principal_id', $('.principal_id').val());
	data.append('imagen',files[0]);
	data.append('nombre', $('.nombre').val());
	data.append('direccion', $('.direccion').val());
	data.append('nombre_imagen', $('.nombre_imagen').val());

    $.ajax({
        type: "POST",
        url: base_url + "clientes/validar_form",
		method: 'POST',
		data: data,
		contentType: false,
		processData: false,
		dataType: 'JSON',
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-cliente').submit();
			}
        }
    });
}

function eliminar_registro(cliente_id){
	$.ajax({
		url: base_url+'/clientes/eliminar_registro',
		type: 'POST',
		dataType: 'JSON',
		data: {cliente_id: cliente_id},
		success: function(res){
			location.reload();
		}
	});
}

function actualizar_registro(cliente_id, nombre, direccion, imagen){
	$('.cliente_id').val(cliente_id);
	$('.nombre').val(nombre);
	$('.direccion').val(direccion);
	$('.nombre_imagen').val(imagen);
}
