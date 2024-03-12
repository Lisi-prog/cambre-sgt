//const { stubString } = require("lodash");

function mostrarActProyecto(id){
    let cuadro_oculto_de_act_proyecto = document.getElementById("cuadro_de_act_proyecto");

    if ($('#cuadro_de_act_proyecto').is(":hidden")) {
        cuadro_oculto_de_act_proyecto.hidden = false;
    }else{
        cuadro_oculto_de_act_proyecto.hidden = true;
    }

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
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function mostrarActProyectoAlt(id){
    let renglones_actualizacion = document.getElementById("cuadro-act");
    let html_act = '';
    document.getElementById("m-ver-act-div").hidden = true;
    document.getElementById("m-ver-act-btn").hidden = true;
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
    },
    error: function (error) {
        console.log(error);
    }
    }));
    cargarFechaEstadoLiderModalVerAct(id);
}

function cargarFechaEstadoLiderModalVerAct(id){
    let estado = document.getElementById("m-ver-act-id_estado");
    let fecha_limite = document.getElementById("m-ver-act-fecha_limite");
    let lider = document.getElementById("m-ver-act-cbx_lider");

    $.when($.ajax({
        type: "post",
        url: '/proyectos/obtener-ultima-actualizacion-servicio/'+id, 
        data: {
            id: id,
        },
    success: function (response) {
        // console.log(response);
        estado.value = response[0].estado;
        fecha_limite.value = response[0].fecha_limite;
        lider.value = response[0].lider;
        // response.forEach(element => {
        //     estado.value = response.estado;
        // });
        
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function mostrarActEtapa(id){
    let cuadro_oculto_de_act_proyecto = document.getElementById("cuadro_de_act_etapa");

    if ($('#cuadro_de_act_etapa').is(":hidden")) {
        cuadro_oculto_de_act_proyecto.hidden = false;
    }else{
        cuadro_oculto_de_act_proyecto.hidden = true;
    }
    let id_etapa = document.getElementById('m_cae_id_etapa');
    id_etapa.value = id;
    let renglones_actualizacion = document.getElementById("cuadro-act-etapa");
    let html_act = '';

    $.when($.ajax({
        type: "post",
        url: '/etapas/obtener-actualizaciones-etapa/'+id, 
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
        },
        error: function (error) {
            console.log(error);
        }
    }));

    let fecha_lim = document.getElementById('m-crear-act-eta-feclimite');
    let estado_actual = document.getElementById('m-crear-act-eta-idestado');
    $.when($.ajax({
        type: "post",
        url: '/etapa/obtener-una-etapa/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            fecha_lim.value = response.fecha_limite;
            estado_actual.value = response.id_estado;
        },
        error: function (error) {
            console.log(error);
        }
    }));
}

function mostrarActEtapaAlt(id){
    let id_etapa = document.getElementById('m_cae_id_etapa');
    id_etapa.value = id;
    let renglones_actualizacion = document.getElementById("cuadro-act-etapa");
    let html_act = '';

    $.when($.ajax({
        type: "post",
        url: '/etapas/obtener-actualizaciones-etapa/'+id, 
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
        },
        error: function (error) {
            console.log(error);
        }
    }));

    let fecha_lim = document.getElementById('m-crear-act-eta-feclimite');
    let estado_actual = document.getElementById('m-crear-act-eta-idestado');
    let etapa_desc = document.getElementById("m-ver-act-etapa");
    let nombre_estado = document.getElementById("m-ver-act-eta-orden");
    let respo = document.getElementById("m-ver-act-eta-responsable");
    let responsable = document.getElementById("cbx_responsable_etapa");
    
    $.when($.ajax({
        type: "post",
        url: '/etapa/obtener-una-etapa/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            fecha_lim.value = response.fecha_limite;
            estado_actual.value = response.id_estado;
            etapa_desc.value = response.descripcion_etapa;
            nombre_estado.value = response.estado;
            respo.value = response.responsable;
            responsable.value = response.id_responsable;
        },
        error: function (error) {
            console.log(error);
        }
    }));
}

function cargarModalEditarOrden(id_orden){
    let input_nom_orden = document.getElementById('nom_orden');
    let input_fec_ini = document.getElementById('fec_ini');
    let input_fec_req = document.getElementById('fec_req');
    let input_horas_estimadas = document.getElementById('horas_estimadas');
    let input_minutos_estimados = document.getElementById('minutos_estimados');
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-una-orden-etapa/'+id_orden, 
        data: {
            id: id_orden,
        },
    success: function (response) {
        response.forEach(element => {
            input_nom_orden.value = element.orden;
            input_fec_ini.value = element.fecha_inicio;
            input_fec_req.value = element.fecha_limite;
            input_horas_estimadas.value = element.duracion_estimada.substring(0, 2);
            input_minutos_estimados.value = element.duracion_estimada.substring(3, 5);
            document.querySelector('#cbx_supervisor').element = response.supervisa;
            document.querySelector('#cbx_responsable').element = response.responsable;
            document.querySelector('#tipo_orden_trabajo').element = response.tipo;
            document.querySelector('#cbx_estado').element = response.estado;
        });
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

function cargarModalVerPartes(id, tipo_orden){
    let html = '';
    obtenerEstados(tipo_orden);
    modificarModalVerPartesEstadoFechaLimite(id);
    let orden = document.getElementById('m-ver-parte-orden');
    orden.value = id;
    let color_encabezado = colorEncabezadoPartePorTipoDeOrden(tipo_orden);
    
    document.getElementById('m-ver-parte-div').hidden = true;
    document.getElementById('m-ver-parte-orden-btn').hidden = true;
    
    document.getElementById('body_ver_parte').innerHTML = '';
    document.getElementById('encabezado_tabla_parte').style.backgroundColor = color_encabezado;

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
                        <td class="text-center">`+element.fecha+`</td>
                        <td class="text-center">`+fecha_lim+`</td>
                        <td class="text-center">`+element.estado+`</td>
                        <td class="text-center">`+element.horas+`</td>
                        <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                        <td class="text-center">`+element.responsable+`</td>
                        `+maq_y_hora+`
                        <td class="text-center">`+element.supervisor+`</td>
                    </tr>`
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
                                    <option selected="selected" value="">Seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group"> 
                                <label for="horas_maquina" class="control-label" style="white-space: nowrap; ">Horas maquina:</label> 
                                <div class="input-group">
                                    <input class="form-control" name="horas_maquina" type="number" min="0" value="00" id="horas_maquina" required="">
                                    <span class="input-group-text">:</span>
                                    <input class="form-control" name="minutos_maquina" type="number" min="0" max="59" value="00" id="minutos_maquina" required="">
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

function obtenerMaquinaria(){
    let select_maquinaria = document.getElementById('m-ver-parte-maquina');
    select_maquinaria.innerHTML = '<option value="">Seleccionar</option>';
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
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-una-orden-etapa/'+id, 
        data: {
            
        },
    success: function (response) {
        // console.log(response);
        estado.value= response[0].id_estado;
        fecha_limite.value= response[0].fecha_limite;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

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

function verCargarActEtaModal(){
    let cuadro_oculto_de_cargar_act_eta = document.getElementById('m-ver-act-eta-div');
    let btn_oculto_de_cargar_act_eta  = document.getElementById('m-ver-act-eta-btn');
    if ($('#m-ver-act-eta-div').is(":hidden")) {
        cuadro_oculto_de_cargar_act_eta.hidden = false;
        btn_oculto_de_cargar_act_eta.hidden = false;
    }else{
        cuadro_oculto_de_cargar_act_eta.hidden = true;
        btn_oculto_de_cargar_act_eta.hidden = true;
    }
}

