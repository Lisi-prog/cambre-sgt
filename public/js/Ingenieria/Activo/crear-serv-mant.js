function cargarServMant(activo){
    // document.getElementById('').value = activo;

    $.ajax({
        type: "post",
        url: 'activo/tareas-prev-pendientes', 
        data: {
            activo: activo,
        },
        success: function (res) {
            console.log(res)
            let renglones_tareas = '';
            let cuadro_tareas = document.getElementById('tareas-prev');

            document.getElementById('activo_serv_mant').value = res.activo.codigo_activo;
            document.getElementById('codigo_serv_mant').value = res.nombre_proyecto;
            document.getElementById('nombre_serv_mant').value = res.nombre_proyecto;

            res.tareas_pend.forEach( e => {
                renglones_tareas += `<tr onclick="toggleCheck(${e.id_tarea_prev_x_activo})">
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkTareaPrend${e.id_tarea_prev_x_activo}" value="${e.id_tarea_prev_x_activo}" name="tareas_prev[]">
                                            </div>
                                        </td>
                                        <td class="text-start">${e.nombre_tarea}</td>
                                        <td class="text-start">${e.ejecucion}</td>
                                        <td class="text-center">${e.zona}</td>
                                        <td class="text-center">${e.fecha_ultima_ejecucion}</td>
                                     </tr>`
            });

            cuadro_tareas.innerHTML = renglones_tareas;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function toggleCheck(id) {
    const check = document.getElementById(`chkTareaPrend${id}`);
    check.checked = !check.checked;
}