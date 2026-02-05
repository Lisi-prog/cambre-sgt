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
                    <h4 class="">Gestionar Servicio de Mantenimiento</h5>
                </div>
                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
                </div> --}}
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
    
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center my-auto">
                                    <h5 class="text-center">Proyecto de Mantenimiento</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    {{-- <button class="btn btn-primary col-9 my-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProyecto" aria-expanded="false" aria-controls="collapsecollapseProyecto">
                                        Opciones
                                    </button>
                                    <div class="collapse" id="collapseProyecto">
                                        <button type="button" class="btn btn-primary col-9" data-bs-toggle="modal" data-bs-target="#editarProyectoModal">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-primary my-2 col-9" data-bs-toggle="modal" data-bs-target="#verActServOrdenModal" onclick="mostrarActProyectoAlt({{$proyecto->id_servicio}})">
                                            Actualizaciones
                                        </button>
                                        {!! Form::open(['method' => 'GET', 'route' => ['proyectos.costos', $proyecto->id_servicio], 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Costos actualizados', ['class' => 'btn btn-primary col-9']) !!}
                                        {!! Form::close() !!}
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        {!! Form::text('id_proyecto_dat', $proyecto->id_servicio, ['class' => 'form-control', 'hidden', 'id' => 'id-servicio-dat']) !!}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('id_proyecto', "ID:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('id_proyecto', $proyecto->codigo_servicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('nom_proyecto', 'Nombre proyecto:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_proyecto', $proyecto->nombre_servicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('id_tipo', 'Tipo:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('id_sector', $proyecto->getSubTipoServicio->nombre_subtipo_servicio, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('lider_proyecto', "Lider de proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('prioridad',$proyecto->getResponsabilidad->getEmpleado->nombre_empleado, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_ini', "Fecha inicio:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_carga',\Carbon\Carbon::parse($proyecto->fecha_inicio)->format($formato_fecha), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_limite', "Fecha limite:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_limite', $proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->fecha_limite ? \Carbon\Carbon::parse($proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->fecha_limite)->format($formato_fecha) : '-', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('estado', $proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->getEstado->nombre_estado, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('prioridad', "Prioridad Nº:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('prioridad', $proyecto->prioridad_servicio ?? 'S/P', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}
                
            </div>
        </div>
    </section>
@endsection