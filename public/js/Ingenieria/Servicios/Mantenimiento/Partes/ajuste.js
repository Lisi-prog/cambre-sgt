var tabla_ajustes

$(document).ready(function () {
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

function openModalNuevoParteAjuste(id_orden, id_etapa){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").show()
    $("#previewAceptarAjusteReview").hide()
    $("#herramental_ajuste").val($("#activo").val())
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
            data[0].get_tareas_mantenimiento.forEach(tarea => {
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
            });
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



function openModalConfirmarParteAjuste(id_orden){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").hide()
    $("#previewAceptarAjusteReview").show()
    $("#btnRowNuevoAjuste").hide()
    $("#horas_ajuste").attr('disabled', 'disabled')
    $("#fecha_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").attr('disabled', 'disabled')
    $("#completado_ajuste").prop('checked', true)
    $("#herramental_ajuste").val($("#activo").val());
    tabla_ajustes.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste/' + id_orden,
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
            $("#horas_ajuste").val(data.get_parte.horas)
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
            nombre_proyecto: $("#nombre_proyecto").text(),
        },
        success: function(data) {
            $('#nuevoParteAjusteModal').modal('hide');
            location.reload();
        }
    });
}

function openModalParteAjustePendiente(id_orden){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").show()
    $("#previewAceptarAjusteReview").hide()
    $("#btnRowNuevoAjuste").show()
    $("#horas_ajuste").removeAttr('disabled')
    $("#fecha_ajuste").removeAttr('disabled')
    $("#herramental_ajuste").val($("#activo").val());
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
            $("#fecha_ajuste").val(data.get_parte.fecha)
            $("#horas_ajuste").val(data.get_parte.horas)
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();
        }
    });
}