function cargarServMant(activo){
    // document.getElementById('').value = activo;
    let sePuedeSel = '';
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

            document.getElementById('id_activo_serv_mant').value = res.activo.id_activo;
            document.getElementById('activo_serv_mant').value = res.activo.codigo_activo;
            document.getElementById('codigo_serv_mant').value = res.nombre_proyecto;
            document.getElementById('nombre_serv_mant').value = res.nombre_proyecto;

            res.tareas_pend.forEach( e => {

                if (e.situacion == 'Disponible') {
                    sePuedeSel = `<div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkTareaPrend${e.tipo}_${e.id}" value="${e.tipo}_${e.id}" name="tareas_prev[]">
                                    </div>`;
                } else {
                    sePuedeSel = '-';
                }

                renglones_tareas += `<tr onclick="toggleCheck('${e.tipo}_${e.id}')">
                                        <td class="text-center">
                                            ${sePuedeSel}
                                        </td>
                                        <td class="text-start">${e.nombre_tarea}</td>
                                        <td class="text-start">${e.ejecucion}</td>
                                        <td class="text-center">${e.zona}</td>
                                        <td class="text-center">${e.fecha_ultima_ejecucion}</td>
                                        <td class="text-center">${e.situacion ?? '-'}</td>
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

    if (!check) {
        return;
    }

    check.checked = !check.checked;
}