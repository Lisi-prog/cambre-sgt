var tabla_inspecciones;
$(document).ready(function () {
    tabla_inspecciones = $('#tabla_inspecciones').DataTable({
        headerCallback: function(thead) {
            $(thead).hide();
        },
        columnDefs: [{ visible: false, targets: [3] },
            { className: "text-center", targets: [1, 2, 3] }
        ],
        order: [],
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por pagina',
            zeroRecords: 'No se ha encontrado registros',
            info: 'Mostrando pagina _PAGE_ de _PAGES_',
            infoEmpty: 'No se ha encontrado registros',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            paginate: {
                first: "Prim.",
                last: "Ult.",
                previous: 'Ant.',
                next: 'Sig.',
            },
        },
        pageLength: 100,
        "aaSorting": []
    });    
    let activo = document.getElementById('activo').value;
    $("#nombre_proyecto_inspeccion").val($("#nombre_proyecto_i").val());
    document.getElementById('herramental_inspeccion').value = activo;
    document.getElementById('nombreActivoInspeccion').textContent = activo;
});

function openModalNuevoParteInspeccion(id_activo, id_orden){
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").show();
    $("#previewAceptarInspeccionReview").hide();
    $("#herramental_inspeccion").val($("#activo").val());
    document.getElementById('nombreActivoInspeccion').textContent = $("#activo").val();
    $("#horas_inspeccion").removeAttr('disabled');
    $("#minutos_inspeccion").removeAttr('disabled');
    $("#fecha_inspeccion").removeAttr('disabled');
    let hoy = new Date();
    hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) + '-' + hoy.getDate().toString().padStart(2, 0);
    $("#fecha_inspeccion").val(hoy);

    tabla_inspecciones.clear();

    $.ajax({
        type: 'GET',
        url: '/get-tareas-por-activo/' + id_activo,
        success: function(data) {
            if (!data.tareas_x_activo.length) return;

            let zona_actual = null;
            let j = 0;
            data.tareas_x_activo.forEach(tarea => {
                if (tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.nombre_zona;
                    addZonaHeader(zona_actual);
                }    
                tabla_inspecciones.row.add([
                    tarea.elemento, 
                    `<input type="radio" name="tareas[${j}][ok]" value="ok" onchange="checkboxTareaRealizada(${j},'${tarea.id_zona}-${tarea.id_zona_tarea}')">
                     <input type="hidden" name="tareas[${j}][id]" value="${tarea.id_zona}-${tarea.id_zona_tarea}">`,
                    `<input type="radio" onchange="checkboxTareaRealizada(${j},'${tarea.id_zona}-${tarea.id_zona_tarea}')" name="tareas[${j}][ok]" value="not_ok">`,
                    `<div id="label_accion_${tarea.id_zona}-${tarea.id_zona_tarea}">-</div>
                     <select name="tareas[${j}][accion]" class="form-select" hidden id="accion_${tarea.id_zona}-${tarea.id_zona_tarea}">
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
        .attr('colspan', 4)
        .addClass('text-center fw-bold text-dark');

    $(zonaRow).find('td:gt(0)').remove();
    $(zonaRow).removeClass('odd even').attr('style', "color: rgb(255, 255, 255); background-color: #2b56843b; font-weight: bold;");
    
    let headerRow = tabla_inspecciones.row.add([
        "Elemento",
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
    
    let completo = validarRadios();
    if(completo){
        $("#completado_inspeccion_value").prop('checked', true);
        $("#completado_inspeccion").attr('checked', 'checked');
    }
    else{
        $("#completado_inspeccion_value").prop('checked', false);
        $("#completado_inspeccion").removeAttr('checked');
    }
}

function openModalConfirmarParteInspeccion(id_orden){   
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").hide();
    $("#previewAceptarInspeccionReview").show();
    $("#horas_inspeccion").attr('disabled', 'disabled');
    $("#minutos_inspeccion").attr('disabled', 'disabled');
    $("#fecha_inspeccion").attr('disabled', 'disabled');
    $("#completado_inspeccion").attr('checked', 'checked');
    $("#herramental_inspeccion").val($("#activo").val());
    document.getElementById('nombreActivoInspeccion').textContent = $("#activo").val();
    
    tabla_inspecciones.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion/' + id_orden,
        success: function(data) {
            let zona_actual = null;
            if(data.get_parte && data.get_parte.get_orden && data.get_parte.get_orden.parte_inspe_x_tareas_mantenimiento) {
                data.get_parte.get_orden.parte_inspe_x_tareas_mantenimiento.forEach(tarea => {
                    let nombre_zona_actual = tarea.get_tarea_mantenimiento.get_zona_tarea ? tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona : (tarea.get_tarea_mantenimiento.nombre_zona || 'Sin Zona');
                    if (nombre_zona_actual !== zona_actual) {
                        zona_actual = nombre_zona_actual;
                        addZonaHeader(zona_actual);
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
                        accion = tarea.get_accion_para_tarea ? tarea.get_accion_para_tarea.nombre_accion : '-';
                    } 
                    
                    tabla_inspecciones.row.add([
                        tarea.get_tarea_mantenimiento.elemento || tarea.get_tarea_mantenimiento.nombre_tarea,
                        ok,
                        not_ok,
                        accion
                    ]);
                });
            }
            if(data.get_parte) {
                $("#fecha_inspeccion").val(data.get_parte.fecha);
            }
            if(data.horas) {
                let [hr, mn] = data.horas.split(':');
                $("#horas_inspeccion").val(hr);
                $("#minutos_inspeccion").val(mn);
            }
            showSpanAviso();
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
            $('#modalNuevoParteInspeccion').modal('hide');
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
    $("#btnGuardarNuevoParteInspeccion").show();
    $("#previewAceptarInspeccionReview").hide();
    $("#herramental_inspeccion").val($("#activo").val());
    document.getElementById('nombreActivoInspeccion').textContent = $("#activo").val();
    $("#horas_inspeccion").removeAttr('disabled');
    $("#minutos_inspeccion").removeAttr('disabled');
    $("#fecha_inspeccion").removeAttr('disabled');

    tabla_inspecciones.clear();

    $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion-pendiente/' + id_activo + '/' + id_orden,
        success: function(data) {
            let zona_actual = null;
            let j = 0;
            let tareasList = data.tareasMantenimiento || data.tareas_x_activo;
            if(tareasList) {
                tareasList.forEach(tarea => {
                    let nombre_zona_actual = tarea.nombre_zona || (tarea.get_zona_tarea ? tarea.get_zona_tarea.nombre_zona : 'Sin Zona');
                    if (nombre_zona_actual !== zona_actual) {
                        zona_actual = nombre_zona_actual;
                        addZonaHeader(zona_actual);
                    } 
                    let disabled = tarea.ok !== null && tarea.ok !== undefined ? 'disabled' : '';
                    let tareaId = tarea.id_tarea_mantenimiento || `${tarea.id_zona}-${tarea.id_zona_tarea}`;

                    tabla_inspecciones.row.add([
                        tarea.elemento || tarea.nombre_tarea,
                        `<input type="radio" name="tareas[${j}][ok]" value="ok" ${disabled} id="ok_${tareaId}" onchange="checkboxTareaRealizada(${j},'${tareaId}')">
                         <input type="hidden" name="tareas[${j}][id]" value="${tareaId}">`,
                        `<input id="not_ok_${tareaId}" type="radio" ${disabled} onchange="checkboxTareaRealizada(${j},'${tareaId}')" name="tareas[${j}][ok]" value="not_ok">`,
                        `<div id="label_accion_${tareaId}">-</div>
                         <select onchange="showSpanAviso()" name="tareas[${j}][accion]" class="form-select" hidden id="accion_${tareaId}" ${disabled}>
                            <option value="NO ACCION" hidden>Seleccionar...</option>
                            ${$("#accion_select_div").html()}
                         </select>`
                    ]);
                    tabla_inspecciones.draw();
                    
                    if(tarea.ok === null || tarea.ok === undefined){
                        $("#accion_" + tareaId).attr('hidden', true);
                        $("#accion_" + tareaId).removeAttr('required');
                        $("#label_accion_" + tareaId).removeAttr('hidden');
                        $(`#ok_${tareaId}`).prop('checked', false);
                        $(`#not_ok_${tareaId}`).prop('checked', false);
                    }
                    else if(tarea.ok == 0){
                        $(`#accion_${tareaId}`).val(tarea.id_accion_tarea);
                        $("#label_accion_" + tareaId).attr('hidden', true);
                        $("#accion_" + tareaId).removeAttr('hidden');
                        $("#accion_" + tareaId).attr('required', 'required');
                        $(`#not_ok_${tareaId}`).prop('checked', true);
                    }
                    else if(tarea.ok == 1){
                        $("#accion_" + tareaId).attr('hidden', true);
                        $("#accion_" + tareaId).removeAttr('required');
                        $("#label_accion_" + tareaId).html('No se requiere acción');
                        $("#label_accion_" + tareaId).removeAttr('hidden');
                        $(`#ok_${tareaId}`).prop('checked', true);
                    }
                    j++;
                });
            }
            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust(); 
            showSpanAviso();
            $("#horas_inspeccion").val('00');
            $("#minutos_inspeccion").val('00');
            let hoy = new Date();
            hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) + '-' + hoy.getDate().toString().padStart(2, 0);
            $("#fecha_inspeccion").val(hoy);
        }
    });
}

