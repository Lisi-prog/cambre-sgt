@extends('layouts.app')

@section('titulo', 'Editar Tarea de Mantenimiento')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Editar Tarea de Mantenimiento</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::model($tarea, ['method' => 'PUT', 'route' => ['tarea_mantenimiento.update', $tarea->id_tarea_mantenimiento], 'class' => '']   ) !!}
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    {!! Form::label('codigo_tarea', 'Código:', ['class' => 'control-label fs-7']) !!}
                                    {!! Form::text('codigo_tarea', $tarea->id_tarea_mantenimiento, ['class' => 'form-control', 'id' => 'codigo_tarea', 'disabled' => true]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                {!! Form::label('nombre_tarea', 'Nombre tarea:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::text('nombre_tarea', null, [
                                        'class' => 'form-control reset-input',
                                        'required' => 'required',
                                        'id' => 'nombre_tarea'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-check">
                                    {!! Form::hidden('en_uso', 0) !!}
                                    {!! Form::checkbox('en_uso', 1, null, ['class' => 'form-check-input', 'id' => 'en_uso']) !!}
                                    {!! Form::label('en_uso', 'En uso', ['class' => 'form-check-label']) !!}
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
                                    {!! Form::open(['method' => 'GET', 'route' => 'tarea_mantenimiento.index', 'style' => '']) !!}
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
        var url = '{{route('tarea_mantenimiento.index')}}';
        document.getElementById('volver').href = url;
    });

</script>
@endsection
