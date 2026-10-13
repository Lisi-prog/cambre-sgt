@extends('Ingenieria.Solicitud.layout.paginaBase')

@section('contenido')
    <div class="row m-auto pt-5">
        <div class="col-3">
        </div>
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Cambre SGI</h4>
                    Requerimiento de ingenieria.
                </div>
                <div class="card-body">
                    <form action="{{ route('ri.sa.guardar') }}" method="POST" class="formulario">
                        @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                            <div class="form-group">
                                <label for="nom_comp" class="control-label fs-7" style="white-space: nowrap;">Nombre completo:</label>
                                <span class="obligatorio">*</span>
                                <input type="text" name="nombre_completo" id="nom_comp" value="{{ old('nombre_completo') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label for="id_sector" class="control-label fs-7" style="white-space: nowrap;">Sector:</label>
                                <span class="obligatorio">*</span>
                                <select name="id_sector" id="id_sector" class="form-select" required>
                                    <option value="" {{ old('id_sector') === null || old('id_sector') === '' ? 'selected' : '' }}>Seleccionar</option>
                                    @foreach ($Sectores as $valor => $nombre)
                                        <option value="{{ $valor }}" {{ (string) old('id_sector') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="descrip" class="control-label fs-7" style="white-space: nowrap;">Descripcion:</label>
                                <span class="obligatorio">*</span>
                                <textarea name='descripcion' id="descrip" class="form-control" rows="54" cols="54" style="resize:none; height: 40vh">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
                                <span class="obligatorio">*</span>
                                <input type="date" name="fecha_req" id="fec_req" value="{{ old('fecha_req', now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ now()->year }}-12-31" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label for="selected-prioridad" class="control-label fs-7" style="white-space: nowrap;">Prioridad:</label>
                                <span class="obligatorio">*</span>
                                <select name="id_prioridad" id="selected-prioridad" class="form-select" required>
                                    <option value="" {{ old('id_prioridad') === null || old('id_prioridad') === '' ? 'selected' : '' }}>Seleccionar</option>
                                    @foreach ($Prioridades as $valor => $nombre)
                                        <option value="{{ $valor }}" {{ (string) old('id_prioridad') === (string) $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id='descrip_urgencia'>
                    </div>

                    <div class="row">
                        <div class="col-4">

                        </div>
                        <div class="col-2">
                                <button type="submit" class="btn btn-success">Enviar</button>
                        </div>
                        <div class="col-2">

                            <a href="{{ route('home') }}" class="btn btn-secondary">Limpiar</a>
                        </div>
                        <div class="col-4">

                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-3">
        </div>
    </div>
    <script src="{{ asset('js/Ingenieria/Solicitud/crear-rssi-no-au.js') }}"></script>
@endsection