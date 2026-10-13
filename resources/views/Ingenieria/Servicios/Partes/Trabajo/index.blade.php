@extends('layouts.app')
@section('titulo', 'Partes de Trabajo')
@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h4 class="titulo page__heading my-auto">Partes de Trabajo</h4>
        </div>
        <div class="ms-auto">
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <button type="button" class="btn btn-primary-outline m-1 rounded" onclick="mostrarFiltro()">Filtros <i class="fas fa-caret-down"></i></button> 
                        </div>
                        <form method="POST" action="{{ route('obtener.partes.trabajo') }}" class="formulario" id="buscar_parte_trabajo">
                        @csrf
                        <div class="row" id="demo" hidden>
                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Servicios:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('cod_serv[]', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="cod_serv[]" > (Seleccionar todo)</label>
                                                        @foreach ($flt_servicios as $proyecto)
                                                            <label><input class="input-filter" name="cod_serv[]" type="checkbox" value="{{$proyecto->id_servicio}}" > {{$proyecto->codigo_servicio}}</label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Fecha desde:</label>
                                                    </div>
                                                    {!! Form::date('fecha_desde', null, [
                                                        'min' => '2023-01-01',
                                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                                        'id' => 'fecha-desde-flt',
                                                        'class' => 'form-control'
                                                    ]) !!}
                                                    <div class="pt-3">
                                                        <label>Fecha hasta:</label>
                                                    </div>
                                                    {!! Form::date('fecha_hasta', null, [
                                                        'min' => '2023-01-01',
                                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                                        'id' => 'fecha-hasta-flt',
                                                        'class' => 'form-control'
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @role('SUPERVISOR')
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row" id='res-opcion'>
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Responsable:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('res[]', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="res[]" checked> (Seleccionar todo)</label>
                                                        @foreach ($flt_responsable as $resp)
                                                            <label><input class="input-filter" name="res[]" type="checkbox" value="{{$resp->id_empleado}}" checked> {{$resp->nombre_empleado}}</label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Supervisor:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('sup[]', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="sup[]" checked> (Seleccionar todo)</label>
                                                        @foreach ($flt_supervisor as $sup)
                                                            <label><input class="input-filter" name="sup[]" type="checkbox" value="{{$sup->id_empleado}}" checked> {{$sup->nombre_empleado}}</label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endrole
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 my-auto">
                                <button class="btn btn-success w-100" id="btn-buscar" type="submit">Buscar</button>
                                </form>
                            </div>
                        </div>                     
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm table-hover" id="tabla_parte_trabajo">
                            <thead style="background-color: #558540;">
                                <th class='text-center' style="color:#fff; width: 5%;">Cod. Parte</th>
                                <th class="text-center" scope="col" style="color:#fff;">Proyecto</th>
                                <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                                <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                                <th class="text-center" scope="col" style="color:#fff; width: 8%;">Fecha</th>
                                <th class="text-center" scope="col" style="color:#fff; width: 8%;">Fecha limite</th>
                                <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                <th class="text-center" scope="col" style="color:#fff;">Horas</th>
                                <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                                <th class="text-center" scope="col" style="color:#fff; width: 5%;">Acciones</th>
                            </thead>
                            <tbody id="accordion">
                                @php
                                    $idCount = 0;
                                @endphp
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('Ingenieria.Servicios.Partes.Trabajo.modal.ver-parte-trabajo')
<script>
    let rutaLog = "{{ route('parte.logs', ['id' => ':id']) }}";
</script>
<script src="{{ asset('js/Ingenieria/Servicios/Partes/parte-trabajo-index.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Partes/parte-trabajo-index.js')) }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Ordenes/filter.js') }}"></script>
<script src="{{ asset('js/filter-to-filter.js') }}"></script>
<script src="{{ asset('js/change-td-color.js') }}"></script>

@endsection