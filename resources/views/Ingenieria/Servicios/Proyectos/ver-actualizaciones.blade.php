@extends('layouts.app')
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
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Actualizaciones del Proyecto</div>
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
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Proyecto</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarProyectoModal">
                                        Editar
                                    </button>
                                </div>
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
                                        <input type="text" name="fecha_limite" id="fec_limite" value="{{ \Carbon\Carbon::parse($proyecto->getActualizaciones->sortBy('id_actualizacion_servicio')->first()->getActualizacion->fecha_limite)->format('d-m-Y') }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="estado" class="control-label" style="white-space: nowrap;">Estado:</label>
                                        <input type="text" name="estado" id="estado" value="{{ $proyecto->getActualizaciones->sortBy('id_actualizacion_servicio')->first()->getActualizacion->getEstado->nombre_estado }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="prioridad" class="control-label" style="white-space: nowrap;">Prioridad Nº:</label>
                                        <input type="text" name="prioridad" id="prioridad" value="{{ $proyecto->prioridad_servicio }}" class="form-control" readonly>
                                    </div>
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
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Etapas</h5>
                                </div> --}}
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearEtapaModal">
                                        Nueva
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="tablaEtapas" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;">Actualizado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Descripcion</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($proyecto->getActualizaciones as $actualizacion_servicio)
                                            <tr>
                                                <td class= 'text-center' >{{\Carbon\Carbon::parse($actualizacion_servicio->getActualizacion->fecha_carga)->format('d-m-Y H:i')}}</td>

                                                <td class= 'text-center' >{{$actualizacion_servicio->getActualizacion->descripcion}}</td>

                                                <td class= 'text-center' >{{$actualizacion_servicio->getActualizacion->getEstado->nombre_estado}}</td>

                                                <td class= 'text-center' >{{$actualizacion_servicio->getActualizacion->getResponsable->first()->getEmpleado->nombre_empleado}}</td>

                                                <td class= 'text-center'>{{\Carbon\Carbon::parse($actualizacion_servicio->getActualizacion->fecha_limite)->format('d-m-Y')}}</td>

                                                <td class='text-center'>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Ordenes del proyecto --}}

                    <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes' hidden>
                        <div class="card">
                            <div class="card-head">
                                <br>
                                <div class="row m-auto">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                        <h5 class="text-center">Ordenes</h5>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                                            Nueva
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div>
                                    <table id="example" class="table table-hover mt-2" class="display">
                                        <thead style="">
                                            <th class="text-center" scope="col" style="color:#fff;width:50%;">Orden</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:25%;">Tipo orden</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:20%;">Acciones</th>
                                        </thead>
                                        <tbody id="cuadro-ordenes">
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                {{-- ------------- --}}

                {{-- Orden de trabajo del proyecto --}}

                <div id='cuadro-orden-de-trabajo' class="col-xs-12 col-sm-12 col-md-12" hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Orden de trabajo</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                                        Nueva
                                    </button> --}}

                                </div>
                            </div>
                            {{-- <br>
                            <div class="text-center"><h5>Viviendas</h5></div>                         --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <tr>
                                            <th class="text-center" scope="col" style="color:#fff; border: 1px solid #fff;" colspan="9">Orden</th>
                                            <th class="text-center" scope="col" style="color:#fff; border: 1px solid #fff;" colspan="3">Ultimo parte</th>
                                        </tr>
                                        <th class="text-center" scope="col" style="color:#fff; width: 50%;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Tipo orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha inicio</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha fin real</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Duracion estimada</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Duracion real</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Fecha</th>
                                        <th class="text-center" scope="col" style="color:#fff;width: 50%;">Descripcion</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Supervisa</th>
                                    </thead>

                                    <tbody id="cuadro-ordenes-trabajo">

                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            {{-- ------------- --}}

                {{-- Partes del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12" id='parte_de_trabajo' hidden>
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Parte de trabajo</h5>
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
                                        <a href="{{ route('proyectos.index') }}" class="btn btn-primary">Volver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="module">
            // import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
            // window.crearCuadrOrdenes = crearCuadrOrdenes;
            // window.cargarModalVerOrden = cargarModalVerOrden;
            // window.obtenerPartes = obtenerPartes;
        </script>

        <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}">

        </script>
        {{-- <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form2.js') }}"></script> --}}

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

            function cargarModalEditar(id, nombre, fecha, lider){
                let input_nombre_etapa = document.getElementById('input-nombre_etapa');
                let input_fec_ini = document.getElementById('input-fec_ini');
                //let id_puesto = document.getElementById('input_id_puesto');

                // console.log(id);
                // console.log(nombre);
                // console.log(fecha);
                // console.log(lider);

                const $select = document.querySelector('#mySelect');
                $select.value = lider;
                //let nombre_puesto = b.parentNode.parentNode.parentNode.children[0].innerText;
                //let precio_hora = b.parentNode.parentNode.parentNode.children[1].innerText;

                //input_puesto.value = nombre_puesto;
                //costo_hora.value = precio_hora.replace('$ ', '').replace('.', '').replace(',', '.');
                //id_puesto.value = id;
            }
        </script>
        <script src="{{ asset('js/change-td-color.js') }}"></script>
    </section>



@endsection

@section('js')

@endsection