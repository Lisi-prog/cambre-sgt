@extends('layouts.app')
@section('titulo', 'Ver R.I.')
@section('content')
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Ver Servicio de ingenieria #{{$Ssi->getSolicitud->id_solicitud}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Servicio de ingenieria</h5></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fecha_carga', "Fecha y hora:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_carga',\Carbon\Carbon::parse($Ssi->getSolicitud->fecha_carga)->format('d-m-Y H:i'), ['class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('estado',$Ssi->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud, ['class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('nom_solicitante', 'Solicitante:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_solicitante', $Ssi->getSolicitud->nombre_solicitante, ['class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('prioridad', "Prioridad:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('prioridad',$Ssi->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud, ['class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('activo', 'Activo:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('activo',$Ssi->getActivo->nombre_activo, ['class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('id_sector', 'Sector:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('id_sector', $Ssi->getSector->nombre_sector, ['class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    @if(!is_null($Ssi->getSolicitud->fecha_requerida))
                                        <div class="form-group">
                                            {!! Form::label('fecha_req', "Fecha requerida:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::date('fecha_req',$Ssi->getSolicitud->fecha_requerida, ['class' => 'form-control', 'readonly']) !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('descrip', "Descripcion de la solicitud:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='descripcion' id='descrip' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Ssi->getSolicitud->descripcion_solicitud}}</textarea>
                                    </div>
                                </div>
                                @if (!is_null($Ssi->getSolicitud->descripcion_urgencia))
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('descrip_urg', "Descripcion urgencia:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            <textarea name='descripcion_urgencia' id='descrip_urg' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Ssi->getSolicitud->descripcion_urgencia ?? ''}}</textarea>
                                        </div>    
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        
                                    </div>
                                </div>
                                <div class="col-5 d-flex">
                                    <div class="ms-auto">
                                        {!! Form::open(['method' => 'GET', 'route' => 's_s_i.index', 'style' => '']) !!}
                                        {!! Form::submit('Volver', ['class' => 'btn btn-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection