var tabla_diagnosticos, tabla_inspecciones, tabla_ajustes
$(document).ready(function () {
    tabla_diagnosticos = $('#tabla_diagnosticos').DataTable({
         columnDefs: [
            { className: "text-center", targets: [0,1,2,3] }
        ],
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
            "aaSorting": []
    });    

    tabla_inspecciones = $('#tabla_inspecciones').DataTable({headerCallback: function(thead) {
        $(thead).hide();
    },columnDefs: [
            { className: "text-center", targets: [0,1,2,3, 4] }
        ],
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
            pageLength: 100,
            "aaSorting": []
    });   

    tabla_ajustes = $('#tabla_ajustes').DataTable({
        autoWidth: false,
         columnDefs: [
            { className: "text-center", targets: [0,1,2,3,4] }, { width: '25%', targets:[0]}
        ],
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
            "aaSorting": []
    });    
});


var i = 0;

function agregarDiagnostico() {
    const ishikawa_categoria = document.getElementById('ishikawa_categoria_div');
    const ishikawa_causa = document.getElementById('ishikawa_causa_div');

    tabla_diagnosticos.row.add([
        i + 1,
        `<select required onchange="cambiarIshikawaCategoria(${i})"
            class="form-select"
            name="ishikawa_categoria[]"
            id="ishikawa_categoria_${i}">
            <option hidden value="">Seleccionar...</option>
            ${ishikawa_categoria.innerHTML}
        </select>`,
        `<div id="prev_ishikawa_cat_${i}">Primero elegir 5M</div>
         <select required hidden
            class="form-select"
            name="ishikawa_causa[]"
            id="ishikawa_causa_${i}">
            <option hidden value="">Seleccionar...</option>
            ${ishikawa_causa.innerHTML}
         </select>`,
        `<button type="button" class="btn btn-danger"
            onclick="eliminarDiagnostico(${i})">Eliminar</button>`
    ]).node().id = `diagnostico_${i}`;

    tabla_diagnosticos.draw(false);
    i++;
    checkSendNuevoParteDiagnostico();
}


function cambiarIshikawaCategoria(indice){
    ishikawa_categoria = document.getElementById(`ishikawa_categoria_${indice}`).value;
    ishikawa_causa = document.getElementById(`ishikawa_causa_${indice}`);
    ishikawa_causa.removeAttribute('hidden');
    document.getElementById(`prev_ishikawa_cat_${indice}`).setAttribute('hidden', true);
    for (let j = 0; j < ishikawa_causa.options.length; j++) {
        if (ishikawa_causa.options[j].dataset.ishikawaCategoria == ishikawa_categoria) {
            ishikawa_causa.options[j].removeAttribute('hidden');
        }
        else{
            ishikawa_causa.options[j].setAttribute('hidden', true);
        }
    }
}

function eliminarDiagnostico(indice){
   tabla_diagnosticos.row('#diagnostico_'+indice).remove().draw();
   //Reordenar indices
   for (let j = 0; j < tabla_diagnosticos.rows().count(); j++) {
        const row = tabla_diagnosticos.row(j).node();
        row.id = `diagnostico_${j}`;
        row.querySelector('td').innerText = j + 1;
        row.querySelector('select').setAttribute('id', `ishikawa_categoria_${j}`);
        row.querySelectorAll('select')[1].setAttribute('id', `ishikawa_causa_${j}`);
        row.querySelector('button').setAttribute('onclick', `eliminarDiagnostico(${j})`);
        row.querySelector('select').setAttribute('onchange', `cambiarIshikawaCategoria(${j})`);
    }
    i= tabla_diagnosticos.rows().count();
    checkSendNuevoParteDiagnostico();
}

function checkSendNuevoParteDiagnostico(){
    if(tabla_diagnosticos.rows().count() > 0 && $("#fecha").val() && $("#horas").val()){
        $("#btnGuardarNuevoParteDiagnostico").removeAttr('disabled');
    }
    else{
        $("#btnGuardarNuevoParteDiagnostico").attr('disabled', 'disabled');
    }
}


