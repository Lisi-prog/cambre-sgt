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

            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 my-auto">
                <h4 class="titulo page__heading my-auto">{{$tipo ?? ''}}</h5>
            </div>
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
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
                        <div class="row" id="demo" hidden>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-11">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="row">
                                            <div class="d-flex flex-row align-items-start justify-content-around">
                                                <div class="card-body d-flex flex-column" style="height: 200px;">
                                                    <div class="">
                                                        <label>Proyectos:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('pry', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                            <label style="font-style: italic"><input name="filter" type="checkbox" value="pry" checked> (Seleccionar todo)</label>
                                                        @foreach ($proyectos->sortBy('codigo_servicio') as $proyecto)

                                                            @if (!empty($flt_serv))
                                                                <label><input class="input-filter" name="pry" type="checkbox" value="{{$proyecto->codigo_servicio}}" {{in_array($proyecto->id_servicio, $flt_serv) ? 'checked' : ''}}> {{$proyecto->codigo_servicio}}</label>
                                                            @else
                                                                <label><input class="input-filter" name="pry" type="checkbox" value="{{$proyecto->codigo_servicio}}" checked> {{$proyecto->codigo_servicio}}</label>
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
                                                        <label>Tipo:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('tip', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="tip" checked> (Seleccionar todo)</label>
                                                        @foreach ($subtipos_servicio as $subtipo_servicio)
                                                            @if (is_null($flt_tip) || in_array($subtipo_servicio->id_subtipo_servicio, $flt_tip))
                                                                <label><input class="input-filter" name="tip" type="checkbox" value="{{$subtipo_servicio->nombre_subtipo_servicio}}" checked> {{$subtipo_servicio->nombre_subtipo_servicio}}</label>
                                                            @else
                                                                <label><input class="input-filter" name="tip" type="checkbox" value="{{$subtipo_servicio->nombre_subtipo_servicio}}"> {{$subtipo_servicio->nombre_subtipo_servicio}}</label>
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
                                                        <label>Lider:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('lid', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="lid" checked> (Seleccionar todo)</label>
                                                        @foreach ($supervisores as $supervisor)
                                                            @if (is_null($flt_lid) || in_array($supervisor->id_empleado, $flt_lid))
                                                                <label><input class="input-filter" name="lid" type="checkbox" value="{{$supervisor->nombre_empleado}}" checked> {{$supervisor->nombre_empleado}}</label>
                                                            @else
                                                                <label><input class="input-filter" name="lid" type="checkbox" value="{{$supervisor->nombre_empleado}}"> {{$supervisor->nombre_empleado}}</label>
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
                                                        <label>Estados:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('est', this)">
                                                    </div>
                                                    <div class="d-flex flex-column overflow-auto">
                                                        <label style="font-style: italic"><input name="filter" type="checkbox" value="est" checked> (Seleccionar todo)</label>
                                                        @foreach ($estados as $estado)

                                                            @if (is_null($flt_est))
                                                                @if ($estado->id_estado < 9)
                                                                    <label><input class="input-filter" name="est" type="checkbox" value="{{$estado->nombre_estado}}" checked> {{$estado->nombre_estado}}</label>
                                                                @else
                                                                    <label><input class="input-filter" name="est" type="checkbox" value="{{$estado->nombre_estado}}"> {{$estado->nombre_estado}}</label>
                                                                @endif
                                                            @else
                                                                @if (in_array($estado->id_estado, $flt_est))
                                                                    <label><input class="input-filter" name="est" type="checkbox" value="{{$estado->nombre_estado}}" checked> {{$estado->nombre_estado}}</label>
                                                                @else
                                                                    <label><input class="input-filter" name="est" type="checkbox" value="{{$estado->nombre_estado}}"> {{$estado->nombre_estado}}</label>
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
                        <div class="table-responsive">
                            <div id="tableFixHead">
                                <table class="table table-striped mt-2" id="example">
                                    <thead style="height:50px;background-color:#28587d;">
                                        <th class='text-center' style="color:#fff;width: 1vw">Prioridad</th>
                                        @if ($opcion == 3)
                                            <th class='text-center' style="color:#fff;width: 2vw" >SSI</th>
                                        @endif
                                        <th class='ml-3 text-center' style="color:#fff;width: 10vw">ID</th>
                                        <th class='text-center' style="color:#fff;width: 8vw">Nombre</th>
                                        <th class='text-center' style="color:#fff;">Tipo</th>
                                        <th class='text-center' style="color:#fff;width: 5vw">Lider</th>
                                        <th class='text-center' style="color:#fff;">Progreso</th>
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
                                            <tr>
                                                <td class='text-center' style="vertical-align: middle;" data-order={{$proyecto->prioridad_servicio ?? 9999999999999}}>{{$proyecto->prioridad_servicio ?? 'S/P'}}</td>

                                                @if ($opcion == 3)
                                                    <td class='text-center' style="vertical-align: middle;">{{$proyecto->getSolicitud->id_solicitud ?? '-'}}</td>
                                                @endif

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->codigo_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->nombre_subtipo_servicio}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$proyecto->lider ?? '-'}}</td>

                                                <td class= 'text-center' style="vertical-align: middle;">
                                                    <div class="progress position-relative" style="background-color: #b2baf8">
                                                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$proyecto->progreso}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$proyecto->total_ord_completa.'/'.$proyecto->total_ord}}</span>
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
                                                                    @if ($proyecto->id_subtipo_servicio != 6)
                                                                        <a href="{{ route('proyectos.gestionar', [$proyecto->id_servicio, 'opcion' => $opcion]) }}" class="btn btn-success w-100">
                                                                            Gestionar
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ route('servicio_mantenimiento.gestionar', [$proyecto->id_servicio, 'opcion' => $opcion]) }}" class="btn btn-success w-100">
                                                                            Gestionar
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row my-2 justify-content-center">
                                                                <div class="col-12">
                                                                    <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#verActualizacionModal" onclick="cargarModalActualizaciones({{$proyecto->id_servicio}})">
                                                                        Actualizaciones
                                                                    </button>
                                                                </div>
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
    </div>
    <script src="{{ asset('js/change-td-color.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/filter.js') }}"></script>
    <script src="{{ asset('js/filter-to-filter.js') }}"></script>
