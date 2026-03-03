@extends('layouts.app')
@section('titulo', 'Ordenes Mantenimiento')
@section('content')

<style>
    
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
                        @include('layouts.loanding')
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead id="encabezado_ordenes">
                                    <th class='text-center' style="color:#fff;min-width:2vw" hidden id="enc_sel"></th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Prioridad</th>
                                    <th class='text-center' style="color:#fff; width:13vw">Proyecto</th>
                                    <th class='text-center' style="color:#fff;" hidden>Proyecto</th>
                                    <th class='text-center' style="color:#fff;min-width:14vw">Orden</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Progreso</th>
                                    <th class='text-center' style="color:#fff;min-width:4vw">Estado</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Fecha Finalizacion</th>
                                    <th class='text-center' style="color: #fff; width:10%">Acciones</th>
                                </thead>
                                
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($ordenes as $orden)
                                        <tr data-id="{{$orden->id_orden}}">
                                            <td hidden class="chk-input" style="vertical-align: middle; padding: 0;">
                                                <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                                  <input class="form-check-input" type="checkbox" value="{{$orden->id_orden}}" id="flexCheck{{$orden->id_orden}}" name="id_ordenes[]">
                                                </div>
                                            </td>

                                            <td class='text-center' style="vertical-align: middle;" data-order="{{$orden->prioridad_servicio ?? 999}}">{{$orden->prioridad_servicio ?? 'S/P'}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->nombre_servicio ?? '-'}}" style="text-decoration:none; font-variant: none;">{{$orden->codigo_servicio ?? '-'}} <i class="fas fa-eye"></i></abbr></td>
                                            
                                            <td class='text-center' style="vertical-align: middle;" hidden>{{$orden->codigo_servicio ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_orden ?? '-'}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">
                                                <div class="progress position-relative" style="background-color: #b2baf8">
                                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$orden->getProgreso()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$orden->total_ope_completo.'/'.$orden->total_ope}}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_estado ?? ''}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->fecha_finalizacion ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenes{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenes{{$idCount}}">
                                                        @if($orden->nombre_estado == 'Espera')
                                                            @if($orden->id_tipo_orden_mantenimiento == 1)
                                                                <button type="button" onclick="openModalNuevoParteDiagnostico({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-pen"></i>
                                                                </button>
                                                            @elseif ($orden->id_tipo_orden_mantenimiento == 2)
                                                                <button type="button" onclick="openModalNuevoParteInspeccion({{$orden->id_activo}},{{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-pen"></i>
                                                                </button>
                                                            @elseif ($orden->id_tipo_orden_mantenimiento == 3)
                                                                <button type="button" onclick="openModalNuevoParteAjuste({{$orden->id_orden}}, {{$orden->id_etapa}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-pen"></i>
                                                                </button>
                                                            @endif
                                                        @elseif ($orden->nombre_estado == 'En proceso')
                                                            @if ($orden->id_tipo_orden_mantenimiento == 2)
                                                                <button type="button" onclick="openModalParteInspeccionPendiente({{$orden->id_activo}},{{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            @elseif ($orden->id_tipo_orden_mantenimiento == 3)
                                                                <button type="button" onclick="openModalParteAjustePendiente({{$orden->id_orden}}, {{$orden->id_etapa}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            @endif
                                                        @elseif ($orden->nombre_estado == 'Revisar')
                                                            @if($orden->id_tipo_orden_mantenimiento == 1)
                                                            <button type="button" onclick="openModalConfirmarParteDiagnostico({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                <i class="fas fa-eye"></i>
                                                            </button>    
                                                            @elseif ($orden->id_tipo_orden_mantenimiento == 2)
                                                                <button type="button" onclick="openModalConfirmarParteInspeccion({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            @elseif ($orden->id_tipo_orden_mantenimiento == 3)
                                                                <button type="button" onclick="openModalConfirmarParteAjuste({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            @endif
                                                        @else
                                                            @if($orden->id_tipo_orden_mantenimiento == 1)
                                                                <button type="button" onclick="openModalVerParteDiagnostico({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>    
                                                            @elseif ($orden->id_tipo_orden_mantenimiento == 2)
                                                                <button type="button" onclick="openModalVerParteInspeccion({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            @elseif ($orden->id_tipo_orden_mantenimiento == 3)
                                                                <button type="button" onclick="openModalVerParteAjuste({{$orden->id_orden}})" class="btn btn-primary" onclick="">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </td> 


                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$orden->manufactura ?? '-'}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">
                                                <div class="progress position-relative" style="background-color: #b2baf8">
                                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$orden->getProgreso()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$orden->total_ope_completo.'/'.$orden->total_ope}}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_estado ?? ''}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->ope_act ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nom_est_ope_act ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->fecha_limite ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->total_horas_hdr ?? '00:00'}}</td>
        
                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenes{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenes{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenes{{$idCount}}">
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden({{$orden->id_orden}}, {{$tipo_orden}})">
                                                                    Ver
                                                                </button>
                                                            </div>
                                                        </div>

                                                        @if ($tipo_orden === 3)
                                                            <div class="row my-2">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['ordenes.hdr', $orden->id_orden], 'style' => 'display:inline']) !!}
                                                                        {!! Form::text('vieneDesde', 2, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!}
                                                                        {!! Form::submit('HDR', ['class' => 'btn btn-info w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, {{$tipo_orden}})">
                                                                    Partes
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            @can('EDITAR-ORDENES')
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarOrden({{$orden->id_orden}}, '{{$orden->descripcion_etapa}}')">
                                                                    Editar
                                                                </button> 
                                                            </div>
                                                            @endcan
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                                @if ($orden->id_estado_mecanizado != 4 )
                                                                    <button type="button" class="btn btn-warning" onclick="crearParteOrdMecEspera({{$orden->id_orden}})">Espera</button>
                                                                @endif

                                                                @if ($orden->id_estado_mecanizado != 5 )
                                                                <button type="button" class="btn btn-info" onclick="crearParteOrdMecEnProceso({{$orden->id_orden}})">En proceso</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td> --}}
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
    <script src="{{ asset('js/change-td-color.js') }}"></script>
    {{--  <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/filter.js') }}"></script>
    <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/ordenes.js') }}"></script>
    <script src="{{ asset('js/filter-to-filter.js') }}"></script> --}}
</section>

{{-- @include('Ingenieria.Servicios.Ordenes.modal.ver-orden')
@include('Ingenieria.Servicios.Ordenes.modal.editar-orden')
@include('Ingenieria.Servicios.Ordenes.modal.ver-partes')
@include('Ingenieria.Servicios.Ordenes.modal.crear-parte-multiple') --}}

<script>
    
    let es_super = {{$es_sup}};
    var table;
    $("#loading").show();

    $(document).ready( function () {
        
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;

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
                    order: [[1, 'asc']],
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
@endsection