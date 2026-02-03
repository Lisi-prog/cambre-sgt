function crearCuadrOrdenes(id_etapa){

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
        // console.log(response);
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
                                            <button type="button" class="btn btn-warning" onclick="obtenerPartes(`+element.id_orden+`)">Partes</button> 
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

function cargarModalVerOrden(id_orden){
    // console.log('jajajamodal');

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
        console.log(response);
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
            // html_odt = `<tr>
            //                 <td class="text-center">`+element.orden+`</td>
            //                 <td class="text-center">`+element.tipo+`</td>
            //                 <td class="text-center">`+element.estado+`</td>
            //                 <td class="text-center">`+element.responsable+`</td>
            //                 <td class="text-center">`+element.fecha_inicio+`</td>
            //                 <td class="text-center">`+element.fecha_limite+`</td>
            //                 <td class="text-center">`+element.fecha_fin_real+`</td>
            //                 <td class="text-center">`+element.duracion_estimada+`</td>
            //                 <td class="text-center">`+element.duracion_real+`</td>
            //                 <td class="text-center">`+element.fecha_ultimo_parte+`</td>
            //                 <td class="text-center">`+element.descripcion_ultimo_parte+`</td>
            //                 <td class="text-center">`+element.supervisa+`</td>
            //             </tr>`
        });
        // div_cuadro_orden_trabajo.innerHTML = html_odt;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

//<button type="button" class="btn btn-warning" onclick="verOrdenTrabajo('+element.id_orden+')">Ver</button>
function verOrdenTrabajo(id_orden){
    let div_cuadro_orden_trabajo = document.getElementById("cuadro-ordenes-trabajo");
    let html_odt = '';
    let cuadro_oculto = document.getElementById("cuadro-orden-de-trabajo");

    if ($('#cuadro-orden-de-trabajo').is(":hidden")) {
        cuadro_oculto.hidden = false;
    }else{
        cuadro_oculto.hidden = true;
    }
    
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-una-orden-etapa/'+id_orden, 
        data: {
            id_orden: id_orden,
        },
    success: function (response) {
        // console.log(response);
        // console.log('hola');
        response.forEach(element => {
            html_odt = `<tr>
                            <td class="text-center">`+element.orden+`</td>
                            <td class="text-center">`+element.tipo+`</td>
                            <td class="text-center">`+element.estado+`</td>
                            <td class="text-center">`+element.responsable+`</td>
                            <td class="text-center">`+element.fecha_inicio+`</td>
                            <td class="text-center">`+element.fecha_limite+`</td>
                            <td class="text-center">`+element.fecha_fin_real+`</td>
                            <td class="text-center">`+element.duracion_estimada+`</td>
                            <td class="text-center">`+element.duracion_real+`</td>
                            <td class="text-center">`+element.fecha_ultimo_parte+`</td>
                            <td class="text-center">`+element.descripcion_ultimo_parte+`</td>
                            <td class="text-center">`+element.supervisa+`</td>
                        </tr>`
        });
        div_cuadro_orden_trabajo.innerHTML = html_odt;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

function obtenerPartes(id_orden){
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
        // console.log(response);
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
