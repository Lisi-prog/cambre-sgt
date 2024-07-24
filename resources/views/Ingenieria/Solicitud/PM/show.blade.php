@extends('layouts.app')
@section('titulo', 'Ver P.M.')

@section('content')
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Ver Propuesta de mejora #{{$pm->getSolicitud->id_solicitud}}</div>
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
                                        <span class="obligatorio">*</span>
                                        {{--    ACTIVOS    --}}
                                        {!! Form::select('id_activo', $activos, $pm->id_activo, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'id_activo',
                                            'disabled'
                                        ]) !!}
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
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            var url = '{{url('p_m')}}';
            document.getElementById('volver').href = url;
        })
    </script>
@endsection