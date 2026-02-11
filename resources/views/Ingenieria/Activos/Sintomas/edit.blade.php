@extends('layouts.app')

@section('titulo', 'Editar Síntoma')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar Síntoma</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::model($sintoma, ['method' => 'PUT', 'route' => ['sintoma.update', $sintoma->id_sintoma], 'class' => '']   ) !!}
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('nombre_sintoma', 'Nombre Síntoma:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('nombre_sintoma', $sintoma->nombre_sintoma, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'id' => 'nombre_sintoma'
                                    ]) !!}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group
                                    {!! Form::label('tipo_sintoma', "Tipo de síntoma:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('tipo_sintoma', $tipos_sintomas->pluck('nombre_tipo_sintoma', 'id_tipo_sintoma'), $sintoma->id_tipo_sintoma, [
                                                    'class' => 'form-select form-control',
                                                    'id' => 'tipo_sintoma',
                                                    'placeholder' => 'Seleccionar',
                                                    'required'
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
        var url = '{{route('tipo_sintoma.index')}}';
        document.getElementById('volver').href = url;
    });
</script>
@endsection