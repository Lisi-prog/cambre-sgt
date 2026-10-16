@extends('layouts.app')

@section('titulo', 'Editar prefijo proyecto')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar prefijo proyecto #{{$prefijo->id_prefijo_proyecto}}</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <form action="{{ route('prefijo_proyecto.update', $prefijo->id_prefijo_proyecto) }}" method="POST">
            @csrf
            @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="nombre_prefijo" class="control-label fs-7" style="white-space: nowrap;">Nombre prefijo proyecto:</label>
                                    <span class="obligatorio">*</span>
                                    <input type="text" name="nombre_prefijo" id="nombre_prefijo" value="{{ old('nombre_prefijo', $prefijo->nombre_prefijo_proyecto) }}" class="form-control" style="text-transform:uppercase" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="descripcion" class="control-label" style="white-space: nowrap;">Descripcion:</label>
                                    <textarea name='descripcion' id="descripcion" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{ old('descripcion', $prefijo->descripcion_prefijo_proyecto) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="d-flex">
                                <div class="me-auto">
                                    (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                </div>
                                <div class="p-1">
                                    {{-- @can('CREAR-OBRAVIVIENDA') --}}
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    {{-- @endcan --}}
                                </div>
                                <div class="p-1">
                                    <a href="{{ route('prefijo_proyecto.index') }}" class="btn btn-danger">Cancelar</a>
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
@endsection