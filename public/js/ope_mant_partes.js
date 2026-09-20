var tabla_diagnosticos = null;
var tabla_inspecciones = null;
var tabla_ajustes = null;

var openModalCrearParteDiagnostico = openModalNuevoParteDiagnostico;

/* ==========================================================================
   INICIALIZACIÓN SEGURA DE DATATABLES (LAZY LOADING)
   ========================================================================== */
function getTablaDiagnosticos() {
    if (!tabla_diagnosticos || !$.fn.DataTable.isDataTable('#tabla_diagnosticos')) {
        if ($('#tabla_diagnosticos').length > 0) {
            tabla_diagnosticos = $('#tabla_diagnosticos').DataTable({
                columnDefs: [{ className: "text-center", targets: [0, 1, 2, 3] }],
                language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar',
                    paginate: { first: "Prim.", last: "Ult.", previous: 'Ant.', next: 'Sig.' }
                },
                "aaSorting": []
            });
        }
    }
    return tabla_diagnosticos;
}

function getTablaInspecciones() {
    if (!tabla_inspecciones || !$.fn.DataTable.isDataTable('#tabla_inspecciones')) {
        if ($('#tabla_inspecciones').length > 0) {
            tabla_inspecciones = $('#tabla_inspecciones').DataTable({
                headerCallback: function (thead) { $(thead).hide(); },
                columnDefs: [{ className: "text-center", targets: [0, 1, 2, 3, 4] }],
                language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar',
                    paginate: { first: "Prim.", last: "Ult.", previous: 'Ant.', next: 'Sig.' }
                },
                pageLength: 100,
                "aaSorting": []
            });
        }
    }
    return tabla_inspecciones;
}

