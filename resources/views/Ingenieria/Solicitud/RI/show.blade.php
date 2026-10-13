@extends('layouts.app')
@section('titulo', 'Ver R.I.')

@section('content')
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Ver Requerimiento de ingenieria #{{$Req_ing->getSolicitud->id_solicitud}}</div>
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
                            <div class="text-center"><h5>Requerimiento de ingenieria</h5></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="fecha_carga" class="control-label" style="white-space: nowrap;">Fecha y hora:</label>
                                        <input type="text" name="fecha_carga" id="fecha_carga" value="{{ \Carbon\Carbon::parse($Req_ing->getSolicitud->fecha_carga)->format('Y-m-d H:i') }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="estado" class="control-label" style="white-space: nowrap;">Estado:</label>
                                        <input type="text" name="estado" id="estado" value="{{ $Req_ing->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud }}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="prioridad" class="control-label" style="white-space: nowrap;">Prioridad:</label>
                                        <input type="text" name="prioridad" id="prioridad" value="{{ $Req_ing->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="nom_solicitante" class="control-label" style="white-space: nowrap;">Solicitante:</label>
                                        <input type="text" name="nom_solicitante" id="nom_solicitante" value="{{ $Req_ing->getSolicitud->nombre_solicitante }}" class="form-control" readonly>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="id_sector" class="control-label" style="white-space: nowrap;">Sector:</label>
                                        <input type="text" name="id_sector" id="id_sector" value="{{ $Req_ing->getSector->nombre_sector }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    @if(!is_null($Req_ing->getSolicitud->fecha_requerida))
                                        <div class="form-group">
                                            <label for="fecha_req" class="control-label" style="white-space: nowrap;">Fecha requerida:</label>
                                            <input type="text" name="fecha_req" id="fecha_req" value="{{ \Carbon\Carbon::parse($Req_ing->getSolicitud->fecha_requerida)->format('d-m-Y') }}" class="form-control" readonly>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="descrip" class="control-label" style="white-space: nowrap;">Descripcion de la solicitud:</label>
                                        <textarea id='descrip' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Req_ing->getSolicitud->descripcion_solicitud}}</textarea>
                                    </div>
                                </div>
                                @if (!is_null($Req_ing->getSolicitud->descripcion_urgencia))
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="descrip_urg" class="control-label" style="white-space: nowrap;">Descripcion urgencia:</label>
                                            <textarea id='descrip_urg' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Req_ing->getSolicitud->descripcion_urgencia ?? ''}}</textarea>
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
                                <div class="col-5">

                                </div>
                                <div class="col-2">
                                    <div class="row">
                                    </div>
                                </div>
                                <div class="col-5 d-flex">
                                    <div class="ms-auto">
                                        <a href="{{ route('r_i.index') }}" class="btn btn-primary">Volver</a>
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