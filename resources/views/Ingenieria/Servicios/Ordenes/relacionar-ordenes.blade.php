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

    .btn-primary-outline {
        background-color: transparent;
        border-color: transparent;
    }
</style>
@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    
    <div class="section-header d-flex">
        <div class="">
            <h4 class="titulo page__heading my-auto">Ordenes</h4>
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
                        <div class="row" id="demo" hidden>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 150px;">
                                            <div class="">
                                                <label>Tipo orden:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                <label><input name="tipo" type="checkbox" value="Trabajo"> Trabajo</label>
                                                <label><input name="tipo" type="checkbox" value="Manufactura"> Manufactura</label>
                                                <label><input name="tipo" type="checkbox" value="Mecanizado"> Mecanizado</label>
                                                <label><input name="tipo" type="checkbox" value="Mantenimiento"> Mantenimiento </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 150px;">
                                            <div class="">
                                                <label>Supervisor:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                @foreach ($supervisores->sortBy('name') as $supervisor)
                                                    <label><input name="sup" type="checkbox" value="{{$supervisor->name}}"> {{$supervisor->name}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 150px;">
                                            <div class="">
                                                <label>Responsable:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                @foreach ($responsables as $responsable)
                                                    <label><input name="res" type="checkbox" value="{{$responsable->nombre_empleado}}"> {{$responsable->nombre_empleado}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="row">
                                    <div class="d-flex flex-row align-items-start justify-content-around">
                                        <div class="card-body d-flex flex-column" style="height: 150px;">
                                            <div class="">
                                                <label>Estados:</label>
                                            </div>
                                            <div class="d-flex flex-column overflow-auto">
                                                @foreach ($estados as $estado)
                                                    <label><input name="est" type="checkbox" value="{{$estado->nombre}}"> {{$estado->nombre}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                        {{-- <div class="pagination justify-content-end">
                                {!! $CategoriasLaborales->links() !!}
                        </div> --}}
                        {!! Form::open(['route' => 'ordenes.relacionar', 'method' => 'POST', 'class' => 'formulario']) !!}
                        <div class="table-responsive" id="formulario">
                            <table class="table table-striped mt-2" id="example">
                                <thead style="height:50px;">
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
                                    <th class='text-center' style="color:#fff; width:15vh">Proyecto</th>
                                    <th class='text-center' style="color:#fff;">Etapa</th>
                                    <th class='text-center' style="color:#fff;">Orden</th>
                                    {{-- <th class='text-center' style="color:#fff;">Tipo de orden</th> --}}
                                    {{-- <th class='text-center' style="color:#fff;">Estado</th> --}}
                                    {{-- <th class='text-center' style="color:#fff;">Supervisor</th> --}}
                                    <th class='text-center' style="color:#fff;">Responsable</th>
                                    <th class='text-center' style="color:#fff; width:9vh">Fecha inicio</th>
                                    <th class='text-center' style="color:#fff; width:9vh">Fecha limite</th>
                                    {{-- <th class='text-center' style="color:#fff;">Fecha finalizacion</th> --}}
                                    <th class='text-center' style="color: #fff;">Id</th>
                                    <th class='text-center' style="color: #fff;">Relacion</th>
                                    <th class='text-center' style="color: #fff;">Id hija</th>
                                </thead>
                                
                                <tbody>
                                    @foreach ($ordenes as $orden)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->getEtapa->getServicio->prioridad_servicio}}</td>
                                            
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->getEtapa->getServicio->nombre_servicio}}" style="text-decoration:none; font-variant: none;">{{$orden->getEtapa->getServicio->codigo_servicio}} <i class="fas fa-eye"></i></abbr></td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->getEtapa->descripcion_etapa}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{$orden->nombre_orden}}</td>

                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$orden->getOrdenDe->getNombreTipoOrden()}}</td> --}}
                                            
                                            {{-- @switch($orden->getOrdenDe->getTipoOrden())
                                                @case(1)
                                                    <td class='text-center' style="vertical-align: middle;">{{$orden->getPartes->sortByDesc('id_parte')->first()->getParteTrabajo->getEstado->nombre_estado ?? ''}}</td>
                                                    @break
                                                @case(2)
                                                    <td class='text-center' style="vertical-align: middle;">{{$orden->getPartes->sortByDesc('id_parte')->first()->getParteManufactura->getEstadoManufactura->nombre_estado_manufactura ?? ''}}</td>
                                                    @break
                                                @case(3)
                                                    <td class='text-center' style="vertical-align: middle;">{{$orden->getPartes->sortByDesc('id_parte')->first()->getParteMecanizado->getEstadoMecanizado->nombre_estado_mecanizado ?? ''}}</td>
                                                    @break
                                                @default
                                                    
                                            @endswitch --}}
                                            
                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$orden->getSupervisor()}}</td> --}}
                                            
                                            <td class='text-center' style="vertical-align: middle;">{{$orden->getNombreResponsable()}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($orden->fecha_inicio ?? '')->format('d-m-Y')}}</td>

                                            <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($orden->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite ?? '')->format('d-m-Y')}}</td>
                                            
                                            {{-- <td class='text-center' style="vertical-align: middle;">{{$orden->getFechaFinalizacion()}}</td> --}}
                                                {{-- ORDEN ACTUAL --}}
                                             <td class='text-center' style="vertical-align: middle;"> {{--{{$orden->id_orden}} --}}
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            {!! Form::text('id_orden[]', $orden->id_orden, ['class' => 'text-center form-control', 'id' => 'input_id_orden', 'readonly']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- RELACION --}}
                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            {{-- {!! Form::label('relacion', 'Relacion:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!} --}}
                                                            {{-- <span class="obligatorio">*</span> --}}
                                                            {!! Form::select('relacion[]', $relaciones->pluck('nombre_relacion_gantt'), null, [
                                                                'placeholder' => 'Seleccionar',
                                                                'class' => 'form-select form-group',
                                                                'id' => 'relacion'
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- ORDEN HIJA --}}
                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            {!! Form::text('id_orden_hija[]', null, ['class' => 'text-center form-control', 'id' => 'input_id_orden_hija']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                        {!! Form::close() !!}
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
    $(document).ready( function () {
        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
            var positions = $('input:checkbox[name="sup"]:checked').map(function() {
                return this.value;
            }).get();
        
            if (positions.length === 0) {
                return true;
            }
            
            if (positions.indexOf(searchData[6]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="res"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[7]) !== -1) {
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
            
            if (offices.indexOf(searchData[5]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="tipo"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[4]) !== -1) {
                return true;
            }
            
            return false;
            }
        );

    var table = $('#example').DataTable();
  
    $('input:checkbox').on('change', function () {
        table.draw();
    });

    } );
</script>

{{-- <script>
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
</script> --}}

<script>
    function mostrarFiltro(){
        let cuadro_filtro = document.getElementById("demo");
        if ($('#demo').is(":hidden")) {
            cuadro_filtro.hidden = false;
        }else{
            cuadro_filtro.hidden = true;
        }
    }
</script>

@endsection