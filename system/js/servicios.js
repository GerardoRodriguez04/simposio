$(document).ready(function() {
	$('#pagination').on('click','a',function(e){
		e.preventDefault();
		var num_page = $(this).attr('data-ci-pagination-page');
		crear_paginacion(num_page);
		scroll_top();
	});

	crear_paginacion(0);

    $(".form-servicios").on("submit", function(e) {
    	$('.btn-success').prop('disabled', true);
    	e.preventDefault();
    	$.ajax({
    		url: base_url+'servicios/form_servicio',
    		type: 'POST',
    		dataType: 'JSON',
			data: $('.form-servicios').serialize(),
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				setTimeout(function(){ window.location.replace(base_url+'servicios'); }, 2000);
			}
    	});
    });

	$('.descripcion').summernote(
		{
			height: 150,   //set editable area's height
			codemirror: { // codemirror options
				theme: 'paper'
			},
			toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['color', ['color',]],
				['para', ['ol']],
				['table', ['table']],
			]
		}
	);
});

function validar_form(){
    $.ajax({
        type: "POST",
        url: base_url + "servicios/validar_form",
        data: $('.form-servicios').serialize(),
        dataType: 'JSON',
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-servicios').submit();
			}
        }
    });
}

function crear_paginacion(pagina){
	$.ajax({
		url: base_url+'servicios/get_servicios/'+pagina,
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
	$('.tbody-servicios tr').remove();

	$.each(result, function(index, val) {
		if(val['activo'] == 1){
			obj = '<span class="badge-'+val['servicio_id']+' badge badge-pill badge-success">Activo</span>';
		}else{
			obj = '<span class="badge-'+val['servicio_id']+' badge badge-pill badge-danger">Inactivo</span>';
		}

		if(permisos('Servicios-Edit')){
			actualizar = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_servicio('+val['servicio_id']+', '+val['departamento_id']+', `'+val['servicio']+'`, '+val['dia']+', '+val['hora']+', '+val['minuto']+', '+val['autorizacion']+', '+val['documentacion']+', `'+val['descripcion']+'`, `Actualizar`);"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';
		}

		if(permisos('Servicios-Delete')){
			eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus('+val['servicio_id']+','+val['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
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

		$('.tbody-servicios').append('<tr class="tr-'+val['servicio_id']+'">'
			+'<td>'+val['servicio_id']+'</td>'
			+'<td>'+val['departamento']+'</td>'
			+'<td>'+val['servicio']+'</td>'
			+'<td>'+val['dia']+' Dia(s) '+val['hora']+' Hora(s) '+val['minuto']+' Minutos(s)</td>'
			+'<td class="text-center">'+autorizacion+'</td>'
			+'<td class="text-center">'+documentacion+'</td>'
			+'<td class="td-estatus-'+val['servicio_id']+'">'
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

function cambiar_estatus(servicio_id, activo) {

	var res = confirm('¿Desea cambiar el estatus del usuario #'+servicio_id);

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'servicios/cambiar_estatus',
			type: 'POST',
			dataType: 'JSON',
			data: {servicio_id: servicio_id, activo: activo},
			success: function(res){
				actualizar_tr(res);
			}
		});
	}

}

function actualizar_tr(res){
	if(res[0]['activo'] == 1){
		obj = '<span class="badge-'+res[0]['servicio_id']+' badge badge-pill badge-success">Activo</span>';
	}else{
		obj = '<span class="badge-'+res[0]['servicio_id']+' badge badge-pill badge-danger">Inactivo</span>';
	}
	if(permisos('Servicios-Edit')){
		actualizar = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_servicio('+res[0]['servicio_id']+', '+res[0]['departamento_id']+', `'+res[0]['servicio']+'`, '+res[0]['dia']+', '+res[0]['hora']+', '+res[0]['minuto']+', '+res[0]['autorizacion']+', '+res[0]['documentacion']+',  `'+res[0]['descripcion']+'`, `Actualizar`);"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';
	}
	if(permisos('Servicios-Delete')){
		eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus('+res[0]['servicio_id']+','+res[0]['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
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

	$('.tr-'+res[0]['servicio_id']).html(
		'<td>'+res[0]['servicio_id']+'</td>'
		+'<td>'+res[0]['departamento']+'</td>'
		+'<td>'+res[0]['servicio']+'</td>'
		+'<td>'+res[0]['dia']+' Dia(s) '+res[0]['hora']+' Hora(s) '+res[0]['minuto']+' Minuto(s)</td>'
		+'<td class="text-center">'+autorizacion+'</td>'
		+'<td class="text-center">'+documentacion+'</td>'
		+'<td class="td-estatus-'+res[0]['servicio_id']+'">'
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

function modal_servicio(servicio_id, departamento_id, servicio, dia, hora, minuto, autorizacion, documentacion, descripcion, titulo_boton){
	$('.form-servicios').trigger('reset');
	$('.servicio_id').val(servicio_id);
	$('.departamento_id option[value='+departamento_id+']').prop('selected', true);
	$('.servicio').val(servicio);
	$('.dia').val(dia);
	$('.hora').val(hora);
	$('.minuto').val(minuto);
	if(autorizacion == 1){
		$('.autorizacion').prop('checked', true);
	}else{
		$('.autorizacion').prop('checked', false);
	}
	if(documentacion == 1){
		$('.documentacion').prop('checked', true);
	}else{
		$('.documentacion').prop('checked', false);
	}
	$('.descripcion').summernote("code", descripcion);
	$('.btn-form').html('<i class="fa fa-plus-circle" aria-hidden="true"></i>'+ titulo_boton);
	$('.modal-servicio').modal('show');
}