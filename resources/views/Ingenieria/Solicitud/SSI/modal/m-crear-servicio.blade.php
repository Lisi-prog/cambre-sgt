<!-- Modal -->
<div class="modal fade" id="crearServicioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Servicio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => ['solicitud.aceptar', $Ssi->getSolicitud->id_solicitud, 1], 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('prefijo_proyecto', 'Prefijo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::select('prefijo_proyecto', $prefijos, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'prefijo_proyecto'
                                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('codigo_proyecto', 'Codigo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('codigo_proyecto', null, [
                                'class' => 'form-control',
                                'style' => 'text-transform:uppercase',
                                'required' => 'required',
                                'id' => 'codigo_proyecto'
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        <div class="form-group">
                            {!! Form::label('nombre', "Nombre proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nombre_proyecto', $Ssi->titulo_propuesta, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('id_tipo_proyecto', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('id_tipo_proyecto', $Tipos_servicios, 5, [
                                'class' => 'form-select form-control',
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
                                    'class' => 'form-select form-control',
                                    'id' => 'lider'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('id_activo', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                {!! Form::select('id_activo', $activos, $Ssi->id_activo, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-control',
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
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('fec_req', 'Fecha requerida:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::date('fecha_req', \Carbon\Carbon::parse($Ssi->getSolicitud->fecha_requerida)->format('Y-m-d'), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fec_req',
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row" id="eta_act_td_dv">
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <div class="form-group">
                            {!! Form::label('opt', 'Opciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="flexRadioEtp" name="op_act_se_eta" checked>
                                <label class="form-check-label" for="flexRadioEtp">
                                    Crear Servicio y etapa con estado "En proceso".
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sin-pri" name="sin-pri">
                                <label class="form-check-label" for="sin-pri">
                                    Sin prioridad.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Aceptar y crear servicio</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Solicitud/buscar-prefijo.js') }}"></script>