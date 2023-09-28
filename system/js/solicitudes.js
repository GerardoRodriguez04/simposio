$(document).ready(function() {
	$('#pagination').on('click','a',function(e){
		e.preventDefault();
		var num_page = $(this).attr('data-ci-pagination-page');
		crear_paginacion(num_page);
		scroll_top();
	});

	crear_paginacion(0);

    $(".form-solicitudes").on("submit", function(e) {
    	$('.btn-success').prop('disabled', true);
    	e.preventDefault();

		var data = new FormData($('.form-solicitudes')[0]);

		data.append('autorizacion', $('.servicio_id option:selected').data('autorizacion'));
		data.append('documentacion', $('.servicio_id option:selected').data('documentacion'));

    	$.ajax({
    		url: base_url+'solicitudes/form_solicitud',
    		type: 'POST',
    		dataType: 'JSON',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				setTimeout(function(){ window.location.replace(base_url+'solicitudes'); }, 2000);
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

	$('.descripcion_servicio').summernote(
		{
			height: 75,   //set editable area's height
			toolbar: false
		}
	);

	$('.descripcion_servicio').summernote('disable');

	$('.nav-solicitud').click();
});

function validar_form(){
	var data = new FormData($('.form-solicitudes')[0]);
	data.append('autorizacion', $('.servicio_id option:selected').data('autorizacion'));
	data.append('documentacion', $('.servicio_id option:selected').data('documentacion'));

    $.ajax({
        url: base_url + "solicitudes/validar_form",
        type: "POST",
        dataType: 'JSON',
        data: data,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-solicitudes').submit();
			}
        }
    });
}

function crear_paginacion(pagina){
	$.ajax({
		url: base_url+'solicitudes/get_solicitudes/'+pagina,
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
	$('.tbody-'+$('.estatus_id').val()+' tr').remove();

	$.each(result, function(index, val) {

		detalles = '';
		cambiar_estatus = '';
		proceso = '';
		documento = ''
		autorizar = '';

		if(val['documento'] !=  null){
			documento = '<a class="dropdown-item" href="'+base_url+'solicitudes/descargar_documento_solicitud/'+val['solicitud_id']+'/'+val['documento']+'"><i class="fa fa-file-text-o" aria-hidden="true" style="color: #d50000;"></i> Descargar</a>';
		}

		// if($('.estatus_id').val() > 1){
			detalles = '<a class="dropdown-item" href="'+base_url+'Solicitudes/detalles_view/'+val['solicitud_id']+'"><i class="fa fa-info-circle" aria-hidden="true" style="color: #00838f;"></i> Detalles</a>';
		// }
		
		if(permisos('Solicitudes-Edit')){
			// if($('.estatus_id').val() == 0){
			// 		autorizar = '<a class="dropdown-item" href="javascript:void(0);" onclick="autorizar_solicitud('+val['solicitud_id']+', 1);"><i class="fa fa-check-circle-o" aria-hidden="true" style="color: #1d9b72;"></i> Autorizar Solicitud</a>';
			// }
			// if($('.estatus_id').val() == 1){					
			// 		cambiar_estatus = '<a class="dropdown-item" href="javascript:void(0);" onclick="servicio_solicitud('+val['solicitud_id']+', '+val['dia']+', '+val['hora']+', '+val['minuto']+', 2, `tomar`);"><i class="fa fa-folder-open-o" aria-hidden="true" style="color: #d05400;"></i> Tomar Solicitud</a>';
			// }
			// if($('.estatus_id').val() == 2){
			// 	cambiar_estatus = '<a class="dropdown-item" href="javascript:void(0);" onclick="servicio_solicitud('+val['solicitud_id']+', '+val['dia']+', '+val['hora']+', '+val['minuto']+', 3, `procesar`);"><i class="fa fa-calendar-check-o" aria-hidden="true" style="color: #d05400;"></i> Procesar Solicitud</a>';
			// }
			// if($('.estatus_id').val() == 3){

			// 	cambiar_estatus = '<a class="dropdown-item" href="javascript:void(0);" onclick="servicio_solicitud('+val['solicitud_id']+', '+val['dia']+', '+val['hora']+', '+val['minuto']+', 4, `finalizar`);"><i class="fa fa-folder" aria-hidden="true" style="color: #d05400;"></i> Finalizar Solicitud</a>';
			// }
		}

		if($('.estatus_id').val() == 0){		
			$('.tbody-'+val['estatus_id']+'').append('<tr class="tr-'+val['solicitud_id']+'">'
				+'<td>'+val['solicitud_id']+'</td>'
				+'<td>'+val['departamento_solicitante']+':<p>'+val['solicitante']+'</p></td>'
				+'<td>'+val['servicio']+'</td>'
				+'<td>'+val['fecha_creacion']+'</td>'
				+'<td>'+val['dia']+' Dia(s) '+val['hora']+' Hora(s) '+val['minuto']+' Minutos(s)</td>'
				+'<td>'
				+'<div class="btn-group">'
				  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
				  +'<div class="dropdown-menu">'
				  +detalles
				  +cambiar_estatus
				  +proceso
				  +autorizar
				  +documento
				  +'</div>'
				+'</div>'
				+'</td>'
			+'</tr>');
		}

		if($('.estatus_id').val() == 1){		
			$('.tbody-'+val['estatus_id']+'').append('<tr class="tr-'+val['solicitud_id']+'">'
				+'<td>'+val['solicitud_id']+'</td>'
				+'<td>'+val['departamento_solicitante']+':<p>'+val['solicitante']+'</p></td>'
				+'<td>'+val['servicio']+'</td>'
				+'<td>'+val['fecha_creacion']+'</td>'
				+'<td>'+val['dia']+' Dia(s) '+val['hora']+' Hora(s) '+val['minuto']+' Minutos(s)</td>'
				+'<td>'
				+'<div class="btn-group">'
				  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
				  +'<div class="dropdown-menu">'
				  +detalles
				  +cambiar_estatus
				  +proceso
				  +autorizar
				  +documento
				  +'</div>'
				+'</div>'
				+'</td>'
			+'</tr>');
		}

		if($('.estatus_id').val() == 2){		
			$('.tbody-'+val['estatus_id']+'').append('<tr class="tr-'+val['solicitud_id']+'">'
				+'<td>'+val['solicitud_id']+'</td>'
				+'<td>'+val['departamento_solicitante']+':<p>'+val['solicitante']+'</p></td>'
				+'<td>'+val['servicio']+'</td>'
				+'<td>'+val['departamento_asignado']+':<p>'+val['responsable']+'</p></td>'
				+'<td>'+val['fecha_inicio']+'</td>'
				+'<td>'+val['fecha_final']+'</td>'
				+'<td>'
				+'<div class="btn-group">'
				  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
				  +'<div class="dropdown-menu">'
				  +detalles
				  +cambiar_estatus
				  +proceso
				  +autorizar
				  +documento
				  +'</div>'
				+'</div>'
				+'</td>'
			+'</tr>');
		}

		if($('.estatus_id').val() == 3){		
			$('.tbody-'+val['estatus_id']+'').append('<tr class="tr-'+val['solicitud_id']+'">'
				+'<td>'+val['solicitud_id']+'</td>'
				+'<td>'+val['departamento_solicitante']+':<p>'+val['solicitante']+'</p></td>'
				+'<td>'+val['servicio']+'</td>'
				+'<td>'+val['departamento_asignado']+':<p>'+val['responsable']+'</p></td>'
				+'<td>'+val['fecha_inicio']+'</td>'
				+'<td>'+val['fecha_final']+'</td>'
				+'<td>'+val['fecha_procesado']+'</td>'
				+'<td>'
				+'<div class="btn-group">'
				  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
				  +'<div class="dropdown-menu">'
				  +detalles
				  +cambiar_estatus
				  +proceso
				  +autorizar
				  +documento
				  +'</div>'
				+'</div>'
				+'</td>'
			+'</tr>');
		}

		if($('.estatus_id').val() == 4){		
			$('.tbody-'+val['estatus_id']+'').append('<tr class="tr-'+val['solicitud_id']+'">'
				+'<td>'+val['solicitud_id']+'</td>'
				+'<td>'+val['departamento_solicitante']+':<p>'+val['solicitante']+'</p></td>'
				+'<td>'+val['servicio']+'</td>'
				+'<td>'+val['departamento_asignado']+':<p>'+val['responsable']+'</p></td>'
				+'<td>'+val['fecha_creacion']+'</td>'
				+'<td>'+val['fecha_inicio']+'</td>'
				+'<td>'+val['fecha_final']+'</td>'
				+'<td>'+val['fecha_procesado']+'</td>'
				+'<td>'+val['fecha_finalizado']+'</td>'
				+'<td>'
				+'<div class="btn-group">'
				  +'<button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desplegar</button>'
				  +'<div class="dropdown-menu">'
				  +detalles
				  +cambiar_estatus
				  +proceso
				  +autorizar
				  +documento
				  +'</div>'
				+'</div>'
				+'</td>'
			+'</tr>');
		}

		row+=1;
	});
}

function scroll_top(){
	$([document.documentElement, document.body]).animate({
		scrollTop: $(".table").offset().top
	}, 1000);
}

function servicio_solicitud(solicitud_id, dia, hora, minuto, estatus_id, mensaje) {
	var res = confirm('¿Desea '+mensaje+' la solicitud #'+solicitud_id+'?');

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'solicitudes/servicio_solicitud',
			type: 'POST',
			dataType: 'JSON',
			data: {solicitud_id: solicitud_id, dia: dia, hora: hora, minuto: minuto, estatus_id: estatus_id},
			success: function(res){
				$('.nav-'+estatus_id).click();
			}
		});
	}
}

function autorizar_solicitud(solicitud_id, estatus_id){
	var res = confirm('¿Desea autorizar la solicitud #'+solicitud_id+'?, pasara al estatus pendiente.');

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'solicitudes/proceso_solicitud',
			type: 'POST',
			dataType: 'JSON',
			data: {solicitud_id: solicitud_id, estatus_id: estatus_id},
			success: function(res){
				$('.nav-'+estatus_id).click();
			}
		});
	}
}

