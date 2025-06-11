@extends('layouts.app')

@section('titulo', 'Editar Tipo Activo')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar Tipo Activo #{{$ta->id_tipo_activo}}</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::model($ta, ['method' => 'PUT', 'route' => ['tipo_activo.update', $ta->id_tipo_activo], 'class' => '']) !!}
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('tipo_activo', 'Tipo Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('tipo_activo', $ta->nombre_tipo_activo, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'id' => 'tipo_activo'
                                    ]) !!}
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
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                    {{-- @endcan --}}
                                    {!! Form::close() !!}
                                </div>
                                <div class="p-1">
                                    {!! Form::open(['method' => 'GET', 'route' => 'tipo_activo.index', 'style' => '']) !!}
                                    {!! Form::submit('Cancelar', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        var url = '{{route('activos.index')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
    });
</script>
@endsection