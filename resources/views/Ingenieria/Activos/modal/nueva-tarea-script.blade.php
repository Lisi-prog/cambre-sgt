<script>
    function mostrarNuevaTarea(id){
        $(`#${id}`).toggleClass("d-none");
    }

    function guardarNuevaTarea(boton){
        const formulario = $(boton).closest(".nueva-tarea-form, .card");
        const nombre = formulario.find("input[name^=nombre_tarea_nueva]");
        if ($(boton).prop('disabled')) return;
        $(boton).prop('disabled', true);
        $.ajax({
            url: '{{ route('tarea_mantenimiento.store') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),

                nombre_tarea: nombre.val(),
            },
            success:function(response){
                const tablas = {
                    '#tabla_set_tareas_mantenimiento': 'correctiva',
                    '#tabla_set_tareas_mantenimiento_preventivas': $('#editarTareasMantenimientoPreventivaModal').length
                        ? 'preventiva_activo' : 'preventiva_tipo'
                };
                Object.entries(tablas).forEach(([selector, tipo]) => {
                    if (!$(selector).length) return;
                    const fila = $(response.filas[tipo]);
                    if ($.fn.dataTable.isDataTable(selector)) {
                        $(selector).DataTable().row.add(fila[0]).draw(false);
                    } else {
                        $(selector).find('tbody').append(fila);
                    }
                });
                nombre.val('');
                formulario.addClass('d-none');
            },
            error:function(xhr){
                const errores = xhr.responseJSON && xhr.responseJSON.errors;
                alert(errores && errores.nombre_tarea
                    ? errores.nombre_tarea.join('\n') : 'Error al crear la tarea');
            },
            complete:function(){
                $(boton).prop('disabled', false);
            }
        });

    }
</script>
