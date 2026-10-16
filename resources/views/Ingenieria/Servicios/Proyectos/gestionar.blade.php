@extends('layouts.app')
@section('titulo', 'Gestionar')
@section('content')
<style>
    .tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        min-height: 200px; /* gives an initial height of 200px to the table */
        max-height: 400px;
    }
    .tableFixHead thead th {
        position: sticky; /* make the table heads sticky */
        top: 0px; /* table head will be placed from the top of the table and sticks to it */
        z-index:2;
    }
    #viv table {
        border-collapse: collapse; /* make the table borders collapse to each other */
        width: 100%;
    }
    /* #viv th,
    #viv td {
    padding: 8px 16px;
    border: 1px solid #ccc;
    }*/
    #viv th {
        background: #2970c1;
    }

    #cot th {
        background: #558540;
    }

    #comac th {
        background: #982b37;
    }

    #comec th {
        background: #d37c00;
    }

    .table {
        zoom: 100%;
    }
    table tbody td {
        padding: 1px 10px !important;
        height: 0px !important;
    }
    .col-4 {
        padding: 5px;
    }
    .col-12 {
        padding: 5px !important;
    }
</style>
@php
    $formato_fecha= Config::get('myconfig.formato_fecha');
    $formato_fecha_hora= Config::get('myconfig.formato_fecha_hora');
    $ultimaActualizacion = optional($proyecto->ultimaActualizacion)->getActualizacion;
