@extends('layouts.app')
@section('titulo', 'Evaluar R.I.')
@section('content')
<style>
     .tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        height: 500px; /* gives an initial height of 200px to the table */
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
                <div class="titulo page__heading py-1 fs-5">Evaluar Requerimiento de ingenieria</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Requerimiento de ingenieria</h5></div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('solicitud.aceptar', ['id' => $Req_ing->getSolicitud->id_solicitud, 'opcion' => 3]) }}" method="POST" class="formulario">
                                @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="fecha_carga" class="control-label" style="white-space: nowrap;">Fecha y hora:</label>
                                        <input type="text" name="fecha_carga" id="fecha_carga" value="{{ old('fecha_carga', \Carbon\Carbon::parse($Req_ing->getSolicitud->fecha_carga)->format('Y-m-d H:i')) }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="nom_solicitante" class="control-label" style="white-space: nowrap;">Solicitante:</label>
                                        <input type="text" name="nom_solicitante" id="nom_solicitante" value="{{ old('nom_solicitante', $Req_ing->getSolicitud->nombre_solicitante) }}" class="form-control" readonly>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="id_sector" class="control-label" style="white-space: nowrap;">Sector:</label>
                                        <input type="text" name="id_sector" id="id_sector" value="{{ old('id_sector', $Req_ing->getSector->nombre_sector) }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    @if(!is_null($Req_ing->getSolicitud->fecha_requerida))
                                        <div class="form-group">
                                            <label for="fecha_req" class="control-label" style="white-space: nowrap;">Fecha requerida:</label>
                                            <input type="text" name="fecha_req" id="fecha_req" value="{{ old('fecha_req', \Carbon\Carbon::parse($Req_ing->getSolicitud->fecha_requerida)->format('Y-m-d')) }}" class="form-control" readonly>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="prioridad" class="control-label" style="white-space: nowrap;">Prioridad:</label>
                                        <input type="text" name="prioridad" id="prioridad" value="{{ old('prioridad', $Req_ing->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud) }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="descrip" class="control-label" style="white-space: nowrap;">Descripcion de la solicitud:</label>
                                        <textarea id='descrip' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Req_ing->getSolicitud->descripcion_solicitud}}</textarea>
                                    </div>
                                </div>
                                @if (!is_null($Req_ing->getSolicitud->descripcion_urgencia))
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="descrip_urg" class="control-label" style="white-space: nowrap;">Descripcion urgencia:</label>
                                            <textarea id='descrip_urg' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Req_ing->getSolicitud->descripcion_urgencia ?? ''}}</textarea>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">

                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
                                                Aceptar
                                            </button>

                                        </div>
                                        <div class="col-6">
                                            <form method="GET" action="{{ route('ri.rechazar', $Req_ing->getSolicitud->id_solicitud) }}">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro que desea RECHAZAR el requerimiento de ingenieria?');">Rechazar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5 d-flex">
                                    <div class="ms-auto">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    @include('Ingenieria.Solicitud.RI.modal.m-crear-servicio')
    <script>
        $(document).ready(function () {
            var url = '{{url('r_i')}}';
            //url = url.replace(':id_servicio', id_servicio);
            document.getElementById('volver').href = url;
        })
        $(function(){
            $('#crear_serv').on('change', mostrarCrearServicio);
        });

        function mostrarCrearServicio(){
            let opcion = Number($(this).val());
            let div_crear_serv = document.getElementById("crear-proyecto");
            switch (opcion) {
                case 0:
                    div_crear_serv.hidden = true;
                    break;

                case 1:
                    div_crear_serv.hidden = false;
                    break;
            }
        }
    </script>
@endsection