function proceso_solicitud(solicitud_id, estatus_id){
	var res = confirm('¿Desea colocar en proceso nuevamente la solicitud #'+solicitud_id+'?');

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'solicitudes/proceso_solicitud',
			type: 'POST',
			dataType: 'JSON',
			data: {solicitud_id: solicitud_id, estatus_id: estatus_id},
			success: function(res){
				$('.nav-'+estatus_id).click();
			}
		});
	}
}

function modal_solicitud(solicitud_id, titulo_boton){
	$('.form-solicitudes').trigger('reset');
	$('.p-info').html('');
	$('.solicitud_id').val(solicitud_id);
	$('.servicio_id option').remove();
	$('.descripcion_servicio').summernote("code", '');
	$('.btn-form').html('<i class="fa fa-plus-circle" aria-hidden="true"></i>'+ titulo_boton);
	$('.modal-solicitud').modal('show');
}

function get_servicios(departamento_id , tipo){
	$('.servicio_id option').remove();
	$('.servicio_solicitado_id option').remove();
	$.ajax({
		url: base_url+'solicitudes/get_servicios',
		type: 'POST',
		dataType: 'JSON',
		data: {departamento_id: departamento_id},
		success: function(res){
			if(tipo == 0){
				$('.servicio_solicitado_id').append('<option data-descripcion="" value="">Seleccione un Servicio</option>');
				$.each(res, function(index, val) {
					$('.servicio_solicitado_id').append('<option data-autorizacion="'+val.autorizacion+'" data-documentacion="'+val.documentacion+'" data-descripcion="'+val.descripcion+'" value="'+val.servicio_id+'">'+val.servicio+'</option>');
				});
			}else{			
				$('.servicio_id').append('<option data-descripcion="" value="">Seleccione un Servicio</option>');
				$.each(res, function(index, val) {
					$('.servicio_id').append('<option data-autorizacion="'+val.autorizacion+'" data-documentacion="'+val.documentacion+'" data-descripcion="'+val.descripcion+'" value="'+val.servicio_id+'">'+val.servicio+'</option>');
				});
			}
		}
	});
}