function openModalNuevoParteDiagnostico(id_orden){
    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico").show();
    tabla_diagnosticos.clear().draw();
    i = 0;
    $("#btnGuardarNuevoParteDiagnostico").show();
    $('.obligatorio').show();
    $("#label_ob_diagnostico").show()
    $("#btnGuardarNuevoParteDiagnostico").attr('disabled', 'disabled');
    $("input:radio[name=a_resolver]").removeAttr('disabled');
    $("#horas").val('');
    $("#horas").removeAttr('disabled');
    let hoy = new Date()
    hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
    '-' + hoy.getDate().toString().padStart(2, 0)
    $("#fecha").val(hoy);
    $("#observaciones_diagonstico").val('');
    $("#observaciones_diagonstico").removeAttr('disabled');
    $("#completado_diagnostico").removeAttr('checked');
    $("#completado_diagnostico").removeAttr('disabled');
    $("#fecha").removeAttr('disabled');
    $("#herramental").val($("#activo").val());
    document.getElementById('nombreActivo').textContent = $("#activo").val();
    $("#id_orden").val(id_orden);
    $("input:radio").attr("checked", false);
}

function openModalVerParteDiagnostico(id_orden, activo){
    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico").hide();
    $("#fecha").attr('disabled', 'disabled');
    $("#horas").attr('disabled', 'disabled');
    $('.obligatorio').hide();
    $("#label_ob_diagnostico").hide();
    $("#completado_diagnostico").prop('disabled', 'disabled');
    $("#observaciones_diagonstico").attr('disabled', 'disabled');
    $("#btnGuardarNuevoParteDiagnostico").hide();
    $("#herramental").val(activo);
    document.getElementById('nombreActivo').textContent = activo;
    tabla_diagnosticos.column(3).visible(false);
    tabla_diagnosticos.clear()
    $.ajax({
        type: 'GET',
        url: '/get-parte-diagnostico-completado/' + id_orden,
        success: function(data) {
            if(!data.length){
                return;
            }
            let diag = data[0];
            $("#horas").val(diag.get_parte.horas);
            $("#fecha").val(diag.get_parte.fecha);
            $("#observaciones_diagonstico").val(diag.get_parte.observaciones);
            $("#completado_diagnostico").prop('checked', true);
            if(diag.en_maquina == 1){
                $("input:radio[name=a_resolver][value='Máquina']").prop("checked", true);
            }
            else if(diag.en_banco == 1){
                $("input:radio[name=a_resolver][value='Banco']").prop("checked", true);
            }
            $("input:radio[name=a_resolver]").attr("disabled", true);
            let i = 1;
            data.forEach(diagnostico => {
                diagnostico.get_parte_diag_x_causa.forEach(parte_diag_x_causa => {
                    tabla_diagnosticos.row.add([
                        i,
                        parte_diag_x_causa.get_ishikawa_causa.get_categoria.nombre_categoria,
                        parte_diag_x_causa.get_ishikawa_causa.nombre_causa,
                        '-'
                    ]);
                    i++;
                });
            });
            tabla_diagnosticos.columns.adjust();
            tabla_diagnosticos.draw();
        }
    });
}

