@extends('layouts.app')
@section('titulo', 'Ordenes Mecanizado')
@section('content')

<link rel="stylesheet" href="{{ asset('css/estilos-tabla.css') }}">

<style>
    #example.tabla-mecanizado { table-layout: fixed; width: 100%; }
    #example.tabla-mecanizado th,
    #example.tabla-mecanizado td {
        min-width: 0;
        padding: 6px 4px;
        white-space: normal;
        overflow-wrap: anywhere;
    }
    #example.tabla-mecanizado thead th div.dt-column-header { gap: 3px; }
    #example.tabla-mecanizado thead th div.dt-column-header .dt-column-title {
        min-width: 0;
        flex-wrap: wrap;
        gap: 3px;
        white-space: normal;
    }
    #example.tabla-mecanizado td:last-child .row { margin-left: 0; margin-right: 0; }
    #example.tabla-mecanizado td:last-child .col-12 { padding-left: 0; padding-right: 0; }
    #example.tabla-mecanizado td:last-child .btn {
        padding: 6px 3px;
        white-space: normal;
        overflow-wrap: anywhere;
    }
    #example.tabla-mecanizado td:last-child .btn-group { flex-wrap: wrap; }
</style>

<section class="section">
    <div class="section-header d-flex mb-3">
        <div class="d-flex">
            <div class="my-auto">
                <h4 class="titulo page__heading my-auto">Ordenes de Mecanizado</h4>
            </div>
            <div class="ms-3 my-auto">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="snHdr">
                    <label class="form-check-label" for="snHdr">Sin Hoja de Ruta</label>
                </div>
            </div>
        </div>
        
        <div class="d-flex ms-auto">
            <div class="me-2">
            </div>
            <div class="">
                @role('SUPERVISOR')
                <div class="d-flex align-items-center">
                    <div class="form-check form-switch me-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="id_selec">
                        <label class="form-check-label" for="id_selec">Seleccion<br>multiple</label>
                    </div>
                    <div class="form-check me-3" hidden id="chk-sel-all">
                        <input class="form-check-input" type="checkbox" value="" id="checkSelAll">
                        <label class="form-check-label" for="checkSelAll">
                        Seleccionar<br>pagina actual
                        </label>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verCargaMulti" onclick="cargarMMultiple()" id="btn-sel-mul">
                        Carga<br>Multiple
                    </button>
                </div>
                @endrole
            </div>
        </div>
    </div>

    <input type="hidden" name="opcion_tipo" value="3" class="form-control" id="opcion-tipo">

    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])

    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-sm mt-2 tabla-mecanizado" id="example" style="width:100%">
                                <thead id="encabezado_ordenes"><tr>
                                    <th class='text-center' style="color:#fff;" hidden id="enc_sel"></th>
                                    <th class='text-center' style="color:#fff;">Prioridad</th>
                                    <th class='text-center' style="color:#fff;">Proyecto</th>
                                    <th class='text-center' style="color:#fff;" hidden>Proyecto</th>
                                    <th class='text-center' style="color:#fff;">Orden</th>
                                    <th class='text-center' style="color:#fff;">Manufactura</th>
                                    <th class='text-center' style="color:#fff;">Progreso</th>
                                    <th class='text-center' style="color:#fff;">Estado</th>
                                    <th class='text-center' style="color:#fff;">Operacion Actual</th>
                                    <th class='text-center' style="color:#fff;">Estado Ope. Actual</th>
                                    <th class='text-center' style="color:#fff;">Fecha limite</th>
                                    <th class='text-center' style="color:#fff;">Total Hs. HDR</th>
                                    <th class='text-center' style="color:#fff;">Cantidad</th>
                                    <th class='text-center' style="color:#fff;">Responsable</th>
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

</section>


