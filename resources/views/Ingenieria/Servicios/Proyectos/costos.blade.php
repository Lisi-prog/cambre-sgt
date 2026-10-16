@extends('layouts.app')
@section('titulo', 'Costos')
@section('content')
<style>
     .tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        height: 300px; /* gives an initial height of 200px to the table */
      }
      .tableFixHead thead th {
        position: sticky; /* make the table heads sticky */
        top: 0px; /* table head will be placed from the top of the table and sticks to it */
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
        background: #ee9b27;
      }
</style>
    <section class="section">
        <div class="d-flex section-header justify-content-center">
            <div class="d-flex flex-row col-12">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 my-auto">
                    <h4 class="">Costos actualizados</h5>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center my-auto">
                                    <h5 class="text-center">Proyecto</h5>
                                </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="id_proyecto" class="control-label" style="white-space: nowrap;">ID:</label>
                                        <input type="text" name="id_proyecto" id="id_proyecto" value="{{ $proyecto->codigo_servicio }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="nom_proyecto" class="control-label" style="white-space: nowrap;">Nombre proyecto:</label>
                                        <input type="text" name="nom_proyecto" id="nom_proyecto" value="{{ $proyecto->nombre_servicio }}" class="form-control" readonly>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="id_tipo" class="control-label" style="white-space: nowrap;">Tipo:</label>
                                        <input type="text" name="id_sector" id="id_tipo" value="{{ $proyecto->getSubTipoServicio->nombre_subtipo_servicio }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="lider_proyecto" class="control-label" style="white-space: nowrap;">Lider de proyecto:</label>
                                        <input type="text" name="prioridad" id="lider_proyecto" value="{{ $proyecto->getResponsabilidad->getEmpleado->nombre_empleado }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="fec_ini" class="control-label" style="white-space: nowrap;">Fecha inicio:</label>
                                        <input type="text" name="fecha_carga" id="fec_ini" value="{{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d-m-Y') }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="fec_limite" class="control-label" style="white-space: nowrap;">Fecha limite:</label>
                                        <input type="text" name="fecha_limite" id="fec_limite" value="{{ \Carbon\Carbon::parse($proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->fecha_limite)->format('d-m-Y') }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="estado" class="control-label" style="white-space: nowrap;">Estado:</label>
                                        <input type="text" name="estado" id="estado" value="{{ $proyecto->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->getEstado->nombre_estado }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="prioridad" class="control-label" style="white-space: nowrap;">Prioridad Nº:</label>
                                        <input type="text" name="prioridad" id="prioridad" value="{{ $proyecto->prioridad_servicio }}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="costo_estimado" class="control-label" style="white-space: nowrap;">Costo estimado:</label>
                                        <input type="text" name="costo_estimado" id="costo_estimado" value="{{ $proyecto->getCostoEstimado() }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="costo_real" class="control-label" style="white-space: nowrap;">Costo real:</label>
                                        <input type="text" name="costo_real" id="costo_real" value="{{ $proyecto->getCostoReal() }}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}
                
                {{-- Actualizaciones del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_act_proyecto' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center">
                                    <h5 class="text-center">Actualizaciones proyecto</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaAct" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Codigo</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha carga</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Descripcion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Responsable</th>                                                          
                                    </thead>
                                    <tbody id="cuadro-act">
                                        
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Etapas del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center my-auto">
                                    <h5 class="text-center my-auto">Etapas</h5>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearEtapaModal">
                                        Nueva etapa
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaEtapas" class="table table-hover mt-2" class="display">
                                    <thead style="background-color: #2970c1">
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha inicio</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha fin real</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Ultima actualizacion</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                                        {{-- <th class="text-center" scope="col" style="color:#fff;width:20%;">Acciones</th>                                                            --}}
                                    </thead>
                                    <tbody>
                                        @foreach ($proyecto->getEtapas as $etapa)
                                            <tr>    
                                                <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td>
                                                
                                                <td class= 'text-center' >{{$etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->getEstado->nombre_estado}}</td>

                                                <td class= 'text-center' >{{$etapa->getResponsable->getEmpleado->nombre_empleado}}</td>

                                                <td class= 'text-center'>{{\Carbon\Carbon::parse($etapa->fecha_inicio)->format('d-m-Y')}}</td>

                                                <td class= 'text-center'>{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_limite)->format('d-m-Y')}}</td>

                                                <td class= 'text-center'>{{$etapa->getFechaFinalizacion() ? \Carbon\Carbon::parse($etapa->getFechaFinalizacion())->format('d-m-Y') : '____-__-__'}}</td>

                                                <td class= 'text-center' >{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_carga)->format('d-m-Y H:i')}}</td>

                                                <td class= 'text-center' >{{$etapa->getCostoEstimado()}}</td>
                                                
                                                <td class= 'text-center' >{{$etapa->getCostoReal()}}</td>

                                                {{-- <td class='text-center'>
                                                    <div class="row my-2">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarEtapaModal" onclick="cargarModalEditarEtapa({{$etapa->id_etapa}})">
                                                                Editar etapa
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-warning w-100" onclick="window.crearCuadrOrdenes({{$etapa->id_etapa}})">
                                                                Cargar ordenes
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" onclick="mostrarActEtapa({{$etapa->id_etapa}})">
                                                                Cargar actualizaciones
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Actualizaciones de la etapa --}}
                <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_act_etapa' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                                    <h5 class="text-center  my-auto">Actualizaciones etapa</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaAct" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Codigo</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha carga</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Descripcion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Responsable</th>                                                          
                                    </thead>
                                    <tbody id="cuadro-act-etapa">
                                        
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                @include('Ingenieria.Servicios.Proyectos.layout.costos-ordenes-v1')

                {{-- Ordenes del proyecto --}}
            
                {{-- <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                                    <h5 class="text-center  my-auto">Ordenes</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                                        Nueva orden
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="example" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Tipo orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Acciones</th>                                                           
                                    </thead>
                                    <tbody id="cuadro-ordenes">
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            {{-- ------------- --}}


                {{-- Partes del proyecto --}}
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
                            {{-- <br>
                            <div class="text-center"><h5>Viviendas</h5></div>                         --}}
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
                {{-- ------------- --}}

                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        {{-- (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong> --}}
                                    </div>
                                    <div class="p-1">
                                    </div>
                                    <div class="p-1">
                                        <a href="{{ route('proyectos.gestionar', $proyecto->id_servicio) }}" class="btn btn-primary">Volver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="module"> 
            import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes, cargarModalNuevaActProyecto} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
            window.crearCuadrOrdenes = crearCuadrOrdenes;
            window.cargarModalVerOrden = cargarModalVerOrden;
            window.obtenerPartes = obtenerPartes;
            window.cargarModalNuevaActProyecto = cargarModalNuevaActProyecto;
        </script>

        <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}">
            
        </script>
        <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/gestionar.js') }}"></script>

        <script>
            $(document).ready(function () {
                $('#exampless').DataTable({
                    language: {
                            lengthMenu: 'Mostrar _MENU_ registros por pagina',
                            zeroRecords: 'No se ha encontrado registros',
                            info: 'Mostrando pagina _PAGE_ de _PAGES_',
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
                        "aaSorting": []
                });
            });
        </script>
    </section>
    @include('Ingenieria.Servicios.Proyectos.modal.crear-etapa')
    @include('Ingenieria.Servicios.Proyectos.modal.editar-etapa')
    @include('Ingenieria.Servicios.Proyectos.modal.crear-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-orden')
    @include('Ingenieria.Servicios.Proyectos.modal.editar-proyecto')
    @include('Ingenieria.Servicios.Proyectos.modal.crear-act')
    @include('Ingenieria.Servicios.Proyectos.modal.crear-act-eta')
    @include('Ingenieria.Servicios.Proyectos.modal.ver-partes')

{{-- @include('layouts.modal.confirmation') --}}
@endsection

@section('js')

@endsection