function openModalParteDiagnosticoPendiente(id_orden, activo){
    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico").show();
    tabla_diagnosticos.clear().draw();
    i = 0;
    $("#btnGuardarNuevoParteDiagnostico").show();
    $('.obligatorio').show();
    $("#label_ob_diagnostico").show()
    $("#btnGuardarNuevoParteDiagnostico").attr('disabled', 'disabled');
    $("input:radio[name=a_resolver]").removeAttr('disabled');
    $("#horas").val('');
    $("#horas").removeAttr('disabled');
    $("#observaciones_diagonstico").removeAttr('disabled');
    $("#completado_diagnostico").removeAttr('checked');
    $("#completado_diagnostico").removeAttr('disabled');
    $("#fecha").removeAttr('disabled');
    $("#herramental").val(activo);
    document.getElementById('nombreActivo').textContent = activo;
    $("#id_orden").val(id_orden);

    let hoy = new Date()
    hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
    '-' + hoy.getDate().toString().padStart(2, 0)
    $("#fecha").val(hoy);
    $.ajax({
        type: 'GET',
        url: '/get-parte-diagnostico-completado/' + id_orden,
        success: function(data) {
            if(!data.length){
                return;
            }
            let diag = data[0];
            $("#observaciones_diagonstico").val(diag.get_parte.observaciones);
            $("#completado_diagnostico").prop('checked', false);
            if(diag.en_maquina == 1){
                $("input:radio[name=a_resolver][value='Máquina']").prop("checked", true);
            }
            else if(diag.en_banco == 1){
                $("input:radio[name=a_resolver][value='Banco']").prop("checked", true);
            }
            $("input:radio[name=a_resolver]").attr("disabled", false);
            let i = 0;
            let tabla_already = tabla_diagnosticos.rows().count();
            data.forEach(diagnostico => {
                diagnostico.get_parte_diag_x_causa.forEach(parte_diag_x_causa => {
                    tabla_diagnosticos.row.add([
                        (i + tabla_already + 1),
                        parte_diag_x_causa.get_ishikawa_causa.get_categoria.nombre_categoria,
                        parte_diag_x_causa.get_ishikawa_causa.nombre_causa,
                        '-'
                    ]);
                    i++;
                });
            });

            tabla_diagnosticos.columns.adjust();
            tabla_diagnosticos.draw();
        }
    });
}

function openModalCrearParteDiagnostico(id_orden, nombre_activo){
    $('#nuevoParteDiagnosticoModal').modal('show');
    $("#btnAgregarFilaDiagnostico").show();
    $("#herramental").val(nombre_activo);
    document.getElementById('nombreActivo').textContent = nombre_activo;
    tabla_diagnosticos.clear().draw();
    i = 0;
    $("#btnGuardarNuevoParteDiagnostico").show();
    $('.obligatorio').show();
    $("#label_ob_diagnostico").show()
    $("#btnGuardarNuevoParteDiagnostico").attr('disabled', 'disabled');
    $("input:radio[name=a_resolver]").removeAttr('disabled');
    $("#horas").val('');
    $("#horas").removeAttr('disabled');
    let hoy = new Date()
    hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
    '-' + hoy.getDate().toString().padStart(2, 0)
    $("#fecha").val(hoy);
    $("#observaciones_diagonstico").val('');
    $("#observaciones_diagonstico").removeAttr('disabled');
    $("#completado_diagnostico").removeAttr('checked');
    $("#completado_diagnostico").removeAttr('disabled');
    $("#fecha").removeAttr('disabled');
    $("#id_orden").val(id_orden);
    $("input:radio").attr("checked", false);
}


