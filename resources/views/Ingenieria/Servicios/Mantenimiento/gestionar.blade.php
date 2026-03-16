@extends('layouts.app')
@section('titulo', 'Gestionar Mantenimiento')
@section('content')

@php
    $formato_fecha= Config::get('myconfig.formato_fecha');
    $formato_fecha_hora= Config::get('myconfig.formato_fecha_hora');
@endphp
    <section class="section">
        <div class="d-flex section-header justify-content-center">
            <div class="d-flex flex-row col-12">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 my-auto">
                    <h4 class="">Gestionar Servicio de Mantenimiento - <label id="nombre_proyecto">{{$proyecto->codigo_servicio}}</label></h5>
                        <input type="text" hidden id="nombre_proyecto_i" value="{{ $proyecto->codigo_servicio }}">
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion de la solicitud --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head py-3 m-auto">
                            <h5>Solicitud</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <div class="row">
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('numero', "Numero:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::text('numero', $solicitud->id_solicitud, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::text('estado', $solicitud->getEstadoSolicitud->nombre_estado_solicitud, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('fec_sol', "Fecha solicitud:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::text('fec_sol', $solicitud->fecha_carga, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('fec_ate', "Fecha atendida:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::text('fec_ate', $solicitud->fecha_inicio ?? '-', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('fec_fin', "Fecha finalizada:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::text('fec_fin', $solicitud->getFechaFinalizada ?? '-', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                {!! Form::label('descrip', "Descripcion de la solicitud:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                <textarea id='descrip' class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" readonly>{{$solicitud->descripcion_solicitud}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                {!! Form::label('activo', "Activo para mantenimiento:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::text('activo', $proyecto->getActivo->codigo_activo, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                {!! Form::label('sintoma', "Sintomas:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                <div class="row">
                                                    @foreach ($solicitud->getServicioDeIngenieria->getSintomasAlt() as $grupo)
                                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                            <li class="d-flex justify-content-between align-items-start">
                                                                <div class="ms-2 me-auto">
                                                                    <div class="fw-bold">{{ $grupo['tipo'] }}</div>

                                                                    <ul class="mb-0">
                                                                        @foreach ($grupo['sintomas'] as $sintoma)
                                                                            <li>{{ $sintoma['nombre'] }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- -------------------------------- --}}
            </div>
            {{-- Ordenes y partes --}}
            <div class="row d-flex align-items-stretch">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="card h-100">
                        <div class="card-head pt-3 m-auto">
                            <h5>Orden de Mantenimiento</h5>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:rgb(101, 101, 197);width:100%;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('est', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('est', '-', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'id' => 'es']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('hs', "Horas:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('hs', '00:00', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'id' => 'hs']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table id="table-orden" class="table table-hover mt-2 table-sm">
                                            <thead style="">
                                                <th class="text-center" scope="col" style="color:#fff;">N°</th>
                                                <th class="text-center" scope="col" style="color:#fff;">Tipo</th>
                                                <th class="text-center" scope="col" style="color:#fff;">Tecnico</th>
                                                <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                                <th class="text-center" scope="col" style="color:#fff;">Horas</th>
                                                {{-- <th class="text-center" scope="col" style="color:#fff;">T. Est.</th> --}}
                                                <th class="text-center" scope="col" style="color:#fff;">Acciones</th>                                                           
                                            </thead>
                                            <tbody>
                                                @php
                                                    $horas_totales = 0;
                                                    $estado = ''
                                                @endphp
                                                @foreach ($ordenes_mantenimiento as $orden)
                                                    <tr>
                                                        <td class= 'text-center' style="vertical-align: middle;">{{$orden->id_orden ?? '-'}}</td>
                                                        <td class= 'text-center' style="vertical-align: middle;">{{$orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->nombre_tipo_orden_mantenimiento ?? '-'}}</td>                                                    
                                                        <td class= 'text-center' style="vertical-align: middle;">-</td>
                                                        <td class= 'text-center' style="vertical-align: middle;">{{$orden->getOrdenMantenimiento->getEstadoActual()}}</td>
                                                        <td class= 'text-center' style="vertical-align: middle;">{{$orden->getHoras()}}</td>
                                                        @php
                                                            if($orden->getHoras()){
                                                                [$h, $m] = explode(':', $orden->getHoras());
                                                                $horas_totales += ($h * 60) + $m;
                                                            }
                                                        @endphp
                                                        <td class= 'text-center' style="vertical-align: middle;">
                                                            @php
                                                                $estado = $orden->getOrdenMantenimiento->getEstadoActual()
                                                            @endphp
                                                            @if($orden->getOrdenMantenimiento->getEstadoActual() == 'Espera')
                                                                @if($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 1)
                                                                    <button type="button" onclick="openModalNuevoParteDiagnostico({{$orden->id_orden}})" class="btn btn-primary">
                                                                        <i class="fas fa-pen"></i>
                                                                    </button>
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 2)
                                                                    <button type="button" onclick="openModalNuevoParteInspeccion({{$proyecto->getActivo->id_activo}},{{$orden->id_orden}})" class="btn btn-primary">
                                                                        <i class="fas fa-pen"></i>
                                                                    </button>
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 3)
                                                                    <button type="button" onclick="openModalNuevoParteAjuste({{$orden->id_orden}}, {{$orden->id_etapa}})" class="btn btn-primary">
                                                                        <i class="fas fa-pen"></i>
                                                                    </button>
                                                                @endif
                                                            @elseif ($orden->getOrdenMantenimiento->getEstadoActual() == 'En proceso')
                                                                @if ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 2)
                                                                    <button type="button" onclick="openModalParteInspeccionPendiente({{$proyecto->getActivo->id_activo}},{{$orden->id_orden}})" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 3)
                                                                    <button type="button" onclick="openModalParteAjustePendiente({{$orden->id_orden}}, {{$orden->id_etapa}})" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                @endif
                                                            @elseif ($orden->getOrdenMantenimiento->getEstadoActual() == 'Revisar')
                                                                <button type="button" onclick="openModalConfirmarParteAjuste({{$orden->id_orden}})" class="btn btn-primary">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            @else
                                                                @if($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 1)
                                                                    <button type="button" onclick="openModalVerParteDiagnostico({{$orden->id_orden}})" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>    
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 2)
                                                                    <button type="button" onclick="openModalVerParteInspeccion({{$orden->id_orden}})" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 3)
                                                                    <button type="button" onclick="openModalVerParteAjuste({{$orden->id_orden}})" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                            <button type="button" class="btn btn-warning" onclick="modalEditarPartes({{$orden->getOrdenMantenimiento->id_orden_mantenimiento}})">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </td>
                                                    </tr>                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @php
                                            $horas = floor($horas_totales / 60);
                                            $minutos = $horas_totales % 60;
                                            $horas_totales = sprintf('%02d:%02d', $horas, $minutos);
                                        @endphp
                                        <input type="text" hidden id="horas_totales" value="{{$horas_totales}}">
                                        <input type="text" hidden id="estado_actual" value="{{$estado}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="card h-100">
                        <div class="card-head pt-3 m-auto">
                            <h5>Parte</h5>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:rgb(101, 101, 197);width:100%;">
                        <div class="card-body">
                            <div class="" style="max-height: 350px; overflow-y: auto; overflow-x: auto;">
                                <table id="table_partes">
                                    <thead>
                                        <th class="text-center" scope="col" style="color:#fff;">ORDEN</th>
                                        <th class="text-center" scope="col" style="color:#fff;">ID</th>
                                        <th class="text-center" scope="col" style="color:#fff;">ESTADO</th>
                                        <th class="text-center" scope="col" style="color:#fff;">RESPONSABLE</th>
                                        <th class="text-center" scope="col" style="color:#fff;">HORAS</th>
                                        <th class="text-center" scope="col" style="color:#fff;">ACCIÓN</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($ordenes_mantenimiento->sortByDesc('id_orden') as $orden_mantenimiento)
                                            @foreach ($orden_mantenimiento->getPartes->sortByDesc('id_parte') as $parte)
                                                <tr>
                                                    <td class= 'text-center' style="vertical-align: middle;">{{ $orden_mantenimiento->id_orden }} {{ $orden_mantenimiento->getOrdenMantenimiento->getTipoOrdenMantenimiento->nombre_tipo_orden_mantenimiento}}</td>
                                                    <td class= 'text-center' style="vertical-align: middle;">{{ $parte->id_parte }}</td>
                                                    <td class= 'text-center' style="vertical-align: middle;">{{ $parte->getParteDe->getEstado->nombre_estado_mantenimiento  ?? '-' }}</td>
                                                    <td class= 'text-center' style="vertical-align: middle;">{{ $parte->getResponsable->getEmpleado->nombre_empleado }}</td>
                                                    <td class= 'text-center' style="vertical-align: middle;">{{ $parte->horas }}</td>
                                                    <td class= 'text-center' style="vertical-align: middle;">
                                                        @if($orden_mantenimiento->getOrdenMantenimiento->getTipoOrdenMantenimiento->nombre_tipo_orden_mantenimiento == 'DIAGNÓSTICO')
                                                            @if($parte->getParteDe->getEstado->nombre_estado_mantenimiento == 'Completo')                                                                
                                                                <button type="button" class="btn btn-primary" onclick="openModalVerParteDiagnostico({{ $orden_mantenimiento->id_orden }})">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>                    
                                                            @endif   
                                                        @elseif($orden_mantenimiento->getOrdenMantenimiento->getTipoOrdenMantenimiento->nombre_tipo_orden_mantenimiento == 'INSPECCIÓN')
                                                            @if($parte->getParteDe->getEstado->nombre_estado_mantenimiento == 'En proceso' || $parte->getParteDe->getEstado->nombre_estado_mantenimiento == 'Completo')
                                                                <button type="button" class="btn btn-primary" onclick="verParteDeInspeccion({{ $parte->id_parte }}, '{{ $parte->getParteDe->getEstado->nombre_estado_mantenimiento }}')">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>      
                                                            @endif   
                                                        @elseif($orden_mantenimiento->getOrdenMantenimiento->getTipoOrdenMantenimiento->nombre_tipo_orden_mantenimiento == 'AJUSTE')
                                                            @if($parte->getParteDe->getEstado->nombre_estado_mantenimiento == 'En proceso' || $parte->getParteDe->getEstado->nombre_estado_mantenimiento == 'Revisar')
                                                                <button type="button" class="btn btn-primary" onclick="verParteDeAjuste({{ $parte->id_parte }}, '{{ $parte->getParteDe->getEstado->nombre_estado_mantenimiento }}')">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>      
                                                            @endif   
                                                        @endif                                                                                   
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach                                          
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-flex align-items-stretch mt-4">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="card h-100">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                                    <h5>Orden de Mecanizado</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    @if ($proyecto->tieneOrdenMantAjusteCompleto())
                                        <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenMecaModal">
                                            Nuevo
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-head pt-3 m-auto">
                            <h5>Orden de Mecanizado</h5>
                        </div> --}}
                        <hr style="height:2px;border-width:0;color:gray;background-color:rgb(101, 101, 197);width:100%;">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tablaOrdenMec" class="table table-hover mt-2 table-sm" class="display">
                                    <thead style="background-color: #d37c00" id="comec">
                                        <th class="text-center" scope="col" style="color:#fff;min-width:6vw">Orden</th>
                                        {{-- <th class="text-center" scope="col" style="color:#fff;">Manufactura</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th> --}}
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                        {{-- <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Supervisor</th> --}}
                                        {{-- <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Responsable</th> --}}
                                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Horas estimadas</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Horas reales</th>
                                        <th class="text-center" scope="col" style="color:#fff;min-width:8vw;">Acciones</th>                                                           
                                    </thead>
                                    <tbody id="cuadro-ordenes-mecanizado">
                                        @php
                                            $idCount = 0;
                                            $opcion = 1;
                                        @endphp
                                        @foreach ($ordenes_mecanizado as $orden)
                                            @if ($orden->id_estado < 7)
                                                <tr>
                                            @else
                                                <tr style="display: none;">
                                            @endif     
                                                    <td class= 'text-center' style="vertical-align: middle;">{{$orden->nombre_orden}}</td>

                                                    {{-- <td class= 'text-center' >{{$orden->nombre_manufactura ?? '-'}}</td>

                                                    <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->descripcion_etapa ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 6).'...' ?? "-"}} <i class="fas fa-eye"></i></abbr></td> --}}

                                                    <td class= 'text-center' style="vertical-align: middle;">{{$orden->nombre_estado}}</td>

                                                    {{-- <td class= 'text-center' >{{$orden->supervisor}}</td> --}}

                                                    {{-- <td class= 'text-center' >{{$orden->responsable}}</td> --}}

                                                    <td class= 'text-center' style="vertical-align: middle;">{{$orden->fecha_limite ?? '-'}}</td>

                                                    <td class= 'text-center' style="vertical-align: middle;">{{$orden->fecha_finalizacion}}</td>

                                                    <td class= 'text-center' style="vertical-align: middle;">{{$orden->horas_estimada}}</td>
                                                            
                                                    <td class= 'text-center' style="vertical-align: middle;">{{$orden->horas_real}}</td>
                                                    
                                                    <td class='text-center'>
                                                        <div class="row justify-content-center" >
                                                            <div class="row justify-content-center" >
                                                                <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenMecanizado{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenMecanizado{{$idCount}}">
                                                                    Opciones
                                                                </button>
                                                            </div>
                                                            <div class="collapse" data-bs-parent="#cuadro-ordenes-mecanizado" id="collapseOrdenMecanizado{{$idCount}}">
                                                                <div class="row my-2">
                                                                    <div class="col-12">
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['ordenes.hdr', $orden->id_orden], 'style' => 'display:inline']) !!}
                                                                            {!! Form::text('vieneDesde', 4, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!}
                                                                            {!! Form::text('opcion', $opcion, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!}
                                                                            {!! Form::text('idServ', $proyecto->id_servicio, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!} 
                                                                            {!! Form::submit('HDR', ['class' => 'btn btn-info w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    {{-- <div class="col-12">
                                                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarMecanizado({{$orden->id_orden}}, '{{$orden->descripcion_etapa}}')">
                                                                            Editar
                                                                        </button>
                                                                    </div> --}}
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-12">
                                                                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, 3)">
                                                                            Partes
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    {{-- <div class="col-12">
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['orden.eliminar', $orden->id_orden], 'style' => 'display:inline', 'onclick' => "return confirm('¿Está seguro que desea BORRAR la orden y sus partes?');"]) !!}
                                                                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @php
                                            $idCount += 1;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="card h-100">
                        <div class="card-head pt-3 m-auto">
                            <h5>Suministros</h5>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:rgb(101, 101, 197);width:100%;">
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('Ingenieria.Servicios.Mantenimiento.Partes.diagnostico') 
    @include('Ingenieria.Servicios.Mantenimiento.Partes.inspeccion') 
    @include('Ingenieria.Servicios.Mantenimiento.Partes.ajuste')
    @include('Ingenieria.Servicios.Mantenimiento.Modal.crear-orden-mec')
    @include('Ingenieria.Servicios.Mantenimiento.Modal.ver-partes')
    @include('Ingenieria.Servicios.Mantenimiento.Partes.editar_partes')

    <div hidden>
        @include('Ingenieria.Servicios.Mantenimiento.Partes.ishikawa_select')
    </div>
    <script>
        $(document).ready(function () {
            var url = '{{url('/s_s_i')}}';
            document.getElementById('volver').href = url;
            document.getElementById('ayudin').hidden = false;

            $('#table_partes').DataTable({
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

            $('#table-orden').DataTable({
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

            $('#verPartesModal').on('hidden.bs.modal', function (e) {
                nuevoParte();
            })

            $(".nuevo-editar-parte").on('submit', function(evt){
                evt.preventDefault();     
                var url_php = $(this).attr("action"); 
                var type_method = $(this).attr("method"); 
                var form_data = $(this).serialize();
                let html = '';
                let id_orden = document.getElementById('m-ver-parte-orden').value;
                $.ajax({
                    type: type_method,
                    url: url_php,
                    data: form_data,
                    success: function(data) {
                        //console.log(data);
                        opcion = parseInt(data.resultado);
                        switch (opcion) {
                            case 1:
                                html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                                Parte creado con exito
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>`;
                                break;
                            case 2:
                                id = document.getElementById('m-id-parte').value;
                                html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                                Parte cod. `+id+` actualizado con exito
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>`;
                                break;
                            case 6:
                                html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                            No se puede actualizar un parte de la cual no eres responsable.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                                break;
                            default:
                                html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                            Ocurrio un error
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                                break;
                        }
                        $('#alert').html(html)
                        recargarPartes(id_orden, data.tipo_orden);
                        nuevoParte();
                        setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);
                    }
                });
        });
        });
    </script>
    <script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/gestionar.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/diagnostico.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/inspeccion.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/ajuste.js') }}"></script>
    <script src="{{ asset('js/change-td-color.js') }}"></script>
@endsection