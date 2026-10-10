@extends('layouts.app')
@section('titulo', 'Evaluar S.S.I.')
@section('content')
<link rel="stylesheet" href="{{ asset('css/estilos-tabla.css') }}">

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <div class="titulo page__heading py-1 fs-5">Evaluar solicitud de servicio de ingenieria</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            @include('layouts.modal.mensajes')
            {{-- Informacion del Requerimiento de ingenieria --}}
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Solicitud de servicio de ingenieria</h5></div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label for="fecha_carga" class="control-label" style="white-space: nowrap; ">Fecha y hora:</label>
                                    <input type="text" name="fecha_carga" id="fecha_carga" class="form-control" readonly value="{{ \Carbon\Carbon::parse($Ssi->getSolicitud->fecha_carga)->format('Y-m-d H:i') }}">
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group">
                                    <label for="nom_solicitante" class="control-label" style="white-space: nowrap; ">Solicitante:</label>
                                    <input type="text" name="nom_solicitante" id="nom_solicitante" class="form-control" readonly value="{{ $Ssi->getSolicitud->nombre_solicitante }}">
                                </div>
                            </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="id_sector" class="control-label" style="white-space: nowrap; ">Sector:</label>
                                    <input type="text" name="id_sector" id="id_sector" class="form-control" readonly value="{{ $Ssi->getSector->nombre_sector }}">
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                @if(!is_null($Ssi->getSolicitud->fecha_requerida))
                                    <div class="form-group">
                                        <label for="fecha_req" class="control-label" style="white-space: nowrap; ">Fecha requerida:</label>
                                        <input type="text" name="fecha_req" id="fecha_req" class="form-control" readonly value="{{ \Carbon\Carbon::parse($Ssi->getSolicitud->fecha_requerida)->format('Y-m-d') }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label for="prioridad" class="control-label" style="white-space: nowrap; ">Prioridad:</label>
                                    <input type="text" name="prioridad" id="prioridad" class="form-control" readonly value="{{ $Ssi->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud }}">
                                </div>
                            </div>
                            @if ($Ssi->getActivo)
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="activo" class="control-label" style="white-space: nowrap; ">Activo:</label>
                                        <input type="text" name="activo" id="activo" class="form-control" readonly value="{{ $Ssi->getActivo->codigo_activo.' - '.$Ssi->getActivo->nombre_activo }}">
                                    </div>
                                </div>
                            @endif


                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            </div>
                        </div>
                        @if ($Ssi->getActivo)
                            <div class="row">
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="descrip" class="control-label" style="white-space: nowrap; ">Sintomas sobre Activo:</label>
                                        <ul class="list-group">
                                            @foreach ($Ssi->getSintomasAlt() as $grupo)
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
                        @endif

                        @if (sizeof($Ssi->getSolicitud->getArchivos) != 0 )
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="archivo" class="control-label" style="white-space: nowrap; ">Archivo/s:</label>
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
                                            @foreach ($Ssi->getSolicitud->getArchivos as $archivo)
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
                                    <label for="descrip" class="control-label" style="white-space: nowrap; ">Descripcion de la solicitud:</label>
                                    <textarea id='descrip' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Ssi->getSolicitud->descripcion_solicitud}}</textarea>
                                </div>
                            </div>
                            @if (!is_null($Ssi->getSolicitud->descripcion_urgencia))
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="descrip_urg" class="control-label" style="white-space: nowrap; ">Descripcion urgencia:</label>
                                        <textarea id='descrip_urg' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Ssi->getSolicitud->descripcion_urgencia ?? ''}}</textarea>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            {{-- ------------- --}}


            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <div class="p-2 bd-highlight">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
                                            Aceptar
                                        </button>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <form method="GET" action="{{ route('ssi.rechazar', $Ssi->getSolicitud->id_solicitud) }}">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro que desea RECHAZAR el servicio de ingenieria?');">Rechazar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@include('Ingenieria.Solicitud.SSI.modal.m-crear-servicio')
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