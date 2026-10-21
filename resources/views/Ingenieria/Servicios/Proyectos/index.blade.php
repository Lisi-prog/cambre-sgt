@extends('layouts.app')
@section('titulo', $tipo ?? '')
@section('content')

<link rel="stylesheet" href="{{ asset('css/estilos-tabla.css') }}">

@include('layouts.modal.delete', ['modo' => 'Agregar'])

<section class="section">
    <div class="section-header d-flex mb-3">
        <div class="d-flex">
            <div class="my-auto">
                <h4 class="titulo page__heading my-auto">{{$tipo ?? ''}}</h4>
            </div>
        </div>
        
        <div class="d-flex ms-auto">
            <div class="me-2">
            </div>
            <div class="">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearProyectoModal">
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
                                    <thead style="height:50px;background-color:#28587d;"><tr>
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
                                        <th class='text-center' style="color: #fff; width: 10%;">Acciones</th>
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


        const filtrosProyectos = @json($filtrosIniciales);
        let valoresProyectos = null;
        const tieneSSI = @json((int) $opcion === 3);
        const ultimaColumna = tieneSSI ? 10 : 9;
        const columnas = Array.from({length: ultimaColumna}, (_, i) => i);
        $('#example').DataTable({
            serverSide: true, processing: true, searchDelay: 350,
            pageLength: 10, lengthMenu: [10, 25, 50, 100, 500],
            order: [[0, 'asc']],
            ajax: {
                url: '{{ route('proyectos.datos') }}', type: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                data: function (datos) {
                    datos.alcance = @json($alcance);
                    datos.filtrosCabecera = JSON.stringify(filtrosProyectos);
                    datos.opcionesFiltros = valoresProyectos === null;
                },
                dataSrc: function (respuesta) {
                    if (respuesta.opcionesFiltros) valoresProyectos = respuesta.opcionesFiltros;
                    return respuesta.data;
                }
            },
            columnDefs: [
                {targets: '_all', className: 'align-middle', defaultContent: '-'},
                {targets: tieneSSI ? [2, 3] : [1, 2], className: 'text-left text-start'},
                {targets: columnas.concat([ultimaColumna]).filter(function (indice) {
                    return !(tieneSSI ? [2, 3] : [1, 2]).includes(indice);
                }), className: 'text-center'},
                {targets: ultimaColumna, orderable: false, searchable: false}
            ],
            language: {
                emptyTable: 'No hay datos disponibles en la tabla', loadingRecords: 'Cargando proyectos...',
                processing: 'Procesando...', lengthMenu: 'Mostrar _MENU_ registros por pagina',
                zeroRecords: 'No se encontraron coincidencias', info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                infoEmpty: 'No hay registros', infoFiltered: '(de _MAX_ registros totales)', search: 'Buscar',
                paginate: {first: 'Prim.', last: 'Ult.', previous: 'Ant.', next: 'Sig.'}
            },
            drawCallback: function () { changeTdColor(); },
            initComplete: function () {
                agregarFiltrosCabecera(this.api(), {columnas: columnas,
                    servidor: {valores: valoresProyectos, selecciones: filtrosProyectos}});
            }
        });
    });
</script>

<script>
    // <i class="fas fa-chevron-right"></i>
    $(document).ready(function () {
        $(document).on('shown.bs.collapse', '#accordion .collapse', function() {
                    $(this)
                        .parent()
                        .find(".fa-chevron-down")
                        .removeClass("fa-chevron-down")
                        .addClass("fa-chevron-right");
                })
                .on('hidden.bs.collapse', '#accordion .collapse', function() {
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
                    if (opcion === 1) {
                        const tabla = $('#example').DataTable();
                        const nodo = tabla.table().node();
                        const abiertos = new Set(Array.from(nodo.querySelectorAll('.collapse.show'), panel => panel.id));
                        tabla.ajax.reload(function () {
                            nodo.querySelectorAll('.collapse').forEach(panel => {
                                if (!abiertos.has(panel.id)) return;
                                panel.classList.add('show');
                                nodo.querySelectorAll('[data-bs-toggle="collapse"]').forEach(boton => {
                                    if (boton.getAttribute('data-bs-target') !== '#' + panel.id) return;
                                    boton.setAttribute('aria-expanded', 'true');
                                    boton.classList.remove('collapsed');
                                    $(boton).find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                                });
                            });
                        }, false);
                    }
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
                                <td class="text-center">${element.codigo}</td>
                                <td class="text-center">${element.fecha_carga}</td>
                                <td class="text-center"><abbr title="${element.descripcion ?? ''}" style="text-decoration:none; font-variant: none;">${(element.descripcion ?? '').slice(0, 25)} <i class="fas fa-eye"></i></abbr></td>
                                <td class="text-center">${element.fecha_limite}</td>
                                <td class="text-center">${element.estado}</td>
                                <td class="text-center">${element.responsable}</td>
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
                                    <td class="text-center">${element.codigo}</td>
                                    <td class="text-center">${element.fecha_carga}</td>
                                    <td class="text-center"><abbr title="${element.descripcion ?? ''}" style="text-decoration:none; font-variant: none;">${(element.descripcion ?? '').slice(0, 25)} <i class="fas fa-eye"></i></abbr></td>
                                    <td class="text-center">${element.fecha_limite}</td>
                                    <td class="text-center">${element.estado}</td>
                                    <td class="text-center">${element.responsable}</td>
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
