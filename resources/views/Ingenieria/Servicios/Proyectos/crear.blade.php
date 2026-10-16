@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Nuevo proyecto</div>
        </div>
        <div class="section-body">
            <div class="row">
                <form action="{{ route('proyectos.store') }}" method="POST" class="formulario">
                    @csrf
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="codigo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Codigo proyecto:</label>
                                        <span class="obligatorio">*</span>
                                        <input type="text" name="codigo_proyecto" id="codigo_proyecto" value="{{ old('codigo_proyecto') }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                    <div class="form-group">
                                        <label for="nombre_proyecto" class="control-label fs-7" style="white-space: nowrap;">Nombre proyecto:</label>
                                        <span class="obligatorio">*</span>
                                        <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="{{ old('nombre_proyecto') }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="id_tipo_proyecto" class="control-label fs-7" style="white-space: nowrap;">Tipo:</label>
                                        <span class="obligatorio">*</span>
                                        <select name="id_tipo_proyecto" id="id_tipo_proyecto" class="form-select" required>
                                            <option value="" {{ old('id_tipo_proyecto') === null || old('id_tipo_proyecto') === '' ? 'selected' : '' }}>Seleccionar</option>
                                            @foreach ($Tipos_servicios as $valor => $nombre)
                                                <option value="{{ $valor }}" {{ (string) old('id_tipo_proyecto') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2" id="fecha_req">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="lider" class="control-label fs-7" style="white-space: nowrap;">Lider:</label>
                                        <span class="obligatorio">*</span>
                                        <select name="lider" id="lider" class="form-select" required>
                                            <option value="" {{ old('lider') === null || old('lider') === '' ? 'selected' : '' }}>Seleccionar</option>
                                            @foreach ($empleados as $valor => $nombre)
                                                <option value="{{ $valor }}" {{ (string) old('lider') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
                                        <span class="obligatorio">*</span>
                                        <input type="date" name="fecha_ini" id="fec_ini" value="{{ old('fecha_ini', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
                                        <span class="obligatorio">*</span>
                                        <input type="date" name="fecha_req" id="fec_req" value="{{ old('fecha_req', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="prioridad" class="control-label fs-7" style="white-space: nowrap;">Prioridad:</label>
                                        <span class="obligatorio">*</span>
                                        <select name="prioridad" id="prioridad" class="form-select" required>
                                            <option value="" {{ old('prioridad') === null || old('prioridad') === '' ? 'selected' : '' }}>Seleccionar</option>
                                            @foreach ($prioridades as $valor => $nombre)
                                                <option value="{{ $valor }}" {{ (string) old('prioridad') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>







                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">

                                            <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                    <div class="p-1">
                                        <a href="{{ route('r_i.index') }}" class="btn btn-primary">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>

@endsection