function openModalNuevoParteInspeccion(id_activo, id_orden, nombre_activo){
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").show()
    $("#previewAceptarInspeccionReview").hide()
    $("#herramental_inspeccion").val(nombre_activo);
    document.getElementById('nombreActivoInspeccion').textContent = nombre_activo;
    $("#horas_inspeccion").removeAttr('disabled')
    $("#fecha_inspeccion").removeAttr('disabled')
    let hoy = new Date()
    hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
    '-' + hoy.getDate().toString().padStart(2, 0)
    $("#fecha_inspeccion").val(hoy)

    tabla_inspecciones.clear();

    $.ajax({
        type: 'GET',
        url: '/get-tareas-por-activo/' + id_activo,
        success: function(data) {

            if (!data.tareas_x_activo.length) return;

            let zona_actual = null;
            let j = 0
            data.tareas_x_activo.forEach(tarea => {
                if (tarea.get_zona_tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.get_zona_tarea.nombre_zona;
                    addZonaHeader(zona_actual)
                }    
                tabla_inspecciones.row.add([
                    tarea.nombre_tarea,

                    tarea.get_ejecucion.nombre_ejecucion,

                    `<input type="radio"
                        name="tareas[${j}][ok]" value="ok"  
                        onchange="checkboxTareaRealizada(${j},${tarea.id_tarea_mantenimiento})">
                    <input type="hidden" name="tareas[${j}][id]" value="${tarea.id_tarea_mantenimiento}">`,

                    `<input type="radio" onchange="checkboxTareaRealizada(${j},${tarea.id_tarea_mantenimiento})" name="tareas[${j}][ok]" value="not_ok">`,

                    `<div id="label_accion_${tarea.id_tarea_mantenimiento}">-</div>
                    <select required name="tareas[${j}][accion]" class="form-select" hidden id="accion_${tarea.id_tarea_mantenimiento}">
                        <option value="NO ACCION" hidden>Seleccionar...</option>
                        ${$("#accion_select_div").html()}
                    </select>`
                ]);
                j++;
            });

            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust();
        }
    });
}


function addZonaHeader(nombreZona) {
    let zonaRow = tabla_inspecciones.row.add([
        nombreZona,
        "",
        "",
        "",
        ""
    ]).node();

    $(zonaRow).find('td').eq(0)
        .attr('colspan', 5)
        .addClass('text-center fw-bold text-dark');

    $(zonaRow).find('td:gt(0)').remove();
    $(zonaRow).removeClass('odd even').attr('style', "color: rgb(255, 255, 255); background-color: #2b56843b; font-weight: bold;");
    let headerRow = tabla_inspecciones.row.add([
        "Tarea",
        "Ejecución",
        "OK",
        "NO OK",
        "Acción"
    ]).node();

    $(headerRow).removeClass('odd even').addClass('zona-columns text-light');
    $(headerRow).find('td').removeClass('odd even').attr('style', "color: rgb(255, 255, 255) !important; background-color: #2b5684; font-weight: bold;");
    $(headerRow).attr('style', "color: rgb(255, 255, 255) !important; background-color: #2b5684; font-weight: bold;");
}


function checkboxTareaRealizada(j, idTarea){
    const radio = $(`input[name="tareas[${j}][ok]"]:checked`).val();

    if (radio === 'not_ok') {
        $("#label_accion_" + idTarea).attr('hidden', true);
        $("#accion_" + idTarea).removeAttr('hidden');
        $("#accion_" + idTarea).attr('required', 'required');
    } else {
        $("#accion_" + idTarea).attr('hidden', true);
        $("#accion_" + idTarea).removeAttr('required');
        $("#label_accion_" + idTarea).html('No se requiere acción')
        $("#label_accion_" + idTarea).removeAttr('hidden');
    }
    
    let completo = validarRadios()
    if(completo){
        $("#completado_inspeccion_value").prop('checked', true)
        $("#completado_inspeccion").prop('checked', true)
    }
    else{
        $("#completado_inspeccion_value").prop('checked', false)
        $("#completado_inspeccion").prop('checked', false)
    }
}

function validarRadios() {
    let completos = true;
    const grupos = {};
    $('input[type="radio"][name^="tareas"]').each(function () {
        grupos[$(this).attr('name')] = true;
    });
    for (let name in grupos) {
        if ($(`input[name="${name}"]:checked`).length === 0) {
            completos = false;
            break;
        }
    }
    return completos;
}

