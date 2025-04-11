@extends('layouts.app')
@section('titulo', 'Hoja de Ruta')
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
</style>

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 my-auto">
                <h4 class="">Hoja de Ruta</h5>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 my-auto">
                <label for="" style="font-weight: bold">Orden:</label> {{$orden->nombre_orden}}
            </div>
        </div>
    </div>

    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])

    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="d-flex justify-content-between">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 my-auto text-center">
                                <h5 class="text-center">Hojas de Ruta</h5>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearHdr" onclick="cargarModalCrearHDR({{$orden->getOrdenDe->id_orden_mecanizado}}, '{{$orden->nombre_orden}}', '{{$orden->getSupervisor()}}')">
                                    Nueva HDR
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead style="">
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Numero</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Codigo</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Fecha</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%">Estado</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:25%;">Observaciones</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Operacion actual</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Progreso</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Acciones</th>                                                           
                                </thead>
                                
                                <tbody id="accordion">
                                    @php
                                        $contador = 1;
                                        $idCount = 0;
                                    @endphp
                                        @foreach ($hojas_de_ruta as $hdr)
                                        {{$hdr->getEstaActivo()}}
                                        <tr>
                                            <td class= 'text-center' style="vertical-align: middle;">{{$contador ?? '-'}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">{{$hdr->id_hoja_de_ruta ?? '-'}}</td>

                                            <td class= 'text-center'style="vertical-align: middle;">{{$hdr->fecha_carga ?? '-'}}</td>

                                            {{-- <td class= 'text-center' style="vertical-align: middle;">{{$hdr->getEstado() ?? '-'}}</td> --}}
                                            <td class= 'text-center' style="vertical-align: middle;">{{$hdr->getEstadoActual() ?? '-'}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">{{ $hdr->observaciones ?? '-'}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">{{$hdr->getUltOpeActiva() ?? '-'}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">
                                                <div class="progress position-relative" style="background-color: #b2baf8">
                                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$hdr->getProgreso()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$hdr->getTotalOpeCompleto().'/'.$hdr->getTotalOpe()}}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHdr{{$idCount}}" aria-expanded="false" aria-controls="collapseHdr{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseHdr{{$idCount}}">
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-warning w-100" onclick="cargarOperaciones({{$hdr->id_hoja_de_ruta}})">
                                                                    Operaciones
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                            @php
                                                $contador += 1;
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

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="d-flex justify-content-between">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 my-auto text-center">
                                <h5 class="text-center">Operaciones</h5>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-2">
                                {{-- <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOpe">
                                    Nuevo
                                </button> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div>
                            <table id="example" class="table table-hover mt-2" class="display">
                                <thead style="">
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Cod. HDR</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">N°</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Fecha</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Ultimo res.</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%">Maquina</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%">Operacion</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%">Estado</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Horas</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Medidas</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Acciones</th>
                                </thead>
                                <tbody id="body_ope">
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('Ingenieria.Servicios.HDR.modal.crear-hdr')
@include('Ingenieria.Servicios.HDR.modal.crear-ope')
@include('Ingenieria.Servicios.HDR.operaciones.modal.m-ver-partes')
<script>
    $(document).ready(function () {
        // let tipo_orden = document.getElementById('tipo_orden').value;
        // var url = '{{route('ordenes.tipo',':tipo_orden')}}';
        // url = url.replace(':tipo_orden', tipo_orden);
        // document.getElementById('volver').href = url;
        $('#example').DataTable({
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
                order: [[0, 'asc']],
                "pageLength": 25
        });
    });
</script>
<script src="{{ asset('js/Ingenieria/Servicios/Ordenes/hoja-de-ruta.js') }}"></script>
@endsection