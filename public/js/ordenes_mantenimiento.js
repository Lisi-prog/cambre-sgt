let x = '';
let ind_rw = '';
let id_emp = $("#id_emp").val();
let b;

var table;
$("#loading").show();
$(document).ready( function () {
    var url = '{{url('/')}}';
    document.getElementById('volver').href = url;
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
    saveDefaultFilters();
    loadFilters();
    $.fn.dataTable.ext.search.push(
        function( settings, searchData, index, rowData, counter ) {

        if (settings.nTable.id !== 'tabla_operaciones') {
            return true; // ignore other tables
        }

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
    
        if (settings.nTable.id !== 'tabla_operaciones') {
            return true; // ignore other tables
        }

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

        if (settings.nTable.id !== 'tabla_operaciones') {
            return true; // ignore other tables
        }

        var offices = $('input:checkbox[name="est"]:checked').map(function() {
            return this.value;
        }).get();
    

        if (offices.length === 0) {
            return true;
        }
        
        if (offices.indexOf(searchData[8]) !== -1) {
            return true;
        }
        
        return false;
        }
    );

    $.fn.dataTable.ext.search.push(
        function( settings, searchData, index, rowData, counter ) {
    
        if (settings.nTable.id !== 'tabla_operaciones') {
            return true; // ignore other tables
        }

        var offices = $('input:checkbox[name="cod_serv"]:checked').map(function() {
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

    $.fn.dataTable.ext.search.push(
        function( settings, searchData, index, rowData, counter ) {

        if (settings.nTable.id !== 'tabla_operaciones') {
            return true; // ignore other tables
        }
        var offices = $('input:checkbox[name="soloAct"]:checked').map(function() {
            return this.value;
        }).get();
                if (offices.length === 0) {
            return true;
        }
        if (offices.indexOf(searchData[12]) !== -1) {
            return true;
        }
        
        return false;
        }
    );

    $.fn.dataTable.ext.search.push(
        function( settings, searchData, index, rowData, counter ) {
        if (settings.nTable.id !== 'tabla_operaciones') {
            return true; // ignore other tables
        }

        var offices = $('input:checkbox[name="asig"]:checked').map(function() {
            return this.value;
        }).get();
                if (offices.length === 0) {
            return true;
        }
        if (offices.indexOf(searchData[10]) !== -1) {
            return true;
        }
        
        return false;
        }
    );

    $.fn.dataTable.ext.order['custom-prioridad'] = function  ( settings, col ) {
        if (settings.nTable.id !== 'tabla_operaciones') {
            return true; // ignore other tables
        }
        return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
            var val = $(td).text();
            if (val === 'S/P') return 999;  
            return parseInt(val) || 0;      
        });
    };

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
            columnDefs: [
                { targets: [0, 4], visible: false },
                { targets: 1,  // Prio. Operacion
                  createdCell: function (td, cellData, rowData, row, col) {
                      $(td).attr('data-order', rowData._order_prioridad);
                  } 
                }, 
                { targets: 2,  // Prio. Global
                  createdCell: function (td, cellData, rowData, row, col) {
                  $(td).attr('data-order', rowData._order_prioridad_servicio);
                }
                },
                {className: "text-center align-middle",
                 targets: [1,2,3,5,6,7,8,9,10,11,12,13,14]}
            ],
            // order: [[ 1, 'asc' ], [2, 'asc']],
            "pageLength": 100
    });
    
$('input:checkbox').on('change', function () {
    saveFilters();
    table.draw();
});

table.on('draw', function () {
    changeTdColor();
})

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

$(".nuevo-editar-orden").on('submit', function(evt){
        evt.preventDefault();     
        
        var url_php = $(this).attr("action"); 
        var type_method = $(this).attr("method"); 
        var form_data = $(this).serialize();

        $.ajax({
            type: type_method,
            url: url_php,
            data: form_data,
            success: function(data) {
                html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modalOrd">
                                        `+data+`
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                $('#alertOrd').html(html)
                setTimeout(function(){document.getElementById('msj-modalOrd').hidden = true;},3000);
                
            }
        });
        actRow();
});
buscarPorFiltros()
$("#loading").hide();
} );

$('.input-filter, input[name="filter"], input[name="sup"], input[name="res"], input[name="est"], input[name="asig"], input[name="soloAct"]').on('change', function(){
    buscarPorFiltros();
});


