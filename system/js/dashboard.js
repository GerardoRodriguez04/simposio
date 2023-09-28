$(document).ready(function() {

});

function get_total(){
    $.ajax({
        url: base_url+'dashboard/get_total',
        type: 'POST',
        dataType: 'JSON',
        data: {param1: 'value1'},
        success: function(res){
            $('.counter-departamentos').html('<span class="counter">'+res['departamentos'][0]['total']+'</span>');
            $('.counter-usuarios').html('<span class="counter">'+res['usuarios'][0]['total']+'</span>');
            $('.counter-servicios').html('<span class="counter">'+res['servicios'][0]['total']+'</span>');

            $('.counter-total').html('<span class="counter">'+res['total'][0]['total']+'</span>');
            $('.counter-pendientes').html('<span class="counter">'+res['pendientes'][0]['pendientes']+'</span>');
            $('.counter-incompletos').html('<span class="counter">'+res['incompletos'][0]['incompletos']+'</span>');
            $('.counter-proceso').html('<span class="counter">'+res['proceso'][0]['proceso']+'</span>');
            $('.counter-procesado').html('<span class="counter">'+res['procesado'][0]['procesado']+'</span>');
            $('.counter-finalizado').html('<span class="counter">'+res['finalizado'][0]['finalizado']+'</span>');
            get_total_departamentos();
        }
    });   
}

function get_total_departamentos(){
    $('.div-contenedor-departamentos .div-departamento').remove();
    $.ajax({
        url: base_url+'dashboard/get_total_departamentos',
        type: 'POST',
        dataType: 'JSON',
        data: {param1: 'value1'},
        success: function(res){
            $.each(res, function(index, resp) {
                $.each(resp, function(index, val) {
                    $('.div-contenedor-departamentos').append('<div class="div-departamento col-md-4">'
                        +'<div class="iq-card iq-card-block iq-card-stretch iq-card-height">'
                           +'<div class="iq-card-body">'
                               +'<div class="bg-primary p-3 rounded d-flex align-items-center justify-content-between mb-3 text-center">'
                                 +'<a href="'+base_url+'dashboard/detalles_view/'+val.departamento_id+'" class="text-white text-center"><i class="ri-information-line"></i> <ins>Departamento '+val.departamento+'</ins></a>'
                               +'</div>'
                               +'<center><h7 class="mb-2">Servicios Solicitados.</h7></center>'
                               +'<div class="row align-items-center justify-content-between mt-3">'
                                  +'<div class="row col-md-12">'
                                    +'<div id="chart-dep-'+val.departamento_id+'"></div>'
                                  +'</div>'
                               +'</div>'
                           +'</div>'
                        +'</div>'
                      +'</div>'
                    );

                    var options = {
                        title: {
                            text: 'Total de Solicitudes '+val['total'][0]['total']+'',
                            align: 'center',
                            margin: 10,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize:  '12px',
                                fontWeight:  'bold',
                                fontFamily:  undefined,
                                color:  '#263238'
                            },
                        },
                        series: [{
                            name: 'Solicitudes',
                            data: [parseInt(val['pendientes'][0]['pendientes']), parseInt(val['incompletos'][0]['incompletos']), parseInt(val['proceso'][0]['proceso']), parseInt(val['procesados'][0]['procesados']), parseInt(val['finalizados'][0]['finalizados'])]
                        }],
                        chart: {
                            height: 200,
                            type: 'bar',
                            sparkline: {
                                show: false
                            },
                            events: {
                                click: function(chart, w, e) {
                                // console.log(chart, w, e)
                                }
                            }
                        },
                        colors: ['#ea4141','#374948', '#d05400', '#001b54', '#00ca00'],
                        plotOptions: {
                            bar: {
                                columnWidth: '45%',
                                distributed: true,
                            }
                        },
                        dataLabels: {
                            enabled: true
                        },
                        legend: {
                            show: false
                        },
                        xaxis: {
                            labels: {
                                rotate: -75,
                            },
                            categories: [
                                'Pendiente',
                                'Incompleto',
                                'Proceso',
                                'Procesado',
                                'Finalizado',
                            ]
                        }
                    };

                    var chart = new ApexCharts(document.querySelector('#chart-dep-'+val.departamento_id+''), options);
                    chart.render();
                });
            });
        }
    });   
}