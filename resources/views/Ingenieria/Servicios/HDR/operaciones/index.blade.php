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
            <!-- Título -->
            <div class="col-auto">
                <h4 class="mb-0">Operaciones de HDR</h4>
            </div>

            <!-- Botón y menú desplegable -->
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
                                                    {{-- @foreach ($flt_operaciones as $operacion)
                                                        <label><input name="sup" type="checkbox" value="{{$operacion}}" checked> {{$operacion}}</label>
                                                    @endforeach --}}
                                                    {{-- @foreach ($operaciones as $operacion)
                                                        <label><input name="sup" type="checkbox" value="{{$operacion->nombre_operacion}}" {{in_array($operacion->nombre_operacion, $flt_operaciones) ? 'checked' : ''}}> {{$operacion->nombre_operacion}}</label>
                                                    @endforeach --}}
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
                                                        <label><input name="asig" type="checkbox" value="{{$tec->nombre_empleado}}"> {{$tec->nombre_empleado}}</label>
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
                        </div>   
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        {!! Form::label('Opciones:') !!}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexOpc1" checked>
                            <label class="form-check-label" for="flexOpc1">
                              Solo activos.
                            </label>
                          </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                        {{-- @if (count($ordenes) != 0)
                            <div class="pagination justify-content-end">
                                {!! $ordenes->links() !!}
                            </div>
                        @endif --}}
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
                                    {{-- <th class='text-center' style="color:#fff;max-width:5vw">Fecha limite</th> --}}
                                    {{-- <th class='text-center' style="color:#fff;max-width:5vw">Fecha finalizacion</th> --}}
                                    <th class='text-center' style="color:#fff;max-width:5vw;">Activo</th>
                                    <th class='text-center' style="color:#fff;max-width:3vw;">Cantidad</th>
                                    <th class='text-center' style="color: #fff;max-width:7vw;">Acciones</th>
                                </thead>
                                
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($operaciones as $ope)
                                     <tr data-id="{{$ope->id_ope_de_hdr}}" class="my-auto">
                                        {{-- <tr data-id="{{$ope->id_ope_de_hdr}}"> --}}
                                            <td hidden class="chk-input" style="vertical-align: middle; padding: 0;">
                                                <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                                <input class="form-check-input" type="checkbox" value="{{$ope->id_ope_de_hdr}}" id="flexCheck{{$ope->id_ope_de_hdr}}" name="id_ope[]">
                                                </div>
                                            </td>

                                            <td class='text-center' style="vertical-align: middle;" data-order="{{$ope->prioridad ?? 999}}">{{$ope->prioridad ?? 'S/P'}}</td>

                                            <td class='text-center' style="vertical-align: middle;" data-order="{{$ope->prioridad_servicio ?? 999}}">{{$ope->prioridad_servicio ?? 'S/P'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$ope->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$ope->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>
                                            
                                            <td class='text-center' style="vertical-align: middle;" hidden>{{$ope->codigo_servicio ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$ope->nombre_orden ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$ope->nombre_operacion ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$ope->codigo_maquinaria ?? '-'}}</td>

                                            {{-- <td class='text-center' style="vertical-align: middle;"><abbr title='{{$orden->descripcion_etapa}}' style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 20)}} <i class="fas fa-eye"></abbr></td> --}}
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$ope->nombre_estado_hdr ?? '-'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$ope->ultimo_res ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$ope->tecnico_asignado ?? '-'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$ope->total_horas ?? '-'}}</td>

                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$ope->fecha_limite ?? '-'}}</td> --}}

                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$ope->fecha_finalizacion ?? '-'}}</td> --}}

                                            <td class='text-center' style="vertical-align: middle;">{{$ope->activo ? 'SI' : 'NO'}}</td>
        
                                            <td class='text-center' style="vertical-align: middle;">{{$ope->cantidad ?? ''}}</td>

                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenes{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                     <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenes{{$idCount}}">
                                                        @if ($ope->id_hoja_de_ruta)
                                                            <div class="row my-2">
                                                                <div class="col-12">
                                                                    <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden({{$ope->getHdr->getOrdMec->id_orden}}, {{3}})">
                                                                        Ver Ord Mec
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesOpeHdrModal" onclick="cargarModalVerPartesOpe({{$ope->id_ope_de_hdr}})">
                                                                    Partes
                                                                </button>
                                                            </div>
                                                        </div>
                                                        @role('SUPERVISOR') 
                                                        @if ($ope->getHdr)
                                                            <div class="row my-2">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['ordenes.hdr', $ope->getHdr->getOrdMec->id_orden], 'style' => 'display:inline', 'target' => '_blank']) !!}
                                                                        {!! Form::submit('HDR', ['class' => 'btn btn-info w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @endrole
                                                        @if ($ope->getHdr)
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#verHdrOpe" onclick="cargarHdrVer({{$ope->getHdr->id_hoja_de_ruta}})">
                                                                    Ver HDR
                                                                </button>
                                                            </div>
                                                        </div>
                                                        @endif
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

    <script src="{{ asset('js/change-td-color.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/filter.js') }}"></script>
    {{-- <script src="{{ asset('js/change-td-color.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/filter.js') }}"></script>
    <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/ordenes.js') }}"></script>
    <script src="{{ asset('js/filter-to-filter.js') }}"></script>
    <script type="module" > 
        import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes, modificarFormularioConArgumentos, cargarModalEditarOrden, colorEncabezadoPorTipoDeOrden} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
        window.crearCuadrOrdenes = crearCuadrOrdenes;
        window.cargarModalVerOrden = cargarModalVerOrden;
        window.obtenerPartes = obtenerPartes;
        window.modificarFormularioConArgumentos= modificarFormularioConArgumentos;
        window.cargarModalEditarOrden = cargarModalEditarOrden;
        window.colorEncabezadoPorTipoDeOrden = colorEncabezadoPorTipoDeOrden;
    </script> --}}
</section>

@include('Ingenieria.Servicios.HDR.operaciones.modal.m-ver-partes')
@include('Ingenieria.Servicios.HDR.operaciones.modal.m-carga-multiple')
@include('Ingenieria.Servicios.HDR.operaciones.modal.m-ver-hdr')
@include('Ingenieria.Servicios.Ordenes.modal.ver-orden')
{{-- @include('Ingenieria.Servicios.Ordenes.modal.editar-orden')
@include('Ingenieria.Servicios.Ordenes.modal.ver-partes') --}}

<script type="module" > 
        import {cargarModalVerOrden} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
        window.cargarModalVerOrden = cargarModalVerOrden;
</script>

<script>
    function mostrarFiltro(id){
        let cuadro_filtro = document.getElementById(id);
        if ($('#'+id).is(":hidden")) {
            cuadro_filtro.hidden = false;
        }else{
            cuadro_filtro.hidden = true;
        }
    }

    function limpiarFiltro(){
        $('input[type=checkbox]').prop("checked", false);
        var table = $('#example').DataTable();
        table.draw();
    }

    function mostrarSelec() {
        let colum_sel = document.getElementsByClassName('chk-input');
        let enca = document.getElementById('enc_sel');
        let chk_sel_all = document.getElementById('chk-sel-all');

        if ($("#id_selec").is(":checked")) {
            enca.hidden = false;
            chk_sel_all.hidden = false;
            table.rows().nodes().to$().find('td.chk-input').removeAttr('hidden');
            // Mostrar la columna de checkboxes
            table.column('.chk-input', { search: 'applied' }).visible(true);
        } else {
            enca.hidden = true;
            chk_sel_all.hidden = true;
            table.rows().nodes().to$().find('td.chk-input').attr('hidden', true);
            // Ocultar la columna de checkboxes
            table.column('.chk-input', { search: 'applied' }).visible(false);
        }

    }
    function cargarMultiple(){
        let ids = document.getElementById('m-parte-multiple-ids');
        let valores = [...document.querySelectorAll('input[name="id_ordenes[]"]:checked')].map(input => input.value);
        ids.value = valores;
        cargarEstadosMecanizados();
        let html = '';
        $.ajax({
            type: "post",
            url: '/orden/obtener-info-orden-mul',
            data: {
                id: valores,
            },
            success: function (response) {
                response.forEach(e => {
                    html += `<tr>
                                <td class="text-center" style="vertical-align: middle;">`+e.proyecto+`</td>
                                <td class="text-center" style="vertical-align: middle;">`+e.orden+`</td>
                            </tr>`;
                });

                document.getElementById('npm_body_ord').innerHTML = html;
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function cargarEditMultiple(){
        let ids = document.getElementById('m-edit-multiple-ids');
        let ids_pm = document.getElementById('m-parte-multiple-ids');
        let valores = [...document.querySelectorAll('input[name="id_ope[]"]:checked')].map(input => input.value);
        ids.value = valores;
        ids_pm.value = valores;
        cargarEstadosOperaciones();
        let html = '';
        $.ajax({
            type: "post",
            url: '/orden/obtener-info-ope-mul',
            data: {
                id: valores,
            },
            success: function (response) {
                response.forEach(e => {
                    html += `<tr>
                                <td class="text-center" style="vertical-align: middle;">`+e.proyecto+`</td>
                                <td class="text-center" style="vertical-align: middle;">`+e.orden+`</td>
                                <td class="text-center" style="vertical-align: middle;">`+e.operacion+`</td>
                            </tr>`;
                });

                document.getElementById('nom_body_ope').innerHTML = html;
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function cargarEstadosOperaciones(){
        let cbxEstOpe = document.getElementById('m-ver-parte-ope-estado');
        let html = '<option value="">Seleccionar</option>';
        $.ajax({
            type: "post",
            url: '/parte/obtener-est-parte-ope',
            data: {
                id: 'a',
            },
            success: function (res) {
                res.forEach(e => {
                    html += `<option value="${e.id_estado_hdr}">${e.nombre_estado_hdr}</option>`;
                });

                cbxEstOpe.innerHTML += html;
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
    // function DeseleccionarTodo()´{
    //     document.querySelectorAll('input[type="checkbox"][name="id_ope[]"]').forEach(function(checkbox) {
    //         checkbox.checked = false;
    //     });
    // }

    // function selecDesTodo(){

    // }

</script>

<script>
    let x = '';
    let ind_rw = '';
    let id_emp = {{Auth::user()->getEmpleado->id_empleado}};
    let b;
    
    var table;
    $(document).ready( function () {
        
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        //dudoso
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'orden';

        $.when($.ajax({
            type: "post",
            url: '/documentacion/obtener/'+nombreArchivo, 
            data: {
                nombreArchivo: nombreArchivo,
            },
            success: function (response) {
                document.getElementById('ayudin').href = "{{url('/')}}"+'/'+response;
            },
            error: function (error) {
                console.log(error);
            }
        }));
        
        // let tipo_orden = window.location.pathname.substring(9, 10);
        // modificarFormularioConArgumentos(tipo_orden, 'formulario-editar-orden', true);
        // document.getElementById('encabezado_ordenes').style.backgroundColor = colorEncabezadoPorTipoDeOrden(tipo_orden);
        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
            var positions = $('input:checkbox[name="sup"]:checked').map(function() {
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

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="res"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[7]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="est"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[8]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="cod_serv"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }


            if (offices.indexOf(searchData[4]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
                  var offices = $('input:checkbox[name="soloAct"]:checked').map(function() {
                return this.value;
            }).get();
                  if (offices.length === 0) {
                return true;
            }
          if (offices.indexOf(searchData[12]) !== -1) {
                return true;
            }
         
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
                  var offices = $('input:checkbox[name="asig"]:checked').map(function() {
                return this.value;
            }).get();
                  if (offices.length === 0) {
                return true;
            }
          if (offices.indexOf(searchData[10]) !== -1) {
                return true;
            }
         
            return false;
            }
        );

        $.fn.dataTable.ext.order['custom-prioridad'] = function  ( settings, col ) {
            return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
                var val = $(td).text();
                if (val === 'S/P') return 999;   // empuja S/P al final
                return parseInt(val) || 0;       // números normales
            });
        };

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
                columnDefs: [
                    { targets: 1 }, // Prio. Operacion
                    { targets: 2 }  // Prio. Global
                ],
                // order: [[ 1, 'asc' ], [2, 'asc']],
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
        // let a = table.row(this).index();
        // var temp = table.row(a).data();
        // temp[0] = 'Tom';
        // table.row(this)
        // .data(temp)
        // .draw();
   });

    $('#verPartesModal').on('hidden.bs.modal', function (e) {
        nuevoParte();
        actRow();
    })

    $('#editarOrdenModal').on('hidden.bs.modal', function (e) {
        actRow();
    })


    // $(".nuevo-editar-parte").on('submit', function(evt){
    //         evt.preventDefault();     
    //         var url_php = $(this).attr("action"); 
    //         var type_method = $(this).attr("method"); 
    //         var form_data = $(this).serialize();
    //         let html = '';
    //         let id_orden = document.getElementById('m-ver-parte-orden').value;
    //         $.ajax({
    //             type: type_method,
    //             url: url_php,
    //             data: form_data,
    //             success: function(data) {
    //                 opcion = parseInt(data.resultado);
    //                 switch (opcion) {
    //                     case 1:
    //                         html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
    //                                         Parte creado con exito
    //                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                                             <span aria-hidden="true">&times;</span>
    //                                         </button>
    //                                     </div>`;
    //                         break;
    //                     case 2:
    //                         id = document.getElementById('m-id-parte').value;
    //                         html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
    //                                         Parte cod. `+id+` actualizado con exito
    //                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                                             <span aria-hidden="true">&times;</span>
    //                                         </button>
    //                                     </div>`;
    //                         break;
    //                     case 6:
    //                         html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
    //                                     No se puede actualizar un parte de la cual no eres responsable.
    //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                                         <span aria-hidden="true">&times;</span>
    //                                     </button>
    //                                 </div>`;
    //                         break;
    //                     default:
    //                         html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
    //                                     Ocurrio un error
    //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                                         <span aria-hidden="true">&times;</span>
    //                                     </button>
    //                                 </div>`;
    //                         break;
    //                 }
    //                 $('#alert').html(html)
    //                 recargarPartes(id_orden, data.tipo_orden);
    //                 nuevoParte();
    //                 setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);
    //             }
    //         });
    // });

    $(".nuevo-editar-orden").on('submit', function(evt){
            evt.preventDefault();     
            
            var url_php = $(this).attr("action"); 
            var type_method = $(this).attr("method"); 
            var form_data = $(this).serialize();

            $.ajax({
                type: type_method,
                url: url_php,
                data: form_data,
                success: function(data) {
                    html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modalOrd">
                                            `+data+`
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                    $('#alertOrd').html(html)
                    setTimeout(function(){document.getElementById('msj-modalOrd').hidden = true;},3000);
                    /*
                    opcion = parseInt(data.resultado);
                    switch (opcion) {
                        case 1:
                            html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Parte creado con exito
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                            break;
                        case 2:
                            id = document.getElementById('m-id-parte').value;
                            html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Parte cod. `+id+` actualizado con exito
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                            break;
                        case 6:
                            html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        No se puede actualizar un parte de la cual no eres responsable.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                            break;
                        default:
                            html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        Ocurrio un error
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                            break;
                    }
                    $('#alert').html(html)
                    recargarPartes(id_orden, data.tipo_orden);
                    nuevoParte();
                    setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);
                    */
                }
            });
            actRow();
    });
    } );

    $(".edit-multi-ope").on('submit', function(evt){
            evt.preventDefault();     
            var url_php = $(this).attr("action"); 
            var type_method = $(this).attr("method"); 
            var form_data = $(this).serialize();
            let html = '';
            // let id_orden = document.getElementById('m-ver-parte-orden').value;
            $.ajax({
                type: type_method,
                url: url_php,
                data: form_data,
                success: function(data) {
                    if (data) {
                        html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Operacion/es editados con exito.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                    } else {
                        html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        Ocurrio un error
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                    }
                    
                    $('#alert-edit').html(html)
                    setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);

                }
            });
    });

    $(".parte-multi-ope").on('submit', function(evt){
            evt.preventDefault();     
            var url_php = $(this).attr("action"); 
            var type_method = $(this).attr("method"); 
            var form_data = $(this).serialize();
            let html = '';
            // let id_orden = document.getElementById('m-ver-parte-orden').value;
            $.ajax({
                type: type_method,
                url: url_php,
                data: form_data,
                success: function(data) {
                    if (data) {
                        html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Operacion/es editados con exito.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                        b=1;                
                    } else {
                        html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        Ocurrio un error
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                    }
                    
                    $('#alert-edit').html(html)
                    setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);

                }
            });
    });

    $('#id_selec').on('change', mostrarSelec);
    // $('#checkSelAll').on('change', selecDesTodo);

    /* $('#flexOpc1').on('change', mostrarOculto);

        function mostrarOculto() {
            document.querySelectorAll('.no-activo').forEach(element => {
                if (element.hidden) {
                    element.hidden = false;
                } else {
                    element.hidden = true;
                }
            });

        } */

    document.getElementById('checkSelAll').addEventListener('change', event => {
        if (document.getElementById('checkSelAll').checked) {
            table.rows({ search: 'applied' }).nodes().to$().find('input[type="checkbox"][name="id_ope[]"]').prop('checked', true);
        } else {
            table.rows({ search: 'applied' }).nodes().to$().find('input[type="checkbox"][name="id_ope[]"]').prop('checked', false);
        }
    })
    
    function cargarModalVerPartesOpe(id){
        let html = '';
        obtenerEstados(5);
        document.getElementById('m-id-ope-hdr').value = id;
        
        $.ajax({
            type: "post",
            url: '/orden/mec/hdr/obtener-hdr-parte/'+id, 
            data: {
                id: id,
            },
            success: function (response) {
                // console.log(response)
                let ultParte = response.partes_ope.length - 1;
                let idCount = 0;
                response.partes_ope.forEach(element => {
                    html += `<tr>
                            <td class="text-center" style="vertical-align: middle;">`+element.id_parte+`</td>
                            <td class="text-center" style="vertical-align: middle;">`+element.fecha+`</td>
                            <td class="text-center" style="vertical-align: middle;">`+element.estado+`</td>
                            <td class="text-center" style="vertical-align: middle;">`+element.horas+`</td>
                            <td class="text-center" style="vertical-align: middle;">`+element.horas_maquina+`</td>
                            <td class="text-center" style="vertical-align: middle;"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                            <td class="text-center" style="vertical-align: middle;">`+element.responsable+`</td>
                            <td class="text-center" style="vertical-align: middle;">`+element.medidas+`</td>
                            <td class="text-center">
                                <div class="row justify-content-center" >
                                    <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOpe`+idCount+`" aria-expanded="false" aria-controls="collapseOrdenes`+idCount+`">
                                        Opciones
                                    </button>
                                </div>
                                <div class="collapse" data-bs-parent="#body_ver_parte_ope" id="collapseOpe`+idCount+`">
                                    <div class="row">
                                        <div class="col-12 my-1">
                                            <button type="button" class="btn btn-primary w-100" onclick="editarParte(`+element.id_parte+`)">
                                                Editar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                    </div>
                                </div>
                            </td>
                        </tr>`
                    idCount ++;
                });

                if (response.medida_chk) {
                    document.getElementById('section-medida').hidden = true;
                } else {
                    document.getElementById('section-medida').hidden = false;
                }
                document.getElementById('body_ver_parte_ope').innerHTML = html;
                document.getElementById('mv-operacion').value = response.partes_ope[0].operacion;
                document.getElementById('mv-ord-mec').value = response.partes_ope[0].orden_mec;
                document.getElementById('mv-estado').value = response.partes_ope[0].estado;
                document.getElementById('m-ver-parte-estado').value = response.partes_ope[ultParte].id_estado;
                obtenerMaquinasPorOpe(response.partes_ope[0].id_operacion);
        },
        complete: function(){
            changeTdColor();
        },
        error: function (error) {
            console.log(error);
        }
        });
    }

    function obtenerEstados(opcion){
        let select_estados = document.getElementById('m-ver-parte-estado');
        select_estados.innerHTML = '<option value="">Seleccionar</option>';
        html_estados = '';
        $.when($.ajax({
            type: "post",
            url: '/orden/obtener-estados-de/'+opcion, 
            data: {
            },
            success: function (response) {
                response.forEach(element => {
                    html_estados += `
                                        <option value="`+element.id_estado+`">`+element.nombre
                                        +`</option> 
                                        `
                });
                select_estados.innerHTML += html_estados;
            },
            error: function (error) {
                console.log(error);
            }
        }));
    }

    function obtenerMaquinasPorOpe(id){
        let select_maquinas = document.getElementById('m-ver-parte-maquina');
        select_maquinas.innerHTML = '<option value="">Seleccionar</option>';
        html_maquinas = '';
        let select_maq = null;
        $.ajax({
            type: "post",
            url: '/operacion/obtener-maquinas-ope-de/'+id, 
            data: {
            },
            success: function (res) {
                if (res.length == 1) {
                    select_maq = 'selected';
                }

                res.forEach(element => {
                    html_maquinas += `
                                       <option value="`+element.id_maquinaria+`" ${select_maq}>`+element.codigo_maquinaria
                                        +`</option> 
                                        `
                });
                select_maquinas.innerHTML += html_maquinas;
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function cargarHdrVer(id){
        let html = '';
        $.ajax({
            type: "post",
            url: '/orden/mec/hdr/obtener-hdr/'+id,
            data: { id: id },
            success: function (response) {
                // console.log(response);
                document.getElementById('m_ver_ubi').value = response.ubicacion;
                document.getElementById('m_ver_cant').value = response.cantidad;
                document.getElementById('m_ver_fec_carga').value = response.fecha_requerida;
                document.getElementById('m_ver_ruta').value = response.ruta;
                document.getElementById('m_ver-obser').value = response.observaciones;
                document.getElementById('m_ver_id_pieza').value = response.nombre_orden;
                document.getElementById('m_ver_confec').value = response.supervisor;

                if (response.obser_fallo) {
                    document.getElementById('obser-fallo').hidden = false;
                }

                document.getElementById('ver-table-body').innerHTML = '';
                response.operaciones.forEach(function (op){
                    html += `<tr>
                            <td class="text-center">`+op.numero+`</td>
                            <td class="text-center">`+op.operacion+`</td>
                            <td class="text-center">`+op.asignado+`</td>
                            <td class="text-center">`+op.maquina ?? '-'+`</td>
                        </tr>`
                });
                document.getElementById('ver-table-body').innerHTML = html;
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
</script>
{{-- <script>
    const toggleButton = document.getElementById('toggleMenu');
    const sideMenu = document.getElementById('sideMenu');

    toggleButton.addEventListener('click', () => {
      sideMenu.classList.toggle('show');
    });
</script> --}}


@endsection