function getTablaAjustes() {
    if (!tabla_ajustes || !$.fn.DataTable.isDataTable('#tabla_ajustes')) {
        if ($('#tabla_ajustes').length > 0) {
           tabla_ajustes = $('#tabla_ajustes').DataTable({
            autoWidth: false,
            columnDefs: [
                { className: "text-center", targets: [1,2,3,4] }, { width: '25%', targets:[0]}, {className: "text-start", targets: [0]}  
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
                "aaSorting": []
        });    
        }
    }
    return tabla_ajustes;
}

$(document).ready(function () {
    getTablaDiagnosticos();
    getTablaInspecciones();
    getTablaAjustes();
});

/* ==========================================================================
   FUNCIONES DE UTILIDAD Y COMPARTIDAS
   ========================================================================== */
function getFechaHoy() {
    let hoy = new Date();
    return hoy.getFullYear().toString() + '-' +
        (hoy.getMonth() + 1).toString().padStart(2, '0') + '-' +
        hoy.getDate().toString().padStart(2, '0');
}

function showSpanAviso() {
    let hayRefabricar = false;

    $("select[id^='accion_']").each(function () {
        let text = $(this).find("option:selected").text();
        if (text && text.trim().toUpperCase() === 'REFABRICAR') {
            hayRefabricar = true;
            return false;
        }
    });

    if (!hayRefabricar) {
        $("#tabla_inspecciones tbody tr, #tabla_ajustes tbody tr").each(function () {
            let text = $(this).find("td").text();
            if (text && text.toUpperCase().includes('REFABRICAR')) {
                hayRefabricar = true;
                return false;
            }
        });
    }

    if (hayRefabricar) {
        $("#span_aviso_mecanizado").show();
    } else {
        $("#span_aviso_mecanizado").hide();
    }
}

/* ==========================================================================
   SECCIÓN DIAGNÓSTICO
   ========================================================================== */
var i_diag = 0;

function agregarDiagnostico() {
    let tabla = getTablaDiagnosticos();
    if (!tabla) return;

    const ishikawa_categoria = document.getElementById('ishikawa_categoria_div');
    const ishikawa_causa = document.getElementById('ishikawa_causa_div');

    tabla.row.add([
        i_diag + 1,
        `<select required onchange="cambiarIshikawaCategoria(${i_diag})" class="form-select" name="ishikawa_categoria[]" id="ishikawa_categoria_${i_diag}">
            <option hidden value="">Seleccionar...</option>
            ${ishikawa_categoria.innerHTML}
        </select>`,
        `<div id="prev_ishikawa_cat_${i_diag}">Primero elegir 5M</div>
         <select required hidden class="form-select" name="ishikawa_causa[]" id="ishikawa_causa_${i_diag}">
            <option hidden value="">Seleccionar...</option>
            ${ishikawa_causa.innerHTML}
         </select>`,
        `<button type="button" class="btn btn-danger" onclick="eliminarDiagnostico(${i_diag})">Eliminar</button>`
    ]).node().id = `diagnostico_${i_diag}`;

    tabla.draw(false);
    i_diag++;
    checkSendNuevoParteDiagnostico();
}

function cambiarIshikawaCategoria(indice) {
    let ishikawa_categoria = document.getElementById(`ishikawa_categoria_${indice}`).value;
    let ishikawa_causa = document.getElementById(`ishikawa_causa_${indice}`);
    ishikawa_causa.removeAttribute('hidden');
    document.getElementById(`prev_ishikawa_cat_${indice}`).setAttribute('hidden', true);

    for (let j = 0; j < ishikawa_causa.options.length; j++) {
        if (ishikawa_causa.options[j].dataset.ishikawaCategoria == ishikawa_categoria) {
            ishikawa_causa.options[j].removeAttribute('hidden');
        } else {
            ishikawa_causa.options[j].setAttribute('hidden', true);
        }
    }
}

function eliminarDiagnostico(indice) {
    let tabla = getTablaDiagnosticos();
    if (!tabla) return;

    tabla.row('#diagnostico_' + indice).remove().draw();
    for (let j = 0; j < tabla.rows().count(); j++) {
        const row = tabla.row(j).node();
        row.id = `diagnostico_${j}`;
        row.querySelector('td').innerText = j + 1;
        row.querySelector('select').setAttribute('id', `ishikawa_categoria_${j}`);
        row.querySelectorAll('select')[1].setAttribute('id', `ishikawa_causa_${j}`);
        row.querySelector('button').setAttribute('onclick', `eliminarDiagnostico(${j})`);
        row.querySelector('select').setAttribute('onchange', `cambiarIshikawaCategoria(${j})`);
    }
    i_diag = tabla.rows().count();
    checkSendNuevoParteDiagnostico();
}

function checkSendNuevoParteDiagnostico() {
    let tabla = getTablaDiagnosticos();
    let count = tabla ? tabla.rows().count() : 0;

    if (count > 0 && $("#fecha").val() && $("#horas").val()) {
        $("#btnGuardarNuevoParteDiagnostico, #btnGuardarNuevoParteDiagnosticoCerrar").removeAttr('disabled');
    } else {
        $("#btnGuardarNuevoParteDiagnostico, #btnGuardarNuevoParteDiagnosticoCerrar").attr('disabled', 'disabled');
    }
}

function openModalNuevoParteDiagnostico(id_orden, nombre_activo, proyecto) {
    let activoFinal = nombre_activo || $("#activo").val();
    let proyectoFinal = proyecto || $("#nombre_proyecto_i").val();

    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico, #btnGuardarNuevoParteDiagnostico, #btnGuardarNuevoParteDiagnosticoCerrar, .obligatorio, #label_ob_diagnostico").show();
    $("#btnGuardarNuevoParteDiagnostico, #btnGuardarNuevoParteDiagnosticoCerrar").attr('disabled', 'disabled');
    
    let tabla = getTablaDiagnosticos();
    if (tabla) tabla.clear().draw();
    i_diag = 0;

    $("input:radio[name=a_resolver]").removeAttr('disabled').prop("checked", false);
    $("#horas, #minutos, #observaciones_diagonstico, #completado_diagnostico, #fecha").removeAttr('disabled');
    $("#horas").val('00');
    $("#minutos").val('00');
    $("#fecha").val(getFechaHoy());
    $("#observaciones_diagonstico").val('');
    $("#completado_diagnostico").removeAttr('checked');

    $("#herramental").val(activoFinal);
    $("#nombre_proyecto_diagnostico").val(proyectoFinal);
    if (document.getElementById('nombreActivo')) document.getElementById('nombreActivo').textContent = activoFinal;
    $("#id_orden").val(id_orden);
}

function openModalVerParteDiagnostico(id_orden, activo) {
    let activoFinal = activo || $("#activo").val();
    
    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico, #btnGuardarNuevoParteDiagnostico, #btnGuardarNuevoParteDiagnosticoCerrar, .obligatorio, #label_ob_diagnostico").hide();
    $("#fecha, #horas, #minutos, #observaciones_diagonstico").attr('disabled', 'disabled');
    $("#completado_diagnostico").prop('disabled', true);

    $("#herramental").val(activoFinal);
    if (document.getElementById('nombreActivo')) document.getElementById('nombreActivo').textContent = activoFinal;

    let tabla = getTablaDiagnosticos();
    if (!tabla) return;

    tabla.column(3).visible(false);
    tabla.clear();

    $.ajax({
        type: 'GET',
        url: '/get-parte-diagnostico-completado/' + id_orden,
        success: function (data) {
            let tabla = getTablaDiagnosticos();
            if (!data.length || !tabla) return;
            let diag = data[0];
            let [hr, mn] = (diag.get_parte.horas || "00:00").split(':');
            $("#horas").val(hr);
            $("#minutos").val(mn);
            $("#fecha").val(diag.get_parte.fecha);
            $("#observaciones_diagonstico").val(diag.get_parte.observaciones);
            $("#completado_diagnostico").prop('checked', true);

            if (diag.en_maquina == 1) $("input:radio[name=a_resolver][value='Máquina']").prop("checked", true);
            else if (diag.en_banco == 1) $("input:radio[name=a_resolver][value='Banco']").prop("checked", true);
            $("input:radio[name=a_resolver]").attr("disabled", true);

            let index = 1;
            data.forEach(diagnostico => {
                diagnostico.get_parte_diag_x_causa.forEach(parte => {
                    tabla.row.add([
                        index,
                        parte.get_ishikawa_causa.get_categoria.nombre_categoria,
                        parte.get_ishikawa_causa.nombre_causa,
                        '-'
                    ]);
                    index++;
                });
            });
            tabla.columns.adjust().draw();
        }
    });
}

function openModalParteDiagnosticoPendiente(id_orden, activo, proyecto) {
    openModalNuevoParteDiagnostico(id_orden, activo, proyecto);

    $.ajax({
        type: 'GET',
        url: '/get-parte-diagnostico-completado/' + id_orden,
        success: function (data) {
            let tabla = getTablaDiagnosticos();
            if (!data.length || !tabla) return;
            let diag = data[0];
            $("#observaciones_diagonstico").val(diag.get_parte.observaciones);
            $("#completado_diagnostico").prop('checked', false);

            if (diag.en_maquina == 1) $("input:radio[name=a_resolver][value='Máquina']").prop("checked", true);
            else if (diag.en_banco == 1) $("input:radio[name=a_resolver][value='Banco']").prop("checked", true);

            let index = 0;
            data.forEach(diagnostico => {
                diagnostico.get_parte_diag_x_causa.forEach(parte => {
                    tabla.row.add([
                        index + 1,
                        parte.get_ishikawa_causa.get_categoria.nombre_categoria,
                        parte.get_ishikawa_causa.nombre_causa,
                        '-'
                    ]);
                    index++;
                });
            });
            tabla.columns.adjust().draw();
        }
    });
}

function diagnosticoPreSubmit(tipo) {
    $("#completado_diagnostico").prop('checked', tipo === 'C');
    $("#formNuevoParteDiagnostico").trigger("submit");
}


/* ==========================================================================
   SECCIÓN INSPECCIÓN
   ========================================================================== */
function openModalNuevoParteInspeccion(id_activo, id_orden, nombre_activo, proyecto) {
    let activoFinal = nombre_activo || $("#activo").val();
    let proyectoFinal = proyecto || $("#nombre_proyecto_i").val();

    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").show();
    $("#previewAceptarInspeccionReview").hide();

    $("#herramental_inspeccion").val(activoFinal);
    $("#nombre_proyecto_inspeccion").val(proyectoFinal);
    if (document.getElementById('nombreActivoInspeccion')) document.getElementById('nombreActivoInspeccion').textContent = activoFinal;

    $("#horas_inspeccion, #minutos_inspeccion, #fecha_inspeccion").removeAttr('disabled');
    $("#fecha_inspeccion").val(getFechaHoy());

    let tabla = getTablaInspecciones();
    if (tabla) tabla.clear();

    $.ajax({
        type: 'GET',
        url: '/get-tareas-por-activo/' + id_activo,
        success: function (data) {
            let tabla = getTablaInspecciones();
            if (!tabla || !data.tareas_x_activo.length) return;

            let zona_actual = null;
            let j = 0;
            data.tareas_x_activo.forEach(tarea => {
                let nombreZona = tarea.nombre_zona || (tarea.get_zona_tarea ? tarea.get_zona_tarea.nombre_zona : 'Sin Zona');
                if (nombreZona !== zona_actual) {
                    zona_actual = nombreZona;
                    addZonaHeader(zona_actual);
                }
                let tareaId = tarea.id_tarea_mantenimiento || `${tarea.id_zona}-${tarea.id_zona_tarea}`;

                tabla.row.add([
                    tarea.nombre_tarea || tarea.elemento,
                    tarea.get_ejecucion ? tarea.get_ejecucion.nombre_ejecucion : '-',
                    `<input type="radio" name="tareas[${j}][ok]" value="ok" onchange="checkboxTareaRealizada(${j}, '${tareaId}')">
                     <input type="hidden" name="tareas[${j}][id]" value="${tareaId}">`,
                    `<input type="radio" onchange="checkboxTareaRealizada(${j}, '${tareaId}')" name="tareas[${j}][ok]" value="not_ok">`,
                    `<div id="label_accion_${tareaId}">-</div>
                     <select onchange="showSpanAviso()" required name="tareas[${j}][accion]" class="form-select" hidden id="accion_${tareaId}">
                        <option value="NO ACCION" hidden>Seleccionar...</option>
                        ${$("#accion_select_div").html()}
                     </select>`
                ]);
                j++;
            });
            tabla.draw();
            tabla.columns.adjust();
        }
    });
}

function addZonaHeader(nombreZona) {
    let tabla = getTablaInspecciones();
    if (!tabla) return;

    let zonaRow = tabla.row.add([nombreZona, "", "", "", ""]).node();

    $(zonaRow).find('td').eq(0).attr('colspan', 5).addClass('text-center fw-bold text-dark');
    $(zonaRow).find('td:gt(0)').remove();
    $(zonaRow).removeClass('odd even').attr('style', "color: #fff; background-color: #2b56843b; font-weight: bold;");

    let headerRow = tabla.row.add(["Tarea / Elemento", "Ejecución", "OK", "NO OK", "Acción"]).node();
    $(headerRow).removeClass('odd even').addClass('zona-columns text-light');
    $(headerRow).find('td').attr('style', "color: #fff !important; background-color: #2b5684; font-weight: bold;");
}

function checkboxTareaRealizada(j, idTarea) {
    const radio = $(`input[name="tareas[${j}][ok]"]:checked`).val();

    if (radio === 'not_ok') {
        $("#label_accion_" + idTarea).attr('hidden', true);
        $("#accion_" + idTarea).removeAttr('hidden').attr('required', 'required');
    } else {
        $("#accion_" + idTarea).attr('hidden', true).removeAttr('required');
        $("#label_accion_" + idTarea).html('No se requiere acción').removeAttr('hidden');
    }

    let completo = validarRadios();
    $("#completado_inspeccion_value, #completado_inspeccion").prop('checked', completo);
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

function openModalParteInspeccionPendiente(id_activo, id_orden, nombre_activo, proyecto) {
    openModalNuevoParteInspeccion(id_activo, id_orden, nombre_activo, proyecto);

    $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion-pendiente/' + id_activo + '/' + id_orden,
        success: function (data) {
            let tabla = getTablaInspecciones();
            let j = 0;
            let tareasList = data.tareasMantenimiento || data.tareas_x_activo;
            if (!tareasList || !tabla) return;

            tabla.clear();
            let zona_actual = null;

            tareasList.forEach(tarea => {
                let nombreZona = tarea.nombre_zona || (tarea.get_zona_tarea ? tarea.get_zona_tarea.nombre_zona : 'Sin Zona');
                if (nombreZona !== zona_actual) {
                    zona_actual = nombreZona;
                    addZonaHeader(zona_actual);
                }
                let tareaId = tarea.id_tarea_mantenimiento || `${tarea.id_zona}-${tarea.id_zona_tarea}`;

                tabla.row.add([
                    tarea.nombre_tarea || tarea.elemento,
                    tarea.get_ejecucion ? tarea.get_ejecucion.nombre_ejecucion : '-',
                    `<input type="radio" name="tareas[${j}][ok]" value="ok" id="ok_${tareaId}" onchange="checkboxTareaRealizada(${j}, '${tareaId}')">
                     <input type="hidden" name="tareas[${j}][id]" value="${tareaId}">`,
                    `<input id="not_ok_${tareaId}" type="radio" onchange="checkboxTareaRealizada(${j}, '${tareaId}')" name="tareas[${j}][ok]" value="not_ok">`,
                    `<div id="label_accion_${tareaId}">-</div>
                     <select onchange="showSpanAviso()" name="tareas[${j}][accion]" class="form-select" hidden id="accion_${tareaId}">
                        <option value="NO ACCION" hidden>Seleccionar...</option>
                        ${$("#accion_select_div").html()}
                     </select>`
                ]);

                if (tarea.ok === 0) {
                    $(`#accion_${tareaId}`).val(tarea.id_accion_tarea).removeAttr('hidden').attr('required', 'required');
                    $("#label_accion_" + tareaId).attr('hidden', true);
                    $(`#not_ok_${tareaId}`).prop('checked', true);
                } else if (tarea.ok == 1) {
                    $("#label_accion_" + tareaId).html('No se requiere acción').removeAttr('hidden');
                    $(`#ok_${tareaId}`).prop('checked', true);
                }
                j++;
            });

            tabla.draw();
            tabla.columns.adjust();
            showSpanAviso();
        }
    });
}

