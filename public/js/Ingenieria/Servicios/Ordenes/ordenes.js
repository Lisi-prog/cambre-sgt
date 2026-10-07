function verCargarParteModalParte(){
     let cuadro_oculto_de_cargar_parte = document.getElementById('m-ver-parte-div');
     let btn_oculto_de_cargar_parte = document.getElementById('m-ver-parte-orden-btn');
     if ($('#m-ver-parte-div').is(":hidden")) {
         cuadro_oculto_de_cargar_parte.hidden = false;
         btn_oculto_de_cargar_parte.hidden = false;
     }else{
         cuadro_oculto_de_cargar_parte.hidden = true;
         btn_oculto_de_cargar_parte.hidden = true;
    }
}

function nuevoParte(){
    let id_orden = document.getElementById('m-ver-parte-orden').value;
    let fecha_de_hoy = new Date(Date.now()).toISOString().split('T')[0];
    document.getElementById('titulo-parte').innerHTML = 'Nuevo parte';
    document.getElementById('m-ver-parte-div').className = document.getElementById('m-ver-parte-div').className.replace( /(?:^|\s)border-primary(?!\S)/g , ' border-warning');
    document.getElementById('observaciones').value = '';
    document.getElementById('fecha').value = fecha_de_hoy;
    document.getElementById('horas').value = '00';
    document.getElementById('minutos').value = '00';
    document.getElementById('m-editar').value = 0;
    document.getElementById('m-id-parte').value = null;
    modificarModalVerPartesEstadoFechaLimite(id_orden);

    if (document.getElementById('m-ver-parte-maquina')){
        document.getElementById('m-ver-parte-maquina').value = 0;
        document.getElementById('horas_maquina').value = '00';
        document.getElementById('minutos_maquina').value = '00';
    }
    
}

function editarParte(id){
    document.getElementById('titulo-parte').innerHTML = 'Editar parte cod: '+id;
    document.getElementById('m-ver-parte-div').className = document.getElementById('m-ver-parte-div').className.replace( /(?:^|\s)border-warning(?!\S)/g , ' border-primary');

    $.when($.ajax({
        type: "post",
        url: '/parte/obtener-una/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            document.getElementById('observaciones').value = response.observaciones;
            document.getElementById('m-ver-parte-estado').value = response.estado;
            document.getElementById('fecha').value = response.fecha;
            document.getElementById('m-ver-parte-fecha-limite').value = response.fecha_limite;

            [hora, minutos] = response.horas.split(':');

            document.getElementById('horas').value = hora;
            document.getElementById('minutos').value = minutos;
            document.getElementById('m-editar').value = 1;
            document.getElementById('m-id-parte').value = response.id_parte;
            
            if (es_super === 0) {
                document.getElementById('m-ver-parte-fecha-limite').readonly = true;
            }
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
        success: function (res) {
            let maq_y_hora = '';
            let idCount = 0;
            let urlLogParte = "/partes/";

            res.forEach(e => {

                let fecha_lim = e.fecha_limite ?? '-';
                
                if (id_emp === e.id_res || es_super === 1) {
                    btn_editar = `<button type="button" class="btn btn-primary w-100" onclick="editarParte(`+e.id_parte+`)">
                                        Editar
                                    </button>`
                } else {
                    btn_editar = '-';
                }

                let vObservacion = e.observaciones ?? '';

                html += `<tr>
                            <td class="text-center">${e.id_parte}</td>
                            <td class="text-center">${e.fecha}</td>
                            <td class="text-center">${fecha_lim}</td>
                            <td class="text-center">${e.estado}</td>
                            <td class="text-center">${e.horas}</td>
                            <td class="text-center"><abbr title="${vObservacion}" style="text-decoration:none; font-variant: none;">${vObservacion.slice(0, 25)} <i class="fas fa-eye"></i></abbr></td>
                            <td class="text-center">${e.responsable}</td>
                            <td class="text-center">${e.supervisor}</td>
                            <td class="text-center">
                                <div class="row justify-content-center" >
                                    <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes${idCount}" aria-expanded="false" aria-controls="collapseOrdenes${idCount}">
                                        Opciones
                                    </button>
                                </div>
                                <div class="collapse" data-bs-parent="#body_ver_parte" id="collapseOrdenes${idCount}">

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary w-100" onclick="editarParte(${e.id_parte})">
                                                Editar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href='${urlLogParte+e.id_parte}/logs' target="_blank">
                                                <button type="button" class="btn btn-warning w-100" >
                                                    Logs
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>`
                        idCount++;
            });
            document.getElementById('body_ver_parte').innerHTML = html;
            document.getElementById('mv-estado').value = res[0].estado_orden;
        },
        error: function (error) {
            console.log(error);
        }
    }));
}