function openModalParteInspeccionPendiente(id_activo, id_orden, nombre_activo){
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").show()
    $("#previewAceptarInspeccionReview").hide()
    $("#herramental_inspeccion").val(nombre_activo);
    document.getElementById('nombreActivoInspeccion').textContent = nombre_activo;
    $("#horas_inspeccion").removeAttr('disabled')
    $("#completado_inspeccion").removeAttr('disabled')
    $("#fecha_inspeccion").removeAttr('disabled')

    tabla_inspecciones.clear();

    $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion-pendiente/' + id_activo + '/' + id_orden,
        success: function(data) {
            console.log(data)
            let zona_actual = null;
            let j = 0
            data.tareasMantenimiento.forEach(tarea => {
                if (tarea.get_zona_tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.get_zona_tarea.nombre_zona;
                    addZonaHeader(zona_actual)
                } 
                tabla_inspecciones.row.add([
                    tarea.nombre_tarea,

                    tarea.get_ejecucion.nombre_ejecucion,

                    `<input type="radio"
                        name="tareas[${j}][ok]" value="ok"  
                        checked  id="ok_${tarea.id_tarea_mantenimiento}"
                        onchange="checkboxTareaRealizada(${j},${tarea.id_tarea_mantenimiento})">
                    <input type="hidden" name="tareas[${j}][id]" value="${tarea.id_tarea_mantenimiento}">`,

                    `<input id="not_ok_${tarea.id_tarea_mantenimiento}" type="radio" onchange="checkboxTareaRealizada(${j},${tarea.id_tarea_mantenimiento})" name="tareas[${j}][ok]" value="not_ok">`,

                    `<div id="label_accion_${tarea.id_tarea_mantenimiento}">-</div>
                    <select required name="tareas[${j}][accion]" class="form-select" hidden id="accion_${tarea.id_tarea_mantenimiento}">
                        <option value="NO ACCION" hidden>Seleccionar...</option>
                        ${$("#accion_select_div").html()}
                    </select>`
                ]);
                tabla_inspecciones.draw();
                
                if(tarea.ok ===null){
                    console.log('null')
                    $("#accion_" + tarea.id_tarea_mantenimiento).attr('hidden', true);
                    $("#accion_" + tarea.id_tarea_mantenimiento).removeAttr('required');
                    $("#label_accion_" + tarea.id_tarea_mantenimiento).removeAttr('hidden');
                    $(`#ok_${tarea.id_tarea_mantenimiento}`).prop('checked', false)
                    $(`#not_ok_${tarea.id_tarea_mantenimiento}`).prop('checked', false)
                }
                else if(tarea.ok === 0){
                    console.log('0')
                    $(`#accion_${tarea.id_tarea_mantenimiento}`).val(tarea.id_accion_tarea)
                    $("#label_accion_" + tarea.id_tarea_mantenimiento).attr('hidden', true);
                    $("#accion_" + tarea.id_tarea_mantenimiento).removeAttr('hidden');
                    $("#accion_" + tarea.id_tarea_mantenimiento).attr('required', 'required');
                    $(`#not_ok_${tarea.id_tarea_mantenimiento}`).prop('checked', true)
                }
                else if(tarea.ok == 1){
                    console.log('1')
                    $("#accion_" + tarea.id_tarea_mantenimiento).attr('hidden', true);
                    $("#accion_" + tarea.id_tarea_mantenimiento).removeAttr('required');
                    $("#label_accion_" + tarea.id_tarea_mantenimiento).html('No se requiere acción')
                    $("#label_accion_" + tarea.id_tarea_mantenimiento).removeAttr('hidden');
                    $(`#ok_${tarea.id_tarea_mantenimiento}`).prop('checked', true)
                }

                j++;
            });
            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust(); 
            $("#horas_inspeccion").val('')
            let hoy = new Date()
            hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
            '-' + hoy.getDate().toString().padStart(2, 0)
            $("#fecha_inspeccion").val(hoy)
        }
    });
}