function add_descripcion(){
	if($('.servicio_id option:selected').data('documentacion') == 1){
		$('.label-documento').html('Documento*');
	}

	if($('.servicio_id option:selected').data('autorizacion') == 1){
		$('.p-info').html(
			'<br><i class="fa fa-info-circle" aria-hidden="true"></i> El tamaño del documento ó archivo no debe ser mayor a 5MB'
			+'<br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> El servicio solicitado requiere autorización, por lo tanto se guardara con el estatus incompleto, para su autorización.'
		);
	}else{
		$('.p-info').html(
			'<br><i class="fa fa-info-circle" aria-hidden="true"></i> El tamaño del documento ó archivo no debe ser mayor a 5MB'
		);
	}

	$('.descripcion_servicio').summernote("code", $('.servicio_id option:selected').data('descripcion'));
	$('.descripcion_servicio').summernote('disable');
}

function get_usuarios(departamento_id ){
	$('.usuario_asignado_id option').remove();
	$.ajax({
		url: base_url+'solicitudes/get_usuarios',
		type: 'POST',
		dataType: 'JSON',
		data: {departamento_id: departamento_id},
		success: function(res){
			$('.usuario_asignado_id').append('<option value="">Seleccione un Servicio</option>');
			$.each(res, function(index, val) {
				$('.usuario_asignado_id').append('<option value="'+val.usuario_id+'">'+val.nombre+' '+val.apellido+'</option>');
			});
		}
	});
}

