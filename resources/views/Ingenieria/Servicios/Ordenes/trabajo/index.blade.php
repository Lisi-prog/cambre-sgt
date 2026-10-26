@extends('layouts.app')
@section('titulo', 'Ordenes')
@section('content')

<link rel="stylesheet" href="{{ asset('css/estilos-tabla.css') }}">

<section class="section">
    <div class="section-header d-flex mb-3">
        <div class="d-flex">
            <div class="my-auto">
                <h4 class="titulo page__heading my-auto">Ordenes de Trabajo</h4>
            </div>
        </div>
        
        <div class="d-flex ms-auto">
            <div class="me-2">
            </div>
            <div class="">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verCargaMultiTime" onclick="" id="btn-sel-mul-ti">
                        Carga Multiple
                    </button>
                </div>
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

                        <div class="table-responsive">
                            <table class="table table-striped mt-2" id="example">
                                <thead id="encabezado_ordenes"><tr>
                                    <th class='text-center' style="color:#fff;min-width:2vw" hidden id="enc_sel"></th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Prioridad</th>
                                    <th class='text-center' style="color:#fff; width:13vw">Proyecto</th>
                                    <th class='text-center' style="color:#fff;" hidden>Proyecto</th>
                                    <th class='text-center' style="color:#fff;min-width:14vw">Orden</th>
                                    <th class='text-center' style="color:#fff;min-width:12vw">Etapa</th>
                                    <th class='text-center' style="color:#fff;min-width:4vw">Estado</th>
                                    <th class='text-center' style="color:#fff;min-width:6vw">Supervisor</th>
                                    <th class='text-center' style="color:#fff;min-width:6vw">Responsable</th>
                                    <th class='text-center' style="color:#fff;">Horas</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Fecha limite</th>
                                    <th class='text-center' style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                                    <th class='text-center' style="color: #fff; width:10%">Acciones</th>
                                </tr></thead>
                                
                                <tbody id="accordion"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


@include('Ingenieria.Servicios.Ordenes.modal.ver-orden')
@include('Ingenieria.Servicios.Ordenes.modal.editar-orden')
@include('Ingenieria.Servicios.Ordenes.modal.ver-partes', ['estadosParte' => $estados])
@include('Ingenieria.Servicios.Ordenes.modal.crear-parte-multiple-time')

@endsection
@section('scripts')
    @role('SUPERVISOR')
        @php
            $es_sup = 1;
        @endphp
    @else
        @php
            $es_sup = 0;
        @endphp
    @endrole
    <script src="{{ asset('js/change-td-color.js') }}?v={{ filemtime(public_path('js/change-td-color.js')) }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/ordenes.js') }}?v={{ filemtime(public_path('js/Ingenieria/Servicios/Ordenes/ordenes.js')) }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/crear-parte-multiple-time.js') }}?v={{ filemtime(public_path('js/Ingenieria/Servicios/Ordenes/crear-parte-multiple-time.js')) }}"></script>

    <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
    <script type="module" > 
        import {crearCuadrOrdenes, cargarModalVerOrden, obtenerPartes, modificarFormularioConArgumentos, cargarModalEditarOrden, colorEncabezadoPorTipoDeOrden} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
        window.crearCuadrOrdenes = crearCuadrOrdenes;
        window.cargarModalVerOrden = cargarModalVerOrden;
        window.obtenerPartes = obtenerPartes;
        window.modificarFormularioConArgumentos= modificarFormularioConArgumentos;
        window.cargarModalEditarOrden = cargarModalEditarOrden;
        window.colorEncabezadoPorTipoDeOrden = colorEncabezadoPorTipoDeOrden;
    </script>
<script>
    let x = '';
    let ind_rw = '';
    let id_emp = {{Auth::user()->getEmpleado->id_empleado}};
    let es_super = {{$es_sup}};
    var table;
    $(document).ready( function () {
        
        var url = '{{url('/')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
        //dudoso
        document.getElementById('ayudin').hidden = false;
        let nombreArchivo = 'orden';

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
        
        let tipo_orden = 1;
        modificarFormularioConArgumentos(tipo_orden, 'formulario-editar-orden', true);
        document.getElementById('encabezado_ordenes').style.backgroundColor = colorEncabezadoPorTipoDeOrden(tipo_orden);
        const filtrosTrabajo = {6: {excluir: @json($estadosExcluidos)}};
        let opcionesTrabajo = null;
        table = $('#example').DataTable({
            serverSide: true, processing: true, searchDelay: 350,
            ajax: {
                url: '{{ route('ordenes.trabajo.datos') }}', type: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                data: function (datos) {
                    datos.filtrosCabecera = JSON.stringify(filtrosTrabajo);
                    datos.opcionesFiltros = opcionesTrabajo === null;
                },
                dataSrc: function (respuesta) {
                    if (respuesta.opcionesFiltros) opcionesTrabajo = respuesta.opcionesFiltros;
                    return respuesta.data;
                }
            },
            columns: Array.from({length: 13}, (_, i) => ({data: 'celdas.' + i})),
            columnDefs: [
                {targets: '_all', defaultContent: '-', className: 'text-center align-middle'},
                {targets: [0, 3], visible: false, searchable: false, orderable: false},
                {targets: 12, searchable: false, orderable: false}
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
                    columnas: [1, 2, 4, 5, 6, 7, 8, 9, 10, 11],
                    servidor: {valores: opcionesTrabajo, selecciones: filtrosTrabajo},
                    excluirInicialmente: {6: @json($estadosExcluidos)}
                });
            }
        });

    $('#example tbody').on('click', 'tr', function () {
        ind_rw = table.row(this).index();
   });

    $('#verPartesModal').on('hidden.bs.modal', function (e) {
        nuevoParte();
        actRow();
    })

    $('#editarOrdenModal').on('hidden.bs.modal', function (e) {
        actRow();
    })


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
                    recargarPartes(id_orden, data.tipo_orden);
                    nuevoParte();
                    setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);
                }
            });
    });

    $(".nuevo-editar-orden").on('submit', function(evt){
            evt.preventDefault();     
            // console.log('hola');

            var url_php = $(this).attr("action"); 
            var type_method = $(this).attr("method"); 
            var form_data = $(this).serialize();

            $.ajax({
                type: type_method,
                url: url_php,
                data: form_data,
                success: function(data) {
                    // console.log(data);
                    html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modalOrd">
                                            `+data+`
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                    $('#alertOrd').html(html);
                    actRow();
                    setTimeout(function(){document.getElementById('msj-modalOrd').hidden = true;},3000);
                }
            });

    });
    } );
    
</script>

<script>
    function actRow() {
        const abiertos = Array.from(document.querySelectorAll('#example .collapse.show'), panel => panel.id);
        table.ajax.reload(function () {
            abiertos.forEach(function (id) {
                const panel = document.getElementById(id);
                if (!panel) return;
                panel.classList.add('show');
                document.querySelectorAll('[aria-controls="' + id + '"]').forEach(boton => boton.setAttribute('aria-expanded', 'true'));
            });
        }, false);
    }
    function actOrdenes() { actRow(); }
</script>
@endsection
