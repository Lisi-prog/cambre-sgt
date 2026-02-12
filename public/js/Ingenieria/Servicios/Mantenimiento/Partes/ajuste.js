var tabla_ajustes

$(document).ready(function () {
    tabla_ajustes = $('#tabla_ajustes').DataTable({
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
            data[0].get_tareas_mantenimiento.forEach(tarea => {
                tabla_ajustes.row.add([
                    tarea.get_tarea_mantenimiento.nombre_tarea,
                    tarea.get_accion_para_tarea.nombre_accion,
                    `<select class="form-select" required name="tareas[${j}][zona]">
                        <option value="">Seleccionar...</option>
                        ${$("#zona_select_div").html()}
                    </select><input hidden name="tareas[${j}][accion]" value="${tarea.get_accion_para_tarea.id_accion_tarea}">`,                    
                    `<select class="form-select" required name="tareas[${j}][maquina]">
                        <option value="">Seleccionar...</option>
                        ${$("#maquina_select_div").html()}
                    </select>`,
                    `<input class="form-check-input" type="checkbox"
                    checked name="tareas[${j}][hecho]"
                    value="${tarea.id_tarea_mantenimiento}">`
                ]);
                j++;
            });
            tabla_ajustes.draw();
            tabla_ajustes.columns.adjust();
        }
    });
}

function agregarNuevoAjusteRow(){

}

function openModalConfirmarParteAjuste(id_orden){
    $('#modalNuevoParteAjuste').modal('show');
    $("#id_orden_ajuste").val(id_orden);
    $("#btnGuardarNuevoParteAjuste").hide()
    $("#previewAceptarAjusteReview").show()
    $("#btnRowNuevoAjuste").hide()
    $("#horas_ajuste").attr('disabled', 'disabled')
    $("#fecha_ajuste").attr('disabled', 'disabled')
    $("#herramental_ajuste").val($("#activo").val());
    tabla_ajustes.clear();
     $.ajax({
        type: 'GET',
        url: '/get-parte-ajuste/' + id_orden,
        success: function(data) {
            let j=0;
            data.get_tareas_ajuste.forEach(tarea => {
                tabla_ajustes.row.add([
                    j,
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