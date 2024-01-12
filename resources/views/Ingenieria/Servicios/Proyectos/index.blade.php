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
                <h4 class="titulo page__heading my-auto">Proyectos</h5>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-4">
                <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearProyectoModal">
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
                            <div id="tableFixHead">
                                <table class="table table-striped mt-2" id="example">
                                    <thead style="height:50px;">
                                        <th class='text-center' style="color:#fff;">Prioridad</th>
                                        {{-- <th class='text-center' style="color:#fff;">Fecha</th> --}}
                                        <th class='ml-3 text-center' style="color:#fff;">ID</th>
                                        <th class='text-center' style="color:#fff;">Nombre</th>
                                        <th class='text-center' style="color:#fff;">Tipo proyecto</th>
                                        {{-- <th class='text-center' style="color:#fff;">Tipo proyecto</th> --}}
                                        <th class='text-center' style="color:#fff;">Lider</th>
                                        <th class='text-center' style="color:#fff;">Progreso</th>
                                        {{-- <th class='text-center' style="color:#fff;">Ordenes</th> --}}
                                        <th class='text-center' style="color:#fff;">Estado</th>
                                        <th class='text-center' style="color:#fff;">Fecha inicio</th>
                                        <th class='text-center' style="color:#fff;">Fecha limite</th>
                                        <th class='text-center' style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($proyectos as $proyecto)
                                            <tr>
                                                {{-- <td class='text-center' style="vertical-align: middle;">{{ $proyecto->getEstado->nombre_estado}}</td> --}}
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->prioridad_servicio}}</td>
    
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->codigo_servicio}}</td>
    
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_servicio}}</td>
    
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->getSubTipoServicio->nombre_subtipo_servicio}}</td>
    
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->getResponsabilidad->getEmpleado->nombre_empleado}}</td>
    
                                                <td class= 'text-center' style="vertical-align: middle;">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$proyecto->getOrdenesRealizadasPorcentaje()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><span style="color: #ffffff">{{$proyecto->getOrdenesRealizadas()}}</span></div>
                                                    </div>
                                                </td>
                                                {{-- <td class= 'text-center' style="vertical-align: middle;">{{$proyecto->getOrdenesRealizadas()}}</td> --}}

                                                <td class= 'text-center' style="vertical-align: middle;">{{$proyecto->getActualizaciones->sortByDesc('id_actualizacion_proyecto')->first()->getActualizacion->getEstado->nombre_estado}}</td>
    
                                                <td class= 'text-center'style="vertical-align: middle;">{{\Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d-m-Y')}}</td>
                                                
                                                <td class= 'text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($proyecto->getActualizaciones->sortByDesc('id_actualizacion_proyecto')->first()->getActualizacion->fecha_limite)->format('d-m-Y')}}</td>
                                                <td>
                                                    <div class="row" hidden>
                                                        <div class="col-12">
                                                            {!! Form::open(['method' => 'GET', 'route' => ['proyectos.show', $proyecto->id_servicio], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Ver', ['class' => 'btn btn-primary w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modificarPrioridadModal" onclick="cargarModalModif({{$proyecto->id_servicio}}, this)">
                                                                Prioridad  
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            {!! Form::open(['method' => 'GET', 'route' => ['proyectos.gestionar', $proyecto->id_servicio], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Gestionar', ['class' => 'btn btn-success w-100']) !!}
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
    </div>
    <script src="{{ asset('js/change-td-color.js') }}"></script>
</section>
    {{-- <script src="{{ asset('js/usuarios/index_usuarios.js') }}"></script> --}}

{{-- <script src="{{ asset('js/categorialaboral/index_categorialaboral.js') }}"></script> --}}
{{-- <script src="{{ asset('js/modal/success.js') }}"></script> --}}

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

<script>
    function cargarModalModif(id){
        let codigo = document.getElementById('m-codigo_proyecto');
        let nombre = document.getElementById('m-nombre_proyecto');
        let id_proyecto = document.getElementById('id_proyecto');
        let num_prioridad = document.getElementById('num_prioridad');
        
        $.when($.ajax({
            type: "post",
            url: '/proyectos/obtener-proyecto/'+id, 
            data: {
                id: id
            },
            success: function (response) {
                let numero_prioridad = response.prioridad_servicio;
                let codigo_proyecto = response.codigo_servicio;
                let nombre_proyecto = response.nombre_servicio;

                codigo.value = codigo_proyecto;
                nombre.value = nombre_proyecto;
                num_prioridad.value = numero_prioridad;
            },
            error: function (error) {
                console.log(error);
            }
            }));
        
        id_proyecto.value = id;
    }
    
</script>

@include('Ingenieria.Servicios.Proyectos.modal.crear-proyecto')
@include('Ingenieria.Servicios.Proyectos.modal.modificar-prioridad')
@endsection