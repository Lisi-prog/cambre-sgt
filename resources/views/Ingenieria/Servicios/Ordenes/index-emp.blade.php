@extends('layouts.app')

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
</style>
@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 my-auto">
                <h4 class="">Ordenes</h5>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
            </div>
        </div>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                        {{-- <div class="pagination justify-content-end">
                                {!! $CategoriasLaborales->links() !!}
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead style="height:50px;">
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
                                    <th class='text-center' style="color:#fff; width:20vh">Proyecto</th>
                                    <th class='text-center' style="color:#fff;">Etapa</th>
                                    <th class='text-center' style="color:#fff;">Orden</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Fecha limite</th>
                                    <th class='text-center' style="color:#fff;">Horas estimadas</th>
                                    <th class='text-center' style="color:#fff;">Horas reales</th>
                                    <th class='text-center' style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($ordenes_trabajo as $orden_trabajo)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->getEtapa->getServicio->prioridad_servicio}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden_trabajo->getEtapa->getServicio->nombre_servicio}}" style="text-decoration:none; font-variant: none;">{{$orden_trabajo->getEtapa->getServicio->codigo_servicio}} <i class="fas fa-eye"></i></abbr></td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->getEtapa->descripcion_etapa}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->nombre_orden}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->getPartes->sortByDesc('id_parte')->first()->getParteDe->getNombreEstado() ?? ''}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($orden_trabajo->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite ?? '')->format('d-m-Y')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{substr($orden_trabajo->duracion_estimada, 0, strlen($orden_trabajo->duracion_estimada)-3) ?? ''}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden_trabajo->getCalculoHorasReales() ?? ''}}</td>

                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden({{$orden_trabajo->id_orden}}, {{$orden_trabajo->getOrdenDe->getTipoOrden()}})">
                                                            ver
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        {!! Form::open(['method' => 'GET', 'route' => ['orden.partes', $orden_trabajo->id_orden], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Parte', ['class' => 'btn btn-warning w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
    <script src="{{ asset('js/change-td-color.js') }}"></script>
    <script type="module"> 
        import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
        window.crearCuadrOrdenes = crearCuadrOrdenes;
        window.cargarModalVerOrden = cargarModalVerOrden;
        window.obtenerPartes = obtenerPartes;
    </script>
</section>

@include('Ingenieria.Servicios.Ordenes.modal.ver-orden')


{{-- <script>
    $(document).ready(function () {
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
                order: [[ 0, 'asc' ]],
                "aaSorting": []
        });
    });
</script> --}}
<script>
    $(document).ready(function () {
        // Setup - add a text input to each footer cell
        $('#example thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#example thead');
    
        var table = $('#example').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            initComplete: function () {
                var api = this.api();
    
                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function (colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" placeholder="' + title + '" />');
    
                        // On every keypress in this input
                        $(
                            'input',
                            $('.filters th').eq($(api.column(colIdx).header()).index())
                        )
                            .off('keyup change')
                            .on('change', function (e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr = '({search})'; //$(this).parents('th').find('select').val();
    
                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != ''
                                            ? regexr.replace('{search}', '(((' + this.value + ')))')
                                            : '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function (e) {
                                e.stopPropagation();
    
                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
        });
    });
</script>

@endsection