function openModalVerParteInspeccion(id_orden, nombre_activo) {
    let activoFinal = nombre_activo || $("#activo").val();

    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion, #previewAceptarInspeccionReview").hide();
    $("#horas_inspeccion, #minutos_inspeccion, #fecha_inspeccion").attr('disabled', 'disabled');
    $("#completado_inspeccion").prop('checked', true);
    $("#herramental_inspeccion").val(activoFinal);
    if (document.getElementById('nombreActivoInspeccion')) document.getElementById('nombreActivoInspeccion').textContent = activoFinal;

    let tabla = getTablaInspecciones();
    if (tabla) tabla.clear();

    $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion-completado/' + id_orden,
        success: function (data) {
            let tabla = getTablaInspecciones();
            if (!tabla) return;
            let zona_actual = null;
            let tareas = data.get_parte?.get_orden?.parte_inspe_x_tareas_mantenimiento || data;

            tareas.forEach(tarea => {
                let nombreZona = tarea.get_tarea_mantenimiento?.get_zona_tarea?.nombre_zona || 'Sin Zona';
                if (nombreZona !== zona_actual) {
                    zona_actual = nombreZona;
                    addZonaHeader(zona_actual);
                }

                let isOk = tarea.ok == 1;
                let okHtml = `<input class="form-check-input" type="radio" disabled ${isOk ? 'checked' : ''}>`;
                let notOkHtml = `<input class="form-check-input" type="radio" disabled ${!isOk ? 'checked' : ''}>`;
                let accionText = !isOk && tarea.get_accion_para_tarea ? tarea.get_accion_para_tarea.nombre_accion : '-';

                tabla.row.add([
                    tarea.get_tarea_mantenimiento?.nombre_tarea || tarea.elemento,
                    tarea.get_tarea_mantenimiento?.get_ejecucion?.nombre_ejecucion || '-',
                    okHtml,
                    notOkHtml,
                    accionText
                ]);
            });

            if (data.get_parte) {
                $("#fecha_inspeccion").val(data.get_parte.fecha);
                let [hr, mn] = (data.horas || "00:00").split(':');
                $("#horas_inspeccion").val(hr);
                $("#minutos_inspeccion").val(mn);
            }
            tabla.draw();
            tabla.columns.adjust();
            showSpanAviso();
        }
    });
}