</section>
@include('Ingenieria.Servicios.Proyectos.modal.ver-act-serv')

<script>
    let x = '';
    $(document).ready(function () {
        var url = '{{url('/')}}';
        document.getElementById('volver').href = url;
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'proyecto';

        $.when($.ajax({
            type: "post",
            url: '/documentacion/obtener/'+nombreArchivo,
            data: {
                nombreArchivo: nombreArchivo,
            },
            success: function (response) {
                document.getElementById('ayudin').href = "{{url('/')}}"+'/'+response;
            },
            error: function (error) {
                console.log(error);
            }
        }));


        const tabla2 = document.querySelector('#example');
        const encabezados = tabla2.querySelectorAll('thead th');

        let indexPry = -1;
        let indexTip = -1;
        let indexLid = -1;
        let indexEstado = -1;

        encabezados.forEach((th, index) => {
            if (th.textContent.trim() === 'ID') {
                indexPry = index;
            }
            if (th.textContent.trim() === 'Tipo') {
                indexTip = index;
            }
            if (th.textContent.trim() === 'Lider') {
                indexLid = index;
            }
            if (th.textContent.trim() === 'Estado') {
                indexEstado = index;
            }
        });

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
                var positions = $('input:checkbox[name="pry"]:checked').map(function() {
                    return this.value;
                }).get();
            
                if (positions.length === 0) {
                    return true;
                }
                
                if (positions.indexOf(searchData[indexPry]) !== -1) {
                    return true;
                }
                
                return false;
            }
        );

        $.fn.dataTable.ext.search.push(
           function( settings, searchData, index, rowData, counter ) {
                var offices = $('input:checkbox[name="tip"]:checked').map(function() {
                        return this.value;
                }).get();
                

                if (offices.length === 0) {
                    return true;
                }
                    
                if (offices.indexOf(searchData[indexTip]) !== -1) {
                    return true;
                }
                    
                return false;
            }
        );

        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {
        
            var offices = $('input:checkbox[name="lid"]:checked').map(function() {
                return this.value;
            }).get();
        

            if (offices.length === 0) {
                return true;
            }
            
            if (offices.indexOf(searchData[indexLid]) !== -1) {
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
            
                if (offices.indexOf(searchData[indexEstado]) !== -1) {
                    return true;
                }
            
                return false;
            }
        );

        var tabla = $('#example').DataTable({
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
                lengthMenu: [
                    [25, 50, 100, 500, -1],
                    [25, 50, 100, 500, 'Todo']
                ],
                "pageLength": 100
        });

        $('input:checkbox').on('change', function () {
            tabla.draw();
        });

        tabla.on('draw',function () {
            changeTdColor();
        })
    });
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

        $(".nueva-act-serv").on('submit', function(evt){
            evt.preventDefault();     
            var url_php = $(this).attr("action"); 
            var type_method = $(this).attr("method"); 
            var form_data = $(this).serialize();
            let html = '';
            $.ajax({
                type: type_method,
                url: url_php,
                data: form_data,
                success: function(data) {
                    let id = document.getElementById('m_act_id_serv').value;
                    opcion = parseInt(data.resultado);
                    switch (opcion) {
                        case 1:
                            html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Actualizacion creado con exito.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                            break;
                        
                        case 0:
                            html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        Ocurrio un error: ${data.error}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                            break;
                    }
                    $('#alert-act-serv').html(html)
                    actualizarRecuadroAct(id);
                    setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);
                }
            });
        });

        $('#verActualizacionModal').on('hidden.bs.modal', function (e) {
            document.getElementById('m_act_id_serv').value = null;
        });
    });
