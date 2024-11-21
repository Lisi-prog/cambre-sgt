@extends('layouts.app')
@section('titulo', 'Notificaciones')

@section('content')
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
                <h4 class="titulo page__heading my-auto">Notificaciones</h5>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-4">
            </div>
        </div>
    </div>
    {{-- @include('layouts.modal.mensajes', ['modo' => 'Agregar']) --}}
    <div class="section-body">   
        <div class="row">
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla-not" class="table table-striped mt-2">
                                <thead style="background-color: #00628c">
                                    <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Fecha</th>
                                    {{-- <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Cod.</th> --}}
                                    <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:1vw">Titulo</th>
                                    <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:6vw">Mensaje</th>
                                    <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:6vw">Leido</th>
                                    <th class="text-center" scope="col" style="color:#fff; min-width:1vw">Acciones</th>                                                           
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($notificaciones as $not)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($not->created_at)->format('Y-m-d H:i')}}</td>

                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$not->id_notificacion ?? '-'}}</td> --}}

                                            <td class='text-center' style="vertical-align: middle;">{{$not->getCuerpo->titulo ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$not->getCuerpo->mensaje ?? '-'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$not->leido ? 'Si' : 'No'}}</td>

                                            <td class='text-center' style="vertical-align: middle;">
                                                <a href="{{$not->getCuerpo->url}}">
                                                    <button type="button" class="btn btn-success">Abrir</button>
                                                </a>
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
    
    <script>
        $(document).ready(function () {
            $('#tabla-not').DataTable({
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
                    order: [[0, 'desc']],
                    lengthMenu: [
                        [25, 50, 100, 500, -1],
                        [25, 50, 100, 500, 'Todo']
                    ],
                    "pageLength": 100
            });
        });
    </script>
</section>

@endsection
