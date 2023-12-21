import opcion1 from './opcion-orden-trabajo.js';
import opcion3 from './opcion-orden-mecanizado.js';

$(function(){
    $('#selected-tipo-orden').on('change', modificarFormulario);
});
function modificarFormulario(){
   let tipo_orden = Number($(this).val());
   let formulario = document.getElementById("formulario");
   let html;
   switch (tipo_orden) {
    case 1:
        formulario.innerHTML = '';
        html = opcion1
        formulario.innerHTML += html;
        cargarTipoOrdenTrabajo();
        cargarEmpleados();
        cargarEstados();
        break;
    case 2:
        formulario.innerHTML = '';
        break;
    case 3:
        formulario.innerHTML = '';
        html = opcion3
        formulario.innerHTML += html;
        cargarTipoOrdenTrabajo();
        cargarEmpleados();
        cargarEstados();
        break;
    case 4:
        formulario.innerHTML = '';
        break;    
    default:
        formulario.innerHTML = '';
        break;
   }

}

export function crearCuadrOrdenes(id_etapa){

    // let div_cuadro_de_orden = document.getElementById("cuadro-ordenes-trabajo");
    // let html_odt = '';
    let cuadro_oculto_de_ordenes = document.getElementById("cuadro_de_ordenes");

    if ($('#cuadro_de_ordenes').is(":hidden")) {
        cuadro_oculto_de_ordenes.hidden = false;
    }else{
        cuadro_oculto_de_ordenes.hidden = true;
    }
    let div_cuadro_orden = document.getElementById("cuadro-ordenes");
    let html_orden = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-orden-etapa/'+id_etapa, 
        data: {
            id_etapa: id_etapa,
        },
    success: function (response) {
        response.forEach(element => {
            html_orden += `<tr>
                                <td class= "text-center"> `+element.orden+`</td> 
                                <td class= "text-center">`+element.tipo+`</td> 
                                <td>
                                    <div class="row"> 
                                        <div class="col"> 
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden(`+element.id_orden+`)">
                                                Ver
                                            </button>
                                        </div>
                                        <div class="col"> 
                                            <button type="button" class="btn btn-warning" onclick="window.obtenerPartes(`+element.id_orden+`)">Partes</button> 
                                        </div> 
                                    </div> 
                                </td> 
                            </tr>`;
        });
        div_cuadro_orden.innerHTML = html_orden;
        
    },
    error: function (error) {
        console.log(error);
    }
    }));
}
export function cargarModalVerEtapa(id_etapa){
    let input_etapa = document.getElementById("input-etapa");
    let input_estado = document.getElementById("input-estado");
    let input_responsable = document.getElementById("input-responsable");
    let input_fecha_inicio = document.getElementById("input-fecha_inicio");
    let input_fecha_limite = document.getElementById("input-fecha_limite");
    let input_fecha_fin = document.getElementById("input-fecha_fin_real");
    let input_duracion_estimada = document.getElementById("input-duracion_estimada");
    let input_duracion_real = document.getElementById("input-duracion_real");
    let input_fecha_ultima_actualizacion = document.getElementById("input-fecha_ultima_actualizacion");
    $.when($.ajax({
        type: "post",
        url: '/etapa/obtener-una-etapa/'+id_etapa, 
        data: {
            id_etapa: id_etapa,
        },
    success: function (response) {
        console.log(response)
            input_etapa.value = response.descripcion_etapa;
            input_estado.value = response.estado;
            input_responsable.value = response.responsable;
            input_fecha_inicio.value = response.fecha_inicio;
            input_fecha_limite.value = response.fecha_limite;
            input_fecha_fin.value = response.fecha_fin_real;
            input_duracion_estimada.value = response.duracion_estimada;
            input_duracion_real.value = response.duracion_real;
            input_fecha_ultima_actualizacion.value = response.input_fecha_ultima_actualizacion;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

export function cargarModalVerOrden(id_orden){
    let input_orden = document.getElementById("input-orden");
    let input_tipo = document.getElementById("input-tipo");
    let input_estado = document.getElementById("input-estado");
    let input_responsable = document.getElementById("input-responsable");
    let input_fecha_inicio = document.getElementById("input-fec_ini");
    let input_fecha_limite = document.getElementById("input-fec_limite");
    let input_fecha_fin = document.getElementById("input-fec_fin");
    let input_duracion_estimada = document.getElementById("input-duracion_estimada");
    let input_duracion_real = document.getElementById("input-duracion_real");
    let input_fecha_ultimo_parte = document.getElementById("input-fecha_ultimo_parte");
    let input_observacion = document.getElementById("input-observacion");
    let input_supervisor = document.getElementById("input-supervisor");

    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-una-orden-etapa/'+id_orden, 
        data: {
            id_orden: id_orden,
        },
    success: function (response) {
        response.forEach(element => {
            input_orden.value = element.orden;
            input_tipo.value = element.tipo;
            input_estado.value = element.estado;
            input_responsable.value = element.responsable;
            input_fecha_inicio.value = element.fecha_inicio;
            input_fecha_limite.value = element.fecha_limite;
            input_fecha_fin.value = element.fecha_fin_real;
            input_duracion_estimada.value = element.duracion_estimada;
            input_duracion_real.value = element.duracion_real;
            input_fecha_ultimo_parte.value = element.fecha_ultimo_parte;
            input_observacion.value = element.descripcion_ultimo_parte;
            input_supervisor.value = element.supervisa;
        });
    },
    error: function (error) {
        console.log(error);
    }
    }));
}
function verOrdenTrabajo(id_orden){
    let div_cuadro_orden_trabajo = document.getElementById("cuadro-ordenes-trabajo");
    let html_odt = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-una-orden-etapa/'+id_orden, 
        data: {
            id_orden: id_orden,
        },
    success: function (response) {
        response.forEach(element => {
            var html_odt = `<tr>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>`
        });
        div_cuadro_orden_trabajo.innerHTML = html_odt;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}
export function obtenerPartes(id_orden){
    let cuadro_oculto_de_partes = document.getElementById("parte_de_trabajo");
    let html_parte = '';
    let div_cuadro_parte = document.getElementById("renglones_parte");
    if ($('#parte_de_trabajo').is(":hidden")) {
        cuadro_oculto_de_partes.hidden = false;
    }else{
        cuadro_oculto_de_partes.hidden = true;
    }

    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-partes-orden/'+id_orden, 
        data: {
            id_orden: id_orden,
        },
    success: function (response) {
         response.forEach(element => {
             html_parte += `<tr>
                                <td class="text-center">`+element.fecha_carga+`</td>
                                 <td class="text-center">`+element.estado+`</td>
                                 <td class="text-center">`+element.observaciones+`</td>
                                 <td class="text-center">`+element.fecha+`</td>
                                 <td class="text-center">`+element.fecha_limite+`</td>
                                 <td class="text-center">`+element.horas+`</td>
                                 <td class="text-center">`+element.responsable+`</td>
                                 <td class="text-center">`+element.supervisor+`</td>
                             </tr>`
         });
         div_cuadro_parte.innerHTML = html_parte;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}


function cargarTipoOrdenTrabajo(){
    let c_bx_tipo_orden = document.getElementById("tipo_orden_trabajo");
    let html_tipo_orden = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-tipo-orden', 
        data: {
            
        },
    success: function (response) {
        response.forEach(element => {
            html_tipo_orden += `
                                <option value="`+element.id_tipo_orden_trabajo+`">`+element.nombre_tipo_orden_trabajo
                                +`</option> 
                                `
        });
        c_bx_tipo_orden.innerHTML += html_tipo_orden;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function cargarEmpleados(){
    let c_bx_empleados = document.getElementById("cbx_responsable");
    let html_empleados = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-empleados', 
        data: {
            
        },
    success: function (response) {
        response.forEach(element => {
            html_empleados += `
                                <option value="`+element.id_empleado+`">`+element.nombre_empleado
                                +`</option> 
                                `
        });
        c_bx_empleados.innerHTML += html_empleados;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function cargarEstados(){
    let c_bx_estados = document.getElementById("cbx_estado");
    let html_estados = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-estados', 
        data: {
            
        },
    success: function (response) {
        response.forEach(element => {
            html_estados += `
                                <option value="`+element.id_estado+`">`+element.nombre_estado
                                +`</option> 
                                `
        });
        c_bx_estados.innerHTML += html_estados;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}
