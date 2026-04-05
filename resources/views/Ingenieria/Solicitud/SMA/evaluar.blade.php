@extends('layouts.app')
@section('titulo', 'Evaluar S.M.A.')
@section('content')
<style>
     .tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        height: 500px; /* gives an initial height of 200px to the table */
      }
      .tableFixHead thead th {
        position: sticky; /* make the table heads sticky */
        top: 0px; /* table head will be placed from the top of the table and sticks to it */
      }
      #viv table {
        border-collapse: collapse; /* make the table borders collapse to each other */
        width: 100%;
      }
      /* #viv th,
      #viv td {
        padding: 8px 16px;
        border: 1px solid #ccc;
      }*/
      #viv th {
        background: #ee9b27;
      }
</style>
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Evaluar solicitud de servicio de mantenimiento</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion del Requerimiento de ingenieria --}}
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Solicitud de servicio de mantenimiento</h5></div>
                        </div>
                        <div class="card-body">
                            {{-- {!! Form::open(['route' => ['solicitud.aceptar', $sma->getSolicitud->id_solicitud, 1], 'method' => 'POST', 'class' => 'formulario']) !!} --}}
                            <div class="row">
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fecha_carga', "Fecha y hora:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('fecha_carga',\Carbon\Carbon::parse($sma->getSolicitud->fecha_carga)->format('Y-m-d H:i'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('nom_solicitante', 'Solicitante:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_solicitante', $sma->getSolicitud->nombre_solicitante, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                 <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('id_sector', 'Sector:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('id_sector', $sma->getSector->nombre_sector, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    @if(!is_null($sma->getSolicitud->fecha_requerida))
                                        <div class="form-group">
                                            {!! Form::label('fecha_req', "Fecha requerida:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::text('fecha_req',\Carbon\Carbon::parse($sma->getSolicitud->fecha_requerida)->format('Y-m-d'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('prioridad', "Prioridad:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('prioridad',$sma->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                {{-- @if ($sma->getActivo)
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('activo', "Activo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::text('activo', $sma->getActivo->codigo_activo.' - '.$sma->getActivo->nombre_activo, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                        </div>
                                    </div>
                                @endif --}}
                                
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                </div>
                            </div>
                            @if (sizeof($sma->getSolicitud->getArchivos) != 0 )
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('archivo', "Archivo/s:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <table class="table table-light table-striped">
                                            <thead>
                                              <tr>
                                                <th class='text-center' scope="col" style="color: #fff; width: 5%;">N°</th>
                                                <th class='text-center' scope="col" style="color: #fff; width: 50%;">Nombre</th>
                                                <th class='text-center' scope="col" style="color: #fff; width: 10%;">Accion</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $count = 1;
                                                @endphp
                                                @foreach ($sma->getSolicitud->getArchivos as $archivo)
                                                    <tr>
                                                        <td class='text-center' style="vertical-align: middle;">{{$count}}</td>
                                                        <td class='text-center' style="vertical-align: middle;">{{$archivo->nombre_archivo}}</td>
                                                        <td class='text-center' style="vertical-align: middle;"><a class="btn btn-primary" type="button" id="button-addon2" href="{{asset($archivo->ruta)}}" download="{{$archivo->nombre_archivo}}">Descargar</a></td>
                                                    </tr>
                                                    @php
                                                        $count++;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('descrip', "Descripcion de la solicitud:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea id='descrip' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$sma->getSolicitud->descripcion_solicitud}}</textarea>
                                    </div>
                                </div>
                                @if ($sma->getActivo)
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    {!! Form::label('activo', "Activo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                    {!! Form::text('activo', $sma->getActivo->codigo_activo.' - '.$sma->getActivo->nombre_activo, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    {!! Form::label('descrip', "Sintomas:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                    <ul class="list-group">
                                                        @foreach ($sma->getSintomasAlt() as $grupo)
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
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- @if (!is_null($sma->getSolicitud->descripcion_urgencia))
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('descrip_urg', "Descripcion urgencia:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            <textarea id='descrip_urg' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$sma->getSolicitud->descripcion_urgencia ?? ''}}</textarea>
                                        </div>    
                                    </div>
                                @endif --}}
                                
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
                                            {!! Form::open(['method' => 'GET', 'route' => ['sma.aceptar', $sma->getSolicitud->id_solicitud], 'style' => '']) !!}
                                            {!! Form::submit('Aceptar', ['class' => 'btn btn-success', 'onclick' => "return confirm('¿Está seguro que desea ACEPTAR el servicio de mantenimiento?');"]) !!}
                                            {!! Form::close() !!}
                                            {{-- {!! Form::submit('Aceptar', ['class' => 'btn btn-success']) !!} --}}
                                            {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
                                                Aceptar   
                                            </button> --}}
                                            {{-- {!! Form::close() !!} --}}
                                        </div>
                                        <div class="col-6">
                                            {!! Form::open(['method' => 'GET', 'route' => ['sma.rechazar', $sma->getSolicitud->id_solicitud], 'style' => '']) !!}
                                            {!! Form::submit('Rechazar', ['class' => 'btn btn-danger', 'onclick' => "return confirm('¿Está seguro que desea RECHAZAR el servicio de mantenimiento?');"]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-5 d-flex">
                                    <div class="ms-auto">
                                        {!! Form::open(['method' => 'GET', 'route' => 's_s_i.index', 'style' => '']) !!}
                                        {!! Form::submit('Volver', ['class' => 'btn btn-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </section>
    {{-- @include('Ingenieria.Solicitud.SSI.modal.m-crear-servicio') --}}
    <script>
        $(document).ready(function () {
            var url = '{{url('s_s_i')}}';
            //url = url.replace(':id_servicio', id_servicio);
            document.getElementById('volver').href = url;
        })

        $(function(){
            $('#crear_serv').on('change', mostrarCrearServicio);
        });

        function mostrarCrearServicio(){
            let opcion = Number($(this).val());
            let div_crear_serv = document.getElementById("crear-proyecto");
            switch (opcion) {
                case 0:
                    div_crear_serv.hidden = true;
                    break;
            
                case 1:
                    div_crear_serv.hidden = false;
                    break;
            }
        }
    </script>
@endsection