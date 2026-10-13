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
    <div class="section-header d-flex mb-3">
        <div class="d-flex">
            <div class="my-auto me-2">
                <h4 class="titulo page__heading my-auto">Propuesta de Mejora - PM</h4>
            </div>
            <div class="">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="det-tab" data-bs-toggle="tab" data-bs-target="#pendientes" type="button" role="tab" onclick="">Pendientes</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="det_adju_tab" data-bs-toggle="tab" data-bs-target="#calificados" type="button" role="tab" onclick="">Calificados</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="d-flex ms-auto">
            <div class="me-2">

            </div>
            <div class="">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearPMModal">
                    Nuevo
                </button>
            </div>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pendientes" role="tabpanel">
                {{-- Pm a calificar --}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive tableFixHead">
                                    <table id="tablaPmACali" class="table table-hover mt-2">
                                        <thead style="background-color: #00628c"><tr>
                                            <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Fecha</th>
                                            <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:1vw">Codigo</th>
                                            <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:6vw">Titulo</th>
                                            <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Proponente/s</th>
                                            <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Usuario</th>
                                            {{-- <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Estado</th> --}}
                                            <th class="text-center" scope="col" style="color:#fff; min-width:1vw">Acciones</th>
                                        </tr></thead>
                                        <tbody id="accordionPmACali"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}
            </div>
            <div class="tab-pane fade" id="calificados" role="tabpanel">
                {{-- Pm calificado --}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive tableFixHead">
                                    <table id="tablaPm" class="table table-hover mt-2">
                                        <thead style="background-color: #00628c">
                                            <tr>
                                                <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Fecha</th>
                                                <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:1vw">Codigo</th>
                                                <th class="text-center apply-filter" scope="col" style="color:#fff;min-width:6vw">Titulo</th>
                                                <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:5vw">Proponente/s</th>
                                                <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:3vw">Usuario</th>
                                                <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Calificacion</th>
                                                <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Necesidad</th>
                                                <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">V. total</th>
                                                <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Interes</th>
                                                <th class="text-center apply-filter no-filter no-search" scope="col" style="color:#fff;min-width:1vw">Estado</th>
                                                <th class="text-center" scope="col" style="color:#fff; width:8%">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="accordionPm"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}
            </div>
        </div>
    </div>

</section>
    @include('Ingenieria.Solicitud.PM.modal.m-crear')
    @include('Ingenieria.Solicitud.layout.avance-servicio')
    <script src="{{ asset('js/Ingenieria/Solicitud/solicitud.js') }}"></script>
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

        function inicializarPM(selector, grupo, columnas, orden) {
            const selecciones = {};
            let valores = null;
            return $(selector).DataTable({
                serverSide: true,
                processing: true,
                searchDelay: 350,
                ajax: {
                    url: '{{ route('pm.datos') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                    data: function (datos) {
                        datos.grupo = grupo;
                        datos.filtrosCabecera = JSON.stringify(selecciones);
                        datos.opcionesFiltros = valores === null;
                    },
                    dataSrc: function (respuesta) {
                        if (respuesta.opcionesFiltros) valores = respuesta.opcionesFiltros;
                        return respuesta.data;
                    }
                },
                columnDefs: [
                    {targets: '_all', defaultContent: '-', className: 'align-middle'},
                    {targets: 2, className: 'text-left text-start'},
                    {targets: columnas.concat([columnas.length]).filter(function (indice) { return indice !== 2; }), className: 'text-center'},
                    {targets: columnas.length, orderable: false, searchable: false}
                ],
                language: {
                    emptyTable: 'No hay datos disponibles en la tabla',
                    loadingRecords: 'Cargando propuestas...', processing: 'Procesando...',
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se encontraron coincidencias',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                    infoEmpty: 'No hay registros', infoFiltered: '(de _MAX_ registros totales)',
                    search: 'Buscar',
                    paginate: {first: 'Prim.', last: 'Ult.', previous: 'Ant.', next: 'Sig.'}
                },
                order: orden, pageLength: 10, lengthMenu: [10, 25, 50, 100, 500],
                drawCallback: function () { changeTdColor(); },
                initComplete: function () {
                    agregarFiltrosCabecera(this.api(), {
                        columnas: columnas, servidor: {valores: valores, selecciones: selecciones}
                    });
                }
            });
        }
        inicializarPM('#tablaPmACali', 'sin_calificar', [0, 1, 2, 3, 4], [[0, 'desc']]);
        inicializarPM('#tablaPm', 'calificadas', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], [[8, 'desc']]);
        });
    </script>
<script src="{{ asset('js/change-td-color.js') }}"></script>
@endsection