function cargarModalVerPartes(id, tipo_orden){
    let html = '';
    let orden = document.getElementById('m-ver-parte-orden');
    orden.value = id;
    modificarModalVerPartesEstadoFechaLimite(id, tipo_orden);
    let color_encabezado = colorEncabezadoPartePorTipoDeOrden(tipo_orden);
    
    document.getElementById('body_ver_parte').innerHTML ? document.getElementById('body_ver_parte').innerHTML = '' : "";
    document.getElementById('encabezado_tabla_parte').style.backgroundColor = color_encabezado;

    let tablaa = document.getElementById('verPartes')
    tablaa.querySelectorAll('th').forEach(encabezado => {
        encabezado.style.backgroundColor = color_encabezado;
      });

    if(tipo_orden == 3){
        document.getElementById('column-maq').hidden = true;
        document.getElementById('column-hora-maq').hidden = true;
    }else{
        document.getElementById('column-maq').hidden = true;
        document.getElementById('column-hora-maq').hidden = true;
    }

    $.ajax({
        type: "post",
        url: '/parte/obtener/'+id, 
        data: {
            id: id,
        },
        success: function (res) {
            let maq_y_hora = '';
            let idCount = 0;
            let urlLogParte = "/parte/";

            res.forEach(element => {
                let fecha_lim = element.fecha_limite ?? '-';

                if (id_emp === element.id_res || es_super === 1) {
                    btn_editar = `<div class="row justify-content-center" >
                                        <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes${idCount}" aria-expanded="false" aria-controls="collapseOrdenes${idCount}">
                                            Opciones
                                        </button>
                                    </div>
                                    <div class="collapse" data-bs-parent="#body_ver_parte" id="collapseOrdenes${idCount}">
                                        <div class="row my-2">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary w-100" onclick="editarParte(${element.id_parte})">
                                                    Editar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a href='${urlLogParte+element.id_parte}/logs' target="_blank">
                                                    <button type="button" class="btn btn-warning w-100" >
                                                        Logs
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>`
                } else {
                    btn_editar = '-';
                }

                let vObservacion = element.observaciones ?? '';

                html += `<tr>
                            <td class="text-center">${element.id_parte}</td>
                            <td class="text-center">${element.fecha}</td>
                            <td class="text-center">${fecha_lim}</td>
                            <td class="text-center">${element.estado}</td>
                            <td class="text-center">${element.horas}</td>
                            <td class="text-center"><abbr title="${vObservacion}" style="text-decoration:none; font-variant: none;">${vObservacion.slice(0, 25)} <i class="fas fa-eye"></i></abbr></td>
                            <td class="text-center">${element.responsable}</td>
                            <td class="text-center">${element.supervisor}</td>
                            <td class="text-center">
                                    ${btn_editar}
                            </td>
                        </tr>`
                idCount++;
            });
            document.getElementById('body_ver_parte').innerHTML = html;
            document.getElementById('mv-orden').value = res[0].orden;
            document.getElementById('mv-etapa').value = res[0].etapa;
            document.getElementById('mv-estado').value = res[0].estado_orden;
        },
        error: function (error) {
            console.log(error);
        }
    });
}


function obtenerEstados(opcion){
    let select_estados = document.getElementById('m-ver-parte-estado');
    select_estados.innerHTML = '<option value="">Seleccionar</option>';
    let html_estados = '';
    return $.ajax({
        type: "post",
        url: '/orden/obtener-estados-de/'+opcion, 
        data: {
            
        },
        success: function (res) {
            res.forEach(element => {
                html_estados += `<option value="${element.id_estado}">${element.nombre}</option>`;
            });
            select_estados.innerHTML += html_estados;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

let solicitudEstadoParte = 0;

function modificarModalVerPartesEstadoFechaLimite(id, tipo_orden){
    let fecha_limite = document.getElementById('m-ver-parte-fecha-limite');
    let estado = document.getElementById('m-ver-parte-estado');
    const guardar = document.getElementById('m-ver-parte-orden-btn');
    const mensaje = document.getElementById('m-ver-parte-estado-mensaje');
    const solicitud = ++solicitudEstadoParte;
    let estado_tecnico = [1, 6, 7];
    estado.disabled = true;
    guardar.disabled = true;
    estado.value = '';
    fecha_limite.value = '';
    if (mensaje) {
        mensaje.hidden = false;
        mensaje.className = 'text-muted';
        mensaje.textContent = 'Cargando estado actual...';
    }
    const mostrarError = function () {
        if (solicitud !== solicitudEstadoParte) return;
        if (mensaje) {
            mensaje.className = 'text-danger';
            mensaje.textContent = 'No se pudo cargar el estado. Cierre y vuelva a abrir el modal para reintentar.';
            mensaje.hidden = false;
        }
    };
    const opciones = estado.dataset.estadosPrecargados === '1' || tipo_orden === undefined
        ? $.Deferred().resolve().promise()
        : obtenerEstados(tipo_orden);

    return opciones.then(function () {
        if (solicitud !== solicitudEstadoParte) return;
        return $.ajax({
                    type: "post",
                    url: '/orden/obtener-una-orden-etapa/'+id,
                    success: function (response) {
                        if (solicitud !== solicitudEstadoParte) return;
                        if (!response || !response[0]) {
                            mostrarError();
                            return;
                        }
                        const idEstado = Number(response[0].id_estado);
                        Array.from(estado.options).forEach(function (opt) {
                            opt.hidden = false;
                            opt.disabled = false;
                            opt.style.display = '';
                        });
                        estado.value = String(idEstado);
                        fecha_limite.value= response[0].fecha_limite;

                        if (estado.value === '') {
                            mostrarError();
                            return;
                        }

                        if (response[0].tec){ //Si es tecnico

                            if (estado_tecnico.includes(idEstado)) { //si el estado del orden es uno de los validos para el tecnico
                                document.querySelectorAll("#m-ver-parte-estado option").forEach(opt => {
                                    if (!estado_tecnico.includes(parseInt(opt.value))) {
                                        opt.style.display = 'none';
                                        opt.hidden = true;
                                        opt.disabled = true;
                                    }
                                });
                            }
                            else{
                                document.querySelectorAll("#m-ver-parte-estado option").forEach(opt => {
                                    if (opt.value != response[0].id_estado) {
                                        opt.style.display = 'none';
                                        opt.hidden = true;
                                        opt.disabled = true;
                                    }
                                });

                            }

                        }
                        estado.disabled = false;
                        guardar.disabled = false;
                        if (mensaje) mensaje.hidden = true;
                    },
                    error: function (error) {
                        mostrarError();
                        console.log(error);
                    }
                    });
    }, mostrarError);
}

function colorEncabezadoPartePorTipoDeOrden(tipo_orden){
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

    $.ajax({
        type: "post",
        url: '/maquinaria/obtener-maquinarias',
        success: function (response) {
            response.forEach(element => {
                html_maquinaria += `<option value="${element.id_maquinaria}">${element.codigo_maquinaria}</option>`;
            });
            select_maquinaria.innerHTML += html_maquinaria;
        },
        error: function (error) {
            console.log(error);
        }
    });
} 

function actRow(){
    let id_orden = document.getElementById('m-ver-parte-orden').value 
                    ? document.getElementById('m-ver-parte-orden').value 
                    : document.getElementById('id_orden_edit').value;
    $.ajax({
        type: "post",
        url: '/parte/obtener-ultimo/'+id_orden,
        success: function (response) { 
            table.cell(ind_rw, 4).data(response.nombre_orden).draw(false);
            table.cell(ind_rw, 6).data(response.estado).draw(false);
            table.cell(ind_rw, 8).data(response.responsable).draw(false);
            table.cell(ind_rw, 9).data(response.total_horas).draw(false);
            table.cell(ind_rw, 10).data(response.fecha_limite).draw(false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function actRowEditarParte(){
    let id_parte = document.getElementById('m-id-parte').value;
    $.ajax({
        type: "post",
        url: '/parte/obtener-una/'+id_parte,
        success: function (response) {
            table.cell(ind_rw, 4).data(response.fecha).draw();
            table.cell(ind_rw, 5).data(response.fecha_limite).draw();
            table.cell(ind_rw, 6).data(response.nombre_estado).draw();
            table.cell(ind_rw, 7).data(response.horas).draw();
        },
        error: function (error) {
            console.log(error);
        }
    });
    document.querySelectorAll("#m-editar-parte-estado option").forEach(opt => {
        opt.style.display = '';  
    });
}


