@extends('layouts.app')
@section('titulo', 'Operaciones de hdr')
@section('content')

<style>
    .tableFixHead {
       overflow-y: auto;
       height: 300px;
     }
     .tableFixHead thead th {
       position: sticky; 
       top: 0px;
     }
     #viv table {
       border-collapse: collapse;
       width: 100%;
     }
     
     #viv th {
       background: #ee9b27;
     } 

    #example thead input {
        width: 100%;
    }

    .btn-primary-outline {
        background-color: transparent;
        border-color: transparent;
    }

    .table {
        zoom: 100%;
    }

    table.dataTable tbody td {
        padding: 0px 10px;
    }
    .col-4 {
        padding: 5px;
    }

    #sideMenu {
      display: flex;
      gap: 0.5rem;
      transition: all 0.3s ease-in-out;
      opacity: 0;
      transform: translateX(20px);
      pointer-events: none;
    }

    #sideMenu.show {
      opacity: 1;
      transform: translateX(0);
      pointer-events: auto;
    }
</style>

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12 align-items-center justify-content-between">
            <div class="col-auto">
                <h4 class="mb-0">Operaciones</h4>
            </div>

            @php
                $ocultoMulti = '';       
            @endphp
            @role(['TECNICO'])
                @php
                    $ocultoMulti = 'd-none';   
                @endphp
            @endrole
            <div class="d-flex align-items-center {{$ocultoMulti}}">
                <div class="form-check form-switch me-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="id_selec">
                    <label class="form-check-label" for="id_selec">Seleccion<br>multiple</label>
                </div>
                <div class="form-check me-3" hidden id="chk-sel-all">
                    <input class="form-check-input" type="checkbox" value="" id="checkSelAll">
                    <label class="form-check-label" for="checkSelAll">
                    Seleccionar<br>todo
                    </label>
                </div>
                <button type="button" class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#verEditarMulti"
                                onclick="cargarEditMultiple()"
                                id="btn-edit-mul">
                            Carga<br>Multiple
                </button>
            </div>
        </div>
    </div>

    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])

    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <button type="button" class="btn btn-primary-outline m-1 rounded" onclick="mostrarFiltro('demo')">Filtros <i class="fas fa-caret-down"></i></button> 
                        </div>
                        <div class="row" id="demo" hidden>
                            <div class="row">
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="row">
                                        <div class="d-flex flex-row align-items-start justify-content-around">
                                            <div class="card-body d-flex flex-column" style="height: 200px;">
                                                <div class="">
                                                    <label>Proyectos:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('cod_serv', this)">
                                                </div>
                                                <div class="d-flex flex-column overflow-auto">
                                                    <label style="font-style: italic"><input name="filter" type="checkbox" value="cod_serv" checked> (Seleccionar todo)</label>
                                                    @foreach ($flt_proyectos as $proyecto)
                                                        <label><input class="input-filter" name="cod_serv" type="checkbox" value="{{$proyecto}}" checked> {{$proyecto}}</label>
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
                                                    <label>Operacion:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('sup', this)">
                                                </div>
                                                <div class="d-flex flex-column overflow-auto">
                                                    <label style="font-style: italic"><input name="filter" type="checkbox" value="sup" checked> (Seleccionar todo)</label>
                                                    @if (empty($flt_operaciones_tec))
                                                        @foreach ($flt_operaciones as $operacion)
                                                            <label><input name="sup" type="checkbox" value="{{$operacion}}" checked> {{$operacion}}</label>
                                                        @endforeach
                                                    @else
                                                        @foreach ($flt_operaciones as $operacion)
                                                            <label><input name="sup" type="checkbox" value="{{$operacion}}" {{in_array($operacion, $flt_operaciones_tec->toArray()) ? 'checked' : ''}}> {{$operacion}}</label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @role('SUPERVISOR')
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Maquina:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('res', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="res"> (Seleccionar todo)</label>
                                                        <label><input name="res" type="checkbox" value="-" checked> NO APLICA</label>
                                                        @foreach ($flt_maquinas as $maquina)
                                                            <label><input name="res" type="checkbox" value="{{$maquina}}"> {{$maquina}}</label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endrole
                                
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="row">
                                        <div class="d-flex flex-row align-items-start justify-content-around">
                                            <div class="card-body d-flex flex-column" style="height: 200px;">
                                                <div class="">
                                                    <label>Estados:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('est', this)">
                                                </div>
                                                <div class="d-flex flex-column overflow-auto">
                                                    <label style="font-style: italic"><input name="filter" type="checkbox" value="est" checked> (Seleccionar todo)</label>
                                                    @foreach ($flt_estados as $estado)
                                                        <label><input name="est" type="checkbox" value="{{$estado}}" {{$estado != 'Completo' && $estado != 'Descartar'  ? 'checked' : ''}}> {{$estado}}</label>
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
                                                    <label>Asignados:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('asig', this)">
                                                </div>
                                                <div class="d-flex flex-column overflow-auto">
                                                    <label style="font-style: italic"><input name="filter" type="checkbox" value="asig"> (Seleccionar todo)</label>
                                                    @role('TECNICO') 
                                                        <label><input name="asig" type="checkbox" value="-" checked> -</label>
                                                    @endrole
                                                    @foreach ($flt_tecnicos as $tec)
                                                        @role('TECNICO') 
                                                            @if (Auth::user()->getEmpleado->nombre_empleado === $tec->nombre_empleado)
                                                                <label><input name="asig" type="checkbox" value="{{$tec->nombre_empleado}}" checked> {{$tec->nombre_empleado}}</label>
                                                            @else
                                                                <label><input name="asig" type="checkbox" value="{{$tec->nombre_empleado}}"> {{$tec->nombre_empleado}}</label>
                                                            @endif
                                                        @else
                                                            <label><input name="asig" type="checkbox" value="{{$tec->nombre_empleado}}"> {{$tec->nombre_empleado}}</label>
                                                        @endrole
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column">
                                            {!! Form::label('Opciones:') !!}
                                            <div class="form-check">
                                                <input name="soloAct" class="form-check-input" type="checkbox" value="SI" id="flexOpc1" checked>
                                                <label class="form-check-label" for="flexOpc1">
                                                    Solo activos.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-secondary m-1 rounded"
                                            onclick="resetFilters()">
                                        Restablecer filtros
                                    </button>
                                </div>
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
                        @include('layouts.loanding')
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mt-2" id="example">
                                <thead id="encabezado_ordenes">
                                    <th class='text-center' style="color:#fff;max-width:2vw;" hidden id="enc_sel"></th>
                                    <th class='text-center' style="color:#fff;max-width:3vw;">Prio. Operacion</th>
                                    <th class='text-center' style="color:#fff;max-width:2vw;">Prio. Global</th>
                                    <th class='text-center' style="color:#fff;max-width:8vw;">Proyecto</th>
                                    <th class='text-center' style="color:#fff;" hidden>Proyecto</th>
                                    <th class='text-center' style="color:#fff;max-width:6vw;">Orden</th>
                                    <th class='text-center' style="color:#fff;max-width:6vw;">Operacion</th>
                                    <th class='text-center' style="color:#fff;max-width:10vw;">Maquina</th>
                                    <th class='text-center' style="color:#fff;max-width:4vw;">Estado</th>
                                    <th class='text-center' style="color:#fff;max-width:6vw;">Ultimo res.</th>
                                    <th class='text-center' style="color:#fff;max-width:6vw;">Asignado</th>
                                    <th class='text-center' style="color:#fff;">Horas</th>
                                    <th class='text-center' style="color:#fff;max-width:5vw;">Activo</th>
                                    <th class='text-center' style="color:#fff;max-width:3vw;">Cantidad</th>
                                    <th class='text-center' style="color: #fff;max-width:7vw;">Acciones</th>
                                </thead>
                                
                                <tbody id="accordion">
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="text" hidden value="{{Auth::user()->getEmpleado->id_empleado}}" id="id_emp">
</section>

@include('Ingenieria.Servicios.Mantenimiento.Partes.diagnostico') 
@include('Ingenieria.Servicios.Mantenimiento.Partes.inspeccion') 
@include('Ingenieria.Servicios.Mantenimiento.Partes.ajuste')

<div hidden>
    @include('Ingenieria.Servicios.Mantenimiento.Partes.ishikawa_select')
</div>

<script>
    const ordenHdrRoute = "{{ url('/ordenes/hdr') }}";
</script>
<script src="{{ asset('js/filter-to-filter.js') }}"></script>
<script src="{{ asset('js/change-td-color.js') }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Ordenes/filter.js') }}"></script>
<script src="{{ asset('js/ordenes_mantenimiento.js') }}"></script>
<script src="{{ asset('js/ope_mant_partes.js') }}"></script>
<script type="module" > 
        import {cargarModalVerOrden} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
        window.cargarModalVerOrden = cargarModalVerOrden;
</script>
@include('Ingenieria.Servicios.HDR.operaciones.modal.m-ver-partes')
@include('Ingenieria.Servicios.HDR.operaciones.modal.m-carga-multiple')
@include('Ingenieria.Servicios.HDR.operaciones.modal.m-ver-hdr')
@include('Ingenieria.Servicios.Ordenes.modal.ver-orden')
@endsection