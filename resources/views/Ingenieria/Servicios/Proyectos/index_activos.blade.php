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
    <div class="section-header d-flex mb-3">
        <div class="d-flex">
            <div class="my-auto">
                <h4 class="titulo page__heading my-auto">Servicio de Activo</h4>
            </div>
        </div>

        <div class="d-flex ms-auto">
            <div class="me-2">
            </div>
            <div class="">
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
                                    <thead style="height:50px;background-color:#28587d;"><tr>
                                        <th class='ml-3 text-center' style="color:#fff;width: 10vw">ID</th>
                                        <th class='text-center' style="color:#fff;width: 8vw">Nombre</th>
                                        <th class='text-center' style="color:#fff;width: 15vw">Descripcion</th>
                                        <th class='text-center' style="color: #fff; width: 5vw">Acciones</th>
                                    </tr></thead>
                                    <tbody id="accordion"></tbody>
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
        const filtrosActivos = {};
        let valoresActivos = null;
        $('#example').DataTable({
            serverSide: true, processing: true, searchDelay: 350,
            pageLength: 10, lengthMenu: [10, 25, 50, 100, 500], order: [[0, 'asc']],
            ajax: {
                url: '{{ route('proyectos.datos') }}', type: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                data: function (datos) {
                    datos.alcance = {modo: 'activos', opcion: 1};
                    datos.filtrosCabecera = JSON.stringify(filtrosActivos);
                    datos.opcionesFiltros = valoresActivos === null;
                },
                dataSrc: function (respuesta) {
                    if (respuesta.opcionesFiltros) valoresActivos = respuesta.opcionesFiltros;
                    return respuesta.data;
                }
            },
            columnDefs: [
                {targets: '_all', className: 'align-middle', defaultContent: '-'},
                {targets: [0, 1, 2], className: 'text-left text-start'},
                {targets: 3, className: 'text-center'},
                {targets: 3, orderable: false, searchable: false}
            ],
            language: {
                emptyTable: 'No hay datos disponibles en la tabla', loadingRecords: 'Cargando activos...',
                processing: 'Procesando...', lengthMenu: 'Mostrar _MENU_ registros por pagina',
                zeroRecords: 'No se encontraron coincidencias', info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                infoEmpty: 'No hay registros', infoFiltered: '(de _MAX_ registros totales)', search: 'Buscar',
                paginate: {first: 'Prim.', last: 'Ult.', previous: 'Ant.', next: 'Sig.'}
            },
            initComplete: function () {
                agregarFiltrosCabecera(this.api(), {columnas: [0, 1, 2],
                    servidor: {valores: valoresActivos, selecciones: filtrosActivos}});
            }
        });
        $(document).on('shown.bs.collapse', '#accordion .collapse', function () {
            $(this).parent().find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        }).on('hidden.bs.collapse', '#accordion .collapse', function () {
            $(this).parent().find('.fa-chevron-right').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        });
    });

</script>
@endsection
