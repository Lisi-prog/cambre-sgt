@extends('layouts.app')
@section('titulo', 'Informes')

@section('content')
<style>

</style>
<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 my-auto">
                <h4 class="titulo page__heading my-auto">Informes</h5>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-4">
            </div>
        </div>
    </div>
    {{-- @include('layouts.modal.mensajes', ['modo' => 'Agregar']) --}}
    <div class="section-body">   
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['route' => 'informes.store', 'method' => 'POST', 'class' => 'formulario', 'id' => 'formulario_informe']) !!}
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('informe', 'Informe:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('id_informe', $tipos, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'id_informe',
                                            'required'
                                        ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('fec_desde', 'Fecha Desde:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::date('fecha_desde', \Carbon\Carbon::now(), [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'input-fec_ini',
                                        'class' => 'form-control',
                                        'required'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('fec_hasta', 'Fecha Hasta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::date('fecha_hasta', \Carbon\Carbon::now(), [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'input-fec_ini',
                                        'class' => 'form-control',
                                        'required'
                                    ]) !!}
                                </div>
                            </div>
                            {{-- <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('tecni', 'Tecnico:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('tecni', $tecnicos, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'id_tecni',
                                        ]) !!}
                                </div>
                            </div> --}}
                            @role('SUPERVISOR')
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('supervi', 'Supervisor:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('supervi', $supervisores, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'id_supervi',
                                            'required'
                                        ]) !!}
                                </div>
                            </div>
                            @endrole
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 my-auto">
                                <div class="form-group my-auto">
                                    <button type="submit" class="btn btn-success w-100" id="btnInforme">Generar</button>
                                    {{-- {!! Form::submit('Generar', ['class' => 'btn btn-success w-100', 'id' => 'btnInforme']) !!} --}}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="ver-informes-sin-datos" hidden>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center">
                                <div id="msj-sin-datos">
                                    <strong>
                                        <span style="border:1px solid red; background:white; color:red; padding:10px;">
                                            &nbsp; No existen datos entre las dos fechas seleccionadas. &nbsp;
                                        </span>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="ver-informes" hidden>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <a href="{{ route('exportar.excel') }}" class="btn btn-info w-100" target='_blank'>
                                    Excel
                                </a>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                {!! Form::open(['method' => 'POST', 'class' => '', 'route' => ['resumen.semanal.pdf'], 'target' => '_blank']) !!}
                                    {!! Form::text('id_tecnico', null, ['class' => 'form-control', 'id' => 'id_tecnico_pdf', 'hidden']) !!}
                                    {!! Form::text('fec_ini', null, ['class' => 'form-control', 'id' => 'fec_ini_pdf', 'hidden']) !!}
                                    {!! Form::text('fec_fin', null, ['class' => 'form-control', 'id' => 'fec_fin_pdf', 'hidden']) !!}
                                    {!! Form::submit('PDF', ['class' => 'btn btn-warning w-100']) !!}
                                {!! Form::close() !!}
                                {{-- <button class="btn btn-warning w-100">PDF</button> --}}
                            </div>
                        </div>
                        <div class="row" id="vista-grafico">

                        </div>
                        <div class="row mt-3" id="avance-subor">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function () {
            var url = '{{url('/')}}';
            document.getElementById('volver').href = url;
        });
    </script>
    <script src="{{ asset('js/Informatica/Informes/index-informes.js') }}?v={{ filemtime(public_path('js/Informatica/Informes/index-informes.js')) }}"></script>
</section>

@endsection
