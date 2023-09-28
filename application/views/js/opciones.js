$(document).ready(function() {
	// $('.usuario_autoriza_id').select2();
	// $('.departamento_solicitante_id').select2();
	$('.departamento_solicitante_id').multipleSelect({
		filter: true,
	});

	$('.usuario_autoriza_id').multipleSelect({
		filter: true,
	});

	$('.perfil_autoriza_id').multipleSelect({
		filter: true,
	});

	$('#pagination').on('click','a',function(e){
		e.preventDefault();
		var num_page = $(this).attr('data-ci-pagination-page');
		crear_paginacion(num_page);
		scroll_top();
	});

	crear_paginacion(0);

    $(".form-opciones").on("submit", function(e) {
    	$('.btn-success').prop('disabled', true);
    	e.preventDefault();
    	$.ajax({
    		url: base_url+'opciones/form_opcion',
    		type: 'POST',
    		dataType: 'JSON',
			data: $('.form-opciones').serialize(),
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				// crear_paginacion(0);
				$('.modal-opciones').modal('hide');
				setTimeout(function(){ location.reload(); }, 2000);
			}
    	});
    });

	// $('.descripcion').summernote(
	// 	{
	// 		height: 150,   //set editable area's height
	// 		codemirror: { // codemirror options
	// 			theme: 'paper'
	// 		},
	// 		toolbar: [
	// 			['style', ['bold', 'italic', 'underline', 'clear']],
	// 			['color', ['color',]],
	// 			['para', ['ol']],
	// 			['table', ['table']],
	// 		]
	// 	}
	// );
});

function validar_form(){
    $.ajax({
        type: "POST",
        url: base_url + "opciones/validar_form",
        data: $('.form-opciones').serialize(),
        dataType: 'JSON',
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-opciones').submit();
			}
        }
    });
}

