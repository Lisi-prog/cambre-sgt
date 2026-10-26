@extends('layouts.app')
@section('titulo', 'Ordenes Mantenimiento')
@section('content')
<link rel="stylesheet" href="{{ asset('css/estilos-tabla.css') }}">

<style>
    .tabla-ordenes {
        width: 100%;
        table-layout: fixed;
    }

    .tabla-ordenes th {
        color: #fff;
        text-align: center;
        vertical-align: middle;
    }

    .tabla-ordenes th,
    #example thead .dt-column-title { flex-wrap: wrap; white-space: normal; min-width: 0; }
    .tabla-ordenes td {
        padding: .5rem .75rem;
    }

    /* Reservar espacio para las columnas con textos más largos */
    .tabla-ordenes .col-proyecto,
    .tabla-ordenes .col-activo {
        min-width: 0;
    }

    .tabla-ordenes td {
        overflow-wrap: anywhere;
    }
</style>

<section class="section">
    <div class="section-header d-flex mb-3">
        <div class="d-flex">
            <div class="my-auto">
                <h4 class="titulo page__heading my-auto">Ordenes de Mantenimiento</h4>
            </div>
        </div>
        
        <div class="d-flex ms-auto">
            <div class="me-2">
            </div>
            <div class="">
            </div>
        </div>
    </div>

    <input type="hidden" name="opcion_tipo" value="4" class="form-control" id="opcion-tipo">

    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])

    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-sm tabla-ordenes mt-2" id="example">
                                <thead id="encabezado_ordenes"><tr>
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
                                    <th class='text-center' style="color:#fff;">Proyecto</th>
                                    <th class='text-center' style="color:#fff;" hidden>Proyecto</th>
                                    <th class='text-center' style="color:#fff;">Orden</th>
                                    <th class='text-center' style="color:#fff;">Tipo</th>
                                    <th class='text-center' style="color:#fff;">Activo</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Asignado</th>
                                    <th class='text-center' style="color:#fff;">Horas</th>
                                    <th class='text-center' style="color:#fff;">Fecha Fin</th>
                                    <th class='text-center' style="color:#fff;">Acciones</th>
                                </tr></thead>
                                
                                <tbody id="accordion"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @role('SUPERVISOR')
        @php
            $es_sup = 1;
        @endphp
    @else
        @php
            $es_sup = 0;
        @endphp
    @endrole
    
</section>

    @include('Ingenieria.Servicios.Mantenimiento.Partes.diagnostico') 
    @include('Ingenieria.Servicios.Mantenimiento.Partes.inspeccion') 
    @include('Ingenieria.Servicios.Mantenimiento.Partes.ajuste')
    @include('Ingenieria.Servicios.Mantenimiento.Modal.ver-partes')
    
@endsection
@section('scripts')
<script>
    
    let es_super = {{$es_sup}};
    var table;

    $(document).ready( function () {
        
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;

        const filtrosMantenimiento = {6: {excluir: ['Completo', 'Rechazado']}};
        let opcionesMantenimiento = null;
        table = $('#example').DataTable({
            serverSide: true, processing: true, searchDelay: 350, autoWidth: false,
            ajax: {
                url: '{{ route('ordenes.mantenimiento.datos') }}', type: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                data: function (datos) {
                    datos.filtrosCabecera = JSON.stringify(filtrosMantenimiento);
                    datos.opcionesFiltros = opcionesMantenimiento === null;
                },
                dataSrc: function (respuesta) {
                    if (respuesta.opcionesFiltros) opcionesMantenimiento = respuesta.opcionesFiltros;
                    return respuesta.data;
                }
            },
            columns: Array.from({length: 11}, (_, i) => ({data: 'celdas.' + i})),
            columnDefs: [
                {targets: '_all', defaultContent: '-', className: 'align-middle'},
                {targets: [0, 1, 4, 5, 6, 7, 8, 9, 10], className: 'text-center'},
                {targets: 3, className: 'text-start'},
                {targets: [2], visible: false, searchable: false, orderable: false},
                {targets: 10, searchable: false, orderable: false}
            ],
            createdRow: function (fila, datos) { fila.dataset.id = datos.id; },
            order: [], pageLength: 10, lengthMenu: [10, 25, 50, 100, 500],
            language: {
                emptyTable: 'No hay datos disponibles en la tabla',
                zeroRecords: 'No se han encontrado registros',
                processing: 'Procesando...', loadingRecords: 'Cargando ordenes...',
                lengthMenu: 'Mostrar _MENU_ registros por pagina',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                infoEmpty: 'No se han encontrado registros',
                infoFiltered: '(Filtrado de _MAX_ registros totales)', search: 'Buscar',
                paginate: {first: 'Prim.', last: 'Ult.', previous: 'Ant.', next: 'Sig.'}
            },
            drawCallback: function () { changeTdColor(); },
            initComplete: function () {
                agregarFiltrosCabecera(this.api(), {
                    columnas: [0, 1, 3, 4, 5, 6, 7, 8, 9],
                    servidor: {valores: opcionesMantenimiento, selecciones: filtrosMantenimiento},
                    excluirInicialmente: {6: ['Completo', 'Rechazado']}
                });
            }
        });

        $('#example tbody').on('click', 'tr', function () {
            ind_rw = table.row(this).index();
        });

    } );
    
</script>
<script src="{{ asset('js/change-td-color.js') }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/diagnostico.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Mantenimiento/Partes/diagnostico.js')) }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/inspeccion.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Mantenimiento/Partes/inspeccion.js')) }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Mantenimiento/Partes/ajuste.js') }}?ver={{ filemtime(public_path('js/Ingenieria/Servicios/Mantenimiento/Partes/ajuste.js')) }}"></script>


@endsection
