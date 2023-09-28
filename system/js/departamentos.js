$(document).ready(function() {
	$('#pagination').on('click','a',function(e){
		e.preventDefault();
		var num_page = $(this).attr('data-ci-pagination-page');
		crear_paginacion(num_page);
		scroll_top();
	});

	crear_paginacion(0);

    $(".form-departamentos").on("submit", function(e) {
    	$('.btn-form').prop('disabled', true);
    	e.preventDefault();
    	$.ajax({
    		url: base_url+'departamentos/form_departamento',
    		type: 'POST',
    		dataType: 'JSON',
			data: $('.form-departamentos').serialize(),
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				setTimeout(function(){ window.location.replace(base_url+'departamentos'); }, 2000);
			}
    	});
    });
});

function validar_form(){
    $.ajax({
        type: "POST",
        url: base_url + "departamentos/validar_form",
        data: $('.form-departamentos').serialize(),
        dataType: 'JSON',
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-departamentos').submit();
			}
        }
    });
}

function crear_paginacion(pagina){
	$.ajax({
		url: base_url+'departamentos/get_departamentos/'+pagina,
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
	$('.tbody-departamentos tr').remove();

	$.each(result, function(index, val) {
		excel = '';
		excel_usuarios = '';

		if(val['activo'] == 1){
			obj = '<span class="badge-'+val['departamento_id']+' badge badge-pill badge-success">Activo</span>';
		}else{
			obj = '<span class="badge-'+val['departamento_id']+' badge badge-pill badge-danger">Inactivo</span>';
		}

		if(permisos('Departamentos-Edit')){
			actualizar = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_departamento('+val['departamento_id']+', `'+val['departamento']+'`, `'+val['descripcion']+'`, `Actualizar`);"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';
			excel = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_excel('+val['departamento_id']+', `'+val['departamento']+'`);"><i class="fa fa-list-alt" aria-hidden="true" style="color: #3366cc;"></i> Cargar Servicios</a>';

			excel_usuarios = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_excel_usuarios('+val['departamento_id']+', `'+val['departamento']+'`);"><i class="fa fa-users" aria-hidden="true" style="color: #1d9b72;"></i> Cargar Usuarios</a>';
		}
		if(permisos('Departamentos-Delete')){
			eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus('+val['departamento_id']+','+val['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
		}


		detalles = '<a class="dropdown-item" href="'+base_url+'Departamentos/detalles/'+val['departamento_id']+'"><i class="fa fa-info-circle" aria-hidden="true" style="color: #272b35;"></i> Detalles</a>';

		$('.tbody-departamentos').append('<tr class="tr-'+val['departamento_id']+'">'
			+'<td>'+val['departamento_id']+'</td>'
			+'<td>'+val['departamento']+'</td>'
			+'<td>'+val['descripcion']+'</td>'
			+'<td class="td-estatus-'+val['departamento_id']+'">'
			+obj
			+'</td>'
			+'<td>'
			+'<div class="btn-group">'
			  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
			  +'<div class="dropdown-menu">'
			  +detalles
			  +actualizar
			  +eliminar
			  +excel
			  +excel_usuarios
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

function cambiar_estatus(departamento_id, activo) {

	var res = confirm('¿Desea cambiar el estatus del usuario #'+departamento_id);

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'departamentos/cambiar_estatus',
			type: 'POST',
			dataType: 'JSON',
			data: {departamento_id: departamento_id, activo: activo},
			success: function(res){
				actualizar_tr(res);
			}
		});
	}

}

function actualizar_tr(res){
	excel = '';
	excel_usuarios = '';
		
	if(res[0]['activo'] == 1){
		obj = '<span class="badge-'+res[0]['departamento_id']+' badge badge-pill badge-success">Activo</span>';
	}else{
		obj = '<span class="badge-'+res[0]['departamento_id']+' badge badge-pill badge-danger">Inactivo</span>';
	}

	if(permisos('Departamentos-Edit')){
		actualizar = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_departamento('+res[0]['departamento_id']+', `'+res[0]['departamento']+'`, `'+res[0]['descripcion']+'`,  `Actualizar`);"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';
		excel = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_excel('+res[0]['departamento_id']+', `'+res[0]['departamento']+'`);"><i class="fa fa-list-alt" aria-hidden="true" style="color: #3366cc;"></i> Cargar Servicios</a>';

		excel_usuarios = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_excel_usuarios('+res[0]['departamento_id']+', `'+res[0]['departamento']+'`);"><i class="fa fa-users" aria-hidden="true" style="color: #1d9b72;"></i> Cargar Servicios</a>';
	}
	if(permisos('Departamentos-Delete')){
		eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus('+res[0]['departamento_id']+','+res[0]['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
	}


	detalles = '<a class="dropdown-item" href="'+base_url+'Departamentos/detalles/'+res[0]['departamento_id']+'"><i class="fa fa-info-circle" aria-hidden="true" style="color: #272b35;"></i> Detalles</a>';

	$('.tr-'+res[0]['departamento_id']).html(
		'<td>'+res[0]['departamento_id']+'</td>'
		+'<td>'+res[0]['departamento']+'</td>'
		+'<td>'+res[0]['descripcion']+'</td>'
		+'<td class="td-estatus-'+res[0]['departamento_id']+'">'
		+obj
		+'</td>'
		+'<td>'
		+'<div class="btn-group">'
		  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
		  +'<div class="dropdown-menu">'
			  +detalles
			  +actualizar
			  +eliminar
			  +excel
			  +excel_usuarios
		  +'</div>'
		+'</div>'
	+'</td>');
}

function modal_departamento(departamento_id, departamento, descripcion, titulo_boton){
	$('.departamento_id').val(departamento_id);
	$('.departamento').val(departamento);
	$('.btn-form').html('<i class="fa fa-plus-circle" aria-hidden="true"></i>'+ titulo_boton);
	$('.modal-departamento').modal('show');
}

function modal_excel(departamento_id, departamento){
	$('.excel_departamento_id').val(departamento_id);
	$('.departamento_span').text(departamento);
	$('.modal-excel').modal('show');
}

function validar_servicios_excel(){
    $('.btn-servicios-excel').prop('disabled', true);
	var data = new FormData($('.form-excel')[0]);
	$.ajax({
		url: base_url+'departamentos/validar_servicios_excel',
		type: 'POST',
		dataType: 'JSON',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data){
			total = 100;
			cantidad = data.length;

			if(data != ''){
				resp = total / cantidad;
				resp = resp.toString().match(/^-?\d+(?:\.\d{0,3})?/)[0];
			    resp = precise_round(resp, 2);
				porcentaje = resp;

				porcentaje_total = cantidad * resp;
				porcentaje_total = porcentaje_total.toString().match(/^-?\d+(?:\.\d{0,3})?/)[0];
			    porcentaje_total = precise_round(porcentaje_total, 2);
				guardar_servicios_excel(data, porcentaje, resp);
			}else{
				alert('Favor de validar que todos los campos esten llenos ó que los datos no se encuentren registrados en el sistema.');
				location.reload();
			}
		}
	});
}

function guardar_servicios_excel(data, porcentaje, resp){

	console.log(data[0].dia);

	if(data[0].dia == '' || data[0].dia == null){
		data[0].dia = 0;
	}
	if(data[0].hora == '' || data[0].hora == null){
		data[0].hora = 0;
	}
	if(data[0].minuto == '' || data[0].minuto == null){
		data[0].minuto = 0;
	}

	$.ajax({
		url: base_url+'departamentos/form_servicios_masivo',
		type: 'POST',
		dataType: 'JSON',
		data:{servicio_id: data[0].servicio_id, servicio: data[0].servicio, dia: data[0].dia, hora: data[0].hora, minuto: data[0].minuto, descripcion: data[0].descripcion, autorizacion: data[0].autorizacion, documentacion: data[0].documentacion, creado_por: data[0].creado_por, active: 1, departamento_id: $('.excel_departamento_id').val()},
		success: function(res){
			console.log(res);
			data = data.slice(1);
			if(data.length == 0){
				location.reload();
			}else{
				guardar_servicios_excel(data, porcentaje, resp);
			}

			porcentaje = parseFloat($('.total_servicios_cargados').val()) + parseFloat(porcentaje);
			porcentaje = porcentaje.toString().match(/^-?\d+(?:\.\d{0,3})?/)[0];
		    porcentaje = precise_round(porcentaje, 2);
			$('.total_servicios_cargados').val(porcentaje);

			$('.progress-bar-servicios').css('width', $('.total_servicios_cargados').val()+'%');
			$('.progress-bar-servicios').attr('aria-valuenow', $('.total_servicios_cargados').val());
			$('.progress-bar-servicios').text($('.total_servicios_cargados').val()+'%');
		}
	});

}

function modal_excel_usuarios(departamento_id, departamento){
	$('.excel_usuarios_departamento_id').val(departamento_id);
	$('.departamento_usuarios_span').text(departamento);
	$('.modal-excel-usuarios').modal('show');
}

function validar_usuarios_excel(){
	if($('.perfil_id option:selected').val() == ''){
		alert('Favor de seleccionar un perfil.');
	}else{
	    $('.btn-usuarios-excel').prop('disabled', true);
		var data = new FormData($('.form-excel-usuarios')[0]);
		$.ajax({
			url: base_url+'departamentos/validar_usuarios_excel',
			type: 'POST',
			dataType: 'JSON',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
				total = 100;
				cantidad = data.length;

				if(data != ''){
					resp = total / cantidad;
					resp = resp.toString().match(/^-?\d+(?:\.\d{0,3})?/)[0];
				    resp = precise_round(resp, 2);
					porcentaje = resp;

					porcentaje_total = cantidad * resp;
					porcentaje_total = porcentaje_total.toString().match(/^-?\d+(?:\.\d{0,3})?/)[0];
				    porcentaje_total = precise_round(porcentaje_total, 2);
					guardar_usuarios_excel(data, porcentaje, resp);
				}else{
					alert('Favor de validar que todos los campos esten llenos ó que los datos no se encuentren registrados en el sistema.');
					location.reload();
				}
			}
		});
	}
}

function guardar_usuarios_excel(data, porcentaje, resp){

	$.ajax({
		url: base_url+'departamentos/form_usuarios_masivo',
		type: 'POST',
		dataType: 'JSON',
		data:{usuario_id: data[0].usuario_id, nombre: data[0].nombre, apellido: data[0].apellido, telefono: data[0].telefono, email: data[0].email, perfil_id: $('.perfil_id option:selected').val(), password: data[0].password, creado_por: data[0].creado_por, activo: 1, departamento_id: $('.excel_usuarios_departamento_id').val()},
		success: function(res){
			console.log(res);
			data = data.slice(1);
			if(data.length == 0){
				location.reload();
			}else{
				guardar_usuarios_excel(data, porcentaje, resp);
			}

			porcentaje = parseFloat($('.total_usuarios_cargados').val()) + parseFloat(porcentaje);
			porcentaje = porcentaje.toString().match(/^-?\d+(?:\.\d{0,3})?/)[0];
		    porcentaje = precise_round(porcentaje, 2);
			$('.total_usuarios_cargados').val(porcentaje);

			$('.progress-bar-usuarios').css('width', $('.total_usuarios_cargados').val()+'%');
			$('.progress-bar-usuarios').attr('aria-valuenow', $('.total_usuarios_cargados').val());
			$('.progress-bar-usuarios').text($('.total_usuarios_cargados').val()+'%');
		}
	});

}