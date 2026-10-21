// El modal se comparte entre la gestión, la hoja de ruta y la lista de órdenes.
$(function () {
    let contexto, secuencia = 0, editable = false, solicitud = 0;
    const escapar = valor => $('<div>').text(valor ?? '').html().replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    const tabla = () => typeof getTablaAjustes === 'function' ? getTablaAjustes() : $('#tabla_ajustes').DataTable();
    const general = () => {
        if ($.fn.DataTable.isDataTable('#tabla_tareas_generales')) return $('#tabla_tareas_generales').DataTable();
        return $('#tabla_tareas_generales').DataTable({
            autoWidth: false,
            columnDefs: [
                { className: 'text-start', targets: [0] },
                { className: 'text-center', targets: [1, 2] }
            ],
            language: tabla().init().language,
            aaSorting: []
        });
    };
    const descripcionTarea = tarea => [tarea?.nombre_tarea, tarea?.get_ejecucion?.nombre_ejecucion, tarea?.get_zona_tarea?.nombre_zona].filter(Boolean).join(' - ');
    const opciones = (items, valor, nombre) => '<option value="">Seleccionar...</option>' + items.map(item => `<option value="${escapar(valor(item))}">${escapar(nombre(item))}</option>`).join('');
    const campos = prefijo => `<input type="checkbox" class="form-check-input ajuste-tarea-hecha" aria-label="Tarea hecha" name="${prefijo}[hecho]" onchange="checkCompletoAjuste()">`;
    const quitar = '<button type="button" class="btn btn-danger ml-2 quitar-tarea">X</button>';

    function elemento(tarea = {}) {
        const j = secuencia++, prefijo = `tareas[${j}]`;
        const zonas = [...new Map(contexto.elementos.map(e => [e.id_zona_tarea, e])).values()];
        const fila = tabla().row.add([
            `<select required class="form-select zona-tarea" aria-label="Zona tarea">${opciones(zonas, e => e.id_zona_tarea, e => e.nombre_zona)}</select>`,
            `<select required class="form-select elemento-tarea" aria-label="Elemento" name="${prefijo}[tarea_mant]"></select>`,
            `<select required class="form-select" id="accion_${j}" name="${prefijo}[accion]" onchange="showSpanAviso()"><option value="">Seleccionar...</option>${$('#accion_select_div').html()}</select>`,
            `<input maxlength="100" class="form-control" name="${prefijo}[observaciones]" value="${escapar(tarea.observaciones)}">`,
            campos(prefijo) + quitar
        ]).draw().node();
        $(fila).find('.zona-tarea').on('change', function () {
            $(fila).find('.elemento-tarea').html(opciones(contexto.elementos.filter(e => e.id_zona_tarea == this.value), e => `${e.id_zona}-${e.id_zona_tarea}`, e => e.elemento));
        }).val(tarea.id_zona_tarea ?? '').trigger('change');
        $(fila).find('.elemento-tarea').val(tarea.id_zona ? `${tarea.id_zona}-${tarea.id_zona_tarea}` : '');
        $(fila).find('[name$="[accion]"]').val(tarea.id_accion_tarea ?? '');
        $(fila).find(':checkbox').prop('checked', !!tarea.hecho);
    }

    function tareaGeneral(tarea = {}, obligatoria = false) {
        const prefijo = `generales[${secuencia++}]`;
        const nombre = descripcionTarea(tarea.get_tarea_mantenimiento ?? tarea);
        const fila = $('<tr>');
        $('<td>').html(obligatoria
            ? `${escapar(nombre)} <span class="badge bg-info ml-auto">Preventiva obligatoria</span><input type="hidden" name="${prefijo}[tarea_mant]" value="${escapar(tarea.id_tarea_mantenimiento)}">`
            : `<select required class="form-select" aria-label="Tarea, ejecución y zona" name="${prefijo}[tarea_mant]">${opciones(contexto.generales, t => t.id_tarea_mantenimiento, descripcionTarea)}</select>`).appendTo(fila);
        if (!obligatoria) fila.find('select').val(tarea.id_tarea_mantenimiento ?? '');
        $('<td>').html(`<input maxlength="100" class="form-control" name="${prefijo}[observaciones]" value="${escapar(tarea.observaciones)}">`).appendTo(fila);
        $('<td>').html(campos(prefijo) + (obligatoria ? '' : quitar)).appendTo(fila);
        fila.find(':checkbox').prop('checked', !!tarea.hecho);
        general().row.add(fila[0]).draw();
    }

    function mostrar(tareas) {
        tabla().clear().draw(); general().clear().draw(); secuencia = 0;
        tareas.forEach(tarea => {
            if (tarea.id_tarea_mantenimiento || tarea.nombre_tarea) {
                if (editable) tareaGeneral(tarea, contexto.preventivas.some(p => p.id_tarea_mantenimiento == tarea.id_tarea_mantenimiento));
                else general().row.add([escapar(descripcionTarea(tarea.get_tarea_mantenimiento ?? tarea)), escapar(tarea.observaciones), tarea.hecho ? 'SI' : 'NO']);
            } else if (editable) elemento(tarea);
            else tabla().row.add([escapar(tarea.get_zona_tarea?.nombre_zona), escapar(tarea.get_zona?.nombre_zona), escapar(tarea.get_accion_tarea?.nombre_accion), escapar(tarea.observaciones), tarea.hecho ? 'SI' : 'NO']);
        });
        if (editable) contexto.preventivas.forEach(p => {
            if (!tareas.some(t => t.id_tarea_mantenimiento == p.id_tarea_mantenimiento)) tareaGeneral({...p, get_tarea_mantenimiento: p}, true);
        });
        tabla().draw();
        general().draw();
        checkCompletoAjuste(); showSpanAviso();
    }

    async function abrir(idOrden, idEtapa, nombre, proyecto, modo, url) {
        const turno = ++solicitud;
        editable = modo === 'editar';
        $('#modalNuevoParteAjuste').modal('show');
        $('#id_orden_ajuste').val(idOrden);
        $('#nombreActivoAjuste').text(nombre || $('#activo').val() || '');
        $('#nombre_proyecto_ajuste').val(proyecto || $('#nombre_proyecto_i').val());
        $('#btnGuardarNuevoParteAjuste').toggle(editable).prop('disabled', true);
        $('#btnRowNuevoAjuste, #btnRowTareaGeneral').hide();
        $('#previewAceptarAjusteReview').toggle(modo === 'revisar');
        $('#horas_ajuste, #minutos_ajuste, #fecha_ajuste').prop('disabled', !editable);
        $('#completado_ajuste').prop('disabled', !editable).prop('checked', false);
        tabla().clear().draw(); general().clear().draw();
        try {
            const parte = url ? await $.getJSON(url) : null;
            if (turno !== solicitud) return;
            if (parte?.get_parte) $('#id_orden_ajuste').val(parte.get_parte.id_orden);
            if (editable) {
                contexto = await $.getJSON('/get-pre-acciones-ajuste/' + idEtapa);
                if (turno !== solicitud) return;
            }
            mostrar(parte?.get_tareas_ajuste || []);
            $('#fecha_ajuste').val(editable ? `${new Date().getFullYear()}-${String(new Date().getMonth() + 1).padStart(2, '0')}-${String(new Date().getDate()).padStart(2, '0')}` : parte?.get_parte?.fecha);
            const tiempo = editable ? ['00', '00'] : (parte?.get_parte?.horas || '00:00').split(':');
            $('#horas_ajuste').val(tiempo[0]); $('#minutos_ajuste').val(tiempo[1]);
            $('#btnGuardarNuevoParteAjuste').prop('disabled', false);
            $('#btnRowNuevoAjuste, #btnRowTareaGeneral').toggle(editable);
            const refabricar = (parte?.get_tareas_ajuste || []).some(t => t.get_accion_tarea?.nombre_accion?.toUpperCase() === 'REFABRICAR');
            const mecanizado = $.fn.DataTable.isDataTable('#tablaOrdenMec') && $('#tablaOrdenMec').DataTable().rows().data().toArray().some(r => r[3] && r[3] !== '____-__-__');
            $('#mensaje_refabricar').toggle(refabricar && !mecanizado);
            $('#btnAceptarAjusteReview').prop('disabled', refabricar && !mecanizado);
        } catch (error) {
            $('#btnAceptarAjusteReview').prop('disabled', true);
            general().clear().row.add(['<span class="text-danger">No se pudo cargar el parte. Cierre el modal e intente nuevamente.</span>', '', '']).draw();
        }
    }

    window.procesarAjuste = accion => {
        $('#btnAceptarAjusteReview').prop('disabled', true);
        $.ajax({
            type: 'POST', url: '/procesar-parte-ajuste',
            data: {id_orden_mantenimiento: $('#id_orden_ajuste').val(), accion,
                nombre_proyecto: $('#nombre_proyecto_ajuste').val()},
            success: () => location.reload(),
            error: () => { $('#btnAceptarAjusteReview').prop('disabled', false); alert('No se pudo procesar el parte. Intente nuevamente.'); }
        });
    };
    window.openModalNuevoParteAjuste = (orden, etapa, nombre, proyecto) => abrir(orden, etapa, nombre, proyecto, 'editar');
    window.openModalParteAjustePendiente = (orden, etapa, nombre, proyecto) => abrir(orden, etapa, nombre, proyecto, 'editar', '/get-parte-ajuste/' + orden);
    window.openModalVerParteAjuste = (orden, nombre) => abrir(orden, null, nombre, null, 'ver', '/get-parte-ajuste-completado/' + orden);
    window.openModalConfirmarParteAjuste = orden => abrir(orden, null, null, null, 'revisar', '/get-parte-ajuste/' + orden);
    window.verParteDeAjuste = (parte, estado) => abrir(null, null, null, null, 'ver', '/get-parte-ajuste-porcion/' + parte);
    window.agregarNuevoAjusteRow = () => { elemento(); checkCompletoAjuste(); };
    window.agregarTareaGeneral = () => { tareaGeneral(); checkCompletoAjuste(); };
    window.showSpanAviso = () => {
        const acciones = tabla().rows().nodes().to$().find('select[name$="[accion]"] option:selected');
        $('#span_aviso_mecanizado').toggle(acciones.toArray().some(a => a.textContent.trim().toUpperCase() === 'REFABRICAR'));
    };
    window.checkCompletoAjuste = () => {
        if (!editable) return;
        const checks = tabla().rows().nodes().to$().find('input[name$="[hecho]"]').add(general().rows().nodes().to$().find('input[name$="[hecho]"]'));
        $('#completado_ajuste').prop('checked', checks.length > 0 && checks.toArray().every(c => c.checked));
    };
    $('#form_ajuste_alta').on('click', '.quitar-tarea', function () {
        const fila = $(this).closest('tr');
        if (fila.closest('table').is('#tabla_ajustes')) tabla().row(fila).remove().draw();
        else general().row(fila).remove().draw();
        checkCompletoAjuste(); showSpanAviso();
    });
    $('#form_ajuste_alta').on('submit', function () {
        $(this).find('.mantenimiento-paginado').remove();
        tabla().rows().nodes().to$().add(general().rows().nodes().to$()).find('input, select').each(function () {
            if (!this.name || this.disabled || (this.type === 'checkbox' && !this.checked) || $.contains(document.getElementById('form_ajuste_alta'), this)) return;
            $('<input>', {type: 'hidden', name: this.name, value: $(this).val(), class: 'mantenimiento-paginado'}).appendTo('#form_ajuste_alta');
        });
    });
});