@include('Ingenieria.Servicios.Ordenes.modal.ver-orden')
@include('Ingenieria.Servicios.Ordenes.modal.editar-orden')
@include('Ingenieria.Servicios.Ordenes.modal.ver-partes', ['estadosParte' => $estados])
@include('Ingenieria.Servicios.Ordenes.modal.crear-parte-multiple')

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
    <script src="{{ asset('js/change-td-color.js') }}"></script>
    <script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
    <script src="{{ asset('js/Ingenieria/Servicios/Ordenes/ordenes.js') }}"></script>
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
    $("#loading").show();

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
        
        let tipo_orden = 3;
        modificarFormularioConArgumentos(tipo_orden, 'formulario-editar-orden', true);
        document.getElementById('encabezado_ordenes').style.backgroundColor = colorEncabezadoPorTipoDeOrden(tipo_orden);
        const filtrosMecanizado = {7: {excluir: @json($estadosExcluidos)}};
        @if ($manufacturaInicial !== null)
        filtrosMecanizado[5] = {incluir: [@json($manufacturaInicial)]};
        @endif
        let opcionesMecanizado = null;
        table = $('#example').DataTable({
            serverSide: true, processing: true, searchDelay: 350, autoWidth: false,
            ajax: {
                url: '{{ route('ordenes.mecanizado.datos') }}', type: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                data: function (datos) {
                    datos.sinHdr = document.getElementById('snHdr').checked;
                    datos.filtrosCabecera = JSON.stringify(filtrosMecanizado);
                    datos.opcionesFiltros = opcionesMecanizado === null;
                },
                dataSrc: function (respuesta) {
                    if (respuesta.opcionesFiltros) opcionesMecanizado = respuesta.opcionesFiltros;
                    return respuesta.data;
                }
            },
            columns: Array.from({length: 15}, (_, i) => ({data: 'celdas.' + i})),
            columnDefs: [
                {targets: '_all', defaultContent: '-', className: 'text-center align-middle'},
                {targets: [0, 3], visible: false, searchable: false, orderable: false},
                {targets: 14, searchable: false, orderable: false}
            ],
            createdRow: function (fila, datos) { fila.dataset.id = datos.id; },
            order: [[1, 'asc']], pageLength: 10, lengthMenu: [10, 25, 50, 100, 500],
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
            drawCallback: function () {
                changeTdColor();
                const seleccion = document.getElementById('id_selec').checked;
                this.api().rows().nodes().to$().find('.chk-input').prop('hidden', !seleccion);
                document.getElementById('checkSelAll').checked = false;
            },
            initComplete: function () {
                agregarFiltrosCabecera(this.api(), {
                    columnas: [1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                    servidor: {valores: opcionesMecanizado, selecciones: filtrosMecanizado},
                    excluirInicialmente: {7: @json($estadosExcluidos)}
                });
            }
        });

        $('#snHdr').on('change', function () { table.draw(); });
        $('#example tbody').on('click', 'tr', function () {
            ind_rw = table.row(this).index();
            // let a = table.row(this).index();
            // var temp = table.row(a).data();
            // temp[0] = 'Tom';
            // table.row(this)
            // .data(temp)
            // .draw();
        });

        $('#verPartesModal').on('hidden.bs.modal', function (e) {
            nuevoParte();
            // actRow();
            actualizarRowOrden();
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
                        /*
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
                        */
                    }
                });

        });

        $("#npm-form-multi").on('submit', function(evt){
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
                        actRow();
                        switch (data) {
                            case '1':
                                document.getElementById('alert-mp').innerHTML = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                                                                    Parte creado con exito
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>`;
                                document.getElementById('alert-mp').hidden = false;
                                break;
                        
                            default:
                                break;
                        }
                        setTimeout(function(){document.getElementById('alert-mp').hidden = true;},3000);
                        // html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modalOrd">
                        //                         `+data+`
                        //                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        //                             <span aria-hidden="true">&times;</span>
                        //                         </button>
                        //                     </div>`;
                        // $('#alertOrd').html(html)
                        // setTimeout(function(){document.getElementById('msj-modalOrd').hidden = true;},3000);
                    }
                });
        });

        $('#id_selec').on('change', function () { table.column(0).visible(this.checked); mostrarSelec(); });

        document.getElementById('checkSelAll').addEventListener('change', event => {

            if (document.getElementById('checkSelAll').checked) {
                table.rows({ search: 'applied' }).nodes().to$().find('input[type="checkbox"][name="id_ordenes[]"]').prop('checked', true);
            } else {
                table.rows({ search: 'applied' }).nodes().to$().find('input[type="checkbox"][name="id_ordenes[]"]').prop('checked', false);
            }

        })

        $("#loading").hide();
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
    function mostrarSelec() {
        let colum_sel = document.getElementsByClassName('chk-input');
        let enca = document.getElementById('enc_sel');
        let btn = document.getElementById('btn-sel-mul'); 
        let selAll = document.getElementById('chk-sel-all');

        if ($("#id_selec").is(":checked")) {
            enca.hidden = false;
            // btn.hidden = false;
            selAll.hidden = false;
            for (let index = 0; index < colum_sel.length; index++) {
                colum_sel[index].hidden = false;
            }
        } else {
            enca.hidden = true;
            // btn.hidden = true;
            selAll.hidden = true;
            for (let index = 0; index < colum_sel.length; index++) {
                colum_sel[index].hidden = true;
            }
        }

    }

    function cargarMMultiple(){
        let ids = document.getElementById('m-parte-multiple-ids');
        let valores = [...document.querySelectorAll('input[name="id_ordenes[]"]:checked')].map(input => input.value);
        ids.value = valores;
        cargarEstadosMecanizados();
        let html = '';
        $.ajax({
            type: "post",
            url: '/orden/obtener-info-orden-mul',
            data: {
                id: valores,
            },
            success: function (response) {
                response.forEach(e => {
                    html += `<tr>
                                <td class="text-center" style="vertical-align: middle;">`+e.codigo_servicio+`</td>
                                <td class="text-center" style="vertical-align: middle;">`+e.nombre_orden+`</td>
                            </tr>`;
                });

                document.getElementById('npm_body_ord').innerHTML = html;
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function cargarEstados(){
        let c_bx_estados = document.getElementById("cbx_estado") ? document.getElementById("cbx_estado") : '';
        let c_bx_estados_edit = document.getElementById("cbx_estado_edit") ? document.getElementById("cbx_estado_edit") : '';
        let html_estados = '';
        $.when($.ajax({
            type: "post",
            url: '/orden/obtener-estados', 
            data: {
                
            },
        success: function (response) {
            response.forEach(element => {
                html_estados += `
                                    <option value="`+element.id_estado+`">`+element.nombre_estado
                                    +`</option> 
                                    `
            });
            c_bx_estados != '' ? c_bx_estados.innerHTML += html_estados : '';
            c_bx_estados_edit != '' ? c_bx_estados_edit.innerHTML += html_estados : '';
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }

    function cargarEstadosMecanizados(){
        // let c_bx_estados_mec =  document.getElementById("cbx_estado_mec") ? document.getElementById("cbx_estado_mec") : '';
        // let c_bx_estados_mec_edit =  document.getElementById("cbx_estado_mec_edit") ? document.getElementById("cbx_estado_mec_edit") : '';
        let html_estados_mec = '';
        $.when($.ajax({
            type: "post",
            url: '/orden/obtener-estados-mecanizados', 
            data: {
                
            },
        success: function (response) {
            response.forEach(element => {
                html_estados_mec += `
                                    <option value="`+element.id_estado_mecanizado+`">`+element.nombre_estado_mecanizado
                                    +`</option> 
                                    `
            });
            // c_bx_estados_mec != '' ? c_bx_estados_mec.innerHTML += html_estados_mec : '';
            // c_bx_estados_mec_edit != '' ? c_bx_estados_mec_edit.innerHTML += html_estados_mec : '';
            document.getElementById('npm-m-ver-parte-estado').innerHTML += html_estados_mec;
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }

    function cargarEstadosManufacturas(){
        let c_bx_estados_man = document.getElementById("cbx_estado_man") ? document.getElementById("cbx_estado_man") : '';
        let c_bx_estados_man_edit = document.getElementById("cbx_estado_man_edit") ? document.getElementById("cbx_estado_man_edit") : '';
        let html_estados_man = '';
        $.when($.ajax({
            type: "post",
            url: '/orden/obtener-estados-manufacturas', 
            data: {
                
            },
        success: function (response) {
            response.forEach(element => {
                html_estados_man += `
                                    <option value="`+element.id_estado_manufactura+`">`+element.nombre_estado_manufactura
                                    +`</option> 
                                    `
            });
            c_bx_estados_man != '' ? c_bx_estados_man.innerHTML += html_estados_man : '';
            c_bx_estados_man_edit != '' ? c_bx_estados_man_edit.innerHTML += html_estados_man : '';
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }

    function actualizarRowOrden(){ actRow(); }
    function actualizarRowOrdenPorId(){ actRow(); }

    function crearParteOrdMecEspera(id){
        if (!confirm("¿Estás seguro que querés crear el parte con estado EN ESPERA?")) {
            return; // no hace nada
        }
        $.ajax({
            type: "post",
            url: '/orden/crear-parte-ord-mec-espera',
            data: {
                id: id,
            },
            success: function (res) {
                console.log(res);
                
            },
            complete: function(){
                actualizarRowOrdenPorId(id);

            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function crearParteOrdMecEnProceso(id){
        if (!confirm("¿Estás seguro que querés crear el parte con estado EN PROCESO?")) {
            return; // no hace nada
        }
        $.ajax({
            type: "post",
            url: '/orden/crear-parte-ord-mec-en-proceso',
            data: {
                id: id,
            },
            success: function (res) {
                console.log(res);
            },
            complete: function(){
                actualizarRowOrdenPorId(id);

            },
            error: function (error) {
                console.log(error);
            }
        });
    }
</script>
@endsection
