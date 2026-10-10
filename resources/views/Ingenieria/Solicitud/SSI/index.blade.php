@extends('layouts.app')
@section('titulo', 'S.S.I.')
@section('content')

<link rel="stylesheet" href="{{ asset('css/estilos-tabla.css') }}">

<section class="section">
    <div class="section-header d-flex mb-3">
        <div class="d-flex">
            <div class="my-auto">
                <h4 class="titulo page__heading my-auto">Solicitud de servicio de ingenieria - SSI</h4>
            </div>
        </div>
        
        <div class="d-flex ms-auto">
            <div class="me-2">
            </div>
            <div class="">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearSSIModal">
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
                            <table class="table table-striped table-sm" id="example">
                                <thead>
                                    <tr>
                                    <th class='text-center' style="color:#fff; width: 10%;">Fecha</th>
                                    <th class='text-center' style="color:#fff; width: 5%;">Cod.</th>
                                    <th class='text-center' style="color:#fff; width: 15%;">Usuario</th>
                                    <th class='text-center' style="color:#fff; width: 5%;">Sector</th>
                                    <th class='text-center' style="color:#fff; width: 30%;">Descripcion</th>
                                    <th class='text-center' style="color:#fff; width: 10%;">Fecha Req.</th>
                                    <th class='text-center' style="color:#fff; width: 5%;">Estado</th>
                                    <th class='text-center' style="color:#fff; width: 5%;">Prioridad</th>
                                    <th class='text-center' style="color:#fff; width: 5%;">Activo</th>
                                    <th class='text-center' style="color: #fff; width: 10%;">Acciones</th>
                                                                    </tr>
                                </thead>
                                <tbody id="accordion"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('Ingenieria.Solicitud.SSI.modal.m-crear')
@include('Ingenieria.Solicitud.layout.avance-servicio')
<script src="{{ asset('js/Ingenieria/Solicitud/solicitud.js') }}"></script>

<script>
    $(document).ready(function () {
        var url = '{{url('/')}}';
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'servicio de ingenieria';

        $.ajax({
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
        });


        const filtrosSSI = {6: {excluir: ['Completo', 'Rechazado', 'Cancelado']}};
        let opcionesFiltrosSSI = null;
        var tabla = $('#example').DataTable({
            serverSide: true,
            searchDelay: 350,
            ajax: {
                url: '{{ route('ssi.datos') }}',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                data: function (datos) {
                    datos.filtrosCabecera = JSON.stringify(filtrosSSI);
                    datos.opcionesFiltros = opcionesFiltrosSSI === null;
                },
                dataSrc: function (respuesta) {
                    if (respuesta.opcionesFiltros) opcionesFiltrosSSI = respuesta.opcionesFiltros;
                    return respuesta.data;
                }
            },
            processing: true,
            columnDefs: [
                { targets: '_all', defaultContent: '-', className: 'align-middle' },
                { targets: [0, 1, 3, 5, 6, 7, 8], className: 'text-center' },
                { targets: 9, orderable: false, searchable: false }
            ],
            drawCallback: function () { changeTdColor(); },
            language: {
                    loadingRecords: 'Cargando solicitudes...',
                    processing: 'Procesando...',
                    emptyTable: 'No hay datos disponibles en la tabla',
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
                    [25, 50, 100, 500],
                    [25, 50, 100, 500]
                ],
                "pageLength": 25,
                initComplete: function () {
                    agregarFiltrosCabecera(this.api(), {
                        columnas: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        servidor: {valores: opcionesFiltrosSSI, selecciones: filtrosSSI},
                        excluirInicialmente: {
                            6: ['Completo', 'Rechazado', 'Cancelado']
                        }
                    });
                }
        });
        tabla.on('draw',function () {
            changeTdColor();
        })



        $('#avanceProyectoModal').on('hidden.bs.modal', function (e) {
            limpiarModal();
        });
    });
</script>
<script src="{{ asset('js/change-td-color.js') }}"></script>

@endsection
