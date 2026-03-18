var tabla_inspecciones
$(document).ready(function () {
    tabla_inspecciones = $('#tabla_inspecciones').DataTable({headerCallback: function(thead) {
        $(thead).hide();
    },columnDefs: [
            { className: "text-center", targets: [0,1,2,3, 4] }
        ],
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
            pageLength: 100,
            "aaSorting": []
    });    
    activo = document.getElementById('activo').value;
    $("#nombre_proyecto_inspeccion").val($("#nombre_proyecto_i").val())
    document.getElementById('herramental_inspeccion').value = activo;
});

function openModalNuevoParteInspeccion(id_activo, id_orden){
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").show()
    $("#previewAceptarInspeccionReview").hide()
    $("#herramental_inspeccion").val($("#activo").val());
    $("#horas_inspeccion").removeAttr('disabled')
    $("#fecha_inspeccion").removeAttr('disabled')
    let hoy = new Date()
    hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
    '-' + hoy.getDate().toString().padStart(2, 0)
    $("#fecha_inspeccion").val(hoy)

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

                    `<input type="radio"
                        name="tareas[${j}][ok]" value="ok"  
                        onchange="checkboxTareaRealizada(${j},${tarea.id_tarea_mantenimiento})">
                    <input type="hidden" name="tareas[${j}][id]" value="${tarea.id_tarea_mantenimiento}">`,

                    `<input type="radio" onchange="checkboxTareaRealizada(${j},${tarea.id_tarea_mantenimiento})" name="tareas[${j}][ok]" value="not_ok">`,

                    `<div id="label_accion_${tarea.id_tarea_mantenimiento}">-</div>
                    <select required name="tareas[${j}][accion]" class="form-select" hidden id="accion_${tarea.id_tarea_mantenimiento}">
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
        "",
        ""
    ]).node();

    $(zonaRow).find('td').eq(0)
        .attr('colspan', 5)
        .addClass('text-center fw-bold text-dark');

    $(zonaRow).find('td:gt(0)').remove();
    $(zonaRow).removeClass('odd even').attr('style', "color: rgb(255, 255, 255); background-color: #2b56843b; font-weight: bold;");
    let headerRow = tabla_inspecciones.row.add([
        "Tarea",
        "Ejecución",
        "OK",
        "NO OK",
        "Acción"
    ]).node();

    $(headerRow).removeClass('odd even').addClass('zona-columns text-light');
    $(headerRow).find('td').removeClass('odd even').attr('style', "color: rgb(255, 255, 255) !important; background-color: #2b5684; font-weight: bold;");
    $(headerRow).attr('style', "color: rgb(255, 255, 255) !important; background-color: #2b5684; font-weight: bold;");
}


function checkboxTareaRealizada(j, idTarea){
    const radio = $(`input[name="tareas[${j}][ok]"]:checked`).val();

    if (radio === 'not_ok') {
        $("#label_accion_" + idTarea).attr('hidden', true);
        $("#accion_" + idTarea).removeAttr('hidden');
        $("#accion_" + idTarea).attr('required', 'required');
    } else {
        $("#accion_" + idTarea).attr('hidden', true);
        $("#accion_" + idTarea).removeAttr('required');
        $("#label_accion_" + idTarea).html('No se requiere acción')
        $("#label_accion_" + idTarea).removeAttr('hidden');
    }
    
    let completo = validarRadios()
    if(completo){
        $("#completado_inspeccion_value").prop('checked', true)
        $("#completado_inspeccion").attr('checked', 'checked')
    }
    else{
        $("#completado_inspeccion_value").prop('checked', false)
        $("#completado_inspeccion").removeAttr('checked')
    }
}


function openModalConfirmarParteInspeccion(id_orden){   
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").hide()
    $("#previewAceptarInspeccionReview").show()
    $("#horas_inspeccion").attr('disabled', 'disabled')
    $("#fecha_inspeccion").attr('disabled', 'disabled')
    $("#completado_inspeccion").attr('checked', 'checked')
    $("#herramental_inspeccion").val($("#activo").val());
    tabla_inspecciones.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion/' + id_orden,
        success: function(data) {
            let zona_actual = null;
            data.get_parte.get_orden.parte_inspe_x_tareas_mantenimiento.forEach(tarea => {
                if (tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona;
                    addZonaHeader(zona_actual)
                }

                let ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled checked>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;

                let not_ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;

                let accion = '-';

                if(tarea.ok == 0){
                    ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;
                    not_ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled checked>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;
                    accion = tarea.get_accion_para_tarea.nombre_accion
                } 
                
                
                tabla_inspecciones.row.add([
                    tarea.get_tarea_mantenimiento.nombre_tarea,
                    tarea.get_tarea_mantenimiento.get_ejecucion.nombre_ejecucion,
                    ok,
                    not_ok,
                    accion
                ]);
            });
            $("#fecha_inspeccion").val(data.get_parte.fecha)
            $("#horas_inspeccion").val(data.horas)
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
            nombre_proyecto: $("#nombre_proyecto_i").text(),
        },
        success: function(data) {
            $('#nuevoParteInspeccionModal').modal('hide');
            location.reload();
        }
    });
}

function validarRadios() {
    let completos = true;
    const grupos = {};
    $('input[type="radio"][name^="tareas"]').each(function () {
        grupos[$(this).attr('name')] = true;
    });
    for (let name in grupos) {
        if ($(`input[name="${name}"]:checked`).length === 0) {
            completos = false;
            break;
        }
    }
    return completos;
}

function openModalParteInspeccionPendiente(id_activo, id_orden){
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
        url: '/get-parte-inspeccion-pendiente/' + id_activo + '/' + id_orden,
        success: function(data) {
            console.log(data)
            let zona_actual = null;
            let j = 0
            data.tareasMantenimiento.forEach(tarea => {
                if (tarea.get_zona_tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.get_zona_tarea.nombre_zona;
                    addZonaHeader(zona_actual)
                } 
                tabla_inspecciones.row.add([
                    tarea.nombre_tarea,

                    tarea.get_ejecucion.nombre_ejecucion,

                    `<input type="radio"
                        name="tareas[${j}][ok]" value="ok"  
                        checked  id="ok_${tarea.id_tarea_mantenimiento}"
                        onchange="checkboxTareaRealizada(${j},${tarea.id_tarea_mantenimiento})">
                    <input type="hidden" name="tareas[${j}][id]" value="${tarea.id_tarea_mantenimiento}">`,

                    `<input id="not_ok_${tarea.id_tarea_mantenimiento}" type="radio" onchange="checkboxTareaRealizada(${j},${tarea.id_tarea_mantenimiento})" name="tareas[${j}][ok]" value="not_ok">`,

                    `<div id="label_accion_${tarea.id_tarea_mantenimiento}">-</div>
                    <select required name="tareas[${j}][accion]" class="form-select" hidden id="accion_${tarea.id_tarea_mantenimiento}">
                        <option value="NO ACCION" hidden>Seleccionar...</option>
                        ${$("#accion_select_div").html()}
                    </select>`
                ]);
                tabla_inspecciones.draw();
                
                if(tarea.ok ===null){
                    console.log('null')
                    $("#accion_" + tarea.id_tarea_mantenimiento).attr('hidden', true);
                    $("#accion_" + tarea.id_tarea_mantenimiento).removeAttr('required');
                    $("#label_accion_" + tarea.id_tarea_mantenimiento).removeAttr('hidden');
                    $(`#ok_${tarea.id_tarea_mantenimiento}`).prop('checked', false)
                    $(`#not_ok_${tarea.id_tarea_mantenimiento}`).prop('checked', false)
                }
                else if(tarea.ok === 0){
                    console.log('0')
                    $(`#accion_${tarea.id_tarea_mantenimiento}`).val(tarea.id_accion_tarea)
                    $("#label_accion_" + tarea.id_tarea_mantenimiento).attr('hidden', true);
                    $("#accion_" + tarea.id_tarea_mantenimiento).removeAttr('hidden');
                    $("#accion_" + tarea.id_tarea_mantenimiento).attr('required', 'required');
                    $(`#not_ok_${tarea.id_tarea_mantenimiento}`).prop('checked', true)
                }
                else if(tarea.ok == 1){
                    console.log('1')
                    $("#accion_" + tarea.id_tarea_mantenimiento).attr('hidden', true);
                    $("#accion_" + tarea.id_tarea_mantenimiento).removeAttr('required');
                    $("#label_accion_" + tarea.id_tarea_mantenimiento).html('No se requiere acción')
                    $("#label_accion_" + tarea.id_tarea_mantenimiento).removeAttr('hidden');
                    $(`#ok_${tarea.id_tarea_mantenimiento}`).prop('checked', true)
                }

                j++;
            });
            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust(); 
            $("#horas_inspeccion").val('')
            let hoy = new Date()
            hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
            '-' + hoy.getDate().toString().padStart(2, 0)
            $("#fecha_inspeccion").val(hoy)
        }
    });
}


