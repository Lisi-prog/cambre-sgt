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
        {!! Form::model($prefijo, ['method' => 'PUT', 'route' => ['prefijo_proyecto.update', $prefijo->id_prefijo_proyecto], 'class' => '']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('nombre_prefijo', 'Nombre prefijo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('nombre_prefijo', $prefijo->nombre_prefijo_proyecto, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'style' => 'text-transform:uppercase',
                                        'id' => 'nombre_prefijo'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <textarea name='descripcion' id="descripcion" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$prefijo->descripcion_prefijo_proyecto}}</textarea>
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
                                    {!! Form::open(['method' => 'GET', 'route' => 'prefijo_proyecto.index', 'style' => '']) !!}
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
@endsection