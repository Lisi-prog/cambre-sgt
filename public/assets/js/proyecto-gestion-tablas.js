/* Tables inside project management share pagination and header filters. */
(function (global, $) {
    'use strict';
    const tablas = new Map();
    const estados = new Map();
    const configuraciones = {
        etapas: {id: 'tablaEtapas', acciones: 9, estado: 1, orden: [[4, 'asc']]},
        trabajo: {id: 'tablaOrdenTrabajo', acciones: 9, estado: 2, etapa: 1, orden: []},
        manufactura: {id: 'tablaOrdenMan', acciones: 10, estado: 3, etapa: 2, orden: []},
        mecanizado: {id: 'tablaOrdenMec', acciones: 9, estado: 3, etapa: 2, orden: []}
    };
    global.inicializarGestionProyecto = function (id, opcion, url, exclusiones) {
        Object.entries(configuraciones).forEach(([grupo, config]) => {
            const selecciones = {[config.estado]: {excluir: exclusiones[grupo] || []}};
            const estado = {valores: null, pedirOpciones: true, selecciones};
            estados.set(grupo, estado);
            const tabla = $('#' + config.id).DataTable({
                serverSide: true, processing: true, searchDelay: 350,
                pageLength: 10, lengthMenu: [10, 25, 50, 100, 500], order: config.orden,
                ajax: {
                    url, type: 'POST',
                    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                    data: function (datos) {
                        datos.grupo = grupo; datos.opcion = opcion;
                        datos.filtrosCabecera = JSON.stringify(selecciones);
                        datos.opcionesFiltros = estado.pedirOpciones;
                    },
                    dataSrc: function (respuesta) {
                        if (respuesta.opcionesFiltros) {
                            estado.valores = respuesta.opcionesFiltros; estado.pedirOpciones = false;
                            document.getElementById(config.id).dispatchEvent(new CustomEvent('datatable-opciones-filtros',
                                {detail: respuesta.opcionesFiltros}));
                        }
                        return respuesta.data;
                    }
                },
                columnDefs: [
                    {targets: '_all', defaultContent: '-', className: 'align-middle'},
                    {targets: 0, className: 'text-left text-start'},
                    {targets: Array.from({length: config.acciones}, (_, i) => i + 1), className: 'text-center'},
                    {targets: config.acciones, orderable: false, searchable: false}
                ],
                language: {
                    emptyTable: 'No hay datos disponibles en la tabla', loadingRecords: 'Cargando...', processing: 'Procesando...',
                    lengthMenu: 'Mostrar _MENU_ registros por pagina', zeroRecords: 'No se encontraron coincidencias',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ registros', infoEmpty: 'No hay registros',
                    infoFiltered: '(de _MAX_ registros totales)', search: 'Buscar',
                    paginate: {first: 'Prim.', last: 'Ult.', previous: 'Ant.', next: 'Sig.'}
                },
                drawCallback: function () { changeTdColor(); },
                initComplete: function () {
                    agregarFiltrosCabecera(this.api(), {
                        columnas: Array.from({length: config.acciones}, (_, i) => i),
                        servidor: {valores: estado.valores, selecciones}
                    });
                }
            });
            tablas.set(grupo, tabla);
        });
        $(document).off('click.gestionEtapa', 'button[name="flt-for-eta"]')
            .on('click.gestionEtapa', 'button[name="flt-for-eta"]', function () {
                for (const grupo of ['trabajo', 'manufactura', 'mecanizado']) {
                    const config = configuraciones[grupo];
                    estados.get(grupo).selecciones[config.etapa] = {incluir: [this.value]};
                    document.getElementById(config.id).dispatchEvent(new CustomEvent('datatable-filtro-columna',
                        {detail: {indice: config.etapa, valores: [this.value], redibujar: false}}));
                    tablas.get(grupo).ajax.reload();
                }
            });
    };
    global.recargarTablasGestion = function () {
        tablas.forEach((tabla, grupo) => {
            estados.get(grupo).pedirOpciones = true;
            tabla.ajax.reload(null, false);
        });
    };
}(window, jQuery));
