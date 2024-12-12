@extends('layouts.app')

@section('titulo', 'Editar maquinaria')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar maquinaria #{{$maquinaria->id_maquinaria}}</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::model($maquinaria, ['method' => 'PUT', 'route' => ['maquinarias.update', $maquinaria->id_maquinaria], 'class' => '']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('codigo_maquinaria', 'Codigo maquinaria:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('codigo_maquinaria', $maquinaria->codigo_maquinaria, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'id' => 'codigo_maquinaria'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('alias_maquinaria', 'Alias maquinaria:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('alias_maquinaria', $maquinaria->alias_maquinaria, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'id' => 'alias_maquinaria'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('id_tipo', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::select('id_tipo', $tipos, $maquinaria->id_tipo_maquinaria ?? null, [
                                        'placeholder' => 'Seleccionar',
                                        'class' => 'form-select reset-input',
                                        'id' => 'id_tipo'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                <div class="form-group">
                                    {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <textarea name='descripcion' id="descripcion" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh">{{$maquinaria->descripcion_maquinaria}}</textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    {!! Form::label('id_sector', 'Sector:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::select('id_sector', $sectores, $maquinaria->id_sector, [
                                        'placeholder' => 'Seleccionar',
                                        'class' => 'form-select',
                                        'id' => 'id_sector'
                                    ]) !!}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('ope', 'Operaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <div class="d-flex flex-column overflow-auto"
                                    style="height: 100px;">
                                        @foreach ($operaciones as $op)
                                            <div class="form-check">
                                                <input name="operaciones[]" class="form-check-input" type="checkbox" value="{{$op->id_operacion}}" id="ope{{$op->id_operacion}}" {{in_array($op->id_operacion, $maquinaria->getOpemaq->pluck('id_operacion')->toArray()) ? 'checked' : ''}}>
                                                <label class="form-check-label" for="ope{{$op->id_operacion}}">
                                                {{$op->nombre_operacion}}
                                                </label>
                                            </div>
                                        @endforeach
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
                                    {!! Form::open(['method' => 'GET', 'route' => 'maquinarias.index', 'style' => '']) !!}
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