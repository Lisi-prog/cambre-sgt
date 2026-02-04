@extends('layouts.app')

@section('titulo', 'Editar Causa - Diagrama de Ishikawa')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar Causa - Diagrama de Ishikawa</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::model($causa, ['method' => 'PUT', 'route' => ['ishikawa_causa.update', $causa->id_ishikawa_causa], 'class' => '']   ) !!}
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('nombre_causa', 'Nombre Causa:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('nombre_causa', $causa->nombre_causa, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'id' => 'nombre_causa'
                                    ]) !!}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('ishikawa_categoria', "Categoría:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('ishikawa_categoria', $categorias->pluck('nombre_categoria', 'id_ishikawa_categoria'), $causa->id_ishikawa_categoria, [
                                                    'class' => 'form-select form-control',
                                                    'id' => 'ishikawa_categoria',
                                                    'placeholder' => 'Seleccionar',
                                                    'required'
                                    ]) !!}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('explicacion_causa', 'Explicación Causa:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::textarea('explicacion_causa', $causa->explicacion, [
                                        'class' => 'form-control',
                                        'id' => 'explicacion_causa',
                                        'rows' => 3
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
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="p-1">
                                    {!! Form::open(['method' => 'GET', 'route' => 'ishikawa_causa.index', 'style' => '']) !!}
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
        var url = '{{route('tipo_sintoma.index')}}';
        document.getElementById('volver').href = url;
    });
</script>
@endsection