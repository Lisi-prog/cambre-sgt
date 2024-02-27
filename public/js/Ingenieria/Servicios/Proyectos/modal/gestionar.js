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
    $.when($.ajax({
        type: "post",
        url: '/parte/obtener/'+id, 
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
                        <td class="text-center">`+element.fecha+`</td>
                        <td class="text-center">`+fecha_lim+`</td>
                        <td class="text-center">`+element.estado+`</td>
                        <td class="text-center">`+element.horas+`</td>
                        <td class="text-center"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                        <td class="text-center">`+element.responsable+`</td>
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