function openModalVerParteInspeccion(id_orden){   
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").hide()
    $("#previewAceptarInspeccionReview").hide()
    $("#horas_inspeccion").attr('disabled', 'disabled')
    $("#fecha_inspeccion").attr('disabled', 'disabled')
    $("#completado_inspeccion").prop('checked', true)
    $("#herramental_inspeccion").val($("#activo").val());
    tabla_inspecciones.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion-completado/' + id_orden,
        success: function(data) {
            let zona_actual = null;
            data.get_parte.get_orden.parte_inspe_x_tareas_mantenimiento.forEach(tarea => {
                if (tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona;
                    addZonaHeader(zona_actual)
                }

                let ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled checked>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;

                let not_ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;

                let accion = '-';

                if(tarea.ok == 0){
                    ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;
                    not_ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled checked>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;
                    accion = tarea.get_accion_para_tarea.nombre_accion
                }      
                tabla_inspecciones.row.add([
                    tarea.get_tarea_mantenimiento.nombre_tarea,
                    tarea.get_tarea_mantenimiento.get_ejecucion.nombre_ejecucion,
                    ok,
                    not_ok,
                    accion
                ]);
            });
            $("#fecha_inspeccion").val(data.get_parte.fecha)
            $("#horas_inspeccion").val(data.horas)
            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust();
        }
    });
}

