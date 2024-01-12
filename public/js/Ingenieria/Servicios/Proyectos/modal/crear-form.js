import opcion1 from './opcion-orden-trabajo.js';
import opcion2 from './opcion-orden-manufactura.js';
import opcion3 from './opcion-orden-mecanizado.js';
import bodyModalOrdenTrabajo from './ver-orden-trabajo.js';
import bodyModalOrdenMecanizado from './ver-orden-mecanizado.js';

let bandera = 1;

$(function(){
    $('#selected-tipo-orden').on('change', modificarFormulario);
    $('#nueva_orden_meca').on('click', modificarFormulario);
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
        cargarSupervisores();
        cargarEmpleados();
        cargarEstados();
        break;
    case 2:
        formulario.innerHTML = '';
        html = opcion2
        formulario.innerHTML += html;
        cargarSupervisores();
        cargarEmpleados();
        cargarEstadosManufacturas();
        break;
    case 3:
        formulario.innerHTML = '';
        html = opcion3
        formulario.innerHTML += html;
        cargarSupervisores();
        cargarEmpleados();
        cargarEstadosMecanizados();
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
            console.log(response);
            let boton_ordenes = '';
            response.forEach(element => {
                if (element.numero_tipo == 2) {
                    boton_ordenes = `<div class="row my-2">
                                            <div class="col-12"> 
                                                <form method="GET" action="http://localhost:8080/orden/manufactura_mecanizado/`+element.id_orden+`" accept-charset="UTF-8" style="display:inline">
                                                    <input class="btn btn-danger w-100" type="submit" value="Agregar mecanizados">
                                                </form>
                                            </div> 
                                        </div>
                    `
                }
                
                html_orden += `<tr>
                                    <td class= "text-center"> `+element.etapa+`</td> 
                                    <td class= "text-center"> `+element.orden+`</td> 
                                    <td class= "text-center">`+element.tipo+`</td>
                                    <td class= "text-center">`+element.estado+`</td>
                                    <td class= "text-center">`+element.responsable+`</td> 
                                    <td class= "text-center">
                                        <div class="row my-2"> 
                                            <div class="col-12"> 
                                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden(`+element.id_orden+`,`+element.numero_tipo+`)">
                                                    Ver orden
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-12"> 
                                                <button type="button" class="btn btn-warning w-100" onclick="window.obtenerPartes(`+element.id_orden+`)">
                                                    Ver partes
                                                </button> 
                                            </div> 
                                        </div>`+boton_ordenes+` 
                                    </td> 
                                </tr>`;
                boton_ordenes = '';
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
            input_etapa.value = response.descripcion_etapa;
            input_estado.value = response.estado;
            input_responsable.value = response.responsable;
            input_fecha_inicio.value = response.fecha_inicio;
            input_fecha_limite.value = response.fecha_limite;
            input_fecha_fin.value = response.fecha_fin_real;
            input_duracion_estimada.value = response.duracion_estimada;
            input_duracion_real.value = response.duracion_real;
            input_fecha_ultima_actualizacion.value = response.fecha_ultima_actualizacion; //.substring(0, 10)
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

export function cargarModalVerOrden(id_orden, tipo){
    let body_modal_ver_orden = document.getElementById('modal-body-ver-orden');
    
    body_modal_ver_orden.innerHTML = '';
    switch (tipo) {
        case 1:
            body_modal_ver_orden.innerHTML = bodyModalOrdenTrabajo;
            cargarModalVerOrdenTrabajo(id_orden);
            break;
            
        case 2:
            body_modal_ver_orden.innerHTML = bodyModalOrdenTrabajo;
            cargarModalVerOrdenManufactura(id_orden);
            break;
        case 3:
            body_modal_ver_orden.innerHTML = bodyModalOrdenMecanizado;
            cargarModalVerOrdenMecanizado(id_orden);
            break;
        default:
            break;
    }
}

function cargarModalVerOrdenTrabajo(id_orden){
    let input_orden = document.getElementById("input-orden");
    let input_tipo = document.getElementById("input-tipo");
    let input_estado = document.getElementById("input-estado");
    let input_responsable = document.getElementById("input-responsable");
    let input_fecha_inicio = document.getElementById("input-fec_inicio");
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

function cargarModalVerOrdenMecanizado(id_orden){
    let input_nombre = document.getElementById("input-nom_orden");
    let input_revision = document.getElementById("input-revision");
    let input_cantidad = document.getElementById("input-cantidad");
    let input_responsable = document.getElementById("input-responsable");
    let input_duracion_estimada = document.getElementById("input-duracion_estimada");
    let input_duracion_real = document.getElementById("input-duracion_real");
    let input_fecha_inicio = document.getElementById("input-fec_inicio");
    let input_fecha_limite = document.getElementById("input-fec_req");
    let input_fecha_fin = document.getElementById("input_fecha_fin");
    let input_estado_mecanizado = document.getElementById("input-estado_mecanizado");
    let input_ruta_plano = document.getElementById("input-ruta_plano");
    let input_observaciones = document.getElementById("input-observaciones");

    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-una-orden-mecanizado-etapa/'+id_orden, 
        data: {
            id_orden: id_orden,
        },
    success: function (response) {
        response.forEach(element => {
            input_nombre.value = element.orden;
            input_revision.value = element.revision;
            input_cantidad.value = element.cantidad;
            input_duracion_estimada.value = element.duracion_estimada;
            input_duracion_real.value = element.duracion_real;
            input_responsable.value = element.responsable;
            input_fecha_inicio.value = element.fecha_inicio;
            input_fecha_limite.value = element.fecha_limite;
            input_ruta_plano.value = element.ruta_plano;
            input_observaciones.value = element.observaciones;
            input_fecha_fin.value = element.fecha_fin_real;
            input_estado_mecanizado.value = element.estado_mecanizado;
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

function cargarSupervisores(){
    let c_bx_supervisores = document.getElementById("cbx_supervisor");
    let html_supervisores = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-supervisores', 
        data: {
            
        },
    success: function (response) {
        response.forEach(element => {
            html_supervisores += `
                                <option value="`+element.id_empleado+`">`+element.nombre_empleado
                                +`</option> 
                                `
        });
        c_bx_supervisores.innerHTML += html_supervisores;
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

function cargarEstadosMecanizados(){
    let c_bx_estados_mec = document.getElementById("cbx_estado_mec");
    let html_estados_mec = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-estados-mecanizados', 
        data: {
            
        },
    success: function (response) {
        response.forEach(element => {
            html_estados_mec += `
                                <option value="`+element.id_estado_mecanizado+`">`+element.nombre_estado_mecanizado
                                +`</option> 
                                `
        });
        c_bx_estados_mec.innerHTML += html_estados_mec;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function cargarEstadosManufacturas(){
    let c_bx_estados_man = document.getElementById("cbx_estado_man");
    let html_estados_man = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-estados-manufacturas', 
        data: {
            
        },
    success: function (response) {
        response.forEach(element => {
            html_estados_man += `
                                <option value="`+element.id_estado_manufactura+`">`+element.nombre_estado_manufactura
                                +`</option> 
                                `
        });
        c_bx_estados_man.innerHTML += html_estados_man;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}