</script>

<script>
    function cargarModalModif(id){
        let codigo = document.getElementById('m-codigo_proyecto');
        let nombre = document.getElementById('m-nombre_proyecto');
        let id_proyecto = document.getElementById('id_proyecto');
        let num_prioridad = document.getElementById('num_prioridad');
        document.getElementById('m_act_id_serv').value = id;

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

    function cargarModalActualizaciones(id) {
        let renglones_actualizacion = document.getElementById("cuadro-act");
        let html_act = '';
        document.getElementById("m-ver-act-div").hidden = true;
        document.getElementById("m-ver-act-btn").hidden = true;
        document.getElementById('m_act_id_serv').value = id;
        
        $.when($.ajax({
            type: "post",
            url: '/proyectos/obtener-actualizaciones-proyecto/'+id, 
            data: {
                id: id,
            },
        success: function (response) {
            response.forEach(element => {
                html_act += `<tr>
                                <td class="text-center">`+element.codigo+`</td>
                                <td class="text-center">`+element.fecha_carga+`</td>
                                <td class="text-center"><abbr title="`+element.descripcion+`" style="text-decoration:none; font-variant: none;">`+element.descripcion.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                                <td class="text-center">`+element.fecha_limite+`</td>
                                <td class="text-center">`+element.estado+`</td>
                                <td class="text-center">`+element.responsable+`</td>    
                                </tr>`
            });
            renglones_actualizacion.innerHTML = html_act;
        },
        error: function (error) {
            console.log(error);
        }
        }));
        cargarFechaEstadoLiderModalVerAct(id);
    }

    function verCargarActModal(){
        let cuadro_oculto_de_cargar_act = document.getElementById('m-ver-act-div');
        let btn_oculto_de_cargar_act = document.getElementById('m-ver-act-btn');
        if ($('#m-ver-act-div').is(":hidden")) {
            cuadro_oculto_de_cargar_act.hidden = false;
            btn_oculto_de_cargar_act.hidden = false;
        }else{
            cuadro_oculto_de_cargar_act.hidden = true;
            btn_oculto_de_cargar_act.hidden = true;
        }
    }

    function cargarFechaEstadoLiderModalVerAct(id){
        let estado = document.getElementById("m-ver-act-id_estado");
        let fecha_limite = document.getElementById("m-ver-act-fecha_limite");
        let lider = document.getElementById("m-ver-act-cbx_lider");
        document.getElementById('m-ver-act-desc').value = '';
        $.when($.ajax({
            type: "post",
            url: '/proyectos/obtener-ultima-actualizacion-servicio/'+id, 
            data: {
                id: id,
            },
        success: function (response) {
            estado.value = response[0].estado;
            fecha_limite.value = response[0].fecha_limite;
            lider.value = response[0].lider;
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }

    function actualizarRecuadroAct(id){
        let renglones_actualizacion = document.getElementById("cuadro-act");
        let html_act = '';
        $.when($.ajax({
            type: "post",
            url: '/proyectos/obtener-actualizaciones-proyecto/'+id, 
            data: {
                id: id,
            },
            success: function (response) {
                response.forEach(element => {
                    html_act += `<tr>
                                    <td class="text-center">`+element.codigo+`</td>
                                    <td class="text-center">`+element.fecha_carga+`</td>
                                    <td class="text-center"><abbr title="`+element.descripcion+`" style="text-decoration:none; font-variant: none;">`+element.descripcion.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                                    <td class="text-center">`+element.fecha_limite+`</td>
                                    <td class="text-center">`+element.estado+`</td>
                                    <td class="text-center">`+element.responsable+`</td>    
                                    </tr>`
                });
                renglones_actualizacion.innerHTML = html_act;
                cargarFechaEstadoLiderModalVerAct(id);
            },
            error: function (error) {
                console.log(error);
            }
        }));
    }

</script>
@include('Ingenieria.Servicios.Proyectos.modal.modificar-prioridad')
@include('Ingenieria.Servicios.Proyectos.modal.crear-proyecto')

@endsection
