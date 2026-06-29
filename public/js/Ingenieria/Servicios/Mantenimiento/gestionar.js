function cargarModalVerPartes(id, tipo_orden){
    let html = '';
    obtenerEstados(tipo_orden);
    modificarModalVerPartesEstadoFechaLimite(id);
    let orden = document.getElementById('m-ver-parte-orden');
    orden.value = id;
    let color_encabezado = colorEncabezadoPartePorTipoDeOrden(tipo_orden);
    
    // document.getElementById('m-ver-parte-div').hidden = true;
    // document.getElementById('m-ver-parte-orden-btn').hidden = true;
    
    document.getElementById('body_ver_parte').innerHTML = '';
    document.getElementById('encabezado_tabla_parte').style.backgroundColor = color_encabezado;

    let tablaa = document.getElementById('verPartes')
    tablaa.querySelectorAll('th').forEach(encabezado => {
        encabezado.style.backgroundColor = color_encabezado;
      });

    if(tipo_orden == 3){
        document.getElementById('column-maq').hidden = false;
        document.getElementById('column-hora-maq').hidden = false;
    }else{
        document.getElementById('column-maq').hidden = true;
        document.getElementById('column-hora-maq').hidden = true;
    }

    $.when($.ajax({
        type: "post",
        url: '/parte/obtener/'+id, 
        data: {
            id: id,
        },
    success: function (response) {
        // console.log(response)
        let maq_y_hora = '';
        let idCount = 0;
        let urlLogParte = "/parte/";
        
        response.forEach(element => {
            if (element.fecha_limite) {
                fecha_lim = element.fecha_limite;
            }else{
                fecha_lim = '-';
            }
            
            if(tipo_orden == 3){
                maq_y_hora = `<td class="text-center">`+element.maquinaria+`</td>
                                  <td class="text-center">`+element.horas_maquinaria+`</td>
                                 `
            }

            html += `<tr>
                        <td class="text-center">`+element.id_parte+`</td>
                        <td class="text-center">`+element.fecha+`</td>
                        <td class="text-center">`+fecha_lim+`</td>
                        <td class="text-center">`+element.estado+`</td>
                        <td class="text-center">`+element.horas+`</td>
                        <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                        <td class="text-center">`+element.responsable+`</td>
                        `+maq_y_hora+`
                        <td class="text-center">`+element.supervisor+`</td>
                        <td class="text-center">
                            <div class="row justify-content-center" >
                                <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes`+idCount+`" aria-expanded="false" aria-controls="collapseOrdenes`+idCount+`">
                                    Opciones
                                </button>
                            </div>
                            <div class="collapse" data-bs-parent="#body_ver_parte" id="collapseOrdenes`+idCount+`">

                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary w-100" onclick="editarParte(`+element.id_parte+`)">
                                            Editar
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a href='`+urlLogParte+element.id_parte+`/logs' target="_blank">
                                            <button type="button" class="btn btn-warning w-100" >
                                                Logs
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>`
            idCount ++;
        });
        document.getElementById('body_ver_parte').innerHTML = html;
        document.getElementById('mv-orden').value = response[0].orden;
        document.getElementById('mv-etapa').value = response[0].etapa;
        document.getElementById('mv-estado').value = response[0].estado_orden;
    },
    error: function (error) {
        console.log(error);
    }
    }));
    
    if(tipo_orden == 3){
        let maquinaria_div = document.getElementById("m-ver-parte-maquinaria");
        let maq_html = `<div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label for="maquina" class="control-label" style="white-space: nowrap; ">Maquina:</label>
                                <select class="form-select form-group" id="m-ver-parte-maquina" name="maquina">
                                    <option selected="selected" value=0>Seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group"> 
                                <label for="horas_maquina" class="control-label" style="white-space: nowrap; ">Horas maquina:</label> 
                                <div class="input-group">
                                    <input class="form-control" name="horas_maquina" type="number" min="0" value="00" id="horas_maquina">
                                    <span class="input-group-text">:</span>
                                    <input class="form-control" name="minutos_maquina" type="number" min="0" max="59" value="00" id="minutos_maquina">
                                </div>
                            </div>
                        </div>
                    </div>`
                maquinaria_div.innerHTML = maq_html;
                obtenerMaquinaria();
    }else{
        document.getElementById("m-ver-parte-maquinaria").innerHTML = '';
    }
}

