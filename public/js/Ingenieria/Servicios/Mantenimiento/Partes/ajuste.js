var tabla_ajustes, tabla_mecanizado

$(document).ready(function () {
    tabla_ajustes = $('#tabla_ajustes').DataTable({
        autoWidth: false,
         columnDefs: [
            { className: "text-center", targets: [1,2,3,4] }, { width: '25%', targets:[0]}, {className: "text-start", targets: [0]}  
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
    $("#nombre_proyecto_ajuste").val($("#nombre_proyecto_i").val())
    tabla_mecanizado = $('#tablaOrdenMec').DataTable({
        autoWidth: false,
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


function openModalNuevoParteAjuste(id_orden, id_etapa){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").show()
    $("#previewAceptarAjusteReview").hide()
    document.getElementById('nombreActivoAjuste').textContent = $("#activo").val();
    $("#horas_ajuste").removeAttr('disabled')
    $("#minutos_ajuste").removeAttr('disabled')
    $("#fecha_ajuste").removeAttr('disabled')
    $("#btnRowNuevoAjuste").show()

    tabla_ajustes.clear();

    $.ajax({
        type: 'GET',
        url: '/get-pre-acciones-ajuste/' + id_etapa,
        success: function(data) {
            let j=0;
            data.forEach(tarea => 
                {
                    if(tarea.id_tarea_mantenimiento != null){
                    tabla_ajustes.row.add([
                        tarea.get_zona.nombre_zona + ' - ' + tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona,
                        `<select class="form-select" name="tareas[${j}][accion]">
                            <option value="">Seleccionar...</option>
                            ${$("#accion_select_div").html()}
                        </select>
                        <input hidden name="tareas[${j}][tarea_mant]" value="${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">`,
                        `<input type="text" class="form-control" name="tareas[${j}][observaciones]" placeholder="Observaciones...">`,
                        `<select class="form-select" name="tareas[${j}][maquina]">
                            <option value="">Seleccionar...</option>
                            ${$("#maquina_select_div").html()}
                        </select>`,
                        `<input onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox"
                        name="tareas[${j}][hecho]">`
                    ]);        
                    }
                    else{
                        tabla_ajustes.row.add([
                        tarea.get_zona.nombre_zona + ' - ' + tarea.get_zona_tarea.nombre_zona,
                        `<select class="form-select" name="tareas[${j}][accion]">
                            <option value="">Seleccionar...</option>
                            ${$("#accion_select_div").html()}
                        </select>
                        <input hidden name="tareas[${j}][tarea_mant]" value="${tarea.id_zona}-${tarea.id_zona_tarea}">`,
                        `<input type="text" class="form-control" name="tareas[${j}][observaciones]" placeholder="Observaciones...">`,
                        `<select class="form-select" name="tareas[${j}][maquina]">
                            <option value="">Seleccionar...</option>
                            ${$("#maquina_select_div").html()}
                        </select>`,
                        `<input onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox"
                        name="tareas[${j}][hecho]">`
                    ]);        
                    }    
                j++;        
            })
            let hoy = new Date()
            hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
            '-' + hoy.getDate().toString().padStart(2, 0)
            $("#fecha_ajuste").val(hoy)
            $("#horas_ajuste").val('00')            
            $("#minutos_ajuste").val('00')            
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();            
            checkCompletoAjuste()
        }
    });
}

function agregarNuevoAjusteRow(){
    let j = tabla_ajustes.rows().count();
    const rowNode = tabla_ajustes.row.add([
        `<select style="width: 100%" class="form-select" name="tareas[${j}][tarea_mant]">
            <option value="">Seleccionar...</option>
            ${$("#tarea_mantenimiento").html()}
        </select>`,
        `<select class="form-select" required name="tareas[${j}][accion]">
            <option value="">Seleccionar...</option>
            ${$("#accion_select_div").html()}
        </select>`,
        `<input type="text" class="form-control" name="tareas[${j}][observaciones]" placeholder="Observaciones...">`,
        `<select class="form-select" required name="tareas[${j}][maquina]" id="tareas_maquina_${j}">
            <option value="">Seleccionar...</option>
            ${$("#maquina_select_div").html()}
        </select>`,
        `<input id="tarea_hecho_${j}" onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox" name="tareas[${j}][hecho]">
         <button type="button" onclick="eliminarRowAjuste(${j})" class="btn btn-danger ms-2">X</button>`
    ]).node();
    rowNode.id = `ajuste_${j}`;
    
    tabla_ajustes.draw();
    $("#completado_ajuste").prop('checked', false)
    checkCompletoAjuste()
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
    });

    tabla_ajustes.draw(false);
}

function checkCompletoAjuste() {
    const checkboxes = document.querySelectorAll(
        'input[name^="tareas"][name$="[hecho]"]'
    );

    let allChecked = true;

    checkboxes.forEach(cb => {
        const id = cb.id.replace('tarea_hecho_', '');
        const maquina = document.getElementById(`tarea_maquina_${id}`);

        if (maquina) maquina.required = cb.checked;

        if (!cb.checked) {
            allChecked = false;
        }
    });

    $("#completado_ajuste").prop('checked', allChecked);
}

function openModalConfirmarParteAjuste(id_orden){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").hide()
    $("#previewAceptarAjusteReview").show()
    $("#btnRowNuevoAjuste").hide()
    $("#horas_ajuste").attr('disabled', 'disabled')
    $("#minutos_ajuste").attr('disabled', 'disabled')
    $("#fecha_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").prop('checked', true)
    document.getElementById('nombreActivoAjuste').textContent = $("#activo").val();
    tabla_ajustes.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste/' + id_orden,
        success: function(data) {
            let j=0;
            let bandera = 0
            data.get_tareas_ajuste.forEach(tarea => {
                tabla_ajustes.row.add([
                    tarea.get_zona.nombre_zona,
                    tarea.get_accion_tarea.nombre_accion,
                    tarea.observaciones ?? '',
                    tarea.get_maquinaria ? tarea.get_maquinaria.alias_maquinaria : 'Sin seleccionar',
                    tarea.hecho? 'SI': 'NO'
                ]);
                j++;
                if(tarea.get_accion_tarea.nombre_accion == 'REFABRICAR' || tarea.get_accion_tarea.nombre_accion== 'Refabricar'){
                    bandera = 1
                }
            }); 
            $("#fecha_ajuste").val(data.get_parte.fecha)
            let [hr, mn] = data.horas.split(':');
            $("#horas_ajuste").val(hr);
            $("#minutos_ajuste").val(mn);
            $("#bandera_refabricar").val(bandera)
            let tieneFinalizacion = tabla_mecanizado.rows().data().toArray()
            .some(r => r[3] !== null && r[3] !== '' && r[3] !== '____-__-__');

            if (bandera == 1 && !tieneFinalizacion) {
                $("#mensaje_refabricar").show();
                $("#btnAceptarAjusteReview").prop('disabled', true);
            } else {
                $("#mensaje_refabricar").hide();
                $("#btnAceptarAjusteReview").prop('disabled', false);
            }
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

function openModalParteAjustePendiente(id_orden, id_etapa){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").show()
    $("#previewAceptarAjusteReview").hide()
    $("#btnRowNuevoAjuste").show()
    $("#horas_ajuste").removeAttr('disabled')
    $("#minutos_ajuste").removeAttr('disabled')
    $("#fecha_ajuste").removeAttr('disabled')
    $("#completado_ajuste").removeAttr('disabled')
    document.getElementById('nombreActivoAjuste').textContent = $("#activo").val();
    tabla_ajustes.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste/' + id_orden,
        success: function(data) {
            let j=0;
            data.get_tareas_ajuste.forEach(tarea => {
                if(tarea.id_tarea_mantenimiento != null){
                    tabla_ajustes.row.add([
                        tarea.get_zona.nombre_zona + ' - ' + tarea.get_tarea_mantenimiento.get_zona_tarea.nombre_zona,
                        `<select class="form-select" name="tareas[${j}][accion]">
                            <option value="">Seleccionar...</option>
                            ${$("#accion_select_div").html()}
                        </select>
                        <input hidden name="tareas[${j}][tarea_mant]" value="${tarea.get_tarea_mantenimiento.id_tarea_mantenimiento}">`,
                        `<input type="text" class="form-control" name="tareas[${j}][observaciones]" placeholder="Observaciones...">`,
                        `<select id="tarea_maquina_${j}" class="form-select" name="tareas[${j}][maquina]">
                            <option value="">Seleccionar...</option>
                            ${$("#maquina_select_div").html()}
                        </select>`,
                        `<input onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox" id="tarea_hecho_${j}"
                        name="tareas[${j}][hecho]">`
                    ]);        
                }
                else{
                    tabla_ajustes.row.add([
                        tarea.get_zona.nombre_zona + ' - ' + tarea.get_zona_tarea.nombre_zona,
                        `<select class="form-select" name="tareas[${j}][accion]">
                            <option value="">Seleccionar...</option>
                            ${$("#accion_select_div").html()}
                        </select>
                        <input hidden name="tareas[${j}][tarea_mant]" value="${tarea.id_zona}-${tarea.id_zona_tarea}">`,
                        `<input type="text" class="form-control" name="tareas[${j}][observaciones]" placeholder="Observaciones...">`,
                        `<select id="tarea_maquina_${j}" class="form-select" name="tareas[${j}][maquina]">
                            <option value="">Seleccionar...</option>
                            ${$("#maquina_select_div").html()}
                        </select>`,
                        `<input onchange="checkCompletoAjuste()" class="form-check-input" type="checkbox" id="tarea_hecho_${j}"
                        name="tareas[${j}][hecho]">`
                    ]);        
                }
                tabla_ajustes.draw();
                $(`#tarea_maquina_${j}`).val(tarea.get_maquinaria?.id_maquinaria ?? '')
                $(`select[name="tareas[${j}][accion]"]`).val(tarea.get_accion_tarea?.id_accion_tarea ?? '')
                tarea.hecho? $(`#tarea_hecho_${j}`).prop('checked', true): $(`#tarea_hecho_${j}`).prop('checked', false)
                j++;
            }); 
            let hoy = new Date()
            hoy = hoy.getFullYear().toString() + '-' + (hoy.getMonth() + 1).toString().padStart(2, 0) +
            '-' + hoy.getDate().toString().padStart(2, 0)
            $("#fecha_ajuste").val(hoy)
            $("#horas_ajuste").val('00')       
            $("#minutos_ajuste").val('00')       
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();
            
            checkCompletoAjuste()
        }
    });
}


function openModalVerParteAjuste(id_orden){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").hide()
    $("#previewAceptarAjusteReview").hide()
    $("#btnRowNuevoAjuste").hide()
    $("#horas_ajuste").attr('disabled', 'disabled')
    $("#minutos_ajuste").attr('disabled', 'disabled')
    $("#fecha_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").prop('checked', true)    
    document.getElementById('nombreActivoAjuste').textContent = $("#activo").val();
    tabla_ajustes.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste-completado/' + id_orden,
        success: function(data) {
            let j=0;
            data.get_tareas_ajuste.forEach(tarea => {
                tabla_ajustes.row.add([
                    tarea.get_zona.nombre_zona,
                    tarea.get_accion_tarea?.nombre_accion ?? 'Sin seleccionar',
                    tarea.observaciones ?? '',
                    tarea.get_maquinaria.alias_maquinaria,
                    tarea.hecho? 'SI': 'NO'
                ]);
                j++;
            }); 
            $("#fecha_ajuste").val(data.get_parte.fecha)
            let [hr, mn] = data.get_parte.horas.split(':');
            $("#horas_ajuste").val(hr);
            $("#minutos_ajuste").val(mn);            
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();
            checkCompletoAjuste()
        }
    });
}

function verParteDeAjuste(id_parte, estado){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").hide()
    $("#previewAceptarAjusteReview").hide()
    $("#btnRowNuevoAjuste").hide()
    $("#horas_ajuste").attr('disabled', 'disabled')
    $("#minutos_ajuste").attr('disabled', 'disabled')
    $("#fecha_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").attr('disabled', 'disabled')
    if(estado == 'Revisar'){
        $("#completado_ajuste").prop('checked', true)
    }else{
        $("#completado_ajuste").prop('checked', false)
    }
    document.getElementById('nombreActivoAjuste').textContent = $("#activo").val();
    tabla_ajustes.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste-porcion/' + id_parte,
        success: function(data) {
            let j=0;
            data.get_tareas_ajuste.forEach(tarea => {
                tabla_ajustes.row.add([
                    tarea.get_zona?.nombre_zona ?? 'Sin seleccionar',
                    tarea.get_accion_tarea?.nombre_accion ?? 'Sin seleccionar',
                    tarea.observaciones ?? '-',
                    tarea.get_maquinaria?.alias_maquinaria ?? 'Sin seleccionar',
                    tarea.hecho? 'SI': 'NO'
                ]);
                j++;
            }); 
            $("#fecha_ajuste").val(data.get_parte.fecha)
            let [hr, mn] = data.get_parte.horas.split(':');
            $("#horas_ajuste").val(hr);
            $("#minutos_ajuste").val(mn);
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();
        }
    });
}