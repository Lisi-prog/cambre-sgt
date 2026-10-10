@extends('layouts.app')
@section('titulo', 'Editar R.I.')
@section('content')
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Editar Servicio de ingenieria #{{$Ssi->getSolicitud->id_solicitud}}</div>
            </div>
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('s_s_i.update', $Ssi->getSolicitud->id_solicitud) }}">
            @csrf
            @method('PUT')
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
                                        <input type="text" name="fecha_carga" id="fecha_carga" class="form-control" readonly value="{{ old('fecha_carga', \Carbon\Carbon::parse($Ssi->getSolicitud->fecha_carga)->format('Y-m-d H:i')) }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="estado" class="control-label" style="white-space: nowrap; ">Estado:</label>
                                        <input type="text" name="estado" id="estado" class="form-control" readonly value="{{ old('estado', $Ssi->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud) }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="nom_solicitante" class="control-label" style="white-space: nowrap; ">Solicitante:</label>
                                        <input type="text" name="nom_solicitante" id="nom_solicitante" class="form-control" readonly value="{{ old('nom_solicitante', $Ssi->getSolicitud->nombre_solicitante) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="prioridad" class="control-label" style="white-space: nowrap; ">Prioridad:</label>
                                        <input type="text" name="prioridad" id="prioridad" class="form-control" readonly value="{{ old('prioridad', $Ssi->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud) }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="id_activo" class="control-label" style="white-space: nowrap; ">Activo:</label>
                                        <select name="id_activo" id="id_activo" class="form-select form-control">
                                            <option value="" {{ old('id_activo', $Ssi->id_activo) == null ? 'selected' : '' }}>Seleccionar</option>
                                            @foreach ($activos as $id => $nombre)
                                                <option value="{{ $id }}" {{ (string) old('id_activo', $Ssi->id_activo) === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="id_sector" class="control-label" style="white-space: nowrap; ">Sector:</label>
                                        <input type="text" name="id_sector" id="id_sector" class="form-control" readonly value="{{ old('id_sector', $Ssi->getSector->nombre_sector) }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    @if(!is_null($Ssi->getSolicitud->fecha_requerida))
                                        <div class="form-group">
                                            <label for="fecha_req" class="control-label" style="white-space: nowrap; ">Fecha requerida:</label>
                                            <input type="date" name="fecha_req" id="fecha_req" class="form-control" required value="{{ old('fecha_req', \Carbon\Carbon::parse($Ssi->getSolicitud->fecha_requerida)->format('Y-m-d')) }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="descrip" class="control-label" style="white-space: nowrap; ">Descripcion de la solicitud:</label>
                                        <textarea name='descripcion' id='descrip' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" required>{{$Ssi->getSolicitud->descripcion_solicitud}}</textarea>
                                    </div>
                                </div>
                                @if (!is_null($Ssi->getSolicitud->descripcion_urgencia))
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="descrip_urg" class="control-label" style="white-space: nowrap; ">Descripcion urgencia:</label>
                                            <textarea name='descripcion_urgencia' id='descrip_urg' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" required>{{$Ssi->getSolicitud->descripcion_urgencia ?? ''}}</textarea>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @php
                    $id_estado_aceptado = Config::get('myconfig.estado_solicitud_aceptado')
                @endphp
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        @if ($Ssi->getSolicitud->id_estado_solicitud < $id_estado_aceptado)
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-5 d-flex">
                                    <div class="ms-auto">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
    <script>
        $(document).ready(function () {
                var url = '{{url('s_s_i')}}';
                //url = url.replace(':id_servicio', id_servicio);
                document.getElementById('volver').href = url;
        })
    </script>
@endsection
