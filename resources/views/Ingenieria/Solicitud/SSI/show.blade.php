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
                                        <label for="fecha_carga" class="control-label" style="white-space: nowrap; ">Fecha y hora:</label>
                                        <input type="text" name="fecha_carga" id="fecha_carga" class="form-control" readonly value="{{ \Carbon\Carbon::parse($Ssi->getSolicitud->fecha_carga)->format('Y-m-d H:i') }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="estado" class="control-label" style="white-space: nowrap; ">Estado:</label>
                                        <input type="text" name="estado" id="estado" class="form-control" readonly value="{{ $Ssi->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="nom_solicitante" class="control-label" style="white-space: nowrap; ">Solicitante:</label>
                                        <input type="text" name="nom_solicitante" id="nom_solicitante" class="form-control" readonly value="{{ $Ssi->getSolicitud->nombre_solicitante }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="prioridad" class="control-label" style="white-space: nowrap; ">Prioridad:</label>
                                        <input type="text" name="prioridad" id="prioridad" class="form-control" readonly value="{{ $Ssi->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="activo" class="control-label" style="white-space: nowrap; ">Activo:</label>
                                        <input type="text" name="activo" id="activo" class="form-control" readonly value="{{ $Ssi->getActivo->nombre_activo ?? '-' }}">
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="id_sector" class="control-label" style="white-space: nowrap; ">Sector:</label>
                                        <input type="text" name="id_sector" id="id_sector" class="form-control" readonly value="{{ $Ssi->getSector->nombre_sector }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    @if(!is_null($Ssi->getSolicitud->fecha_requerida))
                                        <div class="form-group">
                                            <label for="fecha_req" class="control-label" style="white-space: nowrap; ">Fecha requerida:</label>
                                            <input type="date" name="fecha_req" id="fecha_req" class="form-control" readonly value="{{ \Carbon\Carbon::parse($Ssi->getSolicitud->fecha_requerida)->format('Y-m-d') }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
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
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="descrip" class="control-label" style="white-space: nowrap; ">Descripcion de la solicitud:</label>
                                        <textarea name='descripcion' id='descrip' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Ssi->getSolicitud->descripcion_solicitud}}</textarea>
                                    </div>
                                </div>
                                @if (!is_null($Ssi->getSolicitud->descripcion_urgencia))
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="descrip_urg" class="control-label" style="white-space: nowrap; ">Descripcion urgencia:</label>
                                            <textarea name='descripcion_urgencia' id='descrip_urg' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Ssi->getSolicitud->descripcion_urgencia ?? ''}}</textarea>
                                        </div>    
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            var url = '{{url('/s_s_i')}}';
            document.getElementById('volver').href = url;
        });
    </script>

@endsection