@extends('layouts.app')
@section('titulo', 'S.S.I.')
@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
<style>
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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 my-auto">
                <h4 class="titulo page__heading my-auto">Solicitud de servicios de ingenieria</h5>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
                <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearSSIModal">
                    Nuevo   
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
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead style="height:50px;">
                                    <th class='text-center' style="color:#fff;">Fecha</th>
                                    <th class='ml-3 text-center' style="color:#fff;">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Empleado</th>
                                    <th class='text-center' style="color:#fff;">Sector</th>
                                    <th class='text-center' style="color:#fff;">Descripcion</th>
                                    <th class='text-center' style="color:#fff;">Fecha requerida</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $id_estado_aceptado = Config::get('myconfig.estado_solicitud_aceptado');
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($listaSSI as $Ssi)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Ssi->getSolicitud->fecha_carga)->format('d-m-Y H:i')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ssi->getSolicitud->id_solicitud ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ssi->getSolicitud->getEmpleado->nombre_empleado ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ssi->getSector->nombre_sector ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ssi->getSolicitud->descripcion_solicitud ?? '-'}}</td>

                                            @if (is_null($Ssi->getSolicitud->fecha_requerida))
                                                <td class='text-center' style="vertical-align: middle;">Sin fecha</td>
                                            @else
                                                <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Ssi->getSolicitud->fecha_requerida)->format('d-m-Y')}}</td>
                                            @endif
                                            

                                            <td class='text-center' style="vertical-align: middle;">{{$Ssi->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Ssi->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud ?? '-'}}</td>

                                            <td>
                                                <div class="row justify-content-center">
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSSI{{$idCount}}" aria-expanded="false" aria-controls="collapseSSI{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapseSSI{{$idCount}}">
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                @if ($Ssi->getSolicitud->id_estado_solicitud >= $id_estado_aceptado)
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['s_s_i.show', $Ssi->id_servicio_de_ingenieria], 'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Ver', ['class' => 'btn btn-primary w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                @else
                                                                    @hasrole('SUPERVISOR')
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['ssi.evaluar', $Ssi->id_servicio_de_ingenieria], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Evaluar', ['class' => 'btn btn-success w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    @endhasrole
                                                                @endif
                                                            </div>
                                                        </div> 
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['s_s_i.edit', $Ssi->id_servicio_de_ingenieria], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-warning w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
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
</section>
@include('Ingenieria.Solicitud.SSI.modal.m-crear')
    {{-- <script src="{{ asset('js/usuarios/index_usuarios.js') }}"></script> --}}

{{-- <script src="{{ asset('js/categorialaboral/index_categorialaboral.js') }}"></script> --}}
{{-- <script src="{{ asset('js/modal/success.js') }}"></script> --}}

<script>
    $(document).ready(function () {
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        $('#example').DataTable({
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

    
@endsection