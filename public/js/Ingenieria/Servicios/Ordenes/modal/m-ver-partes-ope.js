$(document).ready(function () { 

    $('#verPartesOpeHdrModal').on('hidden.bs.modal', function (e) {
        nuevoParte();
        let id_ope = [document.getElementById('m-id-ope-hdr').value];

            $.ajax({
                type: "post",
                url: '/orden/obtener-info-ope-mul-act',
                data: {
                    id: id_ope,
                },
                success: function (response) {
                    response.forEach(e => {
                        let fila = $('#example tbody tr[data-id="' + e.id_ope_de_hdr + '"]');
                        let rowIndex = table.row(fila).index();

                        table.cell(rowIndex, 2).data(e.prioridad ?? 'S/P').draw();
                        table.cell(rowIndex, 8).data(e.nombre_estado_hdr).draw();

                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
    })

    $(".nuevo-editar-parte").on('submit', function(evt){
        evt.preventDefault();     
        var url_php = $(this).attr("action"); 
        var type_method = $(this).attr("method"); 
        var form_data = $(this).serialize();
        let html = '';
        // let id_orden = document.getElementById('m-ver-parte-orden').value;
        $.ajax({
            type: type_method,
            url: url_php,
            data: form_data,
            success: function(data) {
                let id_ope = document.getElementById('m-id-ope-hdr').value;
                opcion = parseInt(data.resultado);
                switch (opcion) {
                    case 1:
                        html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                        Parte creado con exito
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                        break;
                    case 2:
                        id = document.getElementById('m-id-parte-ope').value;
                        html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                        Parte cod. `+id+` actualizado con exito
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                        break;
                    case 6:
                        html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                    No se puede actualizar un parte de la cual no eres responsable.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`;
                        break;
                    default:
                        html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                    Ocurrio un error
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`;
                        break;
                }
                $('#alert').html(html)
                actualizarPartesOpe(id_ope);
                nuevoParte();
                setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);

            }
        });
    });
});


function editarParte(id){
    document.getElementById('titulo-parte').innerHTML = 'Editar parte cod: '+id;
    document.getElementById('m-ver-parte-div').className = document.getElementById('m-ver-parte-div').className.replace( /(?:^|\s)border-warning(?!\S)/g , ' border-primary');

    $.when($.ajax({
        type: "post",
        url: '/parte-ope-hdr/obtener-una/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            document.getElementById('observaciones').value = response.observaciones;
            document.getElementById('m-ver-parte-estado').value = response.estado;
            document.getElementById('fecha').value = response.fecha;

            [hora, minutos] = response.horas.split(':');

            document.getElementById('horas').value = hora;
            document.getElementById('minutos').value = minutos;
            document.getElementById('m-editar').value = 1;
            document.getElementById('m-id-parte-ope').value = response.id_parte_ope_hdr;

            if (response.medidas === 'SI') {
                document.getElementById('checkDefaultMed').checked = true;
            }else{
                document.getElementById('checkDefaultMed').checked = false;
            }


        },
        error: function (error) {
            console.log(error);
        }
    }));
}

function nuevoParte(){
    let fecha_de_hoy = new Date(Date.now()).toISOString().split('T')[0];
    document.getElementById('titulo-parte').innerHTML = 'Nuevo parte';
    document.getElementById('m-ver-parte-div').className = document.getElementById('m-ver-parte-div').className.replace( /(?:^|\s)border-primary(?!\S)/g , ' border-warning');
    document.getElementById('observaciones').value = '';
    document.getElementById('fecha').value = fecha_de_hoy;
    document.getElementById('horas').value = '00';
    document.getElementById('minutos').value = '00';
    document.getElementById('m-editar').value = 0;
    document.getElementById('m-id-parte-ope').value = null;
    document.getElementById('checkDefaultMed').checked = false;
    let ope_hdr = document.getElementById('m-id-ope-hdr').value;
    seleccionarEstadoOperacion(ope_hdr);
    // modificarModalVerPartesEstadoFechaLimite(id_orden);
    
}

function seleccionarEstadoOperacion(id) {
    // console.log(id);
    $.ajax({
        type: "post",
        url: '/ope-hdr/obtener-estado/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            document.getElementById('m-ver-parte-estado').value = response;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function actualizarPartesOpe(id){
    document.getElementById('body_ver_parte_ope').innerHTML = '';
    let html = '';
    
    $.ajax({
        type: "post",
        url: '/parte-ope/obtener/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            let idCount = 0;
            response.forEach(element => {
                html += `<tr>
                        <td class="text-center">`+element.id_parte_ope_hdr+`</td>
                        <td class="text-center">`+element.fecha+`</td>
                        <td class="text-center">`+element.estado+`</td>
                        <td class="text-center">`+element.horas+`</td>
                        <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                        <td class="text-center">`+element.responsable+`</td>
                        <td class="text-center">`+element.medidas+`</td>
                        <td class="text-center">
                            <div class="row justify-content-center" >
                                <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenesOpe`+idCount+`" aria-expanded="false" aria-controls="collapseOrdenes`+idCount+`">
                                    Opciones
                                </button>
                            </div>
                            <div class="collapse" data-bs-parent="#body_ver_parte_ope" id="collapseOrdenesOpe`+idCount+`">
                                <div class="row">
                                    <div class="col-12 my-1">
                                        <button type="button" class="btn btn-primary w-100" onclick="editarParte(`+element.id_parte_ope_hdr+`)">
                                            Editar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>`;
                idCount++;
            });
            document.getElementById('body_ver_parte_ope').innerHTML = html;
            // document.getElementById('mv-estado').value = response[0].estado_orden;
        },
        error: function (error) {
            console.log(error);
        }
    });
}