<!-- Modal -->
<div class="mcarga modal fade" id="crearProyectoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Proyecto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('proyectos.store') }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="prefijo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Prefijo proyecto:</label>
                            <select name="prefijo_proyecto" id="prefijo_proyecto" class="form-select form-control reset-input">
                                <option value="" {{ old('prefijo_proyecto') === null || old('prefijo_proyecto') === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($prefijos as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('prefijo_proyecto') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            <label for="codigo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Codigo proyecto:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="codigo_proyecto" id="codigo_proyecto" value="{{ old('codigo_proyecto') }}" class="form-control reset-input" style="text-transform:uppercase" required>
                        </div>
                    </div>
                </div>
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            <label for="nombre_proyecto" class="control-label" style="white-space: nowrap;">Nombre proyecto:</label>
                            <span class="obligatorio">*</span>
                            <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="{{ old('nombre_proyecto') }}" class="form-control reset-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            <label for="id_tipo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Tipo:</label>
                            <span class="obligatorio">*</span>
                            <select name="id_tipo_proyecto" id="id_tipo_proyecto" class="form-select reset-input" required>
                                <option value="" {{ old('id_tipo_proyecto') === null || old('id_tipo_proyecto') === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($Tipos_servicios as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('id_tipo_proyecto') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="lider" class="control-label fs-7" style="white-space: nowrap;">Lider:</label>
                                <span class="obligatorio">*</span>
                                <select name="lider" id="lider" class="form-select reset-input">
                                <option value="" {{ old('lider') === null || old('lider') === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($empleados as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('lider') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="id_activo" class="control-label fs-7" style="white-space: nowrap;">Activo:</label>
                                <select name="id_activo" id="id_activo" class="form-select reset-input">
                                <option value="" {{ old('id_activo') === null || old('id_activo') === '' ? 'selected' : '' }}>Seleccionar</option>
                                @foreach ($activos as $valor => $nombre)
                                    <option value="{{ $valor }}" {{ (string) old('id_activo') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            <label for="prioridad" class="control-label fs-7" style="white-space: nowrap;">Prioridad:</label>
                            <span class="obligatorio">*</span>

                            <input type="text" name="prioridad" id="prioridad" value="{{ old('prioridad', $prioridadMax) }}" class="form-control" readonly>


                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
                                        <span class="obligatorio">*</span>
                            <input type="date" name="fecha_ini" id="fec_ini" value="{{ old('fecha_ini', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control reset-fecha-hoy">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
                            <span class="obligatorio">*</span>
                            <input type="date" name="fecha_req" id="fec_req" value="{{ old('fecha_req', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control reset-fecha-hoy">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <fieldset class="form-group">
                            <legend class="control-label fs-7">Etapas a crear:</legend>
                            @foreach (['Investigación', 'Desarrollo', 'Manufactura', 'Puesta a Punto'] as $indice => $nombreEtapa)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="etapas[]"
                                        id="crear_proyecto_etapa_{{ $indice }}" value="{{ $nombreEtapa }}" checked>
                                    <label class="form-check-label" for="crear_proyecto_etapa_{{ $indice }}">
                                        {{ $nombreEtapa }}
                                    </label>
                                </div>
                            @endforeach
                            <small class="form-text text-muted">Se crearán únicamente las etapas seleccionadas.</small>
                        </fieldset>
                    </div>
                    @include('Ingenieria.Servicios.Proyectos.layout.opciones-crear-servicio', ['opcionesCompactas' => true])
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
                                <label for="id_servicio_padre" class="control-label fs-7">Proyecto padre:</label>
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
                </div>
            </div>

            <div class="modal-footer">
                <div class="form-check pe-3">

                  </div>
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
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
