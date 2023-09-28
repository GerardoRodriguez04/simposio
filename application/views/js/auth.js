$(document).bind('keypress', function(e) {
    if (e.keyCode == 13) {
        $('#button_submit').trigger('click');
    }
});


$('#button_submit').click(function() {
    $('.text-alert span').remove();
    $('.text-alert p').remove();
    var form = $('#form-login').serialize();
    $.ajax({
        type: "POST",
        url: base_url + "auth/login_auth",
        data: form,
        dataType: 'json',
        beforeSend: function() {
            $("#progress").show();
        },
        success: function(response) {
            console.log(response);
            if (response.status == "OK") {
                if(response.message != "Colaborador" && response.message != "Recepcion"){
                    location.href = base_url + "dashboard";
                }else if(response.message != "Recepcion"){
                    location.href = base_url + "turnos/turno_asignar_view";
                }else if(response.message != "Colaborador"){
                    location.href = base_url + "turnos";
                }
            } else {
                $('.alert').show();
                $('.text-alert').append('<span>'+response.status+'</span><p>'+response.message+'</p>');
                setTimeout(function(){ $('.alert').hide(); }, 5000);
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            $('.alert').show();
            $('.text-alert').append('<span>'+xhr.status+'</span>');
            setTimeout(function(){ $('.alert').hide(); }, 5000);
        }
    });
});