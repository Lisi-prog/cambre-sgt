@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <h4 class="titulo page__heading my-auto">Nueva propuesta de mejora</h4>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                {!! Form::open(['route' => 'r_i.store', 'method' => 'POST', 'class' => 'formulario']) !!}
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('selected-prioridad', 'Prioridad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('id_prioridad', $Prioridades, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'selected-prioridad',
                                            'required'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('fec_req', 'Fecha requerida:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::date('fecha_req', \Carbon\Carbon::now(), [
                                            'min' => '2023-01-01',
                                            'max' => \Carbon\Carbon::now()->year . '-12',
                                            'id' => 'fec_req',
                                            'class' => 'form-control'
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('descrip', 'Descripcion:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        <textarea name='descripcion' id="descrip" class="form-control" rows="54" cols="54" style="resize:none; height: 40vh"></textarea>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id='descrip_urgencia'>
                                    {{-- <div class="form-group">
                                        {!! Form::label('descrip', 'Descripcion:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        <textarea name='descripcion' id="descrip" class="form-control" rows="54" cols="54" style="resize:none; height: 40vh"></textarea>
                                    </div> --}}
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
                                        {!! Form::open(['method' => 'GET', 'route' => 'p_m.index', 'style' => '']) !!}
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
    <script src="{{ asset('js/Ingenieria/Solicitud/crear-rssi-no-au.js') }}"></script>
@endsection