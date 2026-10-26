<!-- Modal -->
<div class="modal fade" id="editarProyectoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Proyecto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('proyectos.update', $proyecto->id_servicio) }}" method="POST">
                @csrf
                @method('PUT')

            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="form-group">
                            <label for="codigo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Codigo proyecto:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="codigo_proyecto" id="codigo_proyecto" value="{{ old('codigo_proyecto', $proyecto->codigo_servicio) }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <label for="id_tipo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Tipo:</label>
                            <span class="obligatorio">*</span>
                            <select name="id_tipo_proyecto" id="id_tipo_proyecto" class="form-select" required>
                                    <option value="" {{ old('id_tipo_proyecto', $proyecto->getSubTipoServicio->id_subtipo_servicio) === null || old('id_tipo_proyecto', $proyecto->getSubTipoServicio->id_subtipo_servicio) === '' ? 'selected' : '' }}>Seleccionar</option>
                                    @foreach ($Tipos_servicios as $id => $nombre)
                                        <option value="{{ $id }}" {{ (string) old('id_tipo_proyecto', $proyecto->getSubTipoServicio->id_subtipo_servicio) === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="nombre_proyecto" class="control-label" style="white-space: nowrap;">Nombre proyecto:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="{{ old('nombre_proyecto', $proyecto->nombre_servicio) }}" class="form-control" required>
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="lider" class="control-label fs-7" style="white-space: nowrap;">Lider:</label>
                                <span class="obligatorio">*</span>
                                <select name="lider" id="lider" class="form-select" required>
                                    <option value="" {{ old('lider', $proyecto->getResponsabilidad->getEmpleado->id_empleado) === null || old('lider', $proyecto->getResponsabilidad->getEmpleado->id_empleado) === '' ? 'selected' : '' }}>Seleccionar</option>
                                    @foreach ($supervisores as $id => $nombre)
                                        <option value="{{ $id }}" {{ (string) old('lider', $proyecto->getResponsabilidad->getEmpleado->id_empleado) === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label for="fecha_inicio" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
                                        <span class="obligatorio">*</span>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $proyecto->fecha_inicio ? \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('Y-m-d') : '') }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="editar_id_servicio_padre" class="control-label fs-7">Proyecto padre (opcional):</label>
                            @php($tieneProyectosHijos = $proyecto->serviciosHijos()->exists())
                            <select name="id_servicio_padre" id="editar_id_servicio_padre" class="form-select" style="width: 100%" @if($tieneProyectosHijos) disabled @endif>
                                <option value=""></option>
                                @if ($proyecto->id_servicio_padre && $proyecto->servicioPadre)
                                    <option value="{{ $proyecto->servicioPadre->id_servicio }}" selected>
                                        {{ $proyecto->servicioPadre->codigo_servicio }} - {{ $proyecto->servicioPadre->nombre_servicio }}
                                    </option>
                                @endif
                            </select>
                            @if ($tieneProyectosHijos)
                                <small class="form-text text-muted d-block">Este proyecto tiene hijos y no puede vincularse a un proyecto padre.</small>
                            @else
                                <small class="form-text text-muted d-block">Solo se buscan proyectos que no son hijos de otro.</small>
                            @endif
                            @error('id_servicio_padre')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Seleccione otro proyecto para cambiarlo o use la × para quitar el vínculo.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<style>
    #editarProyectoModal .select2-selection--single {
        position: relative;
    }

    #editarProyectoModal .select2-selection__rendered {
        padding-right: 55px;
    }

    #editarProyectoModal .select2-selection__clear {
        position: absolute;
        top: 50%;
        right: 30px;
        z-index: 2;
        margin: 0;
        transform: translateY(-50%);
    }

    #editarProyectoModal .select2-selection__arrow {
        right: 0;
    }
</style>

<script>
    window.addEventListener('load', function () {
        const $modalEditarProyecto = $('#editarProyectoModal');
        const $servicioPadre = $('#editar_id_servicio_padre');

        $modalEditarProyecto.on('shown.bs.modal', function () {
            if (!$servicioPadre.hasClass('select2-hidden-accessible')) {
                $servicioPadre.select2({
                    width: '100%',
                    dropdownParent: $modalEditarProyecto,
                    placeholder: 'Sin proyecto padre',
                    allowClear: true,
                    minimumInputLength: 2,
                    ajax: {
                        url: '{{ route('proyectos.buscar-servicios-padre') }}',
                        dataType: 'json',
                        delay: 300,
                        data: function (params) {
                            return {
                                q: params.term,
                                excluir_id: {{ $proyecto->id_servicio }}
                            };
                        },
                        processResults: function (data) {
                            return data;
                        },
                        cache: true
                    },
                    language: {
                        inputTooShort: function () { return 'Ingrese al menos 2 caracteres'; },
                        searching: function () { return 'Buscando...'; },
                        noResults: function () { return 'No se encontraron proyectos'; },
                        errorLoading: function () { return 'No se pudieron cargar los proyectos'; }
                    }
                });

                $servicioPadre.on('select2:open', function () {
                    setTimeout(function () {
                        document.querySelector('.select2-container--open .select2-search__field').focus();
                    }, 0);
                });
            }
        });
    });
</script>
