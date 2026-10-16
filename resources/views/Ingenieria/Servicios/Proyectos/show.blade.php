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
                <div class="titulo page__heading py-1 fs-5">Ver Proyecto</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Proyecto</h5></div>
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
                                        <input type="text" name="prioridad" id="prioridad" value="{{ null }}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>



                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Etapas</h5>
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
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Fecha inicio</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%">Fecha limite</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Fecha fin real</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Ultima actualizacion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($proyecto->getEtapas as $etapa)
                                            <tr>
                                                <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td>

                                                <td class= 'text-center' >{{$etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->getEstado->nombre_estado}}</td>

                                                <td class= 'text-center' >{{$etapa->getResponsable->first()->getEmpleado->nombre_empleado}}</td>

                                                <td class= 'text-center'>{{\Carbon\Carbon::parse($etapa->fecha_inicio)->format('d-m-Y')}}</td>

                                                <td class= 'text-center'>{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_limite)->format('d-m-Y')}}</td>

                                                <td class= 'text-center'>+late</td>

                                                <td class= 'text-center' >{{\Carbon\Carbon::parse($etapa->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_carga)->format('d-m-Y H:i')}}</td>

                                                <td>
                                                    <a href="{{ route('empleados.index') }}" class="btn btn-warning w-100">Ordenes</a>
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

                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex">
                                    <div class="me-auto">

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
    </section>

@endsection

@section('js')

@endsection