function verParteDeInspeccion(id_parte, completado){
    $('#modalNuevoParteInspeccion').modal('show');
    $("#btnGuardarNuevoParteInspeccion").hide()
    $("#previewAceptarInspeccionReview").hide()
    $("#horas_inspeccion").attr('disabled', 'disabled')
    $("#fecha_inspeccion").attr('disabled', 'disabled')
    $("#completado_inspeccion").prop('checked', true)
    $("#herramental_inspeccion").val($("#activo").val());
    if(completado == 'Completo'){
        $("#completado_inspeccion").prop('checked', true)
    }
    else{
        $("#completado_inspeccion").prop('checked', false)
    }

    tabla_inspecciones.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion-porcion/' + id_parte,
        success: function(data) {
            let zona_actual = null;
            console.log(data)
            data.get_parte_inspe_x_tareas_mantenimiento.forEach(tarea => {
                if (tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona;
                    addZonaHeader(zona_actual)
                }

                let ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled checked>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;

                let not_ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;

                let accion = '-';

                if(tarea.ok == 0){
                    ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;
                    not_ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled checked>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;
                    accion = tarea.get_accion_para_tarea.nombre_accion
                }      
                tabla_inspecciones.row.add([
                    tarea.get_tarea_mantenimiento.nombre_tarea,
                    tarea.get_tarea_mantenimiento.get_ejecucion.nombre_ejecucion,
                    ok,
                    not_ok,
                    accion
                ]);
            });
            
            $("#fecha_inspeccion").val(data.get_parte.fecha)            
            $("#horas_inspeccion").val(data.get_parte.horas)
            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust();
        }
    });
}