$(document).ready(function() {
	get_permisos('perfil_1', 'perfil-1');
});

function get_permisos(perfil, tab){
	console.log(perfil);
	console.log(tab);
	$('.'+tab+' li').remove();
	$.ajax({
		url: base_url+'permisos/get_permisos',
		type: 'POST',
		dataType: 'JSON',
		data: {perfil: perfil},
		success: function(res){
			$.each(res, function(index, val) {
				console.log(val);

				if(val[perfil] == 1){
					checked = 'checked';
					estatus = 0;
				}else{
					checked = '';
					estatus = 1;
				}
				
				if(val.grupo == 0){
					background = '';
				}else{
					background = 'list-group-item-secondary';
				}

				$('.'+tab).append('<li class="list-group-item li-'+val.permiso_id+' '+background+' d-flex justify-content-between align-items-center">'
						+val.nombre		
						+'<div class="custom-control custom-switch custom-switch-icon custom-control-inline">'
							+'<div class="custom-switch-inner">'
							+'<input type="checkbox" class="custom-control-input bg-success" onchange="cambiar_estatus('+val.permiso_id+', `'+perfil+'`, `'+tab+'`, '+estatus+');" id="customSwitch-'+tab+'-'+val.permiso_id+'" '+checked+'>'
							+'<label class="custom-control-label" for="customSwitch-'+tab+'-'+val.permiso_id+'">'
							+'</label>'
                      	+'</div>'
                    +'</div>'
				+'</li>');
			});
		}
	});
}

function cambiar_estatus(permiso_id, perfil, tab, estatus){
	$.ajax({
		url: base_url+'permisos/cambiar_estatus',
		type: 'POST',
		dataType: 'JSON',
		data: {permiso_id: permiso_id, perfil: perfil, tab: tab, estatus: estatus},
		success: function(res){
			$.each(res, function(index, val) {
				if(val[perfil] == 1){
					checked = 'checked';
					estatus = 0;
				}else{
					checked = '';
					estatus = 1;
				}

				$('.li-'+val.permiso_id).html(val.nombre		
					+'<div class="custom-control custom-switch custom-switch-icon custom-control-inline">'
						+'<div class="custom-switch-inner">'
						+'<input type="checkbox" class="custom-control-input bg-success" onchange="cambiar_estatus('+val.permiso_id+', `'+perfil+'`, `'+tab+'`, '+estatus+');" id="customSwitch-'+tab+'-'+val.permiso_id+'" '+checked+'>'
						+'<label class="custom-control-label" for="customSwitch-'+tab+'-'+val.permiso_id+'">'
						+'</label>'
	              	+'</div>'
                +'</div>');
			});
		}
	});
}