function openModalVerParteInspeccion(id_orden, nombre_activo){   
    $('#modalNuevoParteInspeccion').modal('show');
    $("#id_orden_inspeccion").val(id_orden);
    $("#btnGuardarNuevoParteInspeccion").hide()
    $("#previewAceptarInspeccionReview").hide()
    $("#horas_inspeccion").attr('disabled', 'disabled')
    $("#fecha_inspeccion").attr('disabled', 'disabled')
    $("#completado_inspeccion").prop('checked', true)
    $("#herramental_inspeccion").val(nombre_activo);
    document.getElementById('nombreActivoInspeccion').textContent = nombre_activo;
    tabla_inspecciones.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-inspeccion-completado/' + id_orden,
        success: function(data) {
            let zona_actual = null;
            data.get_parte.get_orden.parte_inspe_x_tareas_mantenimiento.forEach(tarea => {
                if (tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona !== zona_actual) {
                    zona_actual = tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona;
                    addZonaHeader(zona_actual)
                }

                let ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled checked>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;

                let not_ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;

                let accion = '-';

                if(tarea.ok == 0){
                    ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;
                    not_ok = `<div class="form-check">
                            <input class="form-check-input" type="radio" name="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}" disabled checked>
                            <label class="form-check-label" for="radioDisabled${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">
                            </label>
                          </div>`;
                    accion = tarea.get_accion_para_tarea.nombre_accion
                }      
                tabla_inspecciones.row.add([
                    tarea.get_tarea_mantenimiento.nombre_tarea,
                    tarea.get_tarea_mantenimiento.get_ejecucion.nombre_ejecucion,
                    ok,
                    not_ok,
                    accion
                ]);
            });
            $("#fecha_inspeccion").val(data.get_parte.fecha)
            $("#horas_inspeccion").val(data.horas)
            tabla_inspecciones.draw();
            tabla_inspecciones.columns.adjust();
        }
    });
}


function openModalNuevoParteAjuste(id_orden, id_etapa, nombre_activo) {
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").show()
    $("#previewAceptarAjusteReview").hide()
    $("#herramental_ajuste").val(nombre_activo)
    document.getElementById('nombreActivoAjuste').textContent = nombre_activo;
    $("#horas_ajuste").removeAttr('disabled')
    $("#fecha_ajuste").removeAttr('disabled')
    $("#btnRowNuevoAjuste").show()

    tabla_ajustes.clear();

    $.ajax({
        type: 'GET',
        url: '/get-pre-acciones-ajuste/' + id_etapa,
        success: function(data) {
            let j=0;
            let opciones = ''
            data.forEach(d => 
                {
                    console.log(d)
                    d.get_tareas_mantenimiento.forEach(tarea => {
                        tabla_ajustes.row.add([
                            (j+1) + ' - ' + tarea.get_tarea_mantenimiento.nombre_tarea,
                            tarea.get_accion_para_tarea.nombre_accion,
                            `<select class="form-select" required name="tareas[${j}][zona]">
                                <option value="">Seleccionar...</option>
                                ${$("#zona_select_div").html()}
                            </select>
                            <input hidden name="tareas[${j}][accion]" value="${tarea.get_accion_para_tarea.id_accion_tarea}">
                            <input hidden name="tareas[${j}][tarea_mant]" value="${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">`,                    
                            `<select class="form-select" required name="tareas[${j}][maquina]">
                                <option value="">Seleccionar...</option>
                                ${$("#maquina_select_div").html()}
                            </select>`,
                            `<input  onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox"
                            name="tareas[${j}][hecho]">`
                        ]);                
                    j++;
                    opciones = opciones += `<option value="${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">${tarea.get_tarea_mantenimiento.nombre_tarea}</option>`     
                    console.log(opciones)
                });               
            })
            let hoy = new Date()
            hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
            '-' + hoy.getDate().toString().padStart(2, 0)
            $("#fecha_ajuste").val(hoy)
            $("#horas_ajuste").val('')            
            $("#tarea_mantenimiento").html(opciones)
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();
        }
    });
}

