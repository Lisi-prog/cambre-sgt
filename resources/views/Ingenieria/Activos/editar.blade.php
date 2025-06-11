@extends('layouts.app')

@section('titulo', 'Editar activo')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar activo #{{$activo->id_activo}}</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::model($activo, ['method' => 'PUT', 'route' => ['activos.update', $activo->id_activo], 'class' => '']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('codigo_activo', 'Codigo activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('codigo_activo', $activo->codigo_activo, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'style' => 'text-transform:uppercase',
                                        'id' => 'codigo_activo'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                <div class="form-group">
                                    {!! Form::label('nombre_activo', 'Nombre activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('nombre_activo', $activo->nombre_activo, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'id' => 'nombre_activo'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <div class="form-group">
                                    {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <textarea name='descripcion' id="descripcion" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$activo->descripcion_activo}}</textarea>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            {!! Form::label('tipo_activo', "Tipo Activo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::select('tipo_activo', $tipos_activo, $activo->id_tipo_activo ?? null, [
                                                    'class' => 'form-select form-control',
                                                    'id' => 'tip_act',
                                                    'placeholder' => 'Seleccionar'
                                                ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            {!! Form::label('est_act', "¿Esta Activo?:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::select('esta_activo', [0 => 'NO', 1 => 'SI'], $activo->esta_activo, [
                                                            'class' => 'form-select form-control',
                                                            'id' => 'est_act',
                                                            'required'
                                                        ]) !!}
                                        </div>
                                    </div>
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
                                    {!! Form::open(['method' => 'GET', 'route' => 'activos.index', 'style' => '']) !!}
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