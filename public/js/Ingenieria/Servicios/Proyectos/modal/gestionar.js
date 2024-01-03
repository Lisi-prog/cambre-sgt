function cargarModalEditarEtapa(id){
    let input_nombre_etapa = document.getElementById('input-nombre_etapa');
    let input_fec_ini = document.getElementById('input-fec_ini');
    let input_id_etapa = document.getElementById('m_ee_id_etapa'); 
    let input_id_servicio = document.getElementById('m_ee_id_servicio');
    
    $.when($.ajax({
        type: "post",
        url: '/etapa/obtener-una-etapa/'+id, 
        data: {
            id: id,
        },
    success: function (response) {
            input_nombre_etapa.value = response.descripcion_etapa;
            input_fec_ini.value = response.fecha_inicio;
            document.querySelector('#m-ce-responsable').value = response.id_responsable;
    },
    error: function (error) {
        console.log(error);
    }
    }));

    input_id_etapa.value = id;

}

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
                            <td class="text-center">`+element.descripcion+`</td>
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
                            <td class="text-center">`+element.descripcion+`</td>
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

