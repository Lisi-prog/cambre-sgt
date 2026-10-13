@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <h4 class="titulo page__heading my-auto">Nueva propuesta de mejora</h4>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <form action="{{ route('r_i.store') }}" method="POST" class="formulario form-prevent-multiple-submits">
                @csrf
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="selected-prioridad" class="control-label fs-7" style="white-space: nowrap;">Prioridad:</label>
                                        <span class="obligatorio">*</span>
                                        <select name="id_prioridad" id="selected-prioridad" class="form-select" required>
                                            <option value="" {{ old('id_prioridad') == null ? 'selected' : '' }}>Seleccionar</option>
                                            @foreach ($Prioridades as $id => $nombre)
                                                <option value="{{ $id }}" {{ (string) old('id_prioridad') === (string) $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
                                        <span class="obligatorio">*</span>
                                        <input type="date" name="fecha_req" id="fec_req" class="form-control" min="2023-01-01" max="{{ \Carbon\Carbon::now()->year . '-12' }}" value="{{ old('fecha_req', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="descrip" class="control-label fs-7" style="white-space: nowrap; ">Descripcion:</label>
                                        <span class="obligatorio">*</span>
                                        <textarea name='descripcion' id="descrip" class="form-control" rows="54" cols="54" style="resize:none; height: 40vh"></textarea>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id='descrip_urgencia'>
                                    {{-- <div class="form-group">
                                        <label for="descrip" class="control-label fs-7" style="white-space: nowrap; ">Descripcion:</label>
                                        <span class="obligatorio">*</span>
                                        <textarea name='descripcion' id="descrip" class="form-control" rows="54" cols="54" style="resize:none; height: 40vh"></textarea>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        {{-- @can('CREAR-OBRAVIVIENDA') --}}
                                            <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                                        {{-- @endcan --}}
                                    </div>
                                    <div class="p-1">
                                        <a href="{{ route('p_m.index') }}" class="btn btn-primary">Cancelar</a>
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
    <script src="{{ asset('js/Ingenieria/Solicitud/crear-rssi-no-au.js') }}"></script>
@endsection