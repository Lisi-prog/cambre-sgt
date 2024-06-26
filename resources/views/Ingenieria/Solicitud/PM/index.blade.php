@extends('layouts.app')
@section('titulo', 'P.M.')
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
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 my-auto">
                <h4 class="titulo page__heading my-auto">Propuesta de mejora</h5>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-4">
                <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearPMModal">
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
                                    <th class='text-center' style="color:#fff;">Titulo</th>
                                    <th class='text-center' style="color:#fff;">Proponente</th>
                                    {{-- <th class='text-center' style="color:#fff;">Sector</th> --}}
                                    <th class='text-center' style="color:#fff;">Empleado</th>
                                    
                                    {{-- <th class='text-center' style="color:#fff;">Fecha requerida</th> --}}
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    {{-- <th class='text-center' style="color:#fff;">Prioridad</th> --}}
                                    <th class='text-center' style="color: #fff;width:13vh">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $id_estado_aceptado = Config::get('myconfig.estado_solicitud_aceptado');
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($ListaPM as $Pm)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Pm->getSolicitud->fecha_carga)->format('Y-m-d H:i')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->id_solicitud}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->titulo_propuesta}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->nombre_emisor}}</td>

                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$Pm->getSector->nombre_sector ?? ''}}</td> --}}

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getEmpleado->nombre_empleado ?? 'no asignado'}}</td>

                                            
                                            
                                            {{-- <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Pm->getSolicitud->fecha_requerida)->format('d-m-Y')}}</td> --}}

                                            <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud}}</td>

                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$Pm->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud}}</td> --}}

                                            <td>
                                                <div class="row justify-content-center" >
                                                    <div class="row justify-content-center" >
                                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePM{{$idCount}}" aria-expanded="false" aria-controls="collapsePM{{$idCount}}">
                                                            Opciones
                                                        </button>
                                                    </div>
                                                    <div class="collapse" data-bs-parent="#accordion" id="collapsePM{{$idCount}}">
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                @if ($Pm->getSolicitud->id_estado_solicitud >= $id_estado_aceptado)
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['p_m.show', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Ver', ['class' => 'btn btn-primary w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                @else
                                                                    @can('EVALUAR-SOLICITUD')
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['pm.evaluar', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Evaluar', ['class' => 'btn btn-success w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                @endif
                                                            </div>
                                                        </div> 
                                                        <div class="row my-2">
                                                            <div class="col-12">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['p_m.edit', $Pm->id_propuesta_de_mejora], 'style' => 'display:inline']) !!}
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
    @include('Ingenieria.Solicitud.PM.modal.m-crear')
    <script>
        $(document).ready(function () {
            var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'propuesta de mejora';

        $.when($.ajax({
            type: "post",
            url: '/documentacion/obtener/'+nombreArchivo, 
            data: {
                nombreArchivo: nombreArchivo,
            },
            success: function (response) {
                document.getElementById('ayudin').href = response;
            },
            error: function (error) {
                console.log(error);
            }
        }));
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