function procesarInspeccion(accion) {
    $.ajax({
        type: 'post',
        url: '/procesar-parte-inspeccion',
        data: {
            id_orden_mantenimiento: $("#id_orden_inspeccion").val(),
            accion: accion,
            nombre_proyecto: $("#nombre_proyecto_i").text(),
        },
        success: function () {
            $('#modalNuevoParteInspeccion').modal('hide');
            location.reload();
        }
    });
}


/* ==========================================================================
   SECCIÓN AJUSTE
   ========================================================================== */
function openModalNuevoParteAjuste(id_orden, id_etapa, nombre_activo, proyecto, id_act, id_tipo) {
    let activoFinal = nombre_activo || $("#activo").val();
    let proyectoFinal = proyecto || $("#nombre_proyecto_i").val();

    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste, #btnRowNuevoAjuste").show();
    $("#previewAceptarAjusteReview").hide();

    $("#herramental_ajuste").val(activoFinal);
    if (document.getElementById('nombreActivoAjuste')) document.getElementById('nombreActivoAjuste').textContent = activoFinal;
    $("#nombre_proyecto_ajuste").val(proyectoFinal);

    $("#horas_ajuste, #minutos_ajuste, #fecha_ajuste").removeAttr('disabled');
    if (id_act) $("#id_activo_para_orden").val(id_act);
    if (id_tipo) $("#id_tipo_activo_para_orden").val(id_tipo);

    let tabla = getTablaAjustes();
    if (tabla) tabla.clear();

    $.ajax({
        type: 'GET',
        url: '/get-pre-acciones-ajuste/' + id_etapa,
        success: function (data) {
            let tabla = getTablaAjustes();
            if (!tabla) return;
            let j = 0;
            let idTipoActivo = data?.[0]?.get_parte?.get_orden?.get_etapa?.get_servicio?.get_activo?.id_tipo_activo ?? id_tipo ?? null;
            let zonas = $('<div>').html($("#zona_select_div").html());

            if (idTipoActivo) {
                zonas.find('option').each(function () {
                    if ($(this).val() === '') return;
                    let tipos = $(this).data('id_tipos');
                    if (typeof tipos === 'string') tipos = JSON.parse(tipos);
                    if (tipos && !tipos.includes(idTipoActivo)) $(this).remove();
                });
            }

            data.forEach(d => {
                let tareas = d.get_tareas_mantenimiento || [d];
                tareas.forEach(tarea => {
                    let nombreTarea = tarea.get_tarea_mantenimiento?.nombre_tarea || tarea.nombre_tarea || '';
                    let nombreZona = tarea.get_tarea_mantenimiento?.get_zona_tarea?.nombre_zona || tarea.get_zona?.nombre_zona || '';
                    let idTarea = tarea.get_tarea_mantenimiento?.id_tarea_mantenimiento || tarea.id_tarea_mantenimiento;
                    let accionNombre = tarea.get_accion_para_tarea?.nombre_accion || '';

                    tabla.row.add([
                        (j + 1) + ' - ' + nombreTarea + (nombreZona ? ' (' + nombreZona + ')' : ''),
                        accionNombre || `<select onchange="showSpanAviso()" id="accion_${j}" class="form-select" name="tareas[${j}][accion]"><option value="">Seleccionar...</option>${$("#accion_select_div").html()}</select>`,
                        `<select id="tareas_zona_${j}" class="form-select" required name="tareas[${j}][zona]">
                            <option value="">Seleccionar...</option>
                            ${zonas.html()}
                        </select>
                        <input hidden name="tareas[${j}][accion]" value="${tarea.get_accion_para_tarea?.id_accion_tarea || ''}">
                        <input hidden name="tareas[${j}][tarea_mant]" value="${idTarea}">`,
                        `<select id="tarea_maquina_${j}" class="form-select" required name="tareas[${j}][maquina]">
                            <option value="">Seleccionar...</option>
                            ${$("#maquina_select_div").html()}
                        </select>`,
                        `<input id="tarea_hecho_${j}" onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox" name="tareas[${j}][hecho]">`
                    ]);
                    j++;
                });
            });

            $("#fecha_ajuste").val(getFechaHoy());
            $("#horas_ajuste, #minutos_ajuste").val('00');
            tabla.draw();
            tabla.columns.adjust();
            checkCompletoAjuste();
        }
    });
}

