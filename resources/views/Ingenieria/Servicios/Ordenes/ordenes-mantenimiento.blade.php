@extends('layouts.app')
@section('titulo', 'Ordenes Mantenimiento')
@section('content')

<style>
.tabla-ordenes {
    width: 100%;
    table-layout: auto;
}

.tabla-ordenes th {
    color: #fff;
    text-align: center;
    vertical-align: middle;
}

.tabla-ordenes th,
.tabla-ordenes td {
    padding: .5rem .75rem;
}

/* Reservar espacio para las columnas con textos más largos */
.tabla-ordenes .col-proyecto,
.tabla-ordenes .col-activo {
    min-width: 180px;
}

.tabla-ordenes td {
    overflow-wrap: anywhere;
}
</style>

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12 align-items-center justify-content-between">
            <!-- Título -->
            <div class="col-auto">
                <h4 class="mb-0">Ordenes de Mantenimiento</h4>
            </div>
        </div>
    </div>
    {!! Form::text('opcion_tipo', 4, ['class' => 'form-control', 'hidden', 'id' => 'opcion-tipo']) !!}

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
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 200px;">
                                            <div class="">
                                                <label>Tipo:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('flt_tip', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="flt_tip" checked> (Seleccionar todo)</label>
                                                @foreach ($flt_tipos as $tipo)
                                                    <label><input class="input-filter" name="flt_tip" type="checkbox" value="{{$tipo}}" checked> {{$tipo}}</label>
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
                                                <label>Activo:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('flt_act', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="flt_act" checked> (Seleccionar todo)</label>
                                                @foreach ($flt_activos as $act)
                                                    <label><input name="flt_act" type="checkbox" value="{{$act}}" checked> {{$act}}</label>
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
                                                <label>Estado:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('est', this)">
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label style="font-style: italic"><input name="filter" type="checkbox" value="est" checked> (Seleccionar todo)</label>
                                                {{-- ope.estado_actual == 'Espera' && ope.esta_activo ? 'Disponible' : ope.estado_actual, --}}
                                                @foreach ($flt_estados as $estado)
                                                    <label><input name="est" type="checkbox" value="{{$estado}}" {{$estado == 'Completo' || $estado == 'Rechazado' ? '' : 'checked'}}> {{$estado}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
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
                            <table class="table table-striped mt-2" id="example">
                                <thead id="encabezado_ordenes">
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
                                    <th class='text-center' style="color:#fff; width:13vw">Proyecto</th>
                                    <th class='text-center' style="color:#fff;" hidden>Proyecto</th>
                                    <th class='text-center' style="color:#fff;">Orden</th>
                                    <th class='text-center' style="color:#fff;">Tipo</th>
                                    <th class='text-center' style="color:#fff;">Activo</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Asignado</th>
                                    <th class='text-center' style="color:#fff;">Horas</th>
                                    <th class='text-center' style="color:#fff;">Fecha Finalizacion</th>
                                    <th class='text-center' style="color:#fff;">Acciones</th>
                                </thead>
                                
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($ordenes as $orden)
                                        <tr data-id="{{$orden->id_orden}}">

                                            <td class='text-center' style="vertical-align: middle;" data-order="{{$orden->prioridad_servicio ?? 999}}">{{$orden->prioridad_servicio ?? 'S/P'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$orden->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>
                                            
                                            <td class='text-center' style="vertical-align: middle;" hidden>{{$orden->codigo_servicio ?? '-'}}</td>

                                            <td class='text-start' style="vertical-align: middle;">{{$orden->nombre_orden ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{ $orden->nombre_tipo_orden_mantenimiento ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{ $orden->codigo_activo ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_estado ?? ''}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_empleado_asignado ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->horas ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->fecha_finalizacion ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenesMan{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenes{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenesMan{{$idCount}}">
                                                        <div class="row">
                                                            @switch($orden->nombre_tipo_orden_mantenimiento)
                                                                @case('DIAGNÓSTICO')
                                                                    {{-- @if ($orden->nombre_estado == 'Espera')
                                                                        <div class="col-12 my-2">
                                                                            <button type="button" class="btn btn-info w-100"
                                                                                onclick="openModalCrearParteDiagnostico({{ $orden->id_orden }}, '{{$orden->codigo_activo}}', '{{$orden->codigo_servicio}}')">
                                                                                Procesar
                                                                            </button>
                                                                        </div>
                                                                    @elseif ($orden->nombre_estado == 'En proceso')
                                                                        <div class="col-12 my-2">
                                                                            <button type="button" class="btn btn-info w-100"
                                                                                onclick="openModalParteDiagnosticoPendiente({{ $orden->id_orden }}, '{{$orden->codigo_activo}}', '{{$orden->codigo_servicio}}')">
                                                                                Procesar
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-12 my-2">
                                                                            <button type="button" class="btn btn-info w-100"
                                                                                onclick="openModalVerParteDiagnostico({{ $orden->id_orden }}, '{{$orden->codigo_activo}}')">
                                                                                Ver parte
                                                                            </button>
                                                                        </div>
                                                                    @endif --}}
                                                                    <div class="col-12 mt-1">                               
                                                                        <a target="_blank" href="/s_m_a/gestionar/{{$orden->id_servicio}}}" type="button" class="btn btn-warning w-100">
                                                                            Ir a gestionar
                                                                        </a>
                                                                    </div>
                                                                    @break
                                                                @case('INSPECCIÓN')
                                                                    {{-- @if ($orden->nombre_estado == 'Espera')
                                                                        <div class="col-12 my-2">
                                                                            <button type="button" class="btn btn-info w-100"
                                                                                onclick="openModalNuevoParteInspeccion({{ $orden->id_activo}}, {{ $orden->id_orden }}, '{{$orden->codigo_activo}}', '{{$orden->codigo_servicio}}')">
                                                                                Procesar
                                                                            </button>
                                                                        </div>
                                                                    @elseif ($orden->nombre_estado == 'En proceso')
                                                                        <div class="col-12 my-2">
                                                                            <button type="button" class="btn btn-info w-100"
                                                                                onclick="openModalParteInspeccionPendiente({{ $orden->id_activo}}, {{ $orden->id_orden }}, '{{$orden->codigo_activo}}', '{{$orden->codigo_servicio}}')">
                                                                                Procesar
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-12 my-2">                               
                                                                            <button type="button" class="btn btn-info w-100" onclick="openModalVerParteInspeccion({{$orden->id_orden}}, '{{$orden->codigo_activo}}')">
                                                                                Ver parte
                                                                            </button>
                                                                        </div>
                                                                    @endif --}}
                                                                    <div class="col-12 mt-1">                               
                                                                        <a target="_blank" href="/s_m_a/gestionar/{{$orden->id_servicio}}}" type="button" class="btn btn-warning w-100">
                                                                            Ir a gestionar
                                                                        </a>
                                                                    </div>
                                                                    @break
                                                                @case('AJUSTE')
                                                                    {{-- @if ($orden->nombre_estado == 'Espera')
                                                                        <div class="col-12 my-2">
                                                                            <button type="button" class="btn btn-info w-100"
                                                                                onclick="openModalNuevoParteAjuste({{$orden->id_orden}}, {{$orden->id_etapa}}, '{{$orden->codigo_activo}}', '{{$orden->codigo_servicio}}', '{{$orden->id_activo}}', '{{$orden->id_tipo_activo}}')">
                                                                                Procesar
                                                                            </button>
                                                                        </div>
                                                                    @elseif ($orden->nombre_estado == 'En proceso')
                                                                        <div class="col-12 my-2">
                                                                            <button type="button" class="btn btn-info w-100"
                                                                                onclick="openModalParteAjustePendiente({{$orden->id_orden}}, {{$orden->id_etapa}}, '{{$orden->codigo_activo}}', '{{$orden->codigo_servicio}}', '{{$orden->id_activo}}', '{{$orden->id_tipo_activo}}')">
                                                                                Procesar
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-12 my-2">                               
                                                                            <button type="button" class="btn btn-info w-100" onclick="openModalVerParteInspeccion({{$orden->id_orden}}, '{{$orden->codigo_activo}}')">
                                                                                Ver parte
                                                                            </button>
                                                                        </div>
                                                                    @endif --}}
                                                                    <div class="col-12 mt-1">                               
                                                                        <a target="_blank" href="/s_m_a/gestionar/{{$orden->id_servicio}}}" type="button" class="btn btn-warning w-100">
                                                                            Ir a gestionar
                                                                        </a>
                                                                    </div>
                                                                    @break
                                                                @default
                                                                    
                                                            @endswitch
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $idCount += 1;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @role('SUPERVISOR')
        @php
            $es_sup = 1;
        @endphp
    @else
        @php
            $es_sup = 0;
        @endphp
    @endrole
    
</section>

    @include('Ingenieria.Servicios.Mantenimiento.Partes.diagnostico') 
    @include('Ingenieria.Servicios.Mantenimiento.Partes.inspeccion') 
    @include('Ingenieria.Servicios.Mantenimiento.Partes.ajuste')
    @include('Ingenieria.Servicios.Mantenimiento.Modal.ver-partes')
    {{-- @include('Ingenieria.Servicios.Mantenimiento.Partes.editar_partes')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-act-serv') --}}
<script>
    
    let es_super = {{$es_sup}};
    var table;
    $("#loading").show();

    $(document).ready( function () {
        
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
            var positions = $('input:checkbox[name="flt_tip"]:checked').map(function() {
                return this.value;
            }).get();
        
            if (positions.length === 0) {
                return true;
            }
            
            if (positions.indexOf(searchData[4]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
            var positions = $('input:checkbox[name="flt_act"]:checked').map(function() {
                return this.value;
            }).get();
        
            if (positions.length === 0) {
                return true;
            }
            
            if (positions.indexOf(searchData[5]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
            var positions = $('input:checkbox[name="est"]:checked').map(function() {
                return this.value;
            }).get();
        
            if (positions.length === 0) {
                return true;
            }
            
            if (positions.indexOf(searchData[6]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        table = $('#example').DataTable({
                language: {
                        lengthMenu: 'Mostrar _MENU_ registros por pagina',
                        zeroRecords: 'No se ha encontrado registros',
                        info: 'Mostrando pagina _PAGE_ a _PAGES_ de _TOTAL_',
                        infoEmpty: 'No se ha encontrado registros',
                        infoFiltered: '(Filtrado de _MAX_ registros totales)',
                        search: 'Buscar',
                        paginate:{
                            first:"Prim.",
                            last: "Ult.",
                            previous: 'Ant.',
                            next: 'Sig.',
                        },
                    },
                    "aaSorting": [],
                    "pageLength": 100
            });
            
        $('input:checkbox').on('change', function () {
            table.draw();
        });
    
        table.on('draw', function () {
            changeTdColor();
        })

        $('#example tbody').on('click', 'tr', function () {
            ind_rw = table.row(this).index();
        });

        $("#loading").hide();
    } );
    
</script>
<script src="{{ asset('js/change-td-color.js') }}"></script>
<script src="{{ asset('js/filter-to-filter.js') }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Ordenes/filter.js') }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/diagnostico.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Mantenimiento/Partes/diagnostico.js')) }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/inspeccion.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Mantenimiento/Partes/inspeccion.js')) }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/ajuste.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Mantenimiento/Partes/ajuste.js')) }}"></script>
{{-- <script src="{{ asset('js/ope_mant_partes.js') }}?ver={{ filemtime(public_path('js/ope_mant_partes.js')) }}"></script> --}}

@endsection