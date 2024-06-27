@extends('layouts.app')
@section('titulo', 'Evaluar P.M.')

@section('content')
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Evaluar Propuesta de mejora #{{$pm->getSolicitud->id_solicitud}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion del Requerimiento de ingenieria --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Propuesta de mejora</h5></div>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => ['solicitud.aceptar', $pm->getSolicitud->id_solicitud], 'method' => 'POST', 'class' => 'formulario']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                    <div class="form-group">
                                        {!! Form::label('titulo-propuesta', 'Titulo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('titulo-propuesta', $pm->titulo_propuesta, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('nombre_emisor', 'Emisor:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('nombre_emisor', $pm->nombre_emisor, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('id_activo', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        {{--    ACTIVOS    --}}
                                        {!! Form::text('id_activo', $pm->getActivo->nombre_activo ?? '-', ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('obj-propuesta', 'Objetivo de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='obj-propuesta' id="obj-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" readonly>{{$pm->objetivo_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>      
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('desc-propuesta', 'Descripcion de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='desc-propuesta' id="desc-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" readonly>{{$pm->descripcion_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('an-i-propuesta', 'Analisis de impacto de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='an-i-propuesta' id="an-i-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" readonly>{{$pm->analisis_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>    
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('bene-propuesta', 'Beneficios de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='bene-propuesta' id="bene-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" readonly>{{$pm->beneficio_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>     
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('prob-propuesta', 'Problemas de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='prob-propuesta' id="prob-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" readonly>{{$pm->problema_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('eva-propuesta', 'Evaluacion de la propuesta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea name='eva-propuesta' id="eva-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" readonly>{{$pm->evaluacion_propuesta}}</textarea>
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
                                <div class="col-5">

                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-6">
                                            {{-- {!! Form::submit('Aceptar', ['class' => 'btn btn-success']) !!} --}}
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
                                                Aceptar   
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="col-6">
                                            {!! Form::open(['method' => 'GET', 'route' => ['pm.rechazar', $pm->getSolicitud->id_solicitud], 'style' => '']) !!}
                                            {!! Form::submit('Rechazar', ['class' => 'btn btn-danger', 'onclick' => "return confirm('¿Está seguro que desea RECHAZAR la propuesta de mejora?');"]) !!}
                                            {!! Form::close() !!}
                                        </div>
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
    @include('Ingenieria.Solicitud.PM.modal.m-crear-servicio')
    <script>
        $(document).ready(function () {
            var url = '{{url('p_m')}}';
            //url = url.replace(':id_servicio', id_servicio);
            document.getElementById('volver').href = url;
        })
    </script>
@endsection