function getTareasFiltradas(idActivo, idTipo) {
    return $("#tarea_mantenimiento option").filter(function () {
        const activo = $(this).data("activo");
        const tipo = $(this).data("tipo");
        return activo == idActivo || tipo == idTipo;
    }).clone();
}

function agregarNuevoAjusteRow() {
    let tabla = getTablaAjustes();
    if (!tabla) return;
    let j = tabla.rows().count();

    const rowNode = tabla.row.add([
        `<div class="d-flex"><div class="my-auto">${j + 1} - </div>
        <select style="width: 85%" class="m-auto form-select" name="tareas[${j}][tarea_mant]">
            <option value="">Seleccionar...</option>
            ${getTareasFiltradas($("#id_activo_para_orden").val(), $("#id_tipo_activo_para_orden").val()).map((_, el) => el.outerHTML).get().join('')}
        </select></div>`,
        `<select onchange="showSpanAviso()" class="form-select" required name="tareas[${j}][accion]">
            <option value="">Seleccionar...</option>
            ${$("#accion_select_div").html()}
        </select>`,
        `<select id="tareas_zona_${j}" class="form-select" required name="tareas[${j}][zona]">
            ${$(`[name="tareas[${j - 1}][zona]"]`).html() || $("#zona_select_div").html()}
        </select>`,
        `<select id="tarea_maquina_${j}" class="form-select" required name="tareas[${j}][maquina]">
            <option value="">Seleccionar...</option>
            ${$("#maquina_select_div").html()}
        </select>`,
        `<input id="tarea_hecho_${j}" onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox" name="tareas[${j}][hecho]">
         <button type="button" onclick="eliminarRowAjuste(${j})" class="btn btn-danger ms-2">X</button>`
    ]).node();
    rowNode.id = `ajuste_${j}`;

    tabla.draw();
    $("#completado_ajuste").prop('checked', false);
    checkCompletoAjuste();
}

function eliminarRowAjuste(indice) {
    let tabla = getTablaAjustes();
    if (!tabla) return;
    tabla.row('#ajuste_' + indice).remove();
    reordenarFilasAjuste();
    checkCompletoAjuste();
}

function reordenarFilasAjuste() {
    let tabla = getTablaAjustes();
    if (!tabla) return;
    tabla.rows().every(function (rowIndex) {
        const row = this.node();
        row.id = `ajuste_${rowIndex}`;

        $(row).find('select, input').each(function () {
            let name = $(this).attr('name');
            if (name) {
                name = name.replace(/tareas\[\d+\]/, `tareas[${rowIndex}]`);
                $(this).attr('name', name);
            }
        });
        $(row).find('button').attr('onclick', `eliminarRowAjuste(${rowIndex})`);
        $(row).find('td').eq(0).find('.my-auto').text((rowIndex + 1) + ' - ');
    });
    tabla.draw(false);
}

function checkCompletoAjuste() {
    const checkboxes = document.querySelectorAll('input[name^="tareas"][name$="[hecho]"]');
    let allChecked = checkboxes.length > 0;

    checkboxes.forEach(cb => {
        const id = cb.id.replace('tarea_hecho_', '');
        const zona = document.getElementById(`tareas_zona_${id}`);
        const maquina = document.getElementById(`tarea_maquina_${id}`);

        if (zona) zona.required = cb.checked;
        if (maquina) maquina.required = cb.checked;

        if (!cb.checked) allChecked = false;
    });

    $("#completado_ajuste").prop('checked', allChecked);
}

