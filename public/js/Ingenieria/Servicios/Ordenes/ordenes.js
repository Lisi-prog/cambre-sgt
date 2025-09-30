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
            // console.log(response);
            document.getElementById('observaciones').value = response.observaciones;
            document.getElementById('m-ver-parte-estado').value = response.estado;
            document.getElementById('fecha').value = response.fecha;
            document.getElementById('m-ver-parte-fecha-limite').value = response.fecha_limite;

            [hora, minutos] = response.horas.split(':');

            document.getElementById('horas').value = hora;
            document.getElementById('minutos').value = minutos;
            document.getElementById('m-editar').value = 1;
            document.getElementById('m-id-parte').value = response.id_parte;

            // if (response.maquinaria) {
            //     if (response.maquinaria != '-') {
            //         document.getElementById('m-ver-parte-maquina').value = response.maquinaria;
            //         [hora_maquina, minutos_maquina] = response.horas_maquinaria.split(':');
            //         document.getElementById('horas_maquina').value = hora_maquina;
            //         document.getElementById('minutos_maquina').value = minutos_maquina;
            //     }else{
            //         document.getElementById('m-ver-parte-maquina').value = 0;
            //         document.getElementById('horas_maquina').value = '00';
            //         document.getElementById('minutos_maquina').value = '00';
            //     }
            // }

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
        success: function (response) {
            // console.log(response)
            let maq_y_hora = '';
            let idCount = 0;
            let urlLogParte = "/partes/";
            response.forEach(element => {
                if (element.fecha_limite) {
                    fecha_lim = element.fecha_limite;
                }else{
                    fecha_lim = '-';
                }
                
                // if(tipo_orden == 3){
                //     maq_y_hora = `<td class="text-center">`+element.maquinaria+`</td>
                //                     <td class="text-center">`+element.horas_maquinaria+`</td>
                //                     `
                // }
                
                if (id_emp === element.id_res || es_super === 1) {
                    btn_editar = `<button type="button" class="btn btn-primary w-100" onclick="editarParte(`+element.id_parte+`)">
                                        Editar
                                    </button>`
                } else {
                    btn_editar = '-';
                }

                html += `<tr>
                            <td class="text-center">`+element.id_parte+`</td>
                            <td class="text-center">`+element.fecha+`</td>
                            <td class="text-center">`+fecha_lim+`</td>
                            <td class="text-center">`+element.estado+`</td>
                            <td class="text-center">`+element.horas+`</td>
                            <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                            <td class="text-center">`+element.responsable+`</td>
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

function cargarModalVerPartes(id, tipo_orden){
    let html = '';
    obtenerEstados(tipo_orden);
    modificarModalVerPartesEstadoFechaLimite(id);
    let orden = document.getElementById('m-ver-parte-orden');
    orden.value = id;
    let color_encabezado = colorEncabezadoPartePorTipoDeOrden(tipo_orden);
    
    
    // document.getElementById('m-ver-parte-div').hidden = true;
    // document.getElementById('m-ver-parte-orden-btn').hidden = true;
    
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
            
            // if(tipo_orden == 3){
            //     maq_y_hora = `<td class="text-center">`+element.maquinaria+`</td>
            //                       <td class="text-center">`+element.horas_maquinaria+`</td>
            //                      `
            // }

            if (id_emp === element.id_res || es_super === 1) {
                btn_editar = `<div class="row justify-content-center" >
                                    <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes`+idCount+`" aria-expanded="false" aria-controls="collapseOrdenes`+idCount+`">
                                        Opciones
                                    </button>
                                </div>
                                <div class="collapse" data-bs-parent="#body_ver_parte" id="collapseOrdenes`+idCount+`">
                                    <div class="row my-2">
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
                                </div>`
            } else {
                btn_editar = '-';
            }

            html += `<tr>
                        <td class="text-center">`+element.id_parte+`</td>
                        <td class="text-center">`+element.fecha+`</td>
                        <td class="text-center">`+fecha_lim+`</td>
                        <td class="text-center">`+element.estado+`</td>
                        <td class="text-center">`+element.horas+`</td>
                        <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                        <td class="text-center">`+element.responsable+`</td>
                        <td class="text-center">`+element.supervisor+`</td>
                        <td class="text-center">
                                `+btn_editar+`
                        </td>
                    </tr>`
            idCount++;
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
    
    // if(tipo_orden == 3){
    //     let maquinaria_div = document.getElementById("m-ver-parte-maquinaria");
    //     let maq_html = `<div class="row"> 
    //                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
    //                         <div class="form-group">
    //                             <label for="maquina" class="control-label" style="white-space: nowrap; ">Maquina:</label>
    //                             <select class="form-select form-group" id="m-ver-parte-maquina" name="maquina">
    //                                 <option selected="selected" value=0>Seleccionar</option>
    //                             </select>
    //                         </div>
    //                     </div>
    //                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
    //                         <div class="form-group"> 
    //                             <label for="horas_maquina" class="control-label" style="white-space: nowrap; ">Horas maquina:</label> 
    //                             <div class="input-group">
    //                                 <input class="form-control" name="horas_maquina" type="number" min="0" value="00" id="horas_maquina">
    //                                 <span class="input-group-text">:</span>
    //                                 <input class="form-control" name="minutos_maquina" type="number" min="0" max="59" value="00" id="minutos_maquina">
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </div>`
    //             maquinaria_div.innerHTML = maq_html;
    //             obtenerMaquinaria();
    // }else{
    //     document.getElementById("m-ver-parte-maquinaria").innerHTML = '';
    // }
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

function actRow(){
    let id_orden = document.getElementById('m-ver-parte-orden').value 
                    ? document.getElementById('m-ver-parte-orden').value 
                    : document.getElementById('id_orden_edit').value;
    $.when($.ajax({
        type: "post",
        url: '/parte/obtener-ultimo/'+id_orden,
        data: {
        },
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
    }));
}

function actRowEditarParte(){
    let id_parte = document.getElementById('m-id-parte').value;
    $.when($.ajax({
        type: "post",
        url: '/parte/obtener-una/'+id_parte, 
        data: {
        },
        success: function (response) {
            // console.log(response)
            table.cell(ind_rw, 4).data(response.fecha).draw();
            table.cell(ind_rw, 5).data(response.fecha_limite).draw();
            table.cell(ind_rw, 6).data(response.nombre_estado).draw();
            table.cell(ind_rw, 7).data(response.horas).draw();
            //table.cell(ind_rw, 5).data(response.observaciones).draw();
        },
        error: function (error) {
            console.log(error);
        }
    }));
    document.querySelectorAll("#m-editar-parte-estado option").forEach(opt => {
        opt.style.display = '';  
    });
}


