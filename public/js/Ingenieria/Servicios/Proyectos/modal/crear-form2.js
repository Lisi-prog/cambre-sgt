function crearCuadrOrdenes(id_etapa){
    //console.log('hola');
    // console.log(id_etapa);
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
        response.forEach(element => {
            html_orden += '<tr> <td class= "text-center"> '+element.orden+'</td> <td class= "text-center">'+element.tipo+'</td> <td><div class="row"> <div class="col-6"> <button type="button" class="btn btn-warning" onclick="verOrdenTrabajo('+element.id_orden+')">Ver</button> </div><div class="col-6"> <button type="button" class="btn btn-warning ">Partes</button> </div> </div> </td> </tr>';
        });
        div_cuadro_orden.innerHTML = html_orden;
    },
    error: function (error) {
        console.log(error);
    }
    }));
}

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
        console.log(response);
        console.log('hola');
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
