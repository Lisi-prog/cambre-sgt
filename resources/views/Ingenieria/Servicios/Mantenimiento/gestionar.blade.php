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
                            <h5>Orden</h5>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:rgb(101, 101, 197);width:100%;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('num', "Numero:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('num', 123, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('est', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('est', '-', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('hs', "Horas:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('hs', '00:00', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
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
                                                @foreach ($ordenes_mantenimiento as $orden)
                                                    <tr>
                                                        <td class= 'text-center' style="vertical-align: middle;">{{$orden->id_orden ?? '-'}}</td>
                                                        <td class= 'text-center' style="vertical-align: middle;">{{$orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->nombre_tipo_orden_mantenimiento ?? '-'}}</td>                                                    
                                                        <td class= 'text-center' style="vertical-align: middle;">-</td>
                                                        <td class= 'text-center' style="vertical-align: middle;">{{$orden->getOrdenMantenimiento->getEstadoActual()}}</td>
                                                        <td class= 'text-center' style="vertical-align: middle;">{{$orden->getHoras()}}</td>
                                                        <td class= 'text-center' style="vertical-align: middle;">
                                                            @if($orden->getOrdenMantenimiento->getEstadoActual() == 'Espera')
                                                                @if($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 1)
                                                                    <button type="button" onclick="openModalNuevoParteDiagnostico({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                        <i class="fas fa-pen"></i>
                                                                    </button>
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 2)
                                                                    <button type="button" onclick="openModalNuevoParteInspeccion({{$proyecto->getActivo->id_activo}},{{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                        <i class="fas fa-pen"></i>
                                                                    </button>
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 3)
                                                                    <button type="button" onclick="openModalNuevoParteAjuste({{$orden->id_orden}}, {{$orden->id_etapa}})" class="btn btn-primary" onclick="">
                                                                        <i class="fas fa-pen"></i>
                                                                    </button>
                                                                @endif
                                                            @elseif ($orden->getOrdenMantenimiento->getEstadoActual() == 'En proceso')
                                                                @if ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 2)
                                                                    <button type="button" onclick="openModalParteInspeccionPendiente({{$proyecto->getActivo->id_activo}},{{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 3)
                                                                    <button type="button" onclick="openModalParteAjustePendiente({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                @endif
                                                            @elseif ($orden->getOrdenMantenimiento->getEstadoActual() == 'Revisar')
                                                                @if($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 1)
                                                                <button type="button" onclick="openModalConfirmarParteDiagnostico({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>    
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 2)
                                                                    <button type="button" onclick="openModalConfirmarParteInspeccion({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                @elseif ($orden->getOrdenMantenimiento->getTipoOrdenMantenimiento->id_tipo_orden_mantenimiento == 3)
                                                                    <button type="button" onclick="openModalConfirmarParteAjuste({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                            <button type="button" class="btn btn-warning" onclick="">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger" onclick="">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
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
                                                    <button type="button" class="btn btn-primary" onclick="openModalDiagnostico({{ $parte->id_parte }})">
                                                        <i class="fas fa-eye"></i>
                                                    </button>                                                    
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
    </section>

    @include('Ingenieria.Servicios.Mantenimiento.Partes.diagnostico') 
    @include('Ingenieria.Servicios.Mantenimiento.Partes.inspeccion') 
    @include('Ingenieria.Servicios.Mantenimiento.Partes.ajuste') 
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
        });
    </script>
    <script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/diagnostico.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/inspeccion.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/ajuste.js') }}"></script>
    <script src="{{ asset('js/change-td-color.js') }}"></script>
@endsection