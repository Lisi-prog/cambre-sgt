@extends('Ingenieria.Solicitud.layout.paginaBase')

@section('contenido')
    <div class="row m-auto pt-5">
        <div class="col-3">
        </div>
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Cambre SGI</h4>
                    Solicitud de servicio de ingenieria.
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'ssi.sa.guardar', 'method' => 'POST', 'class' => 'formulario']) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                            <div class="form-group">
                                {!! Form::label('nom_comp', 'Nombre completo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::text('nombre_completo', null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'id' => 'nom_comp'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                {!! Form::label('id_Sector', 'Sector:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::select('id_sector', $Sectores, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select',
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                {!! Form::label('descrip', 'Descripcion:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                <span class="obligatorio">*</span>
                                <textarea name='descripcion' id="descrip" class="form-control" rows="54" cols="54" style="resize:none; height: 40vh"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
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
                    </div>

                    <div class="row" id='descrip_urgencia'>
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                {!! Form::label('desc_urg', 'Descripcion urgencia', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                <span class="obligatorio">*</span>
                                <textarea id='desc_urg' name='descripcion_urgencia' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh"></textarea>
                            </div>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-4">

                        </div>
                        <div class="col-2">
                                {!! Form::submit('Enviar', ['class' => 'btn btn-success']) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="col-2">
                            
                            {!! Form::open(['method' => 'GET', 'route' => ['home'], 'style' => '']) !!}
                            {!! Form::submit('Limpiar', ['class' => 'btn btn-secondary']) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="col-4">

                        </div>
                        
                    </div>                   
                </div>
            </div>
        </div>
        <div class="col-3">
        </div>
    </div>
    <script src="{{ asset('js/Ingenieria/Solicitud/crear-rssi-no-au.js') }}"></script>
@endsection