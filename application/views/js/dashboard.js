$(document).ready(function() {
    $('#pagination').on('click','a',function(e){
      e.preventDefault(); 
      var num_page = $(this).attr('data-ci-pagination-page');
      crear_paginacion(num_page);
      scroll_top();
    });

    crear_paginacion(0);

    $(".form-registro").on("submit", function(e) {
      $('.btn-form').prop('disabled', true);
      e.preventDefault();
      $.ajax({
        url: base_url+'forms/form_registro',
        type: 'POST',
        dataType: 'JSON',
        data: $('.form-registro').serialize(),
        success: function(res){
          $('.alert-text-exito').html(res);
          $('.alert-success').show();
          setTimeout(function(){ location.reload(); }, 2000);
        }
      });
    });
});

function validar_form(){
  $.ajax({
    type: "POST",
    url: base_url + "forms/validar_form",
    data: $('.form-registro').serialize(),
    dataType: 'JSON',
    success: function(res){
      if(res.estatus == 'ERROR'){
        $('.alert-text-error').html(res.message);
        $('.alert-danger').show();
        setTimeout(function(){ $('.alert-danger').hide(); }, 3000);
      }

      if(res.estatus == 'OK'){
        $('.form-registro').submit();
      }
    }
  });
}

function crear_paginacion(pagina){
    $.ajax({
      url: base_url+'dashboard/get_participantes/'+pagina,
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
    $('.tbody-participantes tr').remove();

    $.each(result, function(index, val) {
      if(val['tipo'] == 1){
        tipo = 'Presencial';
      }else{
        tipo = 'En línea';
      }

      $('.tbody-participantes').append('<tr class="tr-'+val['usuario_id']+'">'
        +'<td>'+val['nombre']+'</td>'
        +'<td>'+val['correo_electronico']+'<br>'+val['telefono']+'</td>'
        +'<td>'+val['universidad']+'</td>'
        +'<td>'+val['carrera']+'</td>'
        +'<td>'+val['area_interes']+'</td>'
        +'<td>'+tipo+'</td>'
        +'<td>'
        +'<button type="button" class="btn btn-info" onclick="modal_actualizar('+val['participante_id']+', `'+val['nombre']+'`, `'+val['correo_electronico']+'`, `'+val['telefono']+'`, `'+val['universidad']+'`, `'+val['carrera']+'`, `'+val['area_interes']+'`);"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'
        +'</td>'
      +'</tr>');

      row+=1;
    });
}

function modal_actualizar(participante_id, nombre, correo_electronico, telefono, universidad, carrera, area_interes){
  $('.participante_id').val(participante_id);
  $('.nombre').val(nombre);
  $('.correo_electronico').val(correo_electronico);
  $('.telefono').val(telefono);
  $('.universidad').val(universidad);
  $('.carrera').val(carrera);
  $('.area_interes').val(area_interes);

  $('.modal-participante').modal(participante_id);
}

function enviar_correo(){
  $.ajax({
    type: "POST",
    url: base_url + "dashboard/enviar_correo",
    dataType: 'JSON',
    success: function(res){
      console.log('res');
    }
  });  
}

function scroll_top(){
    $([document.documentElement, document.body]).animate({
      scrollTop: $(".table").offset().top
    }, 1000);
}