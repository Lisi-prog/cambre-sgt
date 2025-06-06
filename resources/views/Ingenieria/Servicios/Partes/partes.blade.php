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
                        <div class="row">
                            <button type="button" class="btn btn-primary-outline m-1 rounded" onclick="mostrarFiltro()">Filtros <i class="fas fa-caret-down"></i></button> 
                        </div>
                        {!! Form::open(['method' => 'GET', 'route' => ['partes.tipo', $tipo_orden], 'style' => 'display:inline']) !!}
                        <div class="row" id="demo" hidden>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-11">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Proyectos:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('cod_serv[]', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                            <label style="font-style: italic"><input name="filter" type="checkbox" value="cod_serv[]" checked> (Seleccionar todo)</label>
                                                            @foreach ($flt_serv as $proyecto)
                                                                @if (is_null($servicios) || in_array($proyecto->id_servicio, $servicios))
                                                                    <label><input class="input-filter" name="cod_serv[]" type="checkbox" value="{{$proyecto->id_servicio}}" checked> {{$proyecto->codigo_servicio}}</label>
                                                                @else
                                                                    <label><input class="input-filter" name="cod_serv[]" type="checkbox" value="{{$proyecto->id_servicio}}"> {{$proyecto->codigo_servicio}}</label>
                                                                @endif
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
                                                        <label>Fecha desde:</label>
                                                    </div>
                                                    {!! Form::date('fecha_desde', $from, [
                                                        'min' => '2023-01-01',
                                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                                        'id' => 'fecha-desde-flt',
                                                        'class' => 'form-control'
                                                    ]) !!}
                                                    <div class="pt-3">
                                                        <label>Fecha hasta:</label>
                                                    </div>
                                                    {!! Form::date('fecha_hasta', $to, [
                                                        'min' => '2023-01-01',
                                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                                        'id' => 'fecha-hasta-flt',
                                                        'class' => 'form-control'
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @role('SUPERVISOR')
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="row" id='res-opcion'>
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Responsable:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('lid[]', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="lid[]" checked> (Seleccionar todo)</label>
                                                        @foreach ($flt_resp as $resp)
                                                            @if (is_null($respo) || in_array($resp->id_empleado, $respo))
                                                                <label><input class="input-filter" name="lid[]" type="checkbox" value="{{$resp->id_empleado}}" checked> {{$resp->nombre_empleado}}</label>
                                                            @else
                                                                <label><input class="input-filter" name="lid[]" type="checkbox" value="{{$resp->id_empleado}}"> {{$resp->nombre_empleado}}</label>
                                                            @endif
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
                                                        <label>Supervisor:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('sup[]', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="sup[]" checked> (Seleccionar todo)</label>
                                                        @foreach ($flt_sup as $sup)
                                                            @if (is_null($super) || in_array($sup->id_empleado, $super))
                                                                <label><input class="input-filter" name="sup[]" type="checkbox" value="{{$sup->id_empleado}}" checked> {{$sup->nombre_empleado}}</label>
                                                            @else
                                                                <label><input class="input-filter" name="sup[]" type="checkbox" value="{{$sup->id_empleado}}"> {{$sup->nombre_empleado}}</label>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endrole
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
                        <div class="pagination justify-content-end">
                                {!! $partes->links() !!}
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead id="encabezado_partes">
                                    <th class="text-center" scope="col" style="color:#fff;width:4vw">Cod. Parte</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:6vw">Proyecto</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:4vw">Orden</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:4vw">Etapa</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5vw">Fecha</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5vw">Fecha limite</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5vw">Estado</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:4vw">Horas</th>
                                    {{-- <th class="text-center" scope="col" style="color:#fff;mi-width:8vw">Observaciones</th> --}}
                                    @if($tipo_orden == 3) {{-- Mecanizado --}}
                                        <th id="column-maq" class="text-center" scope="col" style="color:#fff;">Maquina</th>
                                        <th id="column-hora-maq" class="text-center" scope="col" style="color:#fff;">Hora maquina</th>
                                    @endif
                                    @role('SUPERVISOR')
                                        <th class="text-center" scope="col" style="color:#fff;width:6vw">Responsable</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:6vw">Supervisor</th>
                                    @endrole
                                    <th class="text-center" scope="col" style="color:#fff;width:6vw">Acciones</th>
                                </thead>
                                <tbody id="accordion">
                                    @php
                                        $idCount = 0;
                                    @endphp
                                    {{-- id_parte, nombre_orden, fecha, fecha_limite, estado, horas, observaciones, responsable, id_responsable, supervisor, id_supervisor, horas_maquina, id_maquinaria, codigo_maquinaria --}}
                                    @foreach ($partes as $parte)
                                        <tr>
                                            <td class='text-center' style="vertical-align: middle;">{{$parte->id_parte}}</td>
                                            <td class='text-center' style="vertical-align: middle;"><abbr title="{{$parte->nombre_servicio}}" style="text-decoration:none; font-variant: none;">{{$parte->codigo_servicio}} <i class="fas fa-eye"></i></abbr></td>
                                            <td class='text-center' style="vertical-align: middle;">{{$parte->nombre_orden}}</td>
                                            <td class='text-center' style="vertical-align: middle;">{{$parte->descripcion_etapa}}</td>
                                            <td class='text-center' style="vertical-align: middle;">{{$parte->fecha}}</td>
                                            <td class='text-center' style="vertical-align: middle;">{{$parte->fecha_limite}}</td>
                                            <td class='text-center' style="vertical-align: middle;">{{$parte->estado}}</td>
                                            <td class='text-center' style="vertical-align: middle;">{{$parte->horas}}</td>
                                            {{-- <td class='text-center' style="vertical-align: middle;"><abbr title="{{$parte->observaciones}}" style="text-decoration:none; font-variant: none;">{{substr($parte->observaciones, 0, 30)}} <i class="fas fa-eye"></i></abbr></td>                                             --}}
                                            @if($tipo_orden == 3) {{-- Mecanizado --}}
                                                <td class='text-center' style="vertical-align: middle;">{{$parte->codigo_maquina ?? '-'}}</td>
                                                <td class='text-center' style="vertical-align: middle;">{{$parte->horas_maquina ?? '--:--'}}</td>
                                            @endif
                                            @role('SUPERVISOR')
                                                <td class='text-center' style="vertical-align: middle;">{{$parte->responsable}}</td>
                                                <td class='text-center' style="vertical-align: middle;">{{$parte->supervisor}}</td>
                                            @endrole
                                            <td class='text-center' style="vertical-align: middle;">
                                                <div class="row justify-content-center" >
                                                    <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePartes{{$idCount}}" aria-expanded="false" aria-controls="collapsePartes{{$idCount}}">
                                                        Opciones
                                                    </button>
                                                </div>
                                                <div class="collapse" data-bs-parent="#accordion" id="collapsePartes{{$idCount}}">
                                                    <div class="row my-2">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verParteModal" onclick="cargarModalVerParte({{$parte->id_parte}})">
                                                                Ver
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarParteModal" onclick="cargarModalEditarParte({{$parte->id_parte}})">
                                                                Editar
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-12">
                                                            <a href='/parte/{{$parte->id_parte}}/logs' target="_blank">
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
        import {colorEncabezadoPorTipoDeOrden, cargarModalEditarParte, cargarModalVerParte} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
        window.colorEncabezadoPorTipoDeOrden = colorEncabezadoPorTipoDeOrden;
        window.cargarModalEditarParte = cargarModalEditarParte;
        window.cargarModalVerParte = cargarModalVerParte;
    </script>
    <script src="{{ asset('js/Ingenieria/Servicios/Partes/filter.js') }}"></script>
    <script src="{{ asset('js/filter-to-filter.js') }}"></script>
</section>

@include('Ingenieria.Servicios.Partes.modal.editar-parte')
@include('Ingenieria.Servicios.Partes.modal.ver-parte')

<script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
<script src="{{ asset('js/change-td-color.js') }}"></script>
<script src="{{ asset('js/Ingenieria/Servicios/Ordenes/ordenes.js') }}"></script>

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
    let ind_rw = '';
    var table;
    $(document).ready(function () {
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        let tipo_orden = window.location.pathname.substring(12, 13);
        document.getElementById('encabezado_partes').style.backgroundColor = colorEncabezadoPorTipoDeOrden(tipo_orden);
        document.getElementById('volver').href = url;
        table = $('#example').DataTable({
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
                    order: [[4, 'desc']],
                    lengthMenu: [
                        [25, 50, 100, 500, -1],
                        [25, 50, 100, 500, 'Todo']
                    ],
                    "pageLength": 500
        });

        table.on('draw', function () {
            changeTdColor();
        })

        $('#example tbody').on('click', 'tr', function () {
            ind_rw = table.row(this).index();
            // let a = table.row(this).index();
            // var temp = table.row(a).data();
            // temp[0] = 'Tom';
            // table.row(this)
            // .data(temp)
            // .draw();
        });

        $('#editarParteModal').on('hidden.bs.modal', function (e) {
            //nuevoParte();
            actRowEditarParte();
        });

        $(".nuevo-editar-parte").on('submit', function(evt){
        
        evt.preventDefault();     
        var url_php = $(this).attr("action"); 
        var type_method = $(this).attr("method"); 
        var form_data = $(this).serialize();
        let html = '';
        let id_orden = document.getElementById('m-ver-parte-orden').value;
        $.ajax({
            type: type_method,
            url: url_php,
            data: form_data,
            success: function(data) {
                //console.log(data);
                opcion = parseInt(data.resultado);
                switch (opcion) {
                    case 1:
                        html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                        Parte creado con exito
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                        break;
                    case 2:
                        id = document.getElementById('m-id-parte').value;
                        html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                        Parte cod. `+id+` actualizado con exito
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                        break;
                    case 6:
                        html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                    No se puede actualizar un parte de la cual no eres responsable.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`;
                        break;
                    default:
                        html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                    Ocurrio un error
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`;
                        break;
                }
                $('#alert').html(html)
                //recargarPartes(id_orden, data.tipo_orden);
                //nuevoParte();
                setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);
            }
        });
    });
    });

    

    
</script>

    
@endsection