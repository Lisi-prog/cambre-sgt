@extends('layouts.app')

@section('titulo', 'Asignar Tipo')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h5 class="titulo page__heading my-auto mr-5">Asignar Zona a Tipo Activo</h5>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        {!! Form::open(['route' => ['zona.asignar.tipo.guardar', $zona->id_zona], 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('zona', 'Tipo Síntoma:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('zona', $zona->nombre_zona, [
                                        'class' => 'form-control',
                                        'id' => 'zona',
                                        'readonly'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                {!! Form::label('sbti', 'Sub-Tipos:', ['class' => 'form-label']) !!}
                                @php
                                    $subtipoasig = $zona->getIdTipos()->toArray();
                                @endphp
                                @foreach ($tipos as $t)
                                    <div class="form-check">
                                        <input name="subtipo[]" class="form-check-input" type="checkbox" value="{{$t->id_tipo_activo}}" id="checkDefault{{$t->id_tipo_activo}}" {{in_array($t->id_tipo_activo, $subtipoasig) ? 'checked' : ''}}>
                                        <label class="form-check-label" for="checkDefault{{$t->id_tipo_activo}}">
                                        {{$t->nombre_tipo_activo}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="d-flex">
                                <div class="me-auto">
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
        var url = '{{route('zona.index')}}';
        document.getElementById('volver').href = url;
    });
</script>
@endsection