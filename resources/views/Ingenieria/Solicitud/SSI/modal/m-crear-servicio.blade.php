<!-- Modal -->
<div class="modal fade" id="crearServicioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Servicio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="det-tab" data-bs-toggle="tab" data-bs-target="#serv-ing" type="button" role="tab" onclick="">Servicio de Ingenieria</button>
                    </li>
                    @if ($Ssi->getActivo)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="det_adju_tab" data-bs-toggle="tab" data-bs-target="#serv-mant" type="button" role="tab" onclick="">Servicio de Mantenimiento</button>
                        </li>
                    @endif
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="serv-ing" role="tabpanel">
                        {!! Form::open(['route' => ['solicitud.aceptar', $Ssi->getSolicitud->id_solicitud, 1], 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits', 'id' => 'form-serv-ing']) !!}
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
                                        {!! Form::label('lider', 'Lider:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('lider', $empleados, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'lider'
                                        ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('id_activo', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::select('id_activo', $activos, $Ssi->id_activo, [
                                        'placeholder' => 'Seleccionar',
                                        'class' => 'form-select form-control',
                                        'id' => 'id_activo'
                                    ]) !!}
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
                            @include('Ingenieria.Servicios.Proyectos.layout.opciones-crear-servicio')
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @if ($Ssi->getActivo)
                    <div class="tab-pane fade show" id="serv-mant" role="tabpanel">
                        {!! Form::open(['method' => 'GET', 'route' => ['sma.aceptar', $Ssi->id_solicitud], 'style' => '', 'id' => 'form-serv-mant']) !!}
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('codigo_proyecto', 'Codigo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('codigo_proyecto', $Ssi->getNombreServicioMan() ?? null, [
                                        'class' => 'form-control',
                                        'style' => 'text-transform:uppercase',
                                        'id' => 'codigo_serv_mant',
                                        'disabled'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <div class="form-group">
                                    {!! Form::label('nombre_proyecto', "Nombre proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nombre_proyecto', $Ssi->getNombreServicioMan() ?? null, [
                                        'class' => 'form-control',
                                        'style' => 'text-transform:uppercase',
                                        'id' => 'nombre_serv_mant',
                                        'disabled'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('lider', 'Lider:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('lider', $empleados, Auth::user()->getEmpleado->id_empleado, [
                                        'placeholder' => 'Seleccionar',
                                        'class' => 'form-select form-control',
                                        'id' => 'lider_serv_mant'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('activo_proyecto', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('activo_proyecto', $Ssi->getActivo ? $Ssi->getActivo->nombre_activo : null, [
                                            'class' => 'form-control',
                                            'style' => 'text-transform:uppercase',
                                            'id' => 'activo_serv_mant',
                                            'disabled'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('tipo_proyecto', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('tipo_proyecto', 'Servicio de Mantenimiento', [
                                        'class' => 'form-control',
                                        'style' => 'text-transform:uppercase',
                                        'id' => 'tipo_proy_serv_mant',
                                        'disabled'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
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
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
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
                        @if ($Ssi->getActivo->getTotalTareasMantenimientoPreventivaPendientes() > 0)
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                {!! Form::label('tar_prev', 'Tareas Preventivas Pendientes:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                <table class="table table-striped mt-2 table-sm" id="example">
                                    <thead>
                                        <th class='text-center' style="color:#fff;">Asignar</th>
                                        <th class='text-center' style="color:#fff;">Tarea</th>
                                        <th class='text-center' style="color:#fff;">Ejecucion</th>
                                        <th class='text-center' style="color:#fff;">Zona</th>
                                        <th class='text-center' style="color:#fff;">Ult. Ejecucion</th>
                                        <th class='text-center' style="color:#fff;">Situacion</th>
                                    </thead>
                                    <tbody id="tareas-prev">
                                        {{-- Tareas por activo --}}
                                        @foreach ($Ssi->getActivo->getTareasMantenimientoPreventivaPendientes as $ta)
                                            <tr onclick="toggleCheck('activo_{{$ta->id_tarea_prev_x_activo}}')">
                                                <td class="text-center">
                                                    @if ($ta->estaEnProceso())
                                                        -
                                                    @else
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                id="chkTareaPrendactivo_{{$ta->id_tarea_prev_x_activo}}"
                                                                value="activo_{{$ta->id_tarea_prev_x_activo}}"
                                                                name="tareas_prev[]">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{$ta->getTareaMantenimiento->nombre_tarea}}</td>
                                                <td>{{$ta->getTareaMantenimiento->getEjecucion->nombre_ejecucion}}</td>
                                                <td>{{$ta->getTareaMantenimiento->getZonaTarea->nombre_zona}}</td>
                                                <td>{{$ta->fecha_ultima_ejecucion}}</td>
                                                <td>{{$ta->estaEnProceso() ? 'En Proceso' : 'Disponible'}}</td>
                                            </tr>
                                        @endforeach

                                        {{-- Tareas por tipo de activo --}}
                                        @foreach ($Ssi->getActivo->getTareasMantenimientoPreventivaPendientesTipo as $ta)
                                            <tr onclick="toggleCheck('tipo_activo_{{$ta->id_tarea_prev_x_tipo_activo}}')">
                                                <td class="text-center">
                                                    @if ($ta->estaEnProceso())
                                                        -
                                                    @else
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                id="chkTareaPrendtipo_activo_{{$ta->id_tarea_prev_x_tipo_activo}}"
                                                                value="tipo_activo_{{$ta->id_tarea_prev_x_tipo_activo}}"
                                                                name="tareas_prev[]">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{$ta->getTareaMantenimiento->nombre_tarea}}</td>
                                                <td>{{$ta->getTareaMantenimiento->getEjecucion->nombre_ejecucion}}</td>
                                                <td>{{$ta->getTareaMantenimiento->getZonaTarea->nombre_zona}}</td>
                                                <td>{{$ta->fecha_ultima_ejecucion}}</td>
                                                <td>{{$ta->estaEnProceso() ? 'En Proceso' : 'Disponible'}}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        {!! Form::close() !!}
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits" id="btn-guardar">Aceptar y crear servicio</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Solicitud/buscar-prefijo.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Solicitud/buscar-prefijo.js')) }}"></script>
<script src="{{ asset('js/Ingenieria/Solicitud/m-crear-servicio-ssi-man.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Solicitud/m-crear-servicio-ssi-man.js')) }}"></script>