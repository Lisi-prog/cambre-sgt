@extends('layouts.app')
@section('titulo', 'Ver P.M.')

@section('content')
    <style>
        .rating {
            position: relative;
            display: flex;
            flex-direction: row-reverse;
            /* margin-top: 10px; */
            border: 1px solid #e4e6fc;
            box-sizing: border-box;
            background: linear-gradient(to right, #f00, #ff0, #0f0);
            z-index: 2;
        }
        .rating input {
            display: none;
        }
        .rating label {
            display: block;
            cursor: pointer;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.5s;
            background: #fff;
            color: #212529;
            font-size: 20px;
            /* border-right: 1px solid #e4e6fc; */
        }

        
        .rating input[type="radio"]:checked ~ label{
            background: transparent;
        }

        .sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index:100;
        }

    </style>
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

                @role('SUPERVISOR')
                {{-- Tabla de puntaje de la Propuesta de mejora --}}
                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                    <div class="card sticky">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Calificacion</h5></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('v-tecnica', 'Viabilidad técnica:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="form-control rating p-0" id="vt">
                                            <input type="radio" name="rating" id="rate5" value=5><label for="rate5">5</label>
                                            <input type="radio" name="rating" id="rate4" value=4><label for="rate4">4</label> 
                                            <input type="radio" name="rating" id="rate3" value=3><label for="rate3">3</label> 
                                            <input type="radio" name="rating" id="rate2" value=2><label for="rate2">2</label> 
                                            <input type="radio" name="rating" id="rate1" value=1><label for="rate1">1</label> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('v-economica', 'Viabilidad económica:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="form-control rating p-0">
                                            <input type="radio" name="ve-rating" id="ve-rate5" value=5><label for="ve-rate5">5</label>
                                            <input type="radio" name="ve-rating" id="ve-rate4" value=4><label for="ve-rate4">4</label> 
                                            <input type="radio" name="ve-rating" id="ve-rate3" value=3><label for="ve-rate3">3</label> 
                                            <input type="radio" name="ve-rating" id="ve-rate2" value=2><label for="ve-rate2">2</label> 
                                            <input type="radio" name="ve-rating" id="ve-rate1" value=1><label for="ve-rate1">1</label> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('v-temporal', 'Viabilidad temporal:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="form-control rating p-0">
                                            <input type="radio" name="vte-rating" id="vte-rate5" value=5><label for="vte-rate5">5</label>
                                            <input type="radio" name="vte-rating" id="vte-rate4" value=4><label for="vte-rate4">4</label> 
                                            <input type="radio" name="vte-rating" id="vte-rate3" value=3><label for="vte-rate3">3</label> 
                                            <input type="radio" name="vte-rating" id="vte-rate2" value=2><label for="vte-rate2">2</label> 
                                            <input type="radio" name="vte-rating" id="vte-rate1" value=1><label for="vte-rate1">1</label> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('v-total', 'Viabilidad total:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="form-control rating p-0">
                                            <input type="radio" name="vto-rating" id="vto-rate5" value=5><label for="vto-rate5">5</label>
                                            <input type="radio" name="vto-rating" id="vto-rate4" value=4><label for="vto-rate4">4</label> 
                                            <input type="radio" name="vto-rating" id="vto-rate3" value=3><label for="vto-rate3">3</label> 
                                            <input type="radio" name="vto-rating" id="vto-rate2" value=2><label for="vto-rate2">2</label> 
                                            <input type="radio" name="vto-rating" id="vto-rate1" value=1><label for="vto-rate1">1</label> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('nececidad', 'Necesidad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="form-control rating p-0">
                                            <input type="radio" name="ne-rating" id="ne-rate5" value=5><label for="ne-rate5">5</label>
                                            <input type="radio" name="ne-rating" id="ne-rate4" value=4><label for="ne-rate4">4</label> 
                                            <input type="radio" name="ne-rating" id="ne-rate3" value=3><label for="ne-rate3">3</label> 
                                            <input type="radio" name="ne-rating" id="ne-rate2" value=2><label for="ne-rate2">2</label> 
                                            <input type="radio" name="ne-rating" id="ne-rate1" value=1><label for="ne-rate1">1</label> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('interes', 'Interés:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('interes', 0, ['class' => 'form-control fs-5', 'id'=> 'nece_id', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('calificacion', 'Calificación:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="form-control rating p-0">
                                            <input type="radio" name="ca-rating" id="ca-rate10" value=10><label for="ca-rate10">10</label>
                                            <input type="radio" name="ca-rating" id="ca-rate9" value=9><label for="ca-rate9">9</label> 
                                            <input type="radio" name="ca-rating" id="ca-rate8" value=8><label for="ca-rate8">8</label> 
                                            <input type="radio" name="ca-rating" id="ca-rate7" value=7><label for="ca-rate7">7</label> 
                                            <input type="radio" name="ca-rating" id="ca-rate6" value=6><label for="ca-rate6">6</label>
                                            <input type="radio" name="ca-rating" id="ca-rate5" value=5><label for="ca-rate5">5</label>
                                            <input type="radio" name="ca-rating" id="ca-rate4" value=4><label for="ca-rate4">4</label> 
                                            <input type="radio" name="ca-rating" id="ca-rate3" value=3><label for="ca-rate3">3</label> 
                                            <input type="radio" name="ca-rating" id="ca-rate2" value=2><label for="ca-rate2">2</label> 
                                            <input type="radio" name="ca-rating" id="ca-rate1" value=1><label for="ca-rate1">1</label> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}
                @endrole
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            var url = '{{url('p_m')}}';
            document.getElementById('volver').href = url;
            
            $('input[name="rating"]').click(function() {
                return false;
            });

            $('input[name="ve-rating"]').click(function() {
                return false;
            });

            $('input[name="vte-rating"]').click(function() {
                return false;
            });

            $('input[name="vto-rating"]').click(function() {
                return false;
            });

            $('input[name="ne-rating"]').click(function() {
                return false;
            });

            $('input[name="ca-rating"]').click(function() {
                return false;
            });

            document.getElementById("rate"+{{$pm->v_tecnica}}).checked = true;

            document.getElementById("ve-rate"+{{$pm->v_economica}}).checked = true;

            document.getElementById("vte-rate"+{{$pm->v_temporal}}).checked = true;

            document.getElementById("vto-rate"+{{$pm->v_total}}).checked = true;

            document.getElementById("ne-rate"+{{$pm->necesidad}}).checked = true;

            document.getElementById("nece_id").value = {{$pm->interes}};

            document.getElementById("ca-rate"+{{$pm->calificacion}}).checked = true;
        })
    </script>
@endsection