function openModalParteAjustePendiente(id_orden, id_etapa, nombre_activo, proyecto, id_act, id_tipo) {
    openModalNuevoParteAjuste(id_orden, id_etapa, nombre_activo, proyecto, id_act, id_tipo);

    $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste/' + id_orden,
        success: function (data) {
            let tabla = getTablaAjustes();
            if (!tabla) return;
            let j = 0;
            tabla.clear();
            data.get_tareas_ajuste.forEach(tarea => {
               if(tarea.id_tarea_mantenimiento != null){
                    tabla_ajustes.row.add([
                        tarea.get_zona.nombre_zona + ' - ' + tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona,
                        `<select onchange="showSpanAviso()" id="accion_${j}" class="form-select" name="tareas[${j}][accion]">
                            <option value="">Seleccionar...</option>
                            ${$("#accion_select_div").html()}
                        </select>
                        <input hidden name="tareas[${j}][tarea_mant]" value="${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">`,
                        `<input type="text" class="form-control" name="tareas[${j}][observaciones]" placeholder="Observaciones..." value="${tarea.observaciones ?? ''}">`,
                        `<select id="tarea_maquina_${j}" class="form-select" name="tareas[${j}][maquina]">
                            <option value="">Seleccionar...</option>
                            ${$("#maquina_select_div").html()}
                        </select>`,
                        `<input onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox" id="tarea_hecho_${j}"
                        name="tareas[${j}][hecho]">`
                    ]);        
                }
                else{
                    tabla_ajustes.row.add([
                        tarea.get_zona.nombre_zona + ' - ' + tarea.get_zona_tarea.nombre_zona,
                        `<select onchange="showSpanAviso()" id="accion_${j}" class="form-select" name="tareas[${j}][accion]">
                            <option value="">Seleccionar...</option>
                            ${$("#accion_select_div").html()}
                        </select>
                        <input hidden name="tareas[${j}][tarea_mant]" value="${tarea.id_zona}-${tarea.id_zona_tarea}">`,
                        `<input type="text" class="form-control" name="tareas[${j}][observaciones]" value="${tarea.observaciones ?? ''}" placeholder="Observaciones...">`,
                        `<select id="tarea_maquina_${j}" class="form-select" name="tareas[${j}][maquina]">
                            <option value="">Seleccionar...</option>
                            ${$("#maquina_select_div").html()}
                        </select>`,
                        `<input onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox" id="tarea_hecho_${j}"
                        name="tareas[${j}][hecho]">`
                    ]);        
                }

                $(`#tarea_maquina_${j}`).val(tarea.id_maquinaria ?? '')
                $(`select[name="tareas[${j}][accion]"]`).val(tarea.get_accion_tarea?.id_accion_tarea ?? '')
                tarea.hecho? $(`#tarea_hecho_${j}`).prop('checked', true): $(`#tarea_hecho_${j}`).prop('checked', false)
                j++;
            });
            tabla.draw();
            tabla.columns.adjust();
            checkCompletoAjuste();
        }
    });
}