function obtenerEstados(opcion){
    let select_estados = document.getElementById('m-ver-parte-estado');
    select_estados.innerHTML = '<option value=0>Seleccionar</option>';
    html_estados = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-estados-de/'+opcion, 
        data: {
            
        },
    success: function (response) {
        // console.log(response);
        response.forEach(element => {
            html_estados += `
                                <option value="`+element.id_estado+`">`+element.nombre
                                +`</option> 
                                `
        });
        select_estados.innerHTML += html_estados;
       /* c_bx_estados_man != '' ? c_bx_estados_man.innerHTML += html_estados_man : '';
        c_bx_estados_man_edit != '' ? c_bx_estados_man_edit.innerHTML += html_estados_man : ''; */
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function modificarModalVerPartesEstadoFechaLimite(id){
    let fecha_limite = document.getElementById('m-ver-parte-fecha-limite');
    let estado = document.getElementById('m-ver-parte-estado');
    let estado_tecnico = [1, 6, 7];
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-una-orden-etapa/'+id, 
        data: {
            
        },
    success: function (response) {

        estado.value= response[0].id_estado;
        fecha_limite.value= response[0].fecha_limite;

        if (response[0].tec){ //Si es tecnico

            if (estado_tecnico.includes(response[0].id_estado)) { //si el estado del orden es uno de los validos para el tecnico
                document.querySelectorAll("#m-ver-parte-estado option").forEach(opt => {
                    if (!estado_tecnico.includes(parseInt(opt.value))) {
                        opt.style.display = 'none';
                    }
                });
            }
            else{
                document.querySelectorAll("#m-ver-parte-estado option").forEach(opt => {
                    if (opt.value != response[0].id_estado) {
                        opt.style.display = 'none';
                    }
                });

            }

        }
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function colorEncabezadoPartePorTipoDeOrden(tipo_orden){
    // console.log('COLOR');
    switch (tipo_orden) {
        case 1:
            return '#93c180';
            break;
        case 2:
            return '#d16b76';
            break;
        case 3:
            return '#f3b065';
            break;
        case 4:
            return '#f3b065';
        break;
        default:
            break;
    }
}

function obtenerMaquinaria(){
    let select_maquinaria = document.getElementById('m-ver-parte-maquina');
    select_maquinaria.innerHTML = '<option value=0>Seleccionar</option>';
    html_maquinaria = '';

    $.when($.ajax({
        type: "post",
        url: '/maquinaria/obtener-maquinarias', 
        data: {
            
        },
    success: function (response) {
        response.forEach(element => {
            html_maquinaria += `
                                <option value="`+element.id_maquinaria+`">`+element.codigo_maquinaria
                                +`</option> 
                                `
        });
        select_maquinaria.innerHTML += html_maquinaria;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function recargarPartes(id, tipo_orden){
    document.getElementById('body_ver_parte').innerHTML = '';
    let html = '';
    
    $.when($.ajax({
        type: "post",
        url: '/parte/obtener/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response)
            let maq_y_hora = '';
            let idCount = 0;
            response.forEach(element => {
                if (element.fecha_limite) {
                    fecha_lim = element.fecha_limite;
                }else{
                    fecha_lim = '-';
                }
                
                if(tipo_orden == 3){
                    maq_y_hora = `<td class="text-center">`+element.maquinaria+`</td>
                                    <td class="text-center">`+element.horas_maquinaria+`</td>
                                    `
                }

                html += `<tr>
                            <td class="text-center">`+element.id_parte+`</td>
                            <td class="text-center">`+element.fecha+`</td>
                            <td class="text-center">`+fecha_lim+`</td>
                            <td class="text-center">`+element.estado+`</td>
                            <td class="text-center">`+element.horas+`</td>
                            <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                            <td class="text-center">`+element.responsable+`</td>
                            `+maq_y_hora+`
                            <td class="text-center">`+element.supervisor+`</td>
                            <td class="text-center">
                                <div class="row justify-content-center" >
                                    <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes`+idCount+`" aria-expanded="false" aria-controls="collapseOrdenes`+idCount+`">
                                        Opciones
                                    </button>
                                </div>
                                <div class="collapse" data-bs-parent="#body_ver_parte" id="collapseOrdenes`+idCount+`">

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary w-100" onclick="editarParte(`+element.id_parte+`)">
                                                Editar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="" onclick="">
                                                Logs
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>`
                idCount++;
            });
            document.getElementById('body_ver_parte').innerHTML = html;
            document.getElementById('mv-estado').value = response[0].estado_orden;
        },
        error: function (error) {
            console.log(error);
        }
    }));
}

function nuevoParte(){
    let id_orden = document.getElementById('m-ver-parte-orden').value;
    let fecha_de_hoy = new Date(Date.now()).toISOString().split('T')[0];
    document.getElementById('titulo-parte').innerHTML = 'Nuevo parte';
    document.getElementById('m-ver-parte-div').className = document.getElementById('m-ver-parte-div').className.replace( /(?:^|\s)border-primary(?!\S)/g , ' border-warning');
    document.getElementById('gmnp-observaciones').value = '';
    document.getElementById('gmnp-fecha').value = fecha_de_hoy;
    document.getElementById('gmnp-horas').value = '00';
    document.getElementById('gmnp-minutos').value = '00';
    document.getElementById('m-editar').value = 0;
    document.getElementById('m-id-parte').value = null;
    modificarModalVerPartesEstadoFechaLimite(id_orden);

    if (document.getElementById('m-ver-parte-maquina')){
        document.getElementById('m-ver-parte-maquina').value = 0;
        document.getElementById('horas_maquina').value = '00';
        document.getElementById('minutos_maquina').value = '00';
    }
    
}

function editarOrdenMantenimiento(){    
    $.ajax({
        type: "post",
        url: '/orden_mantenimiento/editar', 
        data: {
            id_orden: $("#id_orden_editar").val(),
            id_empleado: $("#id_editar_empleado").val()
        },
        success: function (response) {
            // console.log(response)
            let maq_y_hora = '';
            let idCount = 0;
            response.forEach(element => {
                if (element.fecha_limite) {
                    fecha_lim = element.fecha_limite;
                }else{
                    fecha_lim = '-';
                }
                
                if(tipo_orden == 3){
                    maq_y_hora = `<td class="text-center">`+element.maquinaria+`</td>
                                    <td class="text-center">`+element.horas_maquinaria+`</td>
                                    `
                }

                html += `<tr>
                            <td class="text-center">`+element.id_parte+`</td>
                            <td class="text-center">`+element.fecha+`</td>
                            <td class="text-center">`+fecha_lim+`</td>
                            <td class="text-center">`+element.estado+`</td>
                            <td class="text-center">`+element.horas+`</td>
                            <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                            <td class="text-center">`+element.responsable+`</td>
                            `+maq_y_hora+`
                            <td class="text-center">`+element.supervisor+`</td>
                            <td class="text-center">
                                <div class="row justify-content-center" >
                                    <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes`+idCount+`" aria-expanded="false" aria-controls="collapseOrdenes`+idCount+`">
                                        Opciones
                                    </button>
                                </div>
                                <div class="collapse" data-bs-parent="#body_ver_parte" id="collapseOrdenes`+idCount+`">

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary w-100" onclick="editarParte(`+element.id_parte+`)">
                                                Editar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="" onclick="">
                                                Logs
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>`
                idCount++;
            });
            document.getElementById('body_ver_parte').innerHTML = html;
            document.getElementById('mv-estado').value = response[0].estado_orden;
        },
        error: function (error) {
            console.log(error);
        }
    })
}

function modalEditarPartes(id_orden){
    $("#id_orden_editar").val(id_orden)    
    $.ajax({
        type: "get",
        url: '/orden_mantenimiento/check_pre_editar', 
        data: {
            id_orden
        },
        success: function (response) {
           $("#editarPartes").modal('show')
           if(response.esta_activo == 1){
                $("#activo_editar").prop('checked', true);
                $("#label_activo_editar").text("Activa");
           }
           else{
                $("#activo_editar").prop('checked', false);
                $("#label_activo_editar").text("Inactiva");
           }
           if(response.id_empleado){
                $("#id_editar_empleado").val(response.id_empleado);
           }
        },
        error: function (error) {
            console.log(error);
        }
    })    
}


$("#activo_editar").on("change", function () {
    if ($(this).is(":checked")) {
        $("#label_activo_editar").text("Activa");
    } else {
        $("#label_activo_editar").text("Inactiva");
    }
});


function cargarModalActualizaciones(id_servicio){
    let renglones_actualizacion = document.getElementById("cuadro-act");
        let html_act = '';
        document.getElementById("m-ver-act-div").hidden = true;
        document.getElementById("m-ver-act-btn").hidden = true;
        document.getElementById('m_act_id_serv').value = id_servicio;
        
        $.when($.ajax({
            type: "post",
            url: '/proyectos/obtener-actualizaciones-proyecto/'+id_servicio, 
            data: {
                id: id_servicio,
            },
        success: function (response) {
            response.forEach(element => {
                html_act += `<tr>
                                <td class="text-center">`+element.codigo+`</td>
                                <td class="text-center">`+element.fecha_carga+`</td>
                                <td class="text-center"><abbr title="`+element.descripcion+`" style="text-decoration:none; font-variant: none;">`+element.descripcion.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                                <td class="text-center">`+element.fecha_limite+`</td>
                                <td class="text-center">`+element.estado+`</td>
                                <td class="text-center">`+element.responsable+`</td>    
                                </tr>`
            });
            renglones_actualizacion.innerHTML = html_act;
        },
        error: function (error) {
            console.log(error);
        }
        }));
        cargarFechaEstadoLiderModalVerAct(id_servicio);
}


    function cargarFechaEstadoLiderModalVerAct(id){
        let estado = document.getElementById("m-ver-act-id_estado");
        let fecha_limite = document.getElementById("m-ver-act-fecha_limite");
        let lider = document.getElementById("m-ver-act-cbx_lider");
        document.getElementById('m-ver-act-desc').value = '';
        $.when($.ajax({
            type: "post",
            url: '/proyectos/obtener-ultima-actualizacion-servicio/'+id, 
            data: {
                id: id,
            },
        success: function (response) {
            estado.value = response[0].estado;
            fecha_limite.value = response[0].fecha_limite;
            lider.value = response[0].lider;
            
            $('#verActualizacionModal').modal('show');
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }

    function verCargarActModal(){
        let cuadro_oculto_de_cargar_act = document.getElementById('m-ver-act-div');
        let btn_oculto_de_cargar_act = document.getElementById('m-ver-act-btn');
        if ($('#m-ver-act-div').is(":hidden")) {
            cuadro_oculto_de_cargar_act.hidden = false;
            btn_oculto_de_cargar_act.hidden = false;
        }else{
            cuadro_oculto_de_cargar_act.hidden = true;
            btn_oculto_de_cargar_act.hidden = true;
        }
    }

function actualizarRecuadroAct(id){
    let renglones_actualizacion = document.getElementById("cuadro-act");
    let html_act = '';
    $.when($.ajax({
        type: "post",
        url: '/proyectos/obtener-actualizaciones-proyecto/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            response.forEach(element => {
                html_act += `<tr>
                                <td class="text-center">`+element.codigo+`</td>
                                <td class="text-center">`+element.fecha_carga+`</td>
                                <td class="text-center"><abbr title="`+element.descripcion+`" style="text-decoration:none; font-variant: none;">`+element.descripcion.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                                <td class="text-center">`+element.fecha_limite+`</td>
                                <td class="text-center">`+element.estado+`</td>
                                <td class="text-center">`+element.responsable+`</td>    
                                </tr>`
            });
            renglones_actualizacion.innerHTML = html_act;
            cargarFechaEstadoLiderModalVerAct(id);
        },
        error: function (error) {
            console.log(error);
        }
    }));
}