function loadFilters() {
        let saved = localStorage.getItem('dt_filters_example');
        if (!saved) return;

        let filters = JSON.parse(saved);

        $('input[type=checkbox]').each(function () {
            let key = this.name + '_' + this.value;
            if (filters.hasOwnProperty(key)) {
                this.checked = filters[key];
            }
        });
}

function saveFilters() {
    let filters = {};

    $('input[type=checkbox]').each(function () {
        filters[this.name + '_' + this.value] = this.checked;
    });

    localStorage.setItem('dt_filters_example', JSON.stringify(filters));
}

function saveDefaultFilters() {
    if (localStorage.getItem('dt_filters_example_default')) return;

    let defaults = {};
    $('input[type=checkbox]').each(function () {
        defaults[this.name + '_' + this.value] = this.checked;
    });

    localStorage.setItem(
        'dt_filters_example_default',
        JSON.stringify(defaults)
    );
}

function resetFilters() {
    let defaults = localStorage.getItem('dt_filters_example_default');
    if (!defaults) return;

    defaults = JSON.parse(defaults);

    $('input[type=checkbox]').each(function () {
        let key = this.name + '_' + this.value;
        if (defaults.hasOwnProperty(key)) {
            this.checked = defaults[key];
        }
    });

    // Borra filtros actuales
    localStorage.removeItem('dt_filters_example');

    // Redibuja la tabla
    table.search('').columns().search('');
    table.draw();
}

function mostrarFiltro(id){
    let cuadro_filtro = document.getElementById(id);
    if ($('#'+id).is(":hidden")) {
        cuadro_filtro.hidden = false;
    }else{
        cuadro_filtro.hidden = true;
    }
}

function limpiarFiltro(){
    $('input[type=checkbox]').prop("checked", false);
    table.clear();
    table.draw();
}

function mostrarSelec() {
    let colum_sel = document.getElementsByClassName('chk-input');
    let enca = document.getElementById('enc_sel');
    let chk_sel_all = document.getElementById('chk-sel-all');

    if ($("#id_selec").is(":checked")) {
        enca.hidden = false;
        chk_sel_all.hidden = false;
        table.rows().nodes().to$().find('td.chk-input').removeAttr('hidden');
        // Mostrar la columna de checkboxes
        table.column('.chk-input', { search: 'applied' }).visible(true);
    } else {
        enca.hidden = true;
        chk_sel_all.hidden = true;
        table.rows().nodes().to$().find('td.chk-input').attr('hidden', true);
        // Ocultar la columna de checkboxes
        table.column('.chk-input', { search: 'applied' }).visible(false);
    }

}

function cargarMultiple(){
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
                            <td class="text-center" style="vertical-align: middle;">`+e.proyecto+`</td>
                            <td class="text-center" style="vertical-align: middle;">`+e.orden+`</td>
                        </tr>`;
            });

            document.getElementById('npm_body_ord').innerHTML = html;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarEditMultiple(){
    let ids = document.getElementById('m-edit-multiple-ids');
    let ids_pm = document.getElementById('m-parte-multiple-ids');
    let valores = [...document.querySelectorAll('input[name="id_ope[]"]:checked')].map(input => input.value);
    ids.value = valores;
    ids_pm.value = valores;
    cargarEstadosOperaciones();
    let html = '';
    $.ajax({
        type: "post",
        url: '/orden/obtener-info-ope-mul',
        data: {
            id: valores,
        },
        success: function (response) {
            response.forEach(e => {
                html += `<tr>
                            <td class="text-center" style="vertical-align: middle;">`+e.proyecto+`</td>
                            <td class="text-center" style="vertical-align: middle;">`+e.orden+`</td>
                            <td class="text-center" style="vertical-align: middle;">`+e.operacion+`</td>
                        </tr>`;
            });

            document.getElementById('nom_body_ope').innerHTML = html;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarEstadosOperaciones(){
    let cbxEstOpe = document.getElementById('m-ver-parte-ope-estado');
    let html = '<option value="">Seleccionar</option>';
    $.ajax({
        type: "post",
        url: '/parte/obtener-est-parte-ope',
        data: {
            id: 'a',
        },
        success: function (res) {
            res.forEach(e => {
                html += `<option value="${e.id_estado_hdr}">${e.nombre_estado_hdr}</option>`;
            });

            cbxEstOpe.innerHTML += html;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

$(".edit-multi-ope").on('submit', function(evt){
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
                if (data) {
                    html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                        Operacion/es editados con exito.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                } else {
                    html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                    Ocurrio un error
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`;
                }
                
                $('#alert-edit').html(html)
                setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);

            }
        });
});

