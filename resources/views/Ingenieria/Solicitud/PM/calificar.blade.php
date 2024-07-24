@extends('layouts.app')
@section('titulo', 'Calificar P.M.')

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

        .rating input[type="radio"]:hover ~ label,
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
                <div class="titulo page__heading py-1 fs-5">Calificar Propuesta de mejora #{{$pm->getSolicitud->id_solicitud}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion de la Propuesta de mejora --}}
                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
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
                                        {!! Form::label('idctivo', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        {{--    ACTIVOS    --}}
                                        {!! Form::text('idactivo', $pm->getActivo->nombre_activo ?? '-', ['class' => 'form-control', 'readonly']) !!}
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
                            <div class="row">
                                <div class="col-4">

                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <button id="btn_guardar" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#guardaCaliModal" onclick="cargarModalGuardarCali()" disabled>
                                                Guardar   
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
                                <div class="col-4">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-6">
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
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
       
    </section>
    @include('Ingenieria.Solicitud.PM.modal.m-guardar-cali')
    <script src="{{ asset('js/Ingenieria/Solicitud/calificar.js') }}"></script>
    <script>
        $(document).ready(function () {
            var url = '{{url('p_m')}}';
            //url = url.replace(':id_servicio', id_servicio);
            document.getElementById('volver').href = url;
            
            $('input[name="vto-rating"]').click(function() {
                return false;
            });

            document.querySelectorAll('input[name="rating"]').forEach(item => {
                item.addEventListener('click', event => {
                    calculoViabilidadTotal();
                })
            });

            document.querySelectorAll('input[name="ve-rating"]').forEach(item => {
                item.addEventListener('click', event => {
                    calculoViabilidadTotal();
                })
            });

            document.querySelectorAll('input[name="vte-rating"]').forEach(item => {
                item.addEventListener('click', event => {
                    calculoViabilidadTotal();
                })
            });

            document.querySelectorAll('input[name="ne-rating"]').forEach(item => {
                item.addEventListener('click', event => {
                    calculoInteresTotal();
                })
            });

            document.querySelectorAll('input[name="ca-rating"]').forEach(item => {
                item.addEventListener('click', event => {
                    validarBtn();
                })
            });

            function calculoViabilidadTotal(){
                // console.log($('input[name="rating"]:checked').val());
                let v_tec = $('input[name="rating"]:checked').val();
                let v_eco = $('input[name="ve-rating"]:checked').val();
                let v_temp = $('input[name="vte-rating"]:checked').val();
                let v_tot = 0;

                v_tec ??= 0;
                v_eco ??= 0;
                v_temp ??= 0;

                v_tot = Math.round(Math.cbrt(v_tec * v_eco * v_temp));
                
                
                if (v_tot) {
                    document.getElementById("vto-rate"+v_tot).checked = true;
                    calculoInteresTotal();
                }
                validarBtn();
            }

            function calculoInteresTotal(){
                let v_tot = $('input[name="vto-rating"]:checked').val();
                let nec = $('input[name="ne-rating"]:checked').val();
                let input_nec = document.getElementById('nece_id');
                let inte = 0;

                v_tot ??= 0;
                nec ??= 0;

                inte = v_tot * nec;

                input_nec.value = inte;
                validarBtn();
            }

            function validarBtn() {
                let v_tec = $('input[name="rating"]:checked').val();
                let v_eco = $('input[name="ve-rating"]:checked').val();
                let v_temp = $('input[name="vte-rating"]:checked').val();
                let v_tot = $('input[name="vto-rating"]:checked').val();
                let nece = $('input[name="ne-rating"]:checked').val();
                let inte = $('#nece_id').val();
                let cali = $('input[name="ca-rating"]:checked').val();
                let btn_guardar = document.getElementById('btn_guardar');

                v_tec ??= 0;
                v_eco ??= 0;
                v_temp ??= 0;
                v_tot ??= 0;
                nece ??= 0;
                inte ??= 0;
                cali ??= 0; 

                if (v_tec && v_eco && v_temp && v_tot && nece && inte && cali) {
                    btn_guardar.disabled = false;
                }else{
                    btn_guardar.disabled = true;
                }
            }
            
        })

        function cargarModalGuardarCali() {
            let v_tec = $('input[name="rating"]:checked').val();
            let v_eco = $('input[name="ve-rating"]:checked').val();
            let v_temp = $('input[name="vte-rating"]:checked').val();
            let v_tot = $('input[name="vto-rating"]:checked').val();
            let nece = $('input[name="ne-rating"]:checked').val();
            let inte = $('#nece_id').val();
            let cali = $('input[name="ca-rating"]:checked').val();

            let input_v_tec = document.getElementById('input_vi_tec');
            let input_v_eco = document.getElementById('input_vi_eco');
            let input_v_temp = document.getElementById('input_vi_temp');
            let input_v_tot = document.getElementById('input_vi_tot');
            let input_nece = document.getElementById('input_nece');
            let input_inte = document.getElementById('input_inte');
            let input_cali = document.getElementById('input_cali');

            v_tec ??= 0;
            v_eco ??= 0;
            v_temp ??= 0;
            v_tot ??= 0;
            nece ??= 0;
            inte ??= 0;
            cali ??= 0;

            input_v_tec.value = v_tec;
            input_v_eco.value =  v_eco;
            input_v_temp.value = v_temp;
            input_v_tot.value = v_tot;
            input_nece.value = nece;
            input_inte.value = inte;
            input_cali.value = cali;
        }
    </script>
@endsection