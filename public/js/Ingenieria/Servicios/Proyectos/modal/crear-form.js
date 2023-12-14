import opcion1 from './opcion1.js';

$(function(){
    $('#selected-tipo-orden').on('change', modificarFormulario);
});

function modificarFormulario(){
   let tipo_orden = Number($(this).val());
   let formulario = document.getElementById("formulario");
   switch (tipo_orden) {
    case 1:
        formulario.innerHTML = '';
        //var html = '<div class="row"> <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <div class="form-group"> <label for="nom_orden" class="control-label" style="white-space: nowrap; ">Nombre orden de trabajo:</label> <span class="obligatorio">*</span> <input class="form-control" name="nom_orden" type="text" id="nom_orden" required> </div> </div> </div> <div class="row"> <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"> <div class="form-group"> <div class="form-group"> <label for="tipo_orden_trabajo" class="control-label fs-7" style="white-space: nowrap;">Tipo de orden trabajo:</label> <span class="obligatorio">*</span> <select class="form-select form-group" id="tipo_orden_trabajo" name="tipo_orden_trabajo" required><option selected="selected" value="">Seleccionar</option><option value="5">Externo</option><option value="4">Gestion</option><option value="2">Herramental</option><option value="3">Procesos</option><option value="1">Producto</option></select> </div> </div> </div> </div> <div class="row"> <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"> <div class="form-group"> <div class="form-group"> <label for="responsable" class="control-label fs-7" style="white-space: nowrap;">Responsable:</label> <span class="obligatorio">*</span> <select class="form-select form-group" id="responsable" name="responsable" required><option selected="selected" value="">Seleccionar</option><option value="1">Alejandro Virgillo</option></select> </div> </div> </div> <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"> <div class="form-group"> <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label> <span class="obligatorio">*</span> <input min="2023-01-01" max="2023-12" id="fec_ini" class="form-control" name="fecha_ini" type="date" value="2023-12-12" required> </div> </div></div>';
        let html = opcion1
        formulario.innerHTML += html;

        break;
    case 2:
        formulario.innerHTML = '';
        break;
    case 3:
        formulario.innerHTML = '';
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

// module.exports = {
//     crearCuadrOrdenes,
// };
                
