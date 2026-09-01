<!-- Modal -->
<div class="modal fade" id="editarProyectoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Proyecto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::model($proyecto, ['method' => 'PUT', 'route' => ['proyectos.update', $proyecto->id_servicio], 'class' => '']) !!}

            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('codigo_proyecto', 'Codigo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('codigo_proyecto', $proyecto->codigo_servicio, [
                                'class' => 'form-control',
                                'required' => 'required',
                                'id' => 'codigo_proyecto'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('id_tipo_proyecto', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('id_tipo_proyecto', $Tipos_servicios, $proyecto->getSubTipoServicio->id_subtipo_servicio, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select',
                                'id' => 'id_tipo_proyecto',
                                'required'
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('nombre', "Nombre proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_proyecto', $proyecto->nombre_servicio, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('lider', 'Lider:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::select('lider', $supervisores, $proyecto->getResponsabilidad->getEmpleado->id_empleado, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select',
                                    'id' => 'lider',
                                    'required'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('fecha_inicio', 'Fecha inicio:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                            {!! Form::date('fecha_inicio', $proyecto->fecha_inicio, [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fecha_inicio',
                                'class' => 'form-control',
                                'required'
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            {!! Form::label('editar_id_servicio_padre', 'Proyecto padre (opcional):', ['class' => 'control-label fs-7']) !!}
                            <select name="id_servicio_padre" id="editar_id_servicio_padre" class="form-select" style="width: 100%">
                                <option value=""></option>
                                @if ($proyecto->id_servicio_padre && $proyecto->servicioPadre)
                                    <option value="{{ $proyecto->servicioPadre->id_servicio }}" selected>
                                        {{ $proyecto->servicioPadre->codigo_servicio }} - {{ $proyecto->servicioPadre->nombre_servicio }}
                                    </option>
                                @endif
                            </select>
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
            {!! Form::close() !!}
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
