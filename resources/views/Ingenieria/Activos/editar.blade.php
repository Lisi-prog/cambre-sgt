@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar activo #{{$activo->id_codigo}}</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::model($activo, ['method' => 'PUT', 'route' => ['activos.update', $activo->id_activo], 'class' => '']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
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
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                <div class="form-group">
                                    {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <textarea name='descripcion' id="descripcion" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$activo->descripcion_activo}}</textarea>
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
                                    {!! Form::open(['method' => 'GET', 'route' => 'maquinarias.index', 'style' => '']) !!}
                                    {!! Form::submit('Cancelar', ['class' => 'btn btn-primary']) !!}
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
@endsection