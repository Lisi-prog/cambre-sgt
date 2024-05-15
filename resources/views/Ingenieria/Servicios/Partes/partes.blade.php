@extends('layouts.app')
@section('titulo', 'Partes')
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
    .table {
        zoom: 100%;
    }
    table.dataTable tbody td {
        padding: 0px 10px;
    }
    .table td {
        min-height: 0px
    }
    .col-4 {
        padding: 5px;
    }

</style>
@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 my-auto">
                <h4 class="titulo page__heading my-auto">Partes de {{$tipo}}</h5>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
    
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-4">
                {{-- {!! Form::open(['method' => 'GET', 'route' => ['partes.create'], 'class' => '']) !!}
                    {!! Form::submit('Nuevo', ['class' => 'btn btn-success col-9']) !!}
                {!! Form::close() !!} --}}
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
                                <thead id="encabezado_partes">
                                    <th class="text-center" scope="col" style="color:#fff;width:4vw">Cod.</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5vw">Fecha</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5vw">Fecha limite</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5vw">Estado</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:4vw">Horas</th>
                                    <th class="text-center" scope="col" style="color:#fff;mi-width:13vw">Observaciones</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:6vw">Responsable</th>
                                    {{-- <th id="column-maq" class="text-center" scope="col" style="color:#fff;" hidden>Maquina</th>
                                    <th id="column-hora-maq" class="text-center" scope="col" style="color:#fff;" hidden>Hora maquina</th> --}}
                                    <th class="text-center" scope="col" style="color:#fff;width:6vw">Supervisor</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:6vw">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    @foreach ($partes as $parte)
                                        <tr>
                                            <td class="text-center">{{$parte->id_parte}}</td>
                                            <td class="text-center">{{$parte->fecha}}</td>
                                            <td class="text-center">{{$parte->fecha_limite}}</td>
                                            <td class="text-center">{{$parte->getParteDe->getNombreEstado()}}</td>
                                            <td class="text-center">{{$parte->horas}}</td>
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$parte->observaciones}}" style="text-decoration:none; font-variant: none;">{{substr($parte->observaciones, 0, 80)}} <i class="fas fa-eye"></i></abbr></td>                                            <td class="text-center">{{$parte->getResponsable->getEmpleado->nombre_empleado}}</td>
                                            <td class="text-center">{{$parte->getOrden->getSupervisor()}}</td>
                                            <td class="text-center">
                                                <div class="row justify-content-center" >
                                                    <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePartes{{$idCount}}" aria-expanded="false" aria-controls="collapsePartes{{$idCount}}">
                                                        Opciones
                                                    </button>
                                                </div>
                                                <div class="collapse" data-bs-parent="#accordion" id="collapsePartes{{$idCount}}">
                                                    <div class="row my-2">
                                                        {{-- <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" onclick={{editarParte($parte->id_parte)}}>
                                                                Editar
                                                            </button>
                                                        </div> --}}
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <a href='/' target="_blank">
                                                                <button type="button" class="btn btn-warning w-100" >
                                                                    Logs
                                                                </button>
                                                            </a>
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
    <script type="module" > 
        import {colorEncabezadoPorTipoDeOrden} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
        window.colorEncabezadoPorTipoDeOrden = colorEncabezadoPorTipoDeOrden;
    </script>
</section>

{{-- @include('Ingenieria.Servicios.Etapas.modal.editar-etapa') --}}
<script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
<script src="{{ asset('js/change-td-color.js') }}"></script>
<script type="module"> 
    // import {cargarModalVerEtapa, cargarModalEditarEtapa} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
    // window.cargarModalVerEtapa = cargarModalVerEtapa;
    // window.cargarModalEditarEtapa = cargarModalEditarEtapa;
</script>
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
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        let tipo_orden = window.location.pathname.substring(12, 13);
        document.getElementById('encabezado_partes').style.backgroundColor = colorEncabezadoPorTipoDeOrden(tipo_orden);
        document.getElementById('volver').href = url;
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
        table.on('draw', function () {
            changeTdColor();
        })
    });
</script>

    
@endsection