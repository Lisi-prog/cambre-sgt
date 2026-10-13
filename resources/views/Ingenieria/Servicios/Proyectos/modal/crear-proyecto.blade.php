<!-- Modal -->
<div class="mcarga modal fade" id="crearProyectoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Proyecto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'proyectos.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('prefijo_proyecto', 'Prefijo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::select('prefijo_proyecto', $prefijos, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control reset-input',
                                            'id' => 'prefijo_proyecto'
                                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('codigo_proyecto', 'Codigo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('codigo_proyecto', null, [
                                'class' => 'form-control reset-input',
                                'style' => 'text-transform:uppercase',
                                'required' => 'required',
                                'id' => 'codigo_proyecto'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('nombre', "Nombre proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_proyecto', null, ['class' => 'form-control reset-input', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('id_tipo_proyecto', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('id_tipo_proyecto', $Tipos_servicios, null, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select reset-input',
                                'id' => 'id_tipo_proyecto',
                                'required'
                            ]) !!}
                        </div>
                    </div>
                </div>
                


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('lider', 'Lider:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::select('lider', $empleados, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select reset-input',
                                    'id' => 'lider'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('id_activo', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                {!! Form::select('id_activo', $activos, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select reset-input',
                                    'id' => 'id_activo'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('prioridad', 'Prioridad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            
                            {!! Form::text('prioridad', $prioridadMax, ['class' => 'form-control', 'readonly']) !!}

                            {{-- {!! Form::select('prioridad', $prioridades, null, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select',
                                'id' => 'prioridad',
                                'required'
                            ]) !!} --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('fec_ini', 'Fecha inicio:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                            {!! Form::date('fecha_ini', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fec_ini',
                                'class' => 'form-control reset-fecha-hoy'
                            ]) !!}
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('fec_req', 'Fecha requerida:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::date('fecha_req', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fec_req',
                                'class' => 'form-control reset-fecha-hoy'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row" id="busqServPadre">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="vincular_servicio_padre" name="vincular_servicio_padre" value="1">
                                <label class="form-check-label" for="vincular_servicio_padre">
                                    Vincular proyecto padre
                                </label>
                            </div>

                            <div id="selector_servicio_padre" class="d-none">
                                {!! Form::label('id_servicio_padre', 'Proyecto padre:', ['class' => 'control-label fs-7']) !!}
                                <select name="id_servicio_padre" id="id_servicio_padre" class="form-select reset-input" style="width: 100%" disabled>
                                    <option value=""></option>
                                </select>
                                <small class="form-text text-muted">Busque por código o nombre del proyecto.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @include('Ingenieria.Servicios.Proyectos.layout.opciones-crear-servicio')
                    {{-- <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <div class="form-group">
                            {!! Form::label('opt', 'Opciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value=1 id="siGestionar" checked name="gesti">
                                <label class="form-check-label" for="siGestionar">
                                Gestionar despues de guardar.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value=1 id="sin-pri" name="sin-pri">
                                <label class="form-check-label" for="sin-pri">
                                    Sin prioridad.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    </div> --}}
                </div>
            </div>
            
            <div class="modal-footer">
                <div class="form-check pe-3">
                    {{-- <input class="form-check-input" type="checkbox" value=1 id="siGestionar" checked name="gesti">
                    <label class="form-check-label" for="siGestionar">
                      Gestionar despues de guardar.
                    </label> --}}
                  </div>
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div> 
<script type="module" src="{{ asset('js/Ingenieria/Solicitud/buscar-prefijo.js') }}">
</script>

<style>
    #crearProyectoModal .select2-selection--single {
        position: relative;
    }

    #crearProyectoModal .select2-selection__rendered {
        padding-right: 55px;
    }

    #crearProyectoModal .select2-selection__clear {
        position: absolute;
        top: 50%;
        right: 30px;
        z-index: 2;
        margin: 0;
        transform: translateY(-50%);
    }

    #crearProyectoModal .select2-selection__arrow {
        right: 0;
    }
</style>

<script>
    window.addEventListener('load', function () {
        const $modalProyecto = $('#crearProyectoModal');
        const $confirmarVinculo = $('#vincular_servicio_padre');
        const $contenedorServicioPadre = $('#selector_servicio_padre');
        const $servicioPadre = $('#id_servicio_padre');

        $confirmarVinculo.on('change', function () {
            const vincular = this.checked;

            $contenedorServicioPadre.toggleClass('d-none', !vincular);
            $servicioPadre.prop('disabled', !vincular);
            $servicioPadre.prop('required', vincular);

            if (!vincular) {
                $servicioPadre.val(null).trigger('change');
            }
        });

        $modalProyecto.on('shown.bs.modal', function () {
            if (!$servicioPadre.hasClass('select2-hidden-accessible')) {
                $servicioPadre.select2({
                    width: '100%',
                    dropdownParent: $modalProyecto,
                    placeholder: 'Escriba al menos 2 caracteres',
                    allowClear: true,
                    minimumInputLength: 2,
                    ajax: {
                        url: '{{ route('proyectos.buscar-servicios-padre') }}',
                        dataType: 'json',
                        delay: 300,
                        data: function (params) {
                            return { q: params.term };
                        },
                        processResults: function (data) {
                            return data;
                        },
                        cache: true
                    },
                    language: {
                        inputTooShort: function () { return 'Ingrese al menos 2 caracteres'; },
                        searching: function () { return 'Buscando...'; },
                        noResults: function () { return 'No se encontraron servicios'; },
                        errorLoading: function () { return 'No se pudieron cargar los servicios'; }
                    }
                });

                $servicioPadre.on('select2:open', function () {
                    setTimeout(function () {
                        document.querySelector('.select2-container--open .select2-search__field').focus();
                    }, 0);
                });
            }
        });

        $modalProyecto.on('hidden.bs.modal', function () {
            if ($servicioPadre.hasClass('select2-hidden-accessible')) {
                $servicioPadre.val(null).trigger('change');
            }

            $confirmarVinculo.prop('checked', false);
            $servicioPadre.prop({ disabled: true, required: false });
            $contenedorServicioPadre.addClass('d-none');
        });
    });
</script>
