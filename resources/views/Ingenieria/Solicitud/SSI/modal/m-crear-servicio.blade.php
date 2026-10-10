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
                        <form action="{{route('solicitud.aceptar', [$Ssi->getSolicitud->id_solicitud, 1])}}" method="POST" class="formulario form-prevent-multiple-submits" id="form-serv-ing">
                        @csrf
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="prefijo_proyecto" class="control-label fs-7" style="white-space: nowrap; ">Prefijo proyecto:</label>

                                        <select class="form-select form-control" id="prefijo_proyecto" name="prefijo_proyecto">
                                            <option selected="selected" value="">Seleccionar</option>
                                            @foreach ($prefijos as $id => $nombre)
                                                <option value="{{ $id }}">
                                                    {{ $nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <label for="codigo_proyecto" class="control-label fs-7" style="white-space: nowrap; ">Codigo proyecto:</label>
                                        <input class="form-control" style="text-transform:uppercase" required id="codigo_proyecto" name="codigo_proyecto" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <label for="nombre" class="control-label" style="white-space: nowrap; ">Nombre proyecto:</label>
                                        <span class="obligatorio">*</span>
                                        <input class="form-control" name="nombre_proyecto" type="text" value="{{$Ssi->titulo_propuesta}}">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="id_tipo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Tipo:</label>
                                        <span class="obligatorio">*</span>
                                        <select name="id_tipo_proyecto" id="id_tipo_proyecto" class="form-select form-control" required>
                                            @foreach ($Tipos_servicios as $id => $nombre)
                                                <option value="{{ $id }}" {{ (string) old('id_tipo_proyecto', 5) === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                    <div class="form-group">
                                            <label for="lider" class="control-label fs-7" style="white-space: nowrap;">Lider:</label>
                                            <span class="obligatorio">*</span>
                                            <select name="lider" id="lider" class="form-select form-control">
                                                <option value="" {{ old('lider', null) == null ? 'selected' : '' }}>Seleccionar</option>
                                                @foreach ($empleados as $id => $nombre)
                                                    <option value="{{ $id }}" {{ (string) old('lider', null) === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                    <div class="form-group">
                                        <label for="id_activo" class="control-label fs-7" style="white-space: nowrap;">Activo:</label>
                                        <select name="id_activo" id="id_activo" class="form-select form-control">
                                            <option value="" {{ old('id_activo', $Ssi->id_activo) == null ? 'selected' : '' }}>Seleccionar</option>
                                            @foreach ($activos as $id => $nombre)
                                                <option value="{{ $id }}" {{ (string) old('id_activo', $Ssi->id_activo) === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="prioridad" class="control-label fs-7" style="white-space: nowrap;">Prioridad:</label>
                                        <span class="obligatorio">*</span>

                                        <input type="text" name="prioridad" id="prioridad" class="form-control" readonly value="{{ old('prioridad', $prioridadMax) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
                                                    <span class="obligatorio">*</span>
                                        <input type="date" name="fecha_ini" id="fec_ini" class="form-control" min="2023-01-01" max="{{ \Carbon\Carbon::now()->year . '-12' }}" value="{{ old('fecha_ini', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
                                        <span class="obligatorio">*</span>
                                        <input type="date" name="fecha_req" id="fec_req" class="form-control" min="2023-01-01" max="{{ \Carbon\Carbon::now()->year . '-12' }}" value="{{ old('fecha_req', \Carbon\Carbon::parse($Ssi->getSolicitud->fecha_requerida)->format('Y-m-d')) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="eta_act_td_dv">
                                @include('Ingenieria.Servicios.Proyectos.layout.opciones-crear-servicio')
                            </div>
                        </form>
                    </div>
                    @if ($Ssi->getActivo)
                    <div class="tab-pane fade" id="serv-mant" role="tabpanel">
                        <form action="{{ route('sma.aceptar', $Ssi->id_solicitud) }}" method="GET" style="" id="form-serv-mant">
                        @csrf
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="codigo_serv_mant" class="control-label fs-7" style="white-space: nowrap; ">Codigo proyecto:</label>
                                    <input type="text" name="codigo_proyecto" id="codigo_serv_mant" class="form-control" style="text-transform:uppercase" disabled value="{{ old('codigo_proyecto', $Ssi->getNombreServicioMan() ?? null) }}">
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <div class="form-group">
                                    <label for="nombre_serv_mant" class="control-label" style="white-space: nowrap; ">Nombre proyecto:</label>
                                    <input type="text" name="nombre_proyecto" id="nombre_serv_mant" class="form-control" style="text-transform:uppercase" disabled value="{{ old('nombre_proyecto', $Ssi->getNombreServicioMan() ?? null) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="lider_serv_mant" class="control-label fs-7" style="white-space: nowrap;">Lider:</label>
                                    <span class="obligatorio">*</span>
                                    <select name="lider" id="lider_serv_mant" class="form-select form-control">
                                        <option value="" {{ old('lider', Auth::user()->getEmpleado->id_empleado) == null ? 'selected' : '' }}>Seleccionar</option>
                                        @foreach ($empleados as $id => $nombre)
                                            <option value="{{ $id }}" {{ (string) old('lider', Auth::user()->getEmpleado->id_empleado) === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="activo_serv_mant" class="control-label fs-7" style="white-space: nowrap;">Activo:</label>
                                    <input type="text" name="activo_proyecto" id="activo_serv_mant" class="form-control" style="text-transform:uppercase" disabled value="{{ old('activo_proyecto', $Ssi->getActivo ? $Ssi->getActivo->nombre_activo : null) }}">
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group">
                                    <label for="tipo_proy_serv_mant" class="control-label fs-7" style="white-space: nowrap;">Tipo:</label>
                                    <input type="text" name="tipo_proyecto" id="tipo_proy_serv_mant" class="form-control" style="text-transform:uppercase" disabled value="{{ old('tipo_proyecto', 'Servicio de Mantenimiento') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
                                    <span class="obligatorio">*</span>
                                    <input type="date" name="fecha_ini" id="fec_ini" class="form-control" min="2023-01-01" max="{{ \Carbon\Carbon::now()->year . '-12' }}" value="{{ old('fecha_ini', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
                                    <span class="obligatorio">*</span>
                                    <input type="date" name="fecha_req" id="fec_req" class="form-control" min="2023-01-01" max="{{ \Carbon\Carbon::now()->year . '-12' }}" value="{{ old('fecha_req', \Carbon\Carbon::parse($Ssi->getSolicitud->fecha_requerida)->format('Y-m-d')) }}">
                                </div>
                            </div>
                        </div>
                        @if ($Ssi->getActivo->getTotalTareasMantenimientoPreventivaPendientes() > 0)
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="tar_prev" class="control-label fs-7" style="white-space: nowrap;">Tareas Preventivas Pendientes:</label>
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
                                            <tr onclick="toggleCheck('chkTareaPrendactivo_{{$ta->id_tarea_prev_x_activo}}')">
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
                                                                name="tareas_prev[]"
                                                            >
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
                        </form>
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