@endphp
    <section class="section">
        <div class="section-header d-flex mb-3">
            <div class="d-flex">
                <div class="my-auto">
                    <h4 class="titulo page__heading my-auto">Gestionar Servicio Cod.: {{$proyecto->id_servicio}}</h4>
                </div>
            </div>
            
            <div class="d-flex ms-auto">
                <div class="me-2">
                </div>
                <div class="">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verActServOrdenModal" onclick="mostrarActProyectoAlt({{$proyecto->id_servicio}})">Actualizaciones</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarProyectoModal">Editar</button>
                        <a type="button" class="btn btn-primary" href="{{route('proyectos.costos', $proyecto->id_servicio)}}">Costos</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <input type="hidden" name="id_proyecto_dat" id="id-servicio-dat" value="{{ $proyecto->id_servicio }}" class="form-control">
                        <div class="card-body">
                            <div class="card-title">
                                <h5 class="text-center">Proyecto</h5>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="id_proyecto" class="control-label" style="white-space:nowrap;">ID:</label>
                                        <input type="text" name="id_proyecto" id="id_proyecto" value="{{ $proyecto->codigo_servicio }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="nom_proyecto" class="control-label" style="white-space:nowrap;">Nombre proyecto:</label>
                                        <input type="text" name="nom_proyecto" id="nom_proyecto" value="{{ $proyecto->nombre_servicio }}" class="form-control" readonly>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="id_tipo" class="control-label" style="white-space:nowrap;">Tipo:</label>
                                        <input type="text" name="id_sector" id="id_tipo" value="{{ $proyecto->getSubTipoServicio->nombre_subtipo_servicio }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="lider_proyecto" class="control-label" style="white-space:nowrap;">Lider de proyecto:</label>
                                        <input type="text" name="prioridad" id="lider_proyecto" value="{{ optional(optional($proyecto->getResponsabilidad)->getEmpleado)->nombre_empleado ?? '-' }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="fec_ini" class="control-label" style="white-space:nowrap;">Fecha inicio:</label>
                                        <input type="text" name="fecha_carga" id="fec_ini" value="{{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->format($formato_fecha) }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="fec_limite" class="control-label" style="white-space:nowrap;">Fecha limite:</label>
                                        <input type="text" name="fecha_limite" id="fec_limite" value="{{ optional($ultimaActualizacion)->fecha_limite ? \Carbon\Carbon::parse($ultimaActualizacion->fecha_limite)->format($formato_fecha) : '-' }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="estado" class="control-label" style="white-space:nowrap;">Estado:</label>
                                        <input type="text" name="estado" id="estado" value="{{ optional(optional($ultimaActualizacion)->getEstado)->nombre_estado ?? '-' }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="prioridad" class="control-label" style="white-space:nowrap;">Prioridad Nº:</label>
                                        <input type="text" name="prioridad" id="prioridad" value="{{ $proyecto->prioridad_servicio ?? 'S/P' }}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    @if($proyecto->id_activo)
                                        <div class="form-group">
                                            <label for="activo" class="control-label" style="white-space:nowrap;">Activo asociado:</label>
                                            <input type="text" name="activo" id="activo" value="{{ $proyecto->getActivo->codigo_activo.' - '.$proyecto->getActivo->nombre_activo }}" class="form-control" readonly>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">

                                        <label for="horas_estimada" class="control-label" style="white-space:nowrap;">Horas estimadas:</label>
                                        <input type="text" name="horas_estimada" id="horas_estimada" value="{{ $horas_estimada ?? '-' }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">

                                        <label for="horas_real" class="control-label" style="white-space:nowrap;">Horas real:</label>
                                        <input type="text" name="horas_real" id="horas_real" value="{{ $horas_real ?? '-' }}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            @if ($proyecto->id_servicio_padre && $proyecto->servicioPadre)
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="nom_proyecto_pa" class="control-label" style="white-space:nowrap;">Nombre proyecto Padre:</label>

                                        <div class="input-group mb-3">
                                            <input type="text" name="nom_proyecto_pa" id="nom_proyecto_pa" value="{{ $proyecto->servicioPadre->codigo_servicio . ' - ' .
                                                $proyecto->servicioPadre->nombre_servicio }}" class="form-control" readonly>

                                            <a href="{{ route('proyectos.gestionar', $proyecto->id_servicio_padre) }}"
                                            class="btn btn-outline-secondary"
                                            target="_blank"
                                            rel="noopener noreferrer">
                                                Gestionar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="card-title align-items-center" style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 12px;">
                                    <h5 class="text-center mb-0" style="grid-column: 2;">Etapas</h5>
                                    <button type="button" class="btn btn-success" style="grid-column: 3; justify-self: end;" data-bs-toggle="modal" data-bs-target="#crearEtapaModal">
                                        Nueva etapa
                                    </button>
                                </div>
                                <hr>
                                <table id="tablaEtapas" class="table table-hover mt-2">
                                    <thead style="background-color: #2970c1" id="viv"><tr>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:10vw">Etapa</th>
                                        <th class="text-center apply-filter" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center apply-filter" scope="col" style="color:#fff;">Responsable</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Fecha inicio</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Fecha limite</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;">Ultima actualizacion</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;">Horas estimadas</th>
                                        <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;">Horas reales</th>
                                        <th class="text-center" scope="col" style="color:#fff; min-width:6vw">Acciones</th>
                                    </tr></thead>
                                    <tbody id="accordion"></tbody>
                                </table>

                        </div>
                    </div>
                </div>


                @include('Ingenieria.Servicios.Proyectos.layout.gestionar-ordenes')



                <div class="col-xs-12 col-sm-12 col-md-12" id='parte_de_trabajo' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center  my-auto">
                                    <h5 class="text-center  my-auto">Partes</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">

                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="example" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Fecha carga</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Observaciones</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Horas</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Supervisor</th>
                                    </thead>
                                    <tbody id="renglones_parte">

                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-1 position-fixed" style="bottom:2vh; left:0.5vh;" hidden>

                </div>
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12" hidden>
                    <div class="card">
                        <div class="card-body">
                            <div class="row" >
                                <div class="d-flex">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="module">
            import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes, cargarModalNuevaActProyecto, cargarModalEditarEtapa} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
            window.crearCuadrOrdenes = crearCuadrOrdenes;
            window.cargarModalVerOrden = cargarModalVerOrden;
            window.obtenerPartes = obtenerPartes;
            window.cargarModalNuevaActProyecto = cargarModalNuevaActProyecto;
            window.cargarModalEditarEtapa = cargarModalEditarEtapa;
        </script>

        <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js')) }}"></script>



        <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/gestionar.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Proyectos/modal/gestionar.js')) }}"></script>



        <script>
            // let oord = Array();
            let ind_rw = '';
            let opt_act = 0;
            $(document).ready(function () {
                let opcion = '{{$opcion}}';

                var url = '{{route('proyecto.indexprefijo', ':opcion')}}';
                url = url.replace(':opcion', opcion);
                document.getElementById('volver').href = url;
                document.getElementById('ayudin').hidden = false;
                let nombreArchivo = 'gestionar';


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
                // document.getElementById('volver').href = '{{route('proyectos.index')}}';
               inicializarGestionProyecto(@json($proyecto->id_servicio), @json((int) $opcion),
                    '{{ route('proyectos.gestion.datos', $proyecto->id_servicio) }}', @json($exclusionesGestion));
                $('#verPartesModal, #editarOrdenModal, #editarEtapaModal, #crearEtapaModal, #crearOrdenModal, #verActEtapaOrdenModal, #verActServOrdenModal')
                    .on('hidden.bs.modal', function () { recargarTablasGestion(); });
                $('#verActEtapaOrdenModal').on('hidden.bs.modal', function (e) {
                    // console.log('holi');
                    document.getElementById('m-ver-act-eta-descripcion').value = '';
                    document.getElementById('m-ver-act-eta-div').hidden = true;
                });

                $('#crearEtapaModal').on('hidden.bs.modal', function (e) {
                    // console.log('holi');
                    document.getElementById('m-crear-eta-idestado').value = 2;
                });
            });

        </script>


        <script src="{{ asset('js/change-td-color.js') }}"></script>
    </section>
    @include('Ingenieria.Servicios.Proyectos.modal.crear-etapa')
    @include('Ingenieria.Servicios.Proyectos.modal.editar-etapa')
    @include('Ingenieria.Servicios.Proyectos.modal.crear-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.editar-proyecto')


    @include('Ingenieria.Servicios.Proyectos.modal.ver-partes')
    @include('Ingenieria.Servicios.Ordenes.modal.editar-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-act-servicio')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-act-etapa')
    @include('Ingenieria.Servicios.Proyectos.modal.progreso-orden-man')

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/proyecto-gestion-tablas.js') }}"></script>
@endsection
