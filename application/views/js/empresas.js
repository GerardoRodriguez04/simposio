$(document).ready(function() {
	$('.departamento_id').select2();
	
	$('#pagination').on('click','a',function(e){
		e.preventDefault(); 
		var num_page = $(this).attr('data-ci-pagination-page');
		crear_paginacion(num_page);
		scroll_top();
	});

	crear_paginacion(0);

    $(".form-empresas").on("submit", function(e) {
    	$('.btn-success').prop('disabled', true);
    	e.preventDefault();
    	$.ajax({
    		url: base_url+'empresas/form_empresa',
    		type: 'POST',
    		dataType: 'JSON',
			data: $('.form-empresas').serialize(),
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				setTimeout(function(){ window.location.replace(base_url+'empresas'); }, 2000);
			}
    	});
    });

    $(".form-categoria").on("submit", function(e) {
    	$('.btn-success').prop('disabled', true);
    	e.preventDefault();
    	$.ajax({
    		url: base_url+'empresas/form_categoria',
    		type: 'POST',
    		dataType: 'JSON',
			data: $('.form-categoria').serialize(),
			success: function(res){
				$('.alert-text-exito').html(res);
				$('.alert-success').show();
				get_categorias($('#empresa_id').val());
				$('.div-modulos .modulo').remove();
				$('.form-categoria').trigger("reset");
				setTimeout(function(){ $('.alert-success').hide(); }, 3000);
    			$('.btn-success').prop('disabled', false);
			}
    	});
    });
});

function validar_form(){
    $.ajax({
        type: "POST",
        url: base_url + "empresas/validar_form",
        data: $('.form-empresas').serialize(),      
        dataType: 'JSON',
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-empresas').submit();
			}
        }
    });
}

function crear_paginacion(pagina){
	$.ajax({
		url: base_url+'empresas/get_empresas/'+pagina,
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
	$('.tbody-empresas tr').remove();

	$.each(result, function(index, val) {
		if(val['activo'] == 1){
			obj = '<span class="badge-'+val['empresa_id']+' badge badge-pill badge-success">Activo</span>';
		}else{
			obj = '<span class="badge-'+val['empresa_id']+' badge badge-pill badge-danger">Inactivo</span>';
		}

		if(permisos('Empresas-Edit')){
			actualizar = '<a class="dropdown-item" href="'+base_url+'empresas/form_view/'+val['empresa_id']+'"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';
		}
		if(permisos('Empresas-Delete')){
			eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus('+val['empresa_id']+','+val['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
		}

		$('.tbody-empresas').append('<tr class="tr-'+val['empresa_id']+'">'
			+'<td>'+val['empresa_id']+'</td>'
			+'<td>'+val['razon_social']+'</td>' 
			+'<td>'+val['direccion']+'</td>'
			+'<td>'+val['telefono']+'</td>'
			+'<td class="td-estatus-'+val['empresa_id']+'">'
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

function cambiar_estatus(empresa_id, activo) {

	var res = confirm('¿Desea cambiar el estatus de la empresa #'+empresa_id);

	if (res == true) {
		$.ajax({
			async: true, 
			url: base_url+'empresas/cambiar_estatus',
			type: 'POST',
			dataType: 'JSON',
			data: {empresa_id: empresa_id, activo: activo},
			success: function(res){
				actualizar_tr(res);
			}
		});
	}

}

function actualizar_tr(res){
	console.log(res);
	if(res[0]['activo'] == 1){
		obj = '<span class="badge-'+res[0]['empresa_id']+' badge badge-pill badge-success">Activo</span>';
	}else{
		obj = '<span class="badge-'+res[0]['empresa_id']+' badge badge-pill badge-danger">Inactivo</span>';
	}
	
	if(permisos('Empresas-Edit')){
		actualizar = '<a class="dropdown-item" href="'+base_url+'empresas/form_view/'+res[0]['empresa_id']+'"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #00838f;"></i> Actualizar</a>';

		categorias = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_categoria('+res[0]['empresa_id']+');"><i class="fa fa-cubes" aria-hidden="true" style="color: #fc842f;"></i> Categorias</a>';

		modulos = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_modulos('+res[0]['empresa_id']+');"><i class="fa fa-users" aria-hidden="true" style="color: #206c9f;"></i> Asignaciones</a>';
	}

	if(permisos('Empresas-Delete')){
		eliminar = '<a class="dropdown-item" href="javascript:void(0);" onclick="cambiar_estatus('+res[0]['empresa_id']+','+res[0]['activo']+');"><i class="fa fa-lock" aria-hidden="true" style="color: #da153a;"></i> Cambiar Estatus</a>';
	}

	$('.tr-'+res[0]['empresa_id']).html(
		'<td>'+res[0]['empresa_id']+'</td>'
		+'<td>'+res[0]['razon_social']+'</td>' 
		+'<td>'+res[0]['direccion']+'</td>'
		+'<td>'+res[0]['telefono']+'</td>'
		+'<td class="td-estatus-'+res[0]['empresa_id']+'">'
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

function modal_categoria(empresa_id){
	get_categorias(empresa_id);
	$('#empresa_id').val(empresa_id);
}

function validar_form_categoria(){
    $.ajax({
        type: "POST",
        url: base_url + "empresas/validar_form_categoria",
        data: $('.form-categoria').serialize(),      
        dataType: 'JSON',
		success: function(res){
			if(res.estatus == 'ERROR'){
				$('.alert-text-error').html(res.message);
				$('.alert-danger').show();
				setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
			}

			if(res.estatus == 'OK'){
                $('.form-categoria').submit();
			}
        }
    });
}