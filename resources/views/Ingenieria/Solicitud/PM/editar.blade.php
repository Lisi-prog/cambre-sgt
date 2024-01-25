@extends('layouts.app')
@section('titulo', 'Editar P.M.')

@section('content')
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Editar Propuesta de mejora #{{$pm->getSolicitud->id_solicitud}}</div>
            </div>
        </div>
        <div class="section-body">
            {!! Form::model($pm,['method' => 'PUT', 'route' => ['p_m.update', $pm->id_propuesta_de_mejora]]) !!}
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion del Requerimiento de ingenieria --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('fecha_carga', "Fecha y hora:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_carga',\Carbon\Carbon::parse($pm->getSolicitud->fecha_carga)->format('d-m-Y H:i'), ['class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('estado',$pm->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud, ['class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('nom_solicitante', 'Solicitante:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_solicitante', $pm->getSolicitud->nombre_solicitante, ['class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                    <div class="form-group">
                                        {!! Form::label('titulo-propuesta', 'Titulo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('titulo-propuesta', $pm->titulo_propuesta, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('nombre_emisor', 'Emisor:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('nombre_emisor', $pm->nombre_emisor, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('id_activo', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {{--    ACTIVOS    --}}
                                        {!! Form::select('id_activo', $activos, $pm->id_activo, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'id_activo',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('obj-propuesta', 'Objetivo de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        <textarea name='obj-propuesta' id="obj-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->objetivo_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>      
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('desc-propuesta', 'Descripcion de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='desc-propuesta' id="desc-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->descripcion_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('an-i-propuesta', 'Analisis de impacto de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='an-i-propuesta' id="an-i-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->analisis_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>    
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('bene-propuesta', 'Beneficios de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='bene-propuesta' id="bene-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->beneficio_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>     
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('prob-propuesta', 'Problemas de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='prob-propuesta' id="prob-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->problema_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('eva-propuesta', 'Evaluacion de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='eva-propuesta' id="eva-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->evaluacion_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}


                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @php
                                    $id_estado_aceptado = Config::get('myconfig.estado_solicitud_aceptado')
                                @endphp
                                <div class="col-5">

                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        @if ($pm->getSolicitud->id_estado_solicitud < $id_estado_aceptado)
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        @endif
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <div class="col-5 d-flex">
                                    <div class="ms-auto">
                                        {!! Form::open(['method' => 'GET', 'route' => 'p_m.index', 'style' => '']) !!}
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