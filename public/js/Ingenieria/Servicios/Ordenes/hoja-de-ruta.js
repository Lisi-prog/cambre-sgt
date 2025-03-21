function cargarOperaciones(id) {
    let body_tb = document.getElementById('body_ope');
    body_tb.innerHTML = '';
    let fila_ope = '';
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-ope-hdr', 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            response.forEach((op) => {
                fila_ope += `<tr>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.id_hoja_de_ruta}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.numero}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">-</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.ultimo_res ?? '-'}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.codigo_maquinaria}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.nombre_operacion}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.nombre_estado_hdr}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.total_horas}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${op.total_horas ? "NO":"SI" }</td>
                                    <td class='text-center' style="vertical-align: middle;">
                                        
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesOpeHdrModal" onclick="cargarModalVerPartesOpe(${op.id_ope_de_hdr})">
                                                            Partes
                                                        </button>
                                                    </div>
                                                
                                    </td>
                                </tr>
                                `; 
            });
            body_tb.innerHTML += fila_ope;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarModalCrearHDR(id, orden, sup){
    // console.log(id, orden, sup);
    document.getElementById('m_id_pieza').value = orden;
    document.getElementById('m_confec').value = sup;
    let select_hdr = document.getElementById('m-hdr-ant');
    select_hdr.innerHTML = '';
    let html_hdr = '<option selected="selected" value="">Seleccionar</option>';
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-hdr-ant/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response)
            
            response.forEach(element => {
                html_hdr += `
                                    <option value="`+element.id_hoja_de_ruta+`">Cod: `+element.id_hoja_de_ruta+` Fecha: `+element.fecha_carga
                                    +`</option> 
                                    `
            });
            select_hdr.innerHTML += html_hdr;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarModalVerPartesOpe(id){
    let html = '';
    obtenerEstados(5);
    // modificarModalVerPartesEstadoFechaLimite(id);
    // let orden = document.getElementById('m-ver-parte-orden');
    // orden.value = id;
    // let color_encabezado = colorEncabezadoPartePorTipoDeOrden(tipo_orden);
    
    // document.getElementById('body_ver_parte').innerHTML = '';
    // document.getElementById('encabezado_tabla_parte').style.backgroundColor = color_encabezado;

    // let tablaa = document.getElementById('verPartes')
    // tablaa.querySelectorAll('th').forEach(encabezado => {
    //     encabezado.style.backgroundColor = color_encabezado;
    // });

    // if(tipo_orden == 3){
    //     document.getElementById('column-maq').hidden = true;
    //     document.getElementById('column-hora-maq').hidden = true;
    // }else{
    //     document.getElementById('column-maq').hidden = true;
    //     document.getElementById('column-hora-maq').hidden = true;
    // }
    let idCount = 0;
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-hdr-parte/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            console.log(response)
            response.forEach(element => {
            if (element.fecha_limite) {
                fecha_lim = element.fecha_limite;
            }else{
                fecha_lim = '-';
            }

            html += `<tr>
                        <td class="text-center">`+element.id_parte+`</td>
                        <td class="text-center">`+element.fecha+`</td>
                        <td class="text-center">`+element.estado+`</td>
                        <td class="text-center">`+element.horas+`</td>
                        <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                        <td class="text-center">`+element.responsable+`</td>
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
                                    
                                </div>
                            </div>
                        </td>
                    </tr>`
            idCount ++;
        });
        document.getElementById('body_ver_parte').innerHTML = html;
        document.getElementById('mv-operacion').value = response[0].operacion;
        document.getElementById('mv-ord-mec').value = response[0].orden_mec;
        document.getElementById('mv-estado').value = response[0].estado;
        /*let maq_y_hora = '';
        let idCount = 0;
        let urlLogParte = "/parte/";
        
        response.forEach(element => {
            if (element.fecha_limite) {
                fecha_lim = element.fecha_limite;
            }else{
                fecha_lim = '-';
            }

            html += `<tr>
                        <td class="text-center">`+element.id_parte+`</td>
                        <td class="text-center">`+element.fecha+`</td>
                        <td class="text-center">`+fecha_lim+`</td>
                        <td class="text-center">`+element.estado+`</td>
                        <td class="text-center">`+element.horas+`</td>
                        <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                        <td class="text-center">`+element.responsable+`</td>s
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
        document.getElementById('mv-estado').value = response[0].estado_orden; */
    },
    error: function (error) {
        console.log(error);
    }
    });
}

function obtenerEstados(opcion){
    let select_estados = document.getElementById('m-ver-parte-estado');
    select_estados.innerHTML = '<option value="">Seleccionar</option>';
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