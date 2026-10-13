@extends('layouts.app')
@section('titulo', 'R.I.')
@section('content')

<link rel="stylesheet" href="{{ asset('css/estilos-tabla.css') }}">

<section class="section">
    <div class="section-header d-flex mb-3">
        <div class="d-flex">
            <div class="my-auto">
                <h4 class="titulo page__heading my-auto">Requerimientos de ingenieria - RI</h4>
            </div>
        </div>

        <div class="d-flex ms-auto">
            <div class="me-2">
            </div>
            <div class="">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearRIModal">
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
                                <thead style="height:50px;"><tr>
                                    <th class='text-center' style="color:#fff;">Fecha</th>
                                    <th class='text-center' style="color:#fff;">Codigo</th>
                                    <th class='text-center' style="color:#fff;">Empleado</th>
                                    <th class='text-center' style="color:#fff;">Sector</th>
                                    <th class='text-center' style="color:#fff;">Descripcion</th>
                                    <th class='text-center' style="color:#fff;">Fecha requerida</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </tr></thead>
                                <tbody id="accordion"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('Ingenieria.Solicitud.RI.modal.m-crear')

<script>
    $(document).ready(function () {
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'requerimiento de ingenieria';

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
        const filtrosRI = {};
        let valoresRI = null;
        $('#example').DataTable({
            serverSide: true,
            processing: true,
            searchDelay: 350,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100, 500],
            ajax: {
                url: '{{ route('ri.datos') }}',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                data: function (datos) {
                    datos.filtrosCabecera = JSON.stringify(filtrosRI);
                    datos.opcionesFiltros = valoresRI === null;
                },
                dataSrc: function (respuesta) {
                    if (respuesta.opcionesFiltros) valoresRI = respuesta.opcionesFiltros;
                    return respuesta.data;
                }
            },
            columnDefs: [
                {targets: '_all', defaultContent: '-', className: 'align-middle'},
                {targets: [0, 1, 2, 3, 5, 6, 7, 8], className: 'text-center'},
                {targets: 4, className: 'text-left text-start'},
                {targets: 8, orderable: false, searchable: false}
            ],
            initComplete: function () {
                agregarFiltrosCabecera(this.api(), {
                    columnas: [0, 1, 2, 3, 4, 5, 6, 7],
                    servidor: {valores: valoresRI, selecciones: filtrosRI}
                });
            },
            language: {
                    emptyTable: 'No hay datos disponibles en la tabla',
                    processing: 'Procesando...',
                    loadingRecords: 'Cargando requerimientos...',
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
                order: []
        });
    });
</script>


@endsection