function crear_paginacion(pagina){
	$.ajax({
		url: base_url+'opciones/get_opciones/'+pagina,
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
	$('.tbody-opciones tr').remove();

	$.each(result, function(index, val) {
		cambiar_estatus = '';
		eliminar = '';

		if(val['activo'] == 1){
			obj = '<span class="badge-'+val['opcion_servicio_id']+' badge badge-pill badge-success">Activo</span>';
		}else{
			obj = '<span class="badge-'+val['opcion_servicio_id']+' badge badge-pill badge-danger">Inactivo</span>';
		}

		if(permisos('Opciones-Edit')){
			actualizar = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_opcion('+val['opcion_servicio_id']+', '+val['departamento_id']+', '+val['servicio_id']+', `'+val['opcion']+'`, '+val['dia']+', '+val['hora']+', '+val['minuto']+', '+val['autorizacion']+', '+val['tipo_autorizar']+', '+val['documentacion']+', `'+val['descripcion']+'`, `Actualizar`);"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';
		}

		if(permisos('Opciones-Delete')){
			cambiar_estatus = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus_modal('+val['opcion_servicio_id']+','+val['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
			
			eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="eliminar_opcion('+val['opcion_servicio_id']+', this);"><i class="fa fa-trash-o" aria-hidden="true" style="color: #e02830;"></i> Eliminar</a>';
		}


		if(val['autorizacion'] == 1){
			autorizacion = '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #1d9b72;"></i>';
		}else{
			autorizacion = '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #ea4141;"></i>';
		}

		if(val['documentacion'] == 1){
			documentacion = '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #1d9b72;"></i>';
		}else{
			documentacion = '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #ea4141;"></i>';
		}

		$('.tbody-opciones').append('<tr class="tr-'+val['opcion_servicio_id']+'">'
			+'<td>'+val['opcion_servicio_id']+'</td>'
			+'<td>'+val['departamento']+'</td>'
			+'<td>'+val['servicio']+'</td>'
			+'<td>'+val['opcion']+'</td>'
			+'<td>'+val['dia']+' Dia(s) '+val['hora']+' Hora(s) '+val['minuto']+' Minutos(s)</td>'
			+'<td class="text-center">'+autorizacion+'</td>'
			+'<td class="text-center">'+documentacion+'</td>'
			+'<td class="td-estatus-'+val['opcion_servicio_id']+'">'
			+obj
			+'</td>'
			+'<td>'
			+'<div class="btn-group">'
			  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
			  +'<div class="dropdown-menu">'
			  +actualizar
			  +cambiar_estatus
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

function cambiar_estatus_modal(opcion_servicio_id, activo) {

	var res = confirm('¿Desea cambiar el estatus del usuario #'+opcion_servicio_id);

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'opciones/cambiar_estatus',
			type: 'POST',
			dataType: 'JSON',
			data: {opcion_servicio_id: opcion_servicio_id, activo: activo},
			success: function(res){
				console.log(res);
				actualizar_tr(res);
			}
		});
	}

}

function actualizar_tr(res){
	cambiar_estatus = '';
	eliminar = '';
	
	if(res[0]['activo'] == 1){
		obj = '<span class="badge-'+res[0]['opcion_servicio_id']+' badge badge-pill badge-success">Activo</span>';
	}else{
		obj = '<span class="badge-'+res[0]['opcion_servicio_id']+' badge badge-pill badge-danger">Inactivo</span>';
	}
	if(permisos('Opciones-Edit')){
		actualizar = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_opcion('+res[0]['opcion_servicio_id']+', '+res[0]['departamento_id']+', '+res[0]['servicio_id']+', `'+res[0]['opcion']+'`, '+res[0]['dia']+', '+res[0]['hora']+', '+res[0]['minuto']+', '+res[0]['autorizacion']+', '+res[0]['tipo_autorizar']+', '+res[0]['documentacion']+',  `'+res[0]['descripcion']+'`, `Actualizar`);"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';
	}
	if(permisos('Opciones-Delete')){
		cambiar_estatus = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus('+res[0]['opcion_servicio_id']+','+res[0]['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
		
		eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="eliminar_opcion('+res[0]['opcion_servicio_id']+', this);"><i class="fa fa-trash-o" aria-hidden="true" style="color: #e02830;"></i> Eliminar</a>';
	}


		if(res[0]['autorizacion'] == 1){
			autorizacion = '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #1d9b72;"></i>';
		}else{
			autorizacion = '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #ea4141;"></i>';
		}

		if(res[0]['documentacion'] == 1){
			documentacion = '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #1d9b72;"></i>';
		}else{
			documentacion = '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #ea4141;"></i>';
		}

	$('.tr-'+res[0]['opcion_servicio_id']).html(
		'<td>'+res[0]['opcion_servicio_id']+'</td>'
		+'<td>'+res[0]['departamento']+'</td>'
		+'<td>'+res[0]['servicio']+'</td>'
		+'<td>'+res[0]['opcion']+'</td>'
		+'<td>'+res[0]['dia']+' Dia(s) '+res[0]['hora']+' Hora(s) '+res[0]['minuto']+' Minuto(s)</td>'
		+'<td class="text-center">'+autorizacion+'</td>'
		+'<td class="text-center">'+documentacion+'</td>'
		+'<td class="td-estatus-'+res[0]['opcion_servicio_id']+'">'
		+obj
		+'</td>'
		+'<td>'
		+'<div class="btn-group">'
		  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
		  +'<div class="dropdown-menu">'
		  +actualizar
		  +cambiar_estatus
		  +eliminar
		  +'</div>'
		+'</div>'
	+'</td>');
}

function modal_opcion(opcion_servicio_id, departamento_id, servicio_id, opcion, dia, hora, minuto, autorizacion, tipo_autorizar, documentacion, descripcion, titulo_boton){
    $('.btn-success').prop('disabled', false);
	$('.form-opciones').trigger('reset');
	$('.opcion_servicio_id').val(opcion_servicio_id);
	$('.departamento_id option[value='+departamento_id+']').prop('selected', true);

	if(departamento_id > 0){
		get_servicio_departamento(departamento_id, servicio_id);

		get_departamento_opciones(opcion_servicio_id);
	}

	$('.opcion').val(opcion);
	$('.dia').val(dia);
	$('.hora').val(hora);
	$('.minuto').val(minuto);
	if(autorizacion == 1){
		$('.autorizacion').prop('checked', true);
		$("input[name=tipo_autorizar][value=" + tipo_autorizar + "]").attr('checked', 'checked');
		view_radio_autorizar();
		view_select_autorizar(tipo_autorizar);
		get_encargado_autorizacion(tipo_autorizar, opcion_servicio_id);
	}else{
		$('.autorizacion').prop('checked', false);
	}
	if(documentacion == 1){
		$('.documentacion').prop('checked', true);
	}else{
		$('.documentacion').prop('checked', false);
	}
	// $('.descripcion').summernote("code", descripcion);
	$('.descripcion').text(descripcion);
	$('.btn-form').html('<i class="fa fa-plus-circle" aria-hidden="true"></i>'+ titulo_boton);
	$('.modal-opciones').modal('show');
}

function get_departamento_opciones(opcion_servicio_id){
	$.ajax({
		url: base_url+'opciones/get_departamento_opciones',
		type: 'POST',
		dataType: 'JSON',
		data: {opcion_servicio_id: opcion_servicio_id},
		success: function(res){
			$.each(res, function(index, val) {
				// console.log(val.departamento_solicitante_id);
				$('.departamento_solicitante_id option[value="'+val.departamento_solicitante_id+'"]').prop('selected', true);
			});

			// $('.departamento_solicitante_id').trigger('change');
			$('.departamento_solicitante_id').multipleSelect('refresh');
		}
	});
}

function eliminar_opcion(opcion_servicio_id, obj){
	var res = confirm('¿Desea eliminar la opcion #'+opcion_servicio_id+'?');

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'opciones/eliminar_opcion',
			type: 'POST',
			dataType: 'JSON',
			data: {opcion_servicio_id: opcion_servicio_id},
			success: function(res){
				if(res == true){
					$(obj).closest('tr').remove();
				}else{
					alert('El opcion no pudo ser eliminado, ya que se encuentra en una solicitud.');
				}
			}
		});
	}
}

function get_servicio_departamento_buscador(departamento_id){
	$('.buscador_servicio_id option').remove();
	$.ajax({
		url: base_url+'opciones/get_servicio_departamento',
			type: 'POST',
			dataType: 'JSON',
			data: {departamento_id: departamento_id},
			success: function(res){
				if(res != ''){
					$('.buscador_servicio_id').append('<option value="">Seleccione un servicio</option>');
					$.each(res, function(index, val) {
						$('.buscador_servicio_id').append('<option value="'+val.servicio_id+'">'+val.servicio+'</option>');
					});
				}else{
					alert('No encuentran servicios relacionados con el departamento.');
				}
			}
	});
	
}

function get_servicio_departamento(departamento_id, servicio_id){
	$('.servicio_id option').remove();
	$.ajax({
		url: base_url+'opciones/get_servicio_departamento',
			type: 'POST',
			dataType: 'JSON',
			data: {departamento_id: departamento_id},
			success: function(res){
				if(res != ''){
					$('.servicio_id').append('<option value="">Seleccione un servicio</option>');
					$.each(res, function(index, val) {
						$('.servicio_id').append('<option value="'+val.servicio_id+'">'+val.servicio+'</option>');
					});

					if(servicio_id > 0){
						$('.servicio_id option[value='+servicio_id+']').prop('selected', true);
					}
				}else{
					alert('No encuentran servicios relacionados con el departamento.');
				}
			}
	});
	
}

function get_encargado_autorizacion(tipo_autorizar, opcion_servicio_id){
	if($('.autorizacion').prop("checked")){
		$.ajax({
			url: 'opciones/get_encargado_autorizacion',
			type: 'POST',
			dataType: 'JSON',
			data: {departamento_id: $('.departamento_id option:selected').val(), opcion_servicio_id: opcion_servicio_id},
			success: function(res){
						console.log(res);
				$.each(res, function(index, val) {
						// console.log(val);
					if(tipo_autorizar == 1){					
						$('.usuario_autoriza_id > option').each(function() {
							console.log(this.value);
						    if(this.value == val.usuario_autoriza_id){
								$(this).prop('selected', true);
						    }
						});
					}

					if(tipo_autorizar == 2){					
						$('.perfil_autoriza_id > option').each(function() {
							console.log(this.value);
						    if(this.value == val.perfil_autoriza_id){
								$(this).prop('selected', true);
						    }
						});
					}
				});

				$('.usuario_autoriza_id').multipleSelect('refresh');
				$('.perfil_autoriza_id').multipleSelect('refresh');
			}
		});
	}
}

function view_select_autorizar(tipo){
	if(tipo == 1){
		$('.div-usuarios-autorizar').show();
		$('.div-perfiles-autorizar').hide();
	}else{
		$('.div-usuarios-autorizar').hide();
		$('.div-perfiles-autorizar').show();
	}
}

function view_radio_autorizar(){
	if($('.autorizacion').prop("checked")){
		$('.div-radio').show();
	}else{
		$('.div-radio').hide();
		$('.div-perfiles-autorizar').hide();
		$('.div-usuarios-autorizar').hide();
	}
}