function openModalVerParteAjuste(id_orden, nombre_activo) {
    let activoFinal = nombre_activo || $("#activo").val();

    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste, #previewAceptarAjusteReview, #btnRowNuevoAjuste").hide();
    $("#horas_ajuste, #minutos_ajuste, #fecha_ajuste, #completado_ajuste").attr('disabled', 'disabled');
    $("#completado_ajuste").prop('checked', true);

    $("#herramental_ajuste").val(activoFinal);
    if (document.getElementById('nombreActivoAjuste')) document.getElementById('nombreActivoAjuste').textContent = activoFinal;

    let tabla = getTablaAjustes();
    if (tabla) tabla.clear();

    $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste-completado/' + id_orden,
        success: function (data) {
            let tabla = getTablaAjustes();
            if (!tabla) return;
            let j = 0;
            data.get_tareas_ajuste.forEach(tarea => {
                tabla.row.add([
                    (j + 1) + ' - ' + (tarea.get_tarea_mantenimiento?.nombre_tarea || '') + ' (' + (tarea.get_tarea_mantenimiento?.get_zona_tarea?.nombre_zona || '') + ')',
                    tarea.get_accion_tarea?.nombre_accion || '',
                    tarea.get_zona?.nombre_zona || '',
                    tarea.get_maquinaria?.alias_maquinaria || '',
                    tarea.hecho ? 'SI' : 'NO'
                ]);
                j++;
            });
            tabla.draw();
            tabla.columns.adjust();
        }
    });
}