@extends('layouts.app')
@section('titulo', 'Servicio de Activo')
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
                <h4 class="">Servicio de Activo</h5>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 m-auto">
            </div>
        </div>
    </div>

    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])

    <div class="section-body">

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="tableFixHead">
                                <table class="table table-striped mt-2" id="example">
                                    <thead style="height:50px;background-color:#28587d;">
                                        <th class='ml-3 text-center' style="color:#fff;width: 10vw">ID</th>
                                        <th class='text-center' style="color:#fff;width: 8vw">Nombre</th>
                                        <th class='text-center' style="color:#fff;width: 15vw">Descripcion</th>
                                        <th class='text-center' style="color: #fff; width: 5vw">Acciones</th>
                                    </thead>
                                    <tbody  id="accordion">
                                        @php
                                            $idCount = 0;
                                        @endphp
                                        @foreach ($proyectos as $proyecto)
                                            <tr>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->codigo_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->getActivo->descripcion_activo ?? '-'}}</td>

                                                <td>
                                                    <div class="row justify-content-center">
                                                        <div class="row justify-content-center" >
                                                            <button class="btn btn-primary w-100 my-auto" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProyectos{{$idCount}}" aria-expanded="false" aria-controls="collapseProyectos{{$idCount}}">
                                                                Opciones <i class="fas fa-chevron-down m-auto"></i>
                                                            </button>
                                                        </div>
                                                        <div class="collapse" data-bs-parent="#accordion" id="collapseProyectos{{$idCount}}">
                                                            
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['proyectos.gestionar', $proyecto->id_servicio], 'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Gestionar', ['class' => 'btn btn-success w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                            @if (count($proyecto->getServiciosDeEsteActivo()) != 0)
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['proyecto.indexprefijo', $opcion], 'style' => 'display:inline', 'target' => '_blank' ]) !!}
                                                                        @foreach ($proyecto->getServiciosDeEsteActivo() as $id)
                                                                            <input class="input-filter" name="cod_serv[]" type="text" value="{{$id}}" hidden>
                                                                        @endforeach
                                                                    {!! Form::submit('Servicios', ['class' => 'btn btn-info w-100']) !!}
                                                                    {!! Form::close() !!}
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
    </div>
    
    <script src="{{ asset('js/change-td-color.js') }}"></script>
</section>

<script>
    $(document).ready( function () {
        table = $('#example').DataTable({
                    language: {
                            lengthMenu: 'Mostrar _MENU_ registros por pagina',
                            zeroRecords: 'No se ha encontrado registros',
                            info: 'Mostrando pagina _PAGE_ a _PAGES_ de _TOTAL_ ',
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
                        order: [[ 0, 'asc' ]],
                        "pageLength": 100
                });
    });
    
</script>
@endsection