$(".parte-multi-ope").on('submit', function(evt){
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
                if (data) {
                    html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                        Operacion/es editados con exito.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                    b=1;                
                } else {
                    html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                    Ocurrio un error
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`;
                }
                
                $('#alert-edit').html(html)
                setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);

            }
        });
});

$('#id_selec').on('change', mostrarSelec);

document.getElementById('checkSelAll').addEventListener('change', event => {
    if (document.getElementById('checkSelAll').checked) {
        table.rows({ search: 'applied' }).nodes().to$().find('input[type="checkbox"][name="id_ope[]"]').prop('checked', true);
    } else {
        table.rows({ search: 'applied' }).nodes().to$().find('input[type="checkbox"][name="id_ope[]"]').prop('checked', false);
    }
})

function cargarModalVerPartesOpe(id){
    let html = '';
    obtenerEstados(5);
    document.getElementById('m-id-ope-hdr').value = id;
    
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-hdr-parte/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response)
            let ultParte = response.partes_ope.length - 1;
            let idCount = 0;
            response.partes_ope.forEach(element => {
                html += `<tr>
                        <td class="text-center" style="vertical-align: middle;">`+element.id_parte+`</td>
                        <td class="text-center" style="vertical-align: middle;">`+element.fecha+`</td>
                        <td class="text-center" style="vertical-align: middle;">`+element.estado+`</td>
                        <td class="text-center" style="vertical-align: middle;">`+element.horas+`</td>
                        <td class="text-center" style="vertical-align: middle;">`+element.horas_maquina+`</td>
                        <td class="text-center" style="vertical-align: middle;"><abbr title="`+element.observaciones+`" style="text-decoration:none; font-variant: none;">`+element.observaciones.slice(0, 25)+` <i class="fas fa-eye"></i></abbr></td>
                        <td class="text-center" style="vertical-align: middle;">`+element.responsable+`</td>
                        <td class="text-center" style="vertical-align: middle;">`+element.medidas+`</td>
                        <td class="text-center">
                            <div class="row justify-content-center" >
                                <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOpe`+idCount+`" aria-expanded="false" aria-controls="collapseOrdenes`+idCount+`">
                                    Opciones
                                </button>
                            </div>
                            <div class="collapse" data-bs-parent="#body_ver_parte_ope" id="collapseOpe`+idCount+`">
                                <div class="row">
                                    <div class="col-12 my-1">
                                        <button type="button" class="btn btn-primary w-100" onclick="editarParte(`+element.id_parte+`)">
                                            Editar
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                </div>
                            </div>
                        </td>
                    </tr>`
                idCount ++;
            });

            if (response.medida_chk) {
                document.getElementById('section-medida').hidden = true;
            } else {
                document.getElementById('section-medida').hidden = false;
            }
            document.getElementById('body_ver_parte_ope').innerHTML = html;
            document.getElementById('mv-operacion').value = response.partes_ope[0].operacion;
            document.getElementById('mv-ord-mec').value = response.partes_ope[0].orden_mec;
            document.getElementById('mv-estado').value = response.partes_ope[0].estado;
            document.getElementById('m-ver-parte-estado').value = response.partes_ope[ultParte].id_estado;
            obtenerMaquinasPorOpe(response.partes_ope[0].id_operacion);
    },
    complete: function(){
        changeTdColor();
    },
    error: function (error) {
        console.log(error);
    }
    });
}

function obtenerEstados(opcion){
    let select_estados = document.getElementById('m-ver-parte-estado');
    select_estados.innerHTML = '<option value="">Seleccionar</option>';
    html_estados = '';
    $.when($.ajax({
        type: "post",
        url: '/orden/obtener-estados-de/'+opcion, 
        data: {
        },
        success: function (response) {
            response.forEach(element => {
                html_estados += `
                                    <option value="`+element.id_estado+`">`+element.nombre
                                    +`</option> 
                                    `
            });
            select_estados.innerHTML += html_estados;
        },
        error: function (error) {
            console.log(error);
        }
    }));
}

function obtenerMaquinasPorOpe(id){
    let select_maquinas = document.getElementById('m-ver-parte-maquina');
    select_maquinas.innerHTML = '<option value="">Seleccionar</option>';
    html_maquinas = '';
    let select_maq = null;
    $.ajax({
        type: "post",
        url: '/operacion/obtener-maquinas-ope-de/'+id, 
        data: {
        },
        success: function (res) {
            if (res.length == 1) {
                select_maq = 'selected';
            }

            res.forEach(element => {
                html_maquinas += `
                                    <option value="`+element.id_maquinaria+`" ${select_maq}>`+element.codigo_maquinaria
                                    +`</option> 
                                    `
            });
            select_maquinas.innerHTML += html_maquinas;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarHdrVer(id){
    let html = '';
    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-hdr/'+id,
        data: { id: id },
        success: function (response) {
            // console.log(response);
            document.getElementById('m_ver_ubi').value = response.ubicacion;
            document.getElementById('m_ver_cant').value = response.cantidad;
            document.getElementById('m_ver_fec_carga').value = response.fecha_requerida;
            document.getElementById('m_ver_ruta').value = response.ruta;
            document.getElementById('m_ver-obser').value = response.observaciones;
            document.getElementById('m_ver_id_pieza').value = response.nombre_orden;
            document.getElementById('m_ver_confec').value = response.supervisor;

            if (response.obser_fallo) {
                document.getElementById('obser-fallo').hidden = false;
            }

            document.getElementById('ver-table-body').innerHTML = '';
            response.operaciones.forEach(function (op){
                html += `<tr>
                        <td class="text-center">`+op.numero+`</td>
                        <td class="text-center">`+op.operacion+`</td>
                        <td class="text-center">`+op.asignado+`</td>
                        <td class="text-center">`+op.maquina ?? '-'+`</td>
                    </tr>`
            });
            document.getElementById('ver-table-body').innerHTML = html;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function actualizarRowOpePorId(id){
    let id_ope = [id];

    $.ajax({
        type: "post",
        url: '/orden/obtener-info-ope-mul-act',
        data: {
            id: id_ope,
        },
        success: function (response) {
            response.forEach(e => {
                let fila = $('#example tbody tr[data-id="' + e.id_ope_de_hdr + '"]');
                let rowIndex = table.row(fila).index();

                table.cell(rowIndex, 1).data(e.prioridad ?? 'S/P').draw();
                table.cell(rowIndex, 8).data(e.nombre_estado_hdr).draw();

            });
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function crearParteOpeEspera(id){
    if (!confirm("¿Estás seguro que querés crear el parte con estado EN ESPERA?")) {
        return; // no hace nada
    }
    $.ajax({
        type: "post",
        url: '/operacion/crear-parte-espera',
        data: {
            id: id,
        },
        success: function (res) {
            console.log(res);
        },
        complete: function(){
            actualizarRowOpePorId(id);

        },
        error: function (error) {
            console.log(error);
        }
    });
}

function crearParteOpeEnProceso(id){
    if (!confirm("¿Estás seguro que querés crear el parte con estado EN PROCESO?")) {
        return; // no hace nada
    }
    $.ajax({
        type: "post",
        url: '/operacion/crear-parte-en-proceso',
        data: {
            id: id,
        },
        success: function (res) {
            console.log(res);
        },
        complete: function(){
            actualizarRowOpePorId(id);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function isSupervisor() {
    return userRoles.includes('SUPERVISOR');
}

function buscarPorFiltros(){
    let filtros = getSelectedFilters();
    table.clear().draw()
    $.ajax({
        type: 'POST',
        data: filtros,
        url: '/get_operaciones',
        success: function(operaciones) {
            let idCount = 0;
            let opciones = ''

            //OPERACIONES GENERALES
            operaciones['generales'].forEach(ope => {
                opciones = `<div class="row justify-content-center">
                            <div class="row justify-content-center">
                                <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapseOrdenes${idCount}" aria-expanded="false" aria-controls="collapseOrdenes${idCount}">
                                    Opciones
                                </button>
                            </div>
                            <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenes${idCount}">`;
                if (ope.id_hoja_de_ruta) {
                    opciones += `
                    <div class="row my-2">
                        <div class="col-12">
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" 
                            data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden(${ope.get_hdr.get_ord_mec.id_orden}, 3)">
                                Ver Ord Mec
                            </button>
                        </div>
                    </div>`;
                }
                opciones += `
                    <div class="row my-2">
                        <div class="col-12">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" 
                            data-bs-target="#verPartesOpeHdrModal" onclick="cargarModalVerPartesOpe(${ope.id_ope_de_hdr})">
                                Partes
                            </button>
                        </div>
                    </div>`;        
                if (ope.getHdr) {
                    if (ope.can_hdr) {
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">
                                <form method="GET" action="${ordenHdrRoute}/${ope.get_hdr.get_ord_mec.id_orden}" target="_blank" style="display:inline">
                                    <input type="hidden" name="vieneDesde" value="3">
                                    <button type="submit" class="btn btn-info w-100">
                                        HDR
                                    </button>
                                </form>
                            </div>
                        </div>`;
                    }
                    opciones += `
                    <div class="row my-2">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" 
                            data-bs-target="#verHdrOpe" onclick="cargarHdrVer(${ope.get_hdr.id_hoja_de_ruta})">
                                Ver HDR
                            </button>
                        </div>
                    </div>`;
                }
                if (ope.can_hdr) {
                    opciones += `
                    <div class="row my-2">
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        ${ope.id_estado_hdr != 1 ? 
                            `<button type="button" class="btn btn-warning" onclick="crearParteOpeEspera(${ope.id_ope_de_hdr})">
                            Espera
                            </button>` : ''
                        }
                        ${ope.id_estado_hdr != 2 ? 
                            `<button type="button" class="btn btn-info" onclick="crearParteOpeEnProceso(${ope.id_ope_de_hdr})">
                            En proceso
                            </button>` : ''
                        }
                        </div>
                    </div>`;
                }
                opciones += `</div></div>`;
               
                table.row.add({
                    0 : `<div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                    <input class="form-check-input" type="checkbox" value="${ope.id_ope_de_hdr}" id="flexCheck${ope.id_ope_de_hdr}" name="id_ope[]">
                    </div>`,
                    1 : ope.prioridad ?? 'S/P',
                    _order_prioridad: ope.prioridad ?? 999,
                    2: ope.prioridad_servicio ?? 'S/P',
                    _order_prioridad_servicio: ope.prioridad_servicio ?? 999,
                    3: `<abbr title="${ope.nombre_servicio ?? '-'}" style="text-decoration:none; font-variant: none;">
                            ${ope.codigo_servicio ?? '-'}<i class="fas fa-eye"></i>
                        </abbr>`,
                    4: ope.codigo_servicio ?? '-',
                    5: ope.nombre_orden ?? '-',
                    6: ope.nombre_operacion ?? '-',
                    7: ope.codigo_maquinaria ?? '-',
                    8: ope.nombre_estado_hdr ?? '-',
                    9: ope.ultimo_res ?? '-',
                    10: ope.tecnico_asignado ?? '-',
                    11: ope.total_horas ?? '-',
                    12: ope.activo ? 'SI' : 'NO',
                    13: ope.cantidad ?? '-',
                    14: opciones,
                }).node().id = ope.id_ope_de_hdr;     
                idCount++;
            });

            //OPERACIONES DE MANTENIMIENTO
            operaciones['mantenimiento'].forEach(ope => {
                opciones = `<div class="row justify-content-center">
                            <div class="row justify-content-center">
                                <button class="btn btn-primary w-100 btn-opciones" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapseOrdenes${idCount}" aria-expanded="false" aria-controls="collapseOrdenes${idCount}">
                                    Opciones
                                </button>
                            </div>
                            <div class="collapse" data-bs-parent="#accordion" id="collapseOrdenes${idCount}">`;
                if(ope.get_tipo_orden_mantenimiento.nombre_tipo_orden_mantenimiento == 'DIAGNÓSTICO'){
                    if(ope.estado_actual == 'Espera'){
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" class="btn btn-info w-100" onclick="openModalCrearParteDiagnostico(${ope.get_orden.id_orden}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')">
                                    Procesar
                                </button>
                            </div>
                        </div>`;
                    }
                    else if(ope.estado_actual == 'En proceso'){
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" class="btn btn-info w-100" onclick="openModalParteDiagnosticoPendiente(${ope.get_orden.id_orden}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')">
                                    Procesar
                                </button>
                            </div>
                        </div>`;
                    }
                    else{
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" class="btn btn-info w-100" onclick="openModalVerParteDiagnostico(${ope.get_orden.id_orden}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')">
                                    Ver parte
                                </button>
                            </div>
                        </div>`;
                    }
                }
                else if(ope.get_tipo_orden_mantenimiento.nombre_tipo_orden_mantenimiento == 'INSPECCIÓN'){
                    if(ope.estado_actual == 'Espera'){
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" class="btn btn-info w-100" onclick="openModalNuevoParteInspeccion(${ope.get_orden.get_etapa.get_servicio.get_activo.id_activo},${ope.get_orden.id_orden}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')">
                                    Procesar
                                </button>
                            </div>
                        </div>`;
                    }
                    else if(ope.estado_actual == 'En proceso'){
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" onclick="openModalParteInspeccionPendiente(${ope.get_orden.get_etapa.get_servicio.get_activo.id_activo}, ${ope.get_orden.id_orden}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')"  class="btn btn-info w-100">
                                    Procesar
                                </button>
                            </div>
                        </div>`;
                    }
                    else{
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" class="btn btn-info w-100" onclick="openModalVerParteInspeccion(${ope.get_orden.id_orden}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')">
                                    Ver parte
                                </button>
                            </div>
                        </div>`;
                    }
                }
                else if(ope.get_tipo_orden_mantenimiento.nombre_tipo_orden_mantenimiento == 'AJUSTE'){
                    if(ope.estado_actual == 'Espera'){
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" class="btn btn-info w-100"  onclick="openModalNuevoParteAjuste(${ope.get_orden.id_orden}, ${ope.get_orden.get_etapa.id_etapa}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')">
                                    Procesar
                                </button>
                            </div>
                        </div>`;
                    }
                    else if(ope.estado_actual == 'En proceso'){
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" class="btn btn-info w-100" onclick="openModalParteAjustePendiente(${ope.get_orden.id_orden}, ${ope.get_orden.get_etapa.id_etapa}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')">
                                    Procesar
                                </button>
                            </div>
                        </div>`;
                    }
                    else if(ope.estado_actual == 'Revisar'){
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" class="btn btn-info w-100" onclick="openModalConfirmarParteAjuste(${ope.get_orden.id_orden}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')">
                                    Revisar
                                </button>
                            </div>
                        </div>`;
                    }
                    else{
                        opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <button type="button" class="btn btn-info w-100" onclick="openModalVerParteAjuste(${ope.get_orden.id_orden}, '${ope.get_orden.get_etapa.get_servicio.get_activo.codigo_activo}')">
                                    Ver parte
                                </button>
                            </div>
                        </div>`;
                    }
                }
                opciones += `
                        <div class="row my-2">
                            <div class="col-12">                               
                                <a target="_blank" href="/s_m_a/gestionar/${ope.get_orden.get_etapa.get_servicio.id_servicio}" type="button" class="btn btn-warning w-100">
                                    Ir a gestionar
                                </a>
                            </div>
                        </div>`;
                opciones += `</div></div>`;

                table.row.add({
                    0 : `<div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                    <input class="form-check-input" type="checkbox" value="${ope.id_ope_de_hdr}" id="flexCheck${ope.id_ope_de_hdr}" name="id_ope[]">
                    </div>`,
                    1 : 'S/P',
                    _order_prioridad: 999,
                    2: ope.get_orden.get_etapa.get_servicio.prioridad_servicio ?? 'S/P',
                    _order_prioridad_servicio: ope.get_orden.get_etapa.get_servicio.prioridad_servicio ?? 999,
                    3: `<abbr title="${ope.get_orden.get_etapa.get_servicio.nombre_servicio ?? '-'}" style="text-decoration:none; font-variant: none;">
                            ${ope.get_orden.get_etapa.get_servicio.codigo_servicio ?? '-'}<i class="fas fa-eye"></i>
                        </abbr>`,
                    4: ope.get_orden.get_etapa.get_servicio.codigo_servicio ?? '-',
                    5: ope.get_orden.nombre_orden ?? '-',
                    6: ope.get_tipo_orden_mantenimiento.nombre_tipo_orden_mantenimiento,
                    7: '-',
                    8: ope.estado_actual,
                    9: '-',
                    10: ope.get_empleado?.nombre_empleado ?? '-',
                    11: ope.horas,
                    12: ope.esta_activo ? 'SI' : 'NO',
                    13: ope.cantidad ?? '-',
                    14: opciones,
                }).node().id = ope.id_ope_de_hdr;     
                idCount++;
            });

            table.draw()      
        }
    });
}

function getSelectedFilters() {
    return {
        cod_serv: $('input[name="cod_serv"]:checked').map(function () {
            return this.value;
        }).get(),

        sup: $('input[name="sup"]:checked').map(function () {
            return this.value;
        }).get(),

        res: $('input[name="res"]:checked').map(function () {
            return this.value;
        }).get(),

        est: $('input[name="est"]:checked').map(function () {
            return this.value;
        }).get(),

        asig: $('input[name="asig"]:checked').map(function () {
            return this.value;
        }).get(),

        soloAct: $('input[name="soloAct"]').is(':checked') ? 'SI' : 'NO'
    };
}

