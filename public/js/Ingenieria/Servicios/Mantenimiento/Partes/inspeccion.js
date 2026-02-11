var tabla_inspecciones
$(document).ready(function () {
    tabla_inspecciones = $('#tabla_inspecciones').DataTable({headerCallback: function(thead) {
        $(thead).hide();
    },
        language: {
                lengthMenu: 'Mostrar _MENU_ registros por pagina',
                zeroRecords: 'No se ha encontrado registros',
                info: 'Mostrando pagina _PAGE_ de _PAGES_',
                infoEmpty: 'No se ha encontrado registros',
                infoFiltered: '(Filtrado de _MAX_ registros totales)',
                search: 'Buscar',
                paginate:{
                    first:"Prim.",
                    last: "Ult.",
                    previous: 'Ant.',
                    next: 'Sig.',
                },
            },
            "aaSorting": []
    });    
    activo = document.getElementById('activo').value;
    document.getElementById('herramental').value = activo;
});

function openModalNuevoParteInspeccion(id_activo, id_orden){
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").show()
    $("#previewAceptarInspeccionReview").hide()
    $("#herramental_inspeccion").val($("#activo").val());
    $("#horas_inspeccion").removeAttr('disabled')
    $("#fecha_inspeccion").removeAttr('disabled')

    tabla_inspecciones.clear();

    $.ajax({
        type: 'GET',
        url: '/get-tareas-por-activo/' + id_activo,
        success: function(data) {

            if (!data.tareas_x_activo.length) return;

            let zona_actual = null;
            let j = 0
            data.tareas_x_activo.forEach(tarea => {
                if (tarea.get_zona_tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.get_zona_tarea.nombre_zona;
                    addZonaHeader(zona_actual)
                }    
                tabla_inspecciones.row.add([
                    tarea.nombre_tarea,
                    tarea.get_ejecucion.nombre_ejecucion,
                    `<input class="form-check-input" type="checkbox"
                        id="tarea_${tarea.id_tarea_mantenimiento}"
                        checked
                        
                        onchange="checkboxTareaRealizada(${tarea.id_tarea_mantenimiento})"
                        value="${tarea.id_tarea_mantenimiento}">
                        <input type="hidden" name="tareas[${j}][id]" value="${tarea.id_tarea_mantenimiento}">`,
                    `<div id="label_accion_${tarea.id_tarea_mantenimiento}">-</div>
                    <select required name="tareas[${j}][accion]" onchange="setTareasPendientes(${tarea.id_tarea_mantenimiento})" class="form-select" hidden id="accion_${tarea.id_tarea_mantenimiento}">
                        <option value="NO ACCION" hidden>Seleccionar...</option>
                        ${$("#accion_select_div").html()}
                    </select>`
                ]);
                j++;
            });

            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust();
        }
    });
}


function addZonaHeader(nombreZona) {
    let zonaRow = tabla_inspecciones.row.add([
        nombreZona,
        "",
        "",
        ""
    ]).node();

    $(zonaRow).find('td').eq(0)
        .attr('colspan', 4)
        .addClass('text-center fw-bold');

    $(zonaRow).find('td:gt(0)').remove();
    $(zonaRow).attr('style', "color: rgb(255, 255, 255); background-color: #2b56843b; font-weight: bold;");
    let headerRow = tabla_inspecciones.row.add([
        "Tarea",
        "Ejecución",
        "OK",
        "Acción"
    ]).node();

    $(headerRow).addClass('zona-columns');
    $(headerRow).attr('style', "color: rgb(255, 255, 255); background-color: #2b5684; font-weight: bold;");
}


function checkboxTareaRealizada(id){
    if(!$("#tarea_"+id).is(':checked')){
        $("#label_accion_"+id).attr('hidden', 'hidden')
        $("#accion_"+id).removeAttr('hidden')
    }
    else{
        $("#accion_"+id).attr('hidden', 'hidden')
        $("#label_accion_"+id).removeAttr('hidden')
    }
}

function openModalConfirmarParteInspeccion(id_orden){   
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").hide()
    $("#previewAceptarInspeccionReview").show()
    $("#horas_inspeccion").attr('disabled', 'disabled')
    $("#fecha_inspeccion").attr('disabled', 'disabled')
    $("#herramental_inspeccion").val($("#activo").val());
    tabla_inspecciones.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion/' + id_orden,
        success: function(data) {
            let zona_actual = null;
            data.get_tareas_mantenimiento.forEach(tarea => {
                if (tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona;
                    addZonaHeader(zona_actual)
                }
                let ok = 'SI'
                let accion = 'NO SE REQUIERE'
                if(tarea.ok == 0){
                    ok = 'NO'
                    accion = tarea.get_accion_para_tarea.nombre_accion
                }      
                tabla_inspecciones.row.add([
                    tarea.get_tarea_mantenimiento.nombre_tarea,
                    tarea.get_tarea_mantenimiento.get_ejecucion.nombre_ejecucion,
                    ok,
                    accion
                ]);
            });

            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust();
        }
    });
}

function procesarInspeccion(accion){
    $.ajax({
        type: 'post',
        url: '/procesar-parte-inspeccion',
        data: {
            id_orden_mantenimiento: $("#id_orden_inspeccion").val(),
            accion: accion,
            nombre_proyecto: $("#nombre_proyecto").text(),
        },
        success: function(data) {
            $('#nuevoParteInspeccionModal').modal('hide');
            location.reload();
        }
    });
}