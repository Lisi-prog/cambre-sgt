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
                columnDefs: [{ visible: false, targets: [3] }, { className: "text-center", targets: [0, 1, 2, 3] }],
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
    agregarFilaDiagnostico(getTablaDiagnosticos());
}

function eliminarDiagnostico(indice) {
    const tabla = getTablaDiagnosticos();
    tabla.row('#diagnostico_' + indice).remove().draw(false);
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
    cargarSintomasDiagnostico(id_orden);
    cargarCatalogoDiagnostico(id_orden, getTablaDiagnosticos());
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
    cargarSintomasDiagnostico(id_orden);
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
                diagnostico.get_diagnosticos.forEach(parte => {
                    tabla.row.add([
                        index,
                        textoDiagnostico(parte.get_categoria.nombre_diagnostico_categoria),
                        textoDiagnostico(parte.nombre_diagnostico),
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
                diagnostico.get_diagnosticos.forEach(parte => {
                    tabla.row.add([
                        index + 1,
                        textoDiagnostico(parte.get_categoria.nombre_diagnostico_categoria),
                        textoDiagnostico(parte.nombre_diagnostico),
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
    enviarParteDiagnostico(getTablaDiagnosticos());
}


/* ==========================================================================
   SECCIÓN INSPECCIÓN
   ========================================================================== */
function prepararModalInspeccion(id_orden, nombre_activo, proyecto, consulta) {
    const activo = nombre_activo || $('#activo').val() || $('#herramental_inspeccion').val();
    $('#modalNuevoParteInspeccion').modal('show');
    $('#id_orden_inspeccion').val(id_orden);
    $('#herramental_inspeccion').val(activo);
    $('#nombreActivoInspeccion').text(activo);
    $('#nombre_proyecto_inspeccion').val(proyecto || $('#nombre_proyecto_i').val());
    $('#btnGuardarNuevoParteInspeccion, #btnGuardarCompletarParteInspeccion').toggle(!consulta);
    $('#previewAceptarInspeccionReview').hide();
    $('#horas_inspeccion, #minutos_inspeccion, #fecha_inspeccion').prop('disabled', consulta);
    const hoy = new Date();
    $('#fecha_inspeccion').val(`${hoy.getFullYear()}-${String(hoy.getMonth() + 1).padStart(2, '0')}-${String(hoy.getDate()).padStart(2, '0')}`);
    $('#horas_inspeccion, #minutos_inspeccion').val('00');
    getTablaInspecciones().clear().draw();
}

function addZonaHeader(nombreZona) {
    const tabla = getTablaInspecciones();
    // Conservar cuatro celdas reales para que DataTables pueda redibujar y paginar.
    const zona = tabla.row.add([nombreZona, '', '', '']).node();
    $(zona).addClass('text-center fw-bold text-dark').css('background-color', '#2b56843b');
    const encabezado = tabla.row.add(['Elemento', 'OK', 'NO OK', 'Acción']).node();
    $(encabezado).addClass('zona-columns text-light');
    $(encabezado).find('td').css({color: '#fff', backgroundColor: '#2b5684', fontWeight: 'bold'});
}

function agregarElementoInspeccion(tarea, indice, consulta) {
    const tabla = getTablaInspecciones();
    const tareaId = `${tarea.id_zona}-${tarea.id_zona_tarea}`;
    const respondida = tarea.ok !== null && tarea.ok !== undefined;
    const estado = respondida ? Number(tarea.ok) : 2;
    const disabled = consulta ? 'disabled' : '';
    const radio = (valor, resultado, titulo, oculto = false) => `<input ${oculto ? 'hidden' : ''} type="radio" class="form-check-input" aria-label="${titulo}" name="tareas[${indice}][ok]" value="${valor}" ${disabled} ${estado === resultado ? 'checked' : ''} onchange="checkboxTareaRealizada(${indice}, '${tareaId}')">`;
    const accion = estado === 0 ? (tarea.get_accion_para_tarea?.nombre_accion || '-') : '-';
    const accionHtml = consulta ? accion : `<div id="label_accion_${tareaId}" ${estado === 0 ? 'hidden' : ''}>${estado === 2 ? 'NO REVISA' : estado === 1 ? 'No se requiere acción' : '-'}</div>
        <select onchange="showSpanAviso()" name="tareas[${indice}][accion]" class="form-select" id="accion_${tareaId}" hidden disabled>
            <option value="">Seleccionar...</option>${$('#accion_select_div').html()}
        </select>`;
    const fila = tabla.row.add([
        (consulta && estado === 2 ? '<span class="badge bg-secondary mr-2 me-2">Sin revisar</span>' : '') +
            (tarea.get_zona?.nombre_zona || tarea.elemento || tarea.nombre_tarea),
        radio('ok', 1, 'OK') + radio('no_revisa', 2, 'NO REVISA', true) + (consulta ? '' : `<input type="hidden" name="tareas[${indice}][id]" value="${tareaId}">`),
        radio('not_ok', 0, 'NO OK'),
        accionHtml
    ]).node();
    if (!consulta && estado === 0) {
        $(fila).find('select').val(tarea.id_accion_tarea ?? tarea.id_accion);
    }
}

function cargarElementosInspeccion(tareas, consulta) {
    const tabla = getTablaInspecciones();
    tabla.clear();
    const ordenadas = [...tareas].sort((a, b) =>
        (a.get_zona_tarea?.nombre_zona || a.nombre_zona || '').localeCompare(b.get_zona_tarea?.nombre_zona || b.nombre_zona || '', 'es')
    );
    let zonaActual = null;
    ordenadas.forEach((tarea, indice) => {
        const zona = tarea.get_zona_tarea?.nombre_zona || tarea.nombre_zona || 'Sin Zona';
        if (zona !== zonaActual) {
            zonaActual = zona;
            addZonaHeader(zona);
        }
        agregarElementoInspeccion(tarea, indice, consulta);
    });
    tabla.draw();
    tabla.columns.adjust();
    showSpanAviso();
}

function checkboxTareaRealizada(j, idTarea) {
    const fila = getTablaInspecciones().rows().nodes().to$().find(`input[name="tareas[${j}][ok]"]:checked`);
    const resultado = fila.val();
    const select = getTablaInspecciones().rows().nodes().to$().find(`#accion_${idTarea}`);
    const label = getTablaInspecciones().rows().nodes().to$().find(`#label_accion_${idTarea}`);
    if (resultado === 'not_ok') {
        label.prop('hidden', true);
        // Acción ya no se utiliza en la carga de inspección.
        select.prop({hidden: true, disabled: true, required: false});
    } else {
        select.val('').prop({hidden: true, disabled: true, required: false});
        label.text(resultado === 'no_revisa' ? 'NO REVISA' : 'No se requiere acción').prop('hidden', false);
    }
    showSpanAviso();
}

function openModalNuevoParteInspeccion(id_activo, id_orden, nombre_activo, proyecto) {
    prepararModalInspeccion(id_orden, nombre_activo, proyecto, false);
    $.get('/get-tareas-por-activo/' + id_activo, data => cargarElementosInspeccion(data.tareas_x_activo || [], false));
}

function openModalParteInspeccionPendiente(id_activo, id_orden, nombre_activo, proyecto) {
    prepararModalInspeccion(id_orden, nombre_activo, proyecto, false);
    $.get('/get-parte-inspeccion-pendiente/' + id_activo + '/' + id_orden, data =>
        cargarElementosInspeccion(data.tareasMantenimiento || data.tareas_x_activo || [], false)
    );
}

function mostrarDatosParteInspeccion(parte, horas) {
    if (!parte) return;
    $('#fecha_inspeccion').val(parte.fecha);
    const [hr, mn] = (horas || parte.horas || '00:00').split(':');
    $('#horas_inspeccion').val(hr);
    $('#minutos_inspeccion').val(mn);
}

function openModalVerParteInspeccion(id_orden, nombre_activo) {
    prepararModalInspeccion(id_orden, nombre_activo, null, true);
    $.get('/get-parte-inspeccion-completado/' + id_orden, partes => {
        cargarElementosInspeccion(partes.flatMap(parte => parte.elementos || []), true);
        if (partes.length) {
            mostrarDatosParteInspeccion(partes[0].get_parte, partes[0].horas);
        }
    });
}

function openModalConfirmarParteInspeccion(id_orden, nombre_activo) {
    prepararModalInspeccion(id_orden, nombre_activo, null, true);
    $.get('/get-parte-inspeccion/' + id_orden, data => {
        if (!data) return;
        cargarElementosInspeccion(data.elementos || [], true);
        mostrarDatosParteInspeccion(data.get_parte, data.horas);
        $('#previewAceptarInspeccionReview').show();
    });
}

function verParteDeInspeccion(id_parte, completado) {
    prepararModalInspeccion(null, null, null, true);
    $.get('/get-parte-inspeccion-porcion/' + id_parte, data => {
        if (!data) return;
        cargarElementosInspeccion(data.elementos || [], true);
        mostrarDatosParteInspeccion(data.get_parte);
    });
}

function procesarInspeccion(accion) {
    $.ajax({
        type: 'post', url: '/procesar-parte-inspeccion',
        data: {id_orden_mantenimiento: $('#id_orden_inspeccion').val(), accion: accion, nombre_proyecto: $('#nombre_proyecto_i').val()},
        success: function () { location.reload(); }
    });
}

// DataTables mantiene fuera del DOM las otras páginas: incluir sus respuestas al guardar.
$(document).ready(function () {
    $('#form_inspeccion_alta').on('submit', function () {
        const form = this;
        $(form).find('.inspeccion-paginada').remove();
        getTablaInspecciones().rows().nodes().to$().find('input, select').each(function () {
            if (!this.name || (this.type === 'radio' && !this.checked)) return;
            // Incluir los estados previos bloqueados para conservar una foto completa del parte.
            if (this.disabled && this.type !== 'radio') return;
            if (form.contains(this) && !this.disabled) return;
            $('<input>', {type: 'hidden', name: this.name, value: $(this).val(), class: 'inspeccion-paginada'}).appendTo(form);
        });
    });
});