function agregarNuevoAjusteRow(){
    let j = tabla_ajustes.rows().count();

    const rowNode = tabla_ajustes.row.add([
        '<div class="d-flex"><div class="my-auto">' + (j + 1) + ` - </div><select style="width: 85%" class="m-auto form-select" name="tareas[${j}][tarea_mant]"><option value="">Seleccionar...</option>${$("#tarea_mantenimiento").html()}</select></div>`,
        `<select class="form-select" required name="tareas[${j}][accion]">
            <option value="">Seleccionar...</option>
            ${$("#accion_select_div").html()}
        </select>`,
        `<select class="form-select" required name="tareas[${j}][zona]">
            <option value="">Seleccionar...</option>
            ${$("#zona_select_div").html()}
        </select>`,                    
        `<select class="form-select" required name="tareas[${j}][maquina]">
            <option value="">Seleccionar...</option>
            ${$("#maquina_select_div").html()}
        </select>`,
        `<input onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox" name="tareas[${j}][hecho]">
         <button type="button" onclick="eliminarRowAjuste(${j})" class="btn btn-danger ms-2">X</button>`
    ]).node();
    rowNode.id = `ajuste_${j}`;
    
    tabla_ajustes.draw();
    $("#completado_ajuste").prop('checked', false)
}


function eliminarRowAjuste(indice){
    tabla_ajustes.row('#ajuste_' + indice).remove();
    reordenarFilasAjuste();
    checkCompletoAjuste()
}

function reordenarFilasAjuste() {
    tabla_ajustes.rows().every(function (rowIndex) {
        const row = this.node();
        row.id = `ajuste_${rowIndex}`;

        $(row).find('select, input').each(function () {
            let name = $(this).attr('name');
            if (name) {
                name = name.replace(/tareas\[\d+\]/, `tareas[${rowIndex}]`);
                $(this).attr('name', name);
            }
        });
        $(row).find('button').attr('onclick', `eliminarRowAjuste(${rowIndex})`);
        const firstTd = $(row).find('td').eq(0);
        firstTd.find('.my-auto').text((rowIndex + 1) + ' - ');
    });

    tabla_ajustes.draw(false);
}


function checkCompletoAjuste() {
    const checkboxes = document.querySelectorAll('input[name^="tareas"][name$="[hecho]"]');

    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

    if (allChecked) {
        $("#completado_ajuste").prop('checked', true)
    } else {
        $("#completado_ajuste").prop('checked', false)
    }
}



function openModalConfirmarParteAjuste(id_orden, nombre_act){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").hide()
    $("#previewAceptarAjusteReview").show()
    $("#btnRowNuevoAjuste").hide()
    $("#horas_ajuste").attr('disabled', 'disabled')
    $("#fecha_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").prop('checked', true)
    $("#herramental_ajuste").val(nombre_act);
    document.getElementById('nombreActivoInspeccion').textContent = nombre_act;
    tabla_ajustes.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste/' + id_orden,
        success: function(data) {
            let j=0;
            let bandera = 0
            data.get_tareas_ajuste.forEach(tarea => {
                tabla_ajustes.row.add([
                    j+1 + ' - ' + tarea.get_tarea_mantenimiento.nombre_tarea,
                    tarea.get_accion_tarea.nombre_accion,
                    tarea.get_zona.nombre_zona,
                    tarea.get_maquinaria.alias_maquinaria,
                    tarea.hecho? 'SI': 'NO'
                ]);
                j++;
                if(tarea.get_accion_tarea.nombre_accion == 'REFABRICAR' || tarea.get_accion_tarea.nombre_accion== 'Refabricar'){
                    bandera = 1
                }
            }); 
            $("#fecha_ajuste").val(data.get_parte.fecha)
            $("#horas_ajuste").val(data.horas)
            $("#bandera_refabricar").val(bandera)
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();
        }
    });
}

function procesarAjuste(accion){
    $.ajax({
        type: 'post',
        url: '/procesar-parte-ajuste',
        data: {
            id_orden_mantenimiento: $("#id_orden_ajuste").val(),
            accion: accion,
            nombre_proyecto: $("#nombre_proyecto_i").text(),
        },
        success: function(data) {
            $('#nuevoParteAjusteModal').modal('hide');
            location.reload();
        }
    });
}

