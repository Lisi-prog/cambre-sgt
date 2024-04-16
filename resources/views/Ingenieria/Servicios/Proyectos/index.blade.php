@extends('layouts.app')

@section('titulo', $tipo ?? '')

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
    .col-4 {
        padding: 5px;
    }
    .col-5 {
        padding: 5px;
    }
</style>
@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">

    <div class="d-flex section-header justify-content-center" >
        <div class="d-flex flex-row col-12">
        
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 my-auto">
                <h4 class="titulo page__heading my-auto">{{$tipo ?? ''}}</h5>
            </div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            </div>
            <div class="d-flex col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-4">
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
                        <div class="row">
                            <button type="button" class="btn btn-primary-outline m-1 rounded" onclick="mostrarFiltro()">Filtros <i class="fas fa-caret-down"></i></button> 
                        </div>
                        {!! Form::open(['method' => 'GET', 'route' => ['proyecto.indexprefijo', [$prefijo, $tipo]], 'style' => 'display:inline']) !!}
                        <div class="row" id="demo" hidden>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-11">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Proyectos:</label>
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                            <label style="font-style: italic"><input name="filter" type="checkbox" value="cod_serv[]" checked> (Seleccionar todo)</label>
                                                        @foreach ($proyectosFilter as $proyecto)
                                                            @if (is_null($flt_serv))
                                                                @if ($proyecto->id_estado < 9)
                                                                    <label><input class="input-filter" name="cod_serv[]" type="checkbox" value="{{$proyecto->id_servicio}}" checked> {{$proyecto->codigo_servicio}}</label>
                                                                @else
                                                                    <label><input class="input-filter" name="cod_serv[]" type="checkbox" value="{{$proyecto->id_servicio}}"> {{$proyecto->codigo_servicio}}</label>
                                                                @endif
                                                            @else
                                                                @if (in_array($proyecto->id_servicio, $flt_serv))
                                                                    <label><input class="input-filter" name="cod_serv[]" type="checkbox" value="{{$proyecto->id_servicio}}" checked> {{$proyecto->codigo_servicio}}</label>
                                                                @else
                                                                    <label><input class="input-filter" name="cod_serv[]" type="checkbox" value="{{$proyecto->id_servicio}}"> {{$proyecto->codigo_servicio}}</label>
                                                                @endif
                                                            @endif

                                                            {{-- @if (is_null($flt_serv) || in_array($proyecto->id_servicio, $flt_serv))
                                                                <label><input class="input-filter" name="cod_serv[]" type="checkbox" value="{{$proyecto->id_servicio}}" checked> {{$proyecto->codigo_servicio}}</label>
                                                            @else
                                                                <label><input class="input-filter" name="cod_serv[]" type="checkbox" value="{{$proyecto->id_servicio}}"> {{$proyecto->codigo_servicio}}</label>
                                                            @endif --}}
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Tipo:</label>
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="tipos[]" checked> (Seleccionar todo)</label>
                                                        @foreach ($subtipos_servicio as $subtipo_servicio)
                                                            @if (is_null($flt_tip) || in_array($subtipo_servicio->id_subtipo_servicio, $flt_tip))
                                                                <label><input class="input-filter" name="tipos[]" type="checkbox" value="{{$subtipo_servicio->id_subtipo_servicio}}" checked> {{$subtipo_servicio->nombre_subtipo_servicio}}</label>
                                                            @else
                                                                <label><input class="input-filter" name="tipos[]" type="checkbox" value="{{$subtipo_servicio->id_subtipo_servicio}}"> {{$subtipo_servicio->nombre_subtipo_servicio}}</label>
                                                            @endif
                                                            {{-- <label><input class="input-filter" name="tipos[]" type="checkbox" value="{{$subtipo_servicio->id_subtipo_servicio}}" checked> {{$subtipo_servicio->nombre_subtipo_servicio}}</label> --}}
                                                        @endforeach 
                                                        {{-- @foreach ($supervisores as $supervisor)
                                                            <label><input name="supervisores[]" type="checkbox" value="{{$supervisor->id_empleado}}"> {{$supervisor->nombre_empleado}}</label>
                                                        @endforeach --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Lider:</label>
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="lid[]" checked> (Seleccionar todo)</label>
                                                        @foreach ($supervisores as $supervisor)
                                                            @if (is_null($flt_lid) || in_array($supervisor->id_empleado, $flt_lid))
                                                                <label><input class="input-filter" name="lid[]" type="checkbox" value="{{$supervisor->id_empleado}}" checked> {{$supervisor->nombre_empleado}}</label>
                                                            @else
                                                                <label><input class="input-filter" name="lid[]" type="checkbox" value="{{$supervisor->id_empleado}}"> {{$supervisor->nombre_empleado}}</label> 
                                                            @endif
                                                        @endforeach
                                                        {{-- @foreach ($responsables as $responsable)
                                                            <label><input name="responsables[]" type="checkbox" value="{{$responsable->id_empleado}}"> {{$responsable->nombre_empleado}}</label>
                                                        @endforeach --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Estados:</label>
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="estados[]" checked> (Seleccionar todo)</label>
                                                        @foreach ($estados as $estado)

                                                            @if (is_null($flt_est))
                                                                @if ($estado->id_estado < 9)
                                                                    <label><input class="input-filter" name="estados[]" type="checkbox" value={{$estado->id_estado}} checked> {{$estado->nombre_estado}}</label>
                                                                @else
                                                                    <label><input class="input-filter" name="estados[]" type="checkbox" value={{$estado->id_estado}}> {{$estado->nombre_estado}}</label>
                                                                @endif
                                                            @else
                                                                @if (in_array($estado->id_estado, $flt_est))
                                                                    <label><input class="input-filter" name="estados[]" type="checkbox" value={{$estado->id_estado}} checked> {{$estado->nombre_estado}}</label>
                                                                @else
                                                                    <label><input class="input-filter" name="estados[]" type="checkbox" value={{$estado->id_estado}}> {{$estado->nombre_estado}}</label>
                                                                @endif
                                                            @endif
                                                    
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1 my-auto">
                                
                                {!! Form::submit('Filtrar', ['class' => 'btn btn-success w-100', 'id' => 'btn-filtrar']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>                     
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                            {{-- @if (count($proyectos) != 0)
                                <div class="pagination justify-content-end">
                                    {!! $proyectos->links() !!}
                                </div>
                            @endif --}}
                        <div class="table-responsive">
                            <div id="tableFixHead">
                                <table class="table table-striped mt-2" id="example">
                                    <thead style="height:50px;background-color:#28587d;">
                                        <th class='text-center' style="color:#fff;width: 1vw">Prioridad</th>
                                        {{-- <th class='text-center' style="color:#fff;">Fecha</th> --}}
                                        <th class='ml-3 text-center' style="color:#fff;width: 10vw">ID</th>
                                        <th class='text-center' style="color:#fff;width: 8vw">Nombre</th>
                                        <th class='text-center' style="color:#fff;">Tipo</th>
                                        {{-- <th class='text-center' style="color:#fff;">Tipo proyecto</th> --}}
                                        <th class='text-center' style="color:#fff;width: 5vw">Lider</th>
                                        <th class='text-center' style="color:#fff;">Progreso</th>
                                        {{-- <th class='text-center' style="color:#fff;">Ordenes</th> --}}
                                        <th class='text-center' style="color:#fff;">Estado</th>
                                        <th class='text-center' style="color:#fff;width: 5vw">Fecha inicio</th>
                                        <th class='text-center' style="color:#fff;width: 5vw">Fecha limite</th>
                                        <th class='text-center' style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody  id="accordion">
                                        @php
                                            $idCount = 0;
                                        @endphp
                                        @foreach ($proyectos as $proyecto)
                                            {{-- <tr>
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->prioridad_servicio}}</td>
    
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->codigo_servicio}}</td>
    
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_servicio}}</td>
    
                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_subtipo_servicio}}</td>
    
                                                <td class='text-center' style="vertical-align: middle;"><abbr title="{{$proyecto->lider ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($proyecto->lider, 0, 10) ?? "-"}} <i class="fas fa-eye"></i></abbr></td>
    
                                                <td class= 'text-center' style="vertical-align: middle;">
                                                    <div class="progress position-relative" style="background-color: #b2baf8">
                                                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$proyecto->getOrdenesRealizadasPorcentaje()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$proyecto->getOrdenesRealizadas()}}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class= 'text-center' style="vertical-align: middle;">{{$proyecto->nombre_estado}}</td>
    
                                                <td class= 'text-center'style="vertical-align: middle;">{{$proyecto->fecha_inicio}}</td>
                                                
                                                <td class= 'text-center' style="vertical-align: middle;">{{$proyecto->fecha_limite}}</td>
                                                <td>
                                                    <div class="row justify-content-center">
                                                        <div class="row justify-content-center" >
                                                            <button class="btn btn-primary w-100 my-auto" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProyectos{{$idCount}}" aria-expanded="false" aria-controls="collapseProyectos{{$idCount}}">
                                                                Opciones <i class="fas fa-chevron-down m-auto"></i>
                                                            </button>
                                                        </div>
                                                        <div class="collapse" data-bs-parent="#accordion" id="collapseProyectos{{$idCount}}">
                                                            @can('MODIFICAR-PRIORIDAD-PROYECTO')
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modificarPrioridadModal" onclick="cargarModalModif({{$proyecto->id_servicio}}, this)">
                                                                        Prioridad  
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            @endcan
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['proyectos.gestionar', $proyecto->id_servicio], 'style' => 'display:inline']) !!}
                                                                        {!! Form::text('prefijo', $prefijo, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!}
                                                                        {!! Form::text('tipo', $tipo, ['style' => 'disabled;', 'class' => 'form-control', 'hidden']) !!}
                                                                    {!! Form::submit('Gestionar', ['class' => 'btn btn-success w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr> --}}
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
    <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/filter.js') }}"></script>
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

{{-- <script>
    $(document).ready(function () {
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
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
    });
</script> --}}

<script>
    let x = '';

    $(document).ready(function () {
        var url = '{{url('/')}}';
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;

        $('#example').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ a _PAGES_ de _TOTAL_',
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
                order: [[0, 'asc']],
                "pageLength": 25
        });
    });

    /*$(document).ready( function () {
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        //dudoso

        document.getElementById('ayudin').hidden = false;
        // let tipo_orden = window.location.pathname.substring(9, 10);
        // modificarFormularioConArgumentos(tipo_orden, 'formulario-editar-orden', true);
        // document.getElementById('encabezado_ordenes').style.backgroundColor = colorEncabezadoPorTipoDeOrden(tipo_orden);
        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
            var positions = $('input:checkbox[name="lid"]:checked').map(function() {
                return this.value;
            }).get();
        
            if (positions.length === 0) {
                return true;
            }
            
            if (positions.indexOf(searchData[4]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="subtip"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[3]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="est"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[6]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="cod_serv"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }


            if (offices.indexOf(searchData[1]) !== -1) {
                return true;
            }
            
            return false;
            }
        );
    var table = $('#example').DataTable();
  
    $('input:checkbox').on('change', function () {
        table.draw();
    });

    } ); */
</script>

<script>
    // <i class="fas fa-chevron-right"></i>
    $(document).ready(function () {
        $('.collapse')
                .on('shown.bs.collapse', function() {
                    $(this)
                        .parent()
                        .find(".fa-chevron-down")
                        .removeClass("fa-chevron-down")
                        .addClass("fa-chevron-right");
                })
                .on('hidden.bs.collapse', function() {
                    $(this)
                        .parent()
                        .find(".fa-chevron-right")
                        .removeClass("fa-chevron-right")
                        .addClass("fa-chevron-down");          
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