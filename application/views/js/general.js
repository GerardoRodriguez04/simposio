$(document).ready(function() {
	// get_total_notificaciones_solicitudes();
});

function ver_buscador(){
	if($('.form-buscador').css('display') == 'block'){
		$('.form-buscador').hide();
	}else{
		$('.form-buscador').show();
	}
}

function alert_eliminar(obj, table, campo, id){
	var res = confirm('¿Desea eliminar el registro #'+id);

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'general/eliminar_registro',
			type: 'POST',
			dataType: 'JSON',
			data: {table: table, campo: campo, id: id},
			success: function(res){
				if(!res){
					alert('El registro no puede ser eliminado, favor de validar que no este vinculado a otro modulo del sistema.');
					location.reload();
				}else{
					$(obj).closest('tr').remove();
				}
			}
		});
	}
}

function get_total_notificaciones_solicitudes(){
	$.ajax({
		url: base_url+'general/get_total_notificaciones_solicitudes',
		type: 'POST',
		dataType: 'JSON',
		success: function(res){
			$('.icon-notificaciones').html('<i class="ri-notification-2-line"></i><span class="bg-danger dots"></span><small>'+res+'</small>');
		}
	});
}

function get_notificaciones(){
	$('.div-notificaciones .comentario-solicitud').remove();
	$.ajax({
		url: base_url+'general/get_notificaciones',
		type: 'POST',
		dataType: 'JSON',
		success: function(res){
			console.log(res);
			if(res != ''){
				res['notificaciones']['comentario_id'].sort(function(a, b){return b-a});

				for (var i = 0; res['notificaciones']['comentario_id'].length > i; i++) {

					if (i%2==0) { bg = 'bg-white'; }else{ bg = 'bg-light'; }

					$('.div-notificaciones').append(
						'<a href="'+base_url+res['notificaciones']['controller'][i]+'/detalles_view/'+res['notificaciones']['solicitud_id'][i]+'" class="iq-sub-card comentario-solicitud '+bg+'" data-toggle="tooltip" data-placement="top" title="'+res['notificaciones']['comentario'][i]+'">'
						 	+'<div class="media align-items-center">'
						    	+'<div class="media-body ml-3">'
						       		+'<span class="badge badge-pill badge-success">'+res['notificaciones']['tipo'][i]+' #'+res['notificaciones']['solicitud_id'][i]+'</span> <h6 class="mb-0 ">'+res['notificaciones']['usuario'][i]+'</h6>'
						       		+'<p class="mb-0 text-truncate" style="width: 250px; text-overflow: ellipsis !important; white-space: nowrap !important; overflow: hidden !important;">'+res['notificaciones']['comentario'][i]+'</p>'
						       		+'<small class="float-right font-size-8">'+res['notificaciones']['fecha_creacion'][i]+'</small>'
						    	+'</div>'
						 	+'</div>'
						+'</a>'
					);
				}
			}else{
				$('.div-notificaciones').append(
					'<span class="iq-sub-card">No se encontraron nuevas notificaciones.</span>'
				);
			}
		}
	});
}

function precise_round(value, decPlaces) {
  var val = value * Math.pow(10, decPlaces);
  var fraction = (Math.round((val - parseInt(val)) * 10) / 10);

  if (fraction == -0.5) fraction = -0.6;

  val = Math.round(parseInt(val) + fraction) / Math.pow(10, decPlaces);
  return val;
}

function permisos(permisos){
    var resp = PERMISOS.indexOf(permisos);

    if (resp > 0){
        return true; 
    }else{
       return false;  
    }
}