function openModalParteAjustePendiente(id_orden, id_etapa, nombre_activo){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").show()
    $("#previewAceptarAjusteReview").hide()
    $("#btnRowNuevoAjuste").show()
    $("#horas_ajuste").removeAttr('disabled')
    $("#fecha_ajuste").removeAttr('disabled')
    $("#completado_ajuste").removeAttr('disabled')
    $("#herramental_ajuste").val(nombre_activo);
    document.getElementById('nombreActivoInspeccion').textContent = nombre_activo;
    tabla_ajustes.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste/' + id_orden,
        success: function(data) {
            let j=0;
            data.get_tareas_ajuste.forEach(tarea => {
                tabla_ajustes.row.add([
                    (j+1) + ' - ' + tarea.get_tarea_mantenimiento.nombre_tarea,
                    tarea.get_accion_tarea.nombre_accion,
                    `<select id="tareas_zona_${j}" class="form-select" required name="tareas[${j}][zona]">
                        <option value="">Seleccionar...</option>
                        ${$("#zona_select_div").html()}
                    </select>
                    <input hidden name="tareas[${j}][accion]" value="${tarea.get_accion_tarea.id_accion_tarea}">
                    <input hidden name="tareas[${j}][tarea_mant]" value="${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">`,                    
                    `<select class="form-select" required id="tarea_maquina_${j}" name="tareas[${j}][maquina]">
                        <option value="">Seleccionar...</option>
                        ${$("#maquina_select_div").html()}
                    </select>`,
                    `<input id="tarea_hecho_${j}" onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox"
                    name="tareas[${j}][hecho]">`
                ]);
                tabla_ajustes.draw();
                $(`#tarea_maquina_${j}`).val(tarea.get_maquinaria.id_maquinaria)
                $(`#tareas_zona_${j}`).val(tarea.get_zona.id_zona)
                tarea.hecho? $(`#tarea_hecho_${j}`).prop('checked', true): $(`#tarea_hecho_${j}`).prop('checked', false)
                j++;
            }); 
            let hoy = new Date()
            hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
            '-' + hoy.getDate().toString().padStart(2, 0)
            $("#fecha_ajuste").val(hoy)
            $("#horas_ajuste").val('')       
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();
            getTareasSelect(id_etapa)
        }
    });
}

function getTareasSelect(id_etapa){
    $.ajax({
        type: 'GET',
        url: '/get-pre-acciones-ajuste/' + id_etapa,
        success: function(data) {
            let opciones = ''
            data.forEach(d => {
                d.get_tareas_mantenimiento.forEach(tarea => {
                    opciones = opciones += `<option value="${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">${tarea.get_tarea_mantenimiento.nombre_tarea}</option>`     
                });               
            })
            $("#tarea_mantenimiento").html(opciones)
        }
    });
}

function openModalVerParteAjuste(id_orden, nombre_activo){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").hide()
    $("#previewAceptarAjusteReview").hide()
    $("#btnRowNuevoAjuste").hide()
    $("#horas_ajuste").attr('disabled', 'disabled')
    $("#fecha_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").prop('checked', true)
    $("#herramental_ajuste").val(nombre_activo);
    document.getElementById('nombreActivoInspeccion').textContent = nombre_activo;
    tabla_ajustes.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste-completado/' + id_orden,
        success: function(data) {
            let j=0;
            data.get_tareas_ajuste.forEach(tarea => {
                tabla_ajustes.row.add([
                    j+1 + ' - ' + tarea.get_tarea_mantenimiento.nombre_tarea,
                    tarea.get_accion_tarea.nombre_accion,
                    tarea.get_zona.nombre_zona,
                    tarea.get_maquinaria.alias_maquinaria,
                    tarea.hecho? 'SI': 'NO'
                ]);
                j++;
            }); 
            $("#fecha_ajuste").val(data.get_parte.fecha)
            $("#horas_ajuste").val(data.horas)
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();
        }
    });
}