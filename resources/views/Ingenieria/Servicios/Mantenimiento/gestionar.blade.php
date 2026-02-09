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
                    <h4 class="">Gestionar Servicio de Mantenimiento - {{$proyecto->codigo_servicio}}</h5>
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
                            <button  type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoParteDiagnosticoModal">Parte Diagnóstico</button>
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

                {{-- Ordenes y partes --}}
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-head pt-3 m-auto">
                            <h5>Orden</h5>
                        </div>
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
                                        <table class="table table-hover mt-2 table-sm">
                                            <thead style="">
                                                <th class="text-center" scope="col" style="color:#fff;">N°</th>
                                                <th class="text-center" scope="col" style="color:#fff;">Tipo</th>
                                                <th class="text-center" scope="col" style="color:#fff;">Descripcion</th>
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
                                                    <td class= 'text-center' style="vertical-align: middle;">-</td>
                                                    <td class= 'text-center' style="vertical-align: middle;">{{$orden->getOrdenMantenimiento->getEstadoActual()}}</td>
                                                    <td class= 'text-center' style="vertical-align: middle;">00:00</td>
                                                    <td class= 'text-center' style="vertical-align: middle;">
                                                        <button type="button" class="btn btn-primary" onclick="">
                                                            <i class="fas fa-pen"></i>
                                                        </button>
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
                                        <button type="button" class="btn btn-success" onclick="">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-head pt-3 m-auto">
                            <h5>Parte</h5>
                        </div>
                        <div class="card-body">
                            
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </section>

    @include('Ingenieria.Servicios.Mantenimiento.Partes.diagnostico') 
    <div hidden>
        @include('Ingenieria\Servicios\Mantenimiento\Partes\ishikawa_select')
    </div>
    <script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/diagnostico.js') }}"></script>
    <script src="{{ asset('js/change-td-color.js') }}"></script>
@endsection