$(document).ready(function() {
	$('.departamento_id').select2();
	
	$('#pagination').on('click','a',function(e){
		e.preventDefault(); 
		var num_page = $(this).attr('data-ci-pagination-page');
		crear_paginacion(num_page);
		scroll_top();
	});

	crear_paginacion(0);

    $(".form-user").on("submit", function(e) {
    	$('.btn-success').prop('disabled', true);
    	e.preventDefault();
    	$.ajax({
    		url: base_url+'usuarios/form_usuario',
    		type: 'POST',
    		dataType: 'JSON',
			data: $('.form-user').serialize(),
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				setTimeout(function(){ window.location.replace(base_url+'usuarios'); }, 2000);
			}
    	});
    });
});

function validar_form(){
    $.ajax({
        type: "POST",
        url: base_url + "usuarios/validar_form",
        data: $('.form-user').serialize(),      
        dataType: 'JSON',
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-user').submit();
			}
        }
    });
}

function crear_paginacion(pagina){
	$.ajax({
		url: base_url+'usuarios/get_usuarios/'+pagina,
		type: 'GET',
		dataType: 'JSON',
		data: $('.form-buscador').serialize(),
		success: function(response){
			$('#pagination').html(response.pagination);
			listar_tabla(response.result,response.row);
		}
	});
}

function listar_tabla(result, row){
	var row = Number(row);
	$('.tbody-usuarios tr').remove();

	$.each(result, function(index, val) {
		if(val['activo'] == 1){
			obj = '<span class="badge-'+val['usuario_id']+' badge badge-pill badge-success">Activo</span>';
		}else{
			obj = '<span class="badge-'+val['usuario_id']+' badge badge-pill badge-danger">Inactivo</span>';
		}
		
		if(permisos('Usuarios-Edit')){
			actualizar = '<a class="dropdown-item" href="'+base_url+'usuarios/form_view/'+val['usuario_id']+'"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';
		}
		if(permisos('Usuarios-Delete')){
			eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus('+val['usuario_id']+','+val['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
		}

		if(val['usuario_id'] == 1){
			val['departamento'] = 'General';
		}
		$('.tbody-usuarios').append('<tr class="tr-'+val['usuario_id']+'">'
			+'<td>'+val['usuario_id']+'</td>'
			+'<td>'+val['nombre']+' '+val['apellido']+'</td>'
			+'<td>'+val['razon_social']+'</td>'
			+'<td>'+val['telefono']+'</td>'
			+'<td>'+val['email']+'</td>'
			// +'<td>'+val['departamento']+'</td>'
			+'<td>'+val['perfil']+'</td>'
			// +'<td class="td-estatus-'+val['usuario_id']+'">'
			// +obj
			// +'</td>'
			+'<td>'
			+'<div class="btn-group">'
			  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
			  +'<div class="dropdown-menu">'
			  +actualizar
			  +eliminar
			  +'</div>'
			+'</div>'
			+'</td>'
		+'</tr>');

		row+=1;
	});

}

function scroll_top(){
	$([document.documentElement, document.body]).animate({
		scrollTop: $(".table").offset().top
	}, 1000);
}

function cambiar_estatus(usuario_id, activo) {

	var res = confirm('¿Desea cambiar el estatus del usuario #'+usuario_id);

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'usuarios/cambiar_estatus',
			type: 'POST',
			dataType: 'JSON',
			data: {usuario_id: usuario_id, activo: activo},
			success: function(res){
				actualizar_tr(res);
			}
		});
	}

}

function actualizar_tr(res){
	if(res[0]['activo'] == 1){
		obj = '<span class="badge-'+res[0]['usuario_id']+' badge badge-pill badge-success">Activo</span>';
	}else{
		obj = '<span class="badge-'+res[0]['usuario_id']+' badge badge-pill badge-danger">Inactivo</span>';
	}
	
	if(permisos('Usuarios-Edit')){
		actualizar = '<a class="dropdown-item" href="'+base_url+'usuarios/form_view/'+res[0]['usuario_id']+'"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';
	}
	if(permisos('Usuarios-Delete')){
		eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus('+res[0]['usuario_id']+','+res[0]['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
	}

	$('.tr-'+res[0]['usuario_id']).html(
		'<td>'+res[0]['usuario_id']+'</td>'
		+'<td>'+res[0]['nombre']+'</td>' 
		+'<td>'+res[0]['apellido']+'</td>'
		+'<td>'+res[0]['telefono']+'</td>'
		+'<td>'+res[0]['email']+'</td>'
		// +'<td>'+res[0]['departamento']+'</td>'
		+'<td>'+res[0]['perfil']+'</td>'
		+'<td class="td-estatus-'+res[0]['usuario_id']+'">'
		+obj
		+'</td>'
		+'<td>'
		+'<div class="btn-group">'
		  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
		  +'<div class="dropdown-menu">'
			  +actualizar
			  +eliminar
		  +'</div>'
		+'</div>'
	+'</td>');
}

function validar_password(obj){
	$('.btn-success').prop('disabled', true);
	$.ajax({
		url: base_url+'usuarios/validar_password',
		type: 'POST',
		dataType: 'JSON',
		data: $('.form-password').serialize(),
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
				$('.btn-success').prop('disabled', false);
			}else{
				update_password();
				$('.btn-success').prop('disabled', true);
			}
		}
	});
}

function update_password(){
	$('.btn-success').prop('disabled', true);
	$.ajax({
		url: base_url+'usuarios/update_password',
		type: 'POST',
		dataType: 'JSON',
		data: $('.form-password').serialize(),
		success: function(res){
			if(res.estatus == 'OK'){
				$('.alert-text-exito').html(res.message);
				$('.alert-success').show();
				setTimeout(function(){ location.reload(); }, 2000);
				$('.btn-success').prop('disabled', true);
			}else{
				$('.btn-success').prop('disabled', false);
			}
		}
	});
}