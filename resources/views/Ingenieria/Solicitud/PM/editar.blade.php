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
            <form method="POST" action="{{ route('p_m.update', $pm->id_propuesta_de_mejora) }}">
                @csrf
                @method('PUT')
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion del Requerimiento de ingenieria --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="fecha_carga" class="control-label" style="white-space: nowrap; ">Fecha y hora:</label>
                                        <input type="text" name="fecha_carga" id="fecha_carga" class="form-control" readonly value="{{ old('fecha_carga', \Carbon\Carbon::parse($pm->getSolicitud->fecha_carga)->format('Y-m-d H:i')) }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="estado" class="control-label" style="white-space: nowrap; ">Estado:</label>
                                        <input type="text" name="estado" id="estado" class="form-control" readonly value="{{ old('estado', $pm->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud) }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="nom_solicitante" class="control-label" style="white-space: nowrap; ">Solicitante:</label>
                                        <input type="text" name="nom_solicitante" id="nom_solicitante" class="form-control" readonly value="{{ old('nom_solicitante', $pm->getSolicitud->nombre_solicitante) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                    <div class="form-group">
                                        <label for="titulo-propuesta" class="control-label fs-7" style="white-space: nowrap;">Titulo:</label>
                                        <span class="obligatorio">*</span>
                                        <input type="text" name="titulo-propuesta" id="titulo-propuesta" class="form-control" required value="{{ old('titulo-propuesta', $pm->titulo_propuesta) }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="nombre_emisor" class="control-label fs-7" style="white-space: nowrap;">Emisor:</label>
                                        <span class="obligatorio">*</span>
                                        <input type="text" name="nombre_emisor" id="nombre_emisor" class="form-control" required value="{{ old('nombre_emisor', $pm->nombre_emisor) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="id_activo" class="control-label fs-7" style="white-space: nowrap;">Activo:</label>
                                        {{-- <span class="obligatorio">*</span> --}}
                                        {{--    ACTIVOS    --}}
                                        <select name="id_activo" id="id_activo" class="form-select form-control">
                                            <option value="" {{ old('id_activo', $pm->id_activo) == null ? 'selected' : '' }}>Seleccionar</option>
                                            @foreach ($activos as $id => $nombre)
                                                <option value="{{ $id }}" {{ (string) old('id_activo', $pm->id_activo) === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="obj-propuesta" class="control-label fs-7" style="white-space: nowrap; ">Objetivo de la propuesta:</label>
                                        <span class="obligatorio">*</span>
                                        <textarea name='obj-propuesta' id="obj-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->objetivo_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="desc-propuesta" class="control-label fs-7" style="white-space: nowrap; ">Descripcion de la propuesta:</label>
                                        <textarea name='desc-propuesta' id="desc-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->descripcion_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="an-i-propuesta" class="control-label fs-7" style="white-space: nowrap; ">Analisis de impacto de la propuesta:</label>
                                        <textarea name='an-i-propuesta' id="an-i-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->analisis_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="bene-propuesta" class="control-label fs-7" style="white-space: nowrap; ">Beneficios de la propuesta:</label>
                                        <textarea name='bene-propuesta' id="bene-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->beneficio_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="prob-propuesta" class="control-label fs-7" style="white-space: nowrap; ">Problemas de la propuesta:</label>
                                        <textarea name='prob-propuesta' id="prob-propuesta" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$pm->problema_propuesta}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="eva-propuesta" class="control-label fs-7" style="white-space: nowrap; ">Evaluacion de la propuesta:</label>
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
            var url = '{{url('p_m')}}';
            //url = url.replace(':id_servicio', id_servicio);
            document.getElementById('volver').href = url;
        })
    </script>
@endsection