function openModalVerParteInspeccion(id_orden){   
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").hide();
    $("#previewAceptarInspeccionReview").hide();
    $("#horas_inspeccion").attr('disabled', 'disabled');
    $("#minutos_inspeccion").attr('disabled', 'disabled');
    $("#fecha_inspeccion").attr('disabled', 'disabled');
    $("#completado_inspeccion").prop('checked', true);
    $("#herramental_inspeccion").val($("#activo").val());
    document.getElementById('nombreActivoInspeccion').textContent = $("#activo").val();
    
    tabla_inspecciones.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion-completado/' + id_orden,
        success: function(data) {
            // Unimos todos los elementos de los diferentes partes de inspección
            let todosLosElementos = data.flatMap(d => d.elementos || []);

            // Ordenamos alfabéticamente por el nombre de la zona tarea
            todosLosElementos.sort((a, b) => {
                let tareaA = a.get_zona_tarea ? a.get_zona_tarea.nombre_zona : '';
                let tareaB = b.get_zona_tarea ? b.get_zona_tarea.nombre_zona : '';
                return tareaA.localeCompare(tareaB);
            });

            let zona_actual = null;
            
            todosLosElementos.forEach(elemento => {
                let nombre_zona_actual = elemento.get_zona_tarea ? elemento.get_zona_tarea.nombre_zona : 'Sin Zona';
                if (nombre_zona_actual !== zona_actual) {
                    zona_actual = nombre_zona_actual;
                    addZonaHeader(zona_actual);
                }

                let ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}" disabled checked>
                            <label class="form-check-label" for="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}">
                            </label>
                          </div>`;

                let not_ok = `<div class="form-check">
                                <input class="form-check-input" type="radio" name="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}" disabled>
                                <label class="form-check-label" for="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}">
                                </label>
                              </div>`;

                let accion = '-';

               if(elemento.ok == 0){
                    ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}" disabled>
                            <label class="form-check-label" for="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}">
                            </label>
                          </div>`;
                    not_ok = `<div class="form-check">
                                <input class="form-check-input" type="radio" name="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}" disabled checked>
                                <label class="form-check-label" for="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}">
                                </label>
                              </div>`;
                    accion = elemento.get_accion_para_tarea ? elemento.get_accion_para_tarea.nombre_accion : '-';
                }       
                tabla_inspecciones.row.add([
                    elemento.get_zona.nombre_zona,
                    ok,
                    not_ok,
                    accion
                ]);
            });

            // Tomamos los datos generales (como horas o fecha) del primer registro si existe
            if(data.length > 0) {
                let primerParte = data[0];
                if(primerParte.get_parte) {
                    $("#fecha_inspeccion").val(primerParte.get_parte.fecha);
                }
                if(primerParte.horas) {
                    let [hr, mn] = primerParte.horas.split(':');
                    $("#horas_inspeccion").val(hr);
                    $("#minutos_inspeccion").val(mn);
                }
            }

            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust();
            showSpanAviso();
        }
    });
}

function verParteDeInspeccion(id_parte, completado){
    $('#modalNuevoParteInspeccion').modal('show');
    $("#btnGuardarNuevoParteInspeccion").hide();
    $("#previewAceptarInspeccionReview").hide();
    $("#horas_inspeccion").attr('disabled', 'disabled');
    $("#minutos_inspeccion").attr('disabled', 'disabled');
    $("#fecha_inspeccion").attr('disabled', 'disabled');
    $("#completado_inspeccion").prop('checked', true);
    $("#herramental_inspeccion").val($("#activo").val());
    document.getElementById('nombreActivoInspeccion').textContent = $("#activo").val();
    if(completado == 'Completo'){
        $("#completado_inspeccion").prop('checked', true);
    }
    else{
        $("#completado_inspeccion").prop('checked', false);
    }

    tabla_inspecciones.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion-porcion/' + id_parte,
        success: function(data) {
            let zona_actual = null;
            if(data.elementos) {
                data.elementos.forEach(elemento => {
                    let nombre_zona_actual = elemento.get_zona_tarea ? elemento.get_zona_tarea.nombre_zona : 'Sin Zona';
                    if (nombre_zona_actual !== zona_actual) {
                        zona_actual = nombre_zona_actual;
                        addZonaHeader(zona_actual);
                    }

                    let ok = `<div class="form-check">
                                <input class="form-check-input" type="radio" name="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}" disabled checked>
                                <label class="form-check-label" for="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}">
                                </label>
                              </div>`;

                    let not_ok = `<div class="form-check">
                                <input class="form-check-input" type="radio" name="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}" disabled>
                                <label class="form-check-label" for="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}">
                                </label>
                              </div>`;

                    let accion = '-';

                    if(elemento.ok == 0){
                        ok = `<div class="form-check">
                                <input class="form-check-input" type="radio" name="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}" disabled>
                                <label class="form-check-label" for="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}">
                                </label>
                              </div>`;
                        not_ok = `<div class="form-check">
                                <input class="form-check-input" type="radio" name="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}" disabled checked>
                                <label class="form-check-label" for="radioDisabled${elemento.id_zona}-${elemento.id_zona_tarea}">
                                </label>
                              </div>`;
                        accion = elemento.get_accion_para_tarea ? elemento.get_accion_para_tarea.nombre_accion : '-';
                    }      
                    tabla_inspecciones.row.add([
                        elemento.get_zona.nombre_zona,
                        ok,
                        not_ok,
                        accion
                    ]);
                });
            }
            if(data.get_parte) {
                $("#fecha_inspeccion").val(data.get_parte.fecha);            
                let [hr, mn] = data.get_parte.horas.split(':');
                $("#horas_inspeccion").val(hr);
                $("#minutos_inspeccion").val(mn);
            }
            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust();
            showSpanAviso();
        }
    });
}