function tab_val(estatus_id){
	console.log(estatus_id);
	$('.estatus_id').val(estatus_id);
	crear_paginacion(0);
}

function get_solicitud_detalle(solicitud_id){
	$.ajax({
		url: base_url+'solicitudes/get_solicitud_detalle',
		type: 'POST',
		dataType: 'JSON',
		data: {solicitud_id: solicitud_id},
		success: function(res){
			documento = '';
			procesar = '';

			if(res[0]['documento'] != null){
				documento = '&nbsp;&nbsp;<a href="'+base_url+'solicitudes/descargar_documento_solicitud/'+res[0]['solicitud_id']+'/'+res[0]['documento']+'" class="btn btn-outline-danger btn-xs btn-documento-solicitud"><i class="fa fa-file-text-o" aria-hidden="true"></i> Descargar</a>&nbsp;&nbsp;';
			}

			// if(res[0]['estatus_id'] == 2){
			// 	procesar = '<a class="btn btn-outline-warning" href="javascript:void(0);" onclick="servicio_solicitud('+res[0]['solicitud_id']+', '+res[0]['dia']+', '+res[0]['hora']+', '+res[0]['minuto']+', 3, `procesar`);"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Procesar Solicitud</a>';
			// }

			// if(res[0]['estatus_id'] == 3){
			// 	procesar = '<a class="btn btn-outline-warning" href="javascript:void(0);" onclick="servicio_solicitud('+res[0]['solicitud_id']+', '+res[0]['dia']+', '+res[0]['hora']+', '+res[0]['minuto']+', 4, `finalizar`);"><i class="fa fa-folder" aria-hidden="true"></i> Finalizar Solicitud</a>';
			// }

			$('.detalle-title').html('<span class="badge badge-primary estatus"></span>'
	    		+'&nbsp;&nbsp;Solicitud # '+res[0]['solicitud_id']
	    		+'<small class="mb-0 titulo_servicio" style="font-size: 17px;"></small>'
	    		+documento
	    		+procesar
	    	);

			$('.titulo_servicio').html('&nbsp;&nbsp;'+res[0]['servicio']);
			$('.estatus').html(res[0]['estatus']);
			$('.descripcion_solicitud').html(res[0]['descripcion']);
			$('.duracion_servicio').html(res[0]['dia']+' Dia(s) '+res[0]['hora']+' Hora(s) '+res[0]['minuto']+' Minutos(s)');
			$('.descripcion_servicio').summernote('code', res[0]['servicio_descripcion']);

			$('.departamento_solicitante_solicitud').html(res[0]['departamento_solicitante']);
			$('.solicitante_solicitud').html(res[0]['solicitante']);
			$('.departamento_responsable_servicio').html(res[0]['departamento_asignado']);
			$('.responsable_servicio').html(res[0]['responsable']);

			$('.fecha_solicitud').html(res[0]['fecha_creacion']);
			$('.fecha_inicio').html(res[0]['fecha_inicio']);
			$('.fecha_final').html(res[0]['fecha_final']);
			$('.fecha_procesado').html(res[0]['fecha_procesado']);
			$('.fecha_finalizado').html(res[0]['fecha_finalizado']);
		}
	});
}

function get_comentarios(solicitud_id){
	$('.div-comentarios .media-support').remove();
	$('.div-comentarios hr').remove();
	$.ajax({
		url: base_url+'solicitudes/get_comentarios',
		type: 'POST',
		dataType: 'JSON',
		data: {solicitud_id: solicitud_id},
		success: function(res){
			$.each(res, function(index, val) {
				doc = '';

				if(val.documento != '' && val.documento != null){
					doc = '<a href="'+base_url+'solicitudes/descargar_documento/'+val.comentario_id+'/'+val.documento+'" class="badge badge-primary" style="background: #d05400 !important;"><i class="fa fa-file-code-o" aria-hidden="true"></i> Descargar</a>';
				}

				$('.div-comentarios').append(
					'<div class="media-support">'
						+'<div class="media-support-header mb-2">'
						   +'<div class="media-support-info mt-2">'
						      +'<span class="badge badge-danger">'+val.tipo_comentario_descripcion+'</span>'
						      +'<h6 class="mb-0">'+val.nombre+' '+val.apellido+'</h6>'
						      +'<small>'+val.fecha_creacion+'</small>'
						   +'</div>'
						   +'<div class="mt-3">'
						      +doc
						   +'</div>'
						+'</div>'
						+'<div class="media-support-body">'
						   +'<p class="mb-0">'+val.comentario+'</p>'
						+'</div>'
					+'</div>'
					+'<hr class="mt-4 mb-4">'
                );
			});
			get_total_notificaciones_solicitudes();
		}
	});
}

function agregar_comentario(){
    $('.btn-success').prop('disabled', true);
	var data = new FormData($('.form-comentarios')[0]);
	$.ajax({
		url: base_url+'solicitudes/agregar_comentario',
		type: 'POST',
		dataType: 'JSON',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		success: function(res){
			location.reload();
		}
	});
}

function get_documentos(solicitud_id){
	$('.div-documentos .div-documento').remove();
	$.ajax({
		url: base_url+'solicitudes/get_documentos',
		type: 'POST',
		dataType: 'JSON',
		data: {solicitud_id: solicitud_id},
		success: function(res){
			$.each(res, function(index, val) {
				if(val.documento != '' && val.documento != null){				
					var path = val.documento;
					var path_splitted = path.split('.');
					var extension = path_splitted.pop();
					console.log(extension);

					if(extension == 'docx' || extension == 'doc'){
						file = 'doc.png';
					}else if(extension == 'xlsx' || extension == 'xls'){
						file = 'xls.png';
					}else if(extension == 'rar' || extension == 'zip'){
						file = 'zip.png';
					}else if(extension == 'ppt'){
						file = 'ppt.png';
					}else if(extension == 'pdf'){
						file = 'pdf.png';
					}else if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'PNG' || extension == 'gif'){
						file = 'jpg.png';
					}else{
						file = 'file.png';
					}

					$('.div-documentos').append(
						'<div class="col-md-2 div-documento">'
			  				+'<a href="'+base_url+'solicitudes/descargar_documento/'+val.comentario_id+'/'+val.documento+'">'
				  				+'<img src="'+path_image+'icon_files/'+file+'" class="img-thumbnail" alt="'+val.documento+'">'
				  				+'<span style="font-size: 11px;">'+val.titulo+'</span>'
			  				+'</a>'
				  		+'</div>'
	                );
				}
			});
		}
	});
}
