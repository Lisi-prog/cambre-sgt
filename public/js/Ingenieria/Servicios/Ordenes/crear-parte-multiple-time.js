$(document).ready(function() {
    
    $(".carga-multiple-parte").on('submit', function(evt){
            evt.preventDefault();     
            var url_php = $(this).attr("action"); 
            var type_method = $(this).attr("method"); 
            var form_data = $(this).serialize();
            let html = '';
            // let id_orden = document.getElementById('m-ver-parte-orden').value;
            $.ajax({
                type: type_method,
                url: url_php,
                data: form_data,
                success: function(data) {
                    opcion = parseInt(data.resultado);
                    switch (opcion) {
                        case 1:
                            html = `<div class="alert alert-success alert-dismissible fade show " role="alert" id="msj-modal">
                                            Partes creado con exito.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>`;
                            document.getElementById('table-body-CPMT').innerHTML = '';
                            actOrdenes(data.ordenes);
                            break;
                        default:
                            html = `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msj-modal">
                                        Ocurrio un error
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>`;
                            console.log(data.error)
                            break;
                    }
                    $('#alert-cm').html(html);
                    setTimeout(function(){document.getElementById('msj-modal').hidden = true;},3000);

                }
            });
    });

    document.getElementById('addRow').addEventListener('click', (e) => {
        e.preventDefault();
        addRow();
    })

    /*document.querySelector('#editableTableCPMT').addEventListener('input', function (e) {
        if (e.target && e.target.matches('input[name="hora-fin[]"]')) {
            const row = e.target.closest('tr');
            const horaIniInput = row.querySelector('input[name="hora-ini[]"]');
            const horaFinInput = row.querySelector('input[name="hora-fin[]"]');
            const horasInput = row.querySelector('input[name="horas[]"]');

            const horaIni = horaIniInput.value;
            const horaFin = horaFinInput.value;

            if (horaIni && horaFin) {
                const [iniH, iniM] = horaIni.split(':').map(Number);
                const [finH, finM] = horaFin.split(':').map(Number);

                const iniDate = new Date(0, 0, 0, iniH, iniM);
                const finDate = new Date(0, 0, 0, finH, finM);

                let diff = (finDate - iniDate) / 60000; // en minutos

                if (diff < 0) {
                    diff += 24 * 60; // pasa de medianoche
                }

                const horas = Math.floor(diff / 60);
                const minutos = diff % 60;

                // Formatear a HH:MM con ceros a la izquierda
                const horasStr = horas.toString().padStart(2, '0');
                const minutosStr = minutos.toString().padStart(2, '0');

                horasInput.value = `${horasStr}:${minutosStr}`;
            } else {
                horasInput.value = '';
            }
        }
    });*/

    document.querySelector('#editableTableCPMT').addEventListener('input', function (e) {

        if (
            e.target.matches('input[name="hora_ini_horas[]"]') ||
            e.target.matches('input[name="hora_ini_minutos[]"]') ||
            e.target.matches('input[name="hora_fin_horas[]"]') ||
            e.target.matches('input[name="hora_fin_minutos[]"]')
        ) {

            const row = e.target.closest('tr');

            const iniH = parseInt(row.querySelector('input[name="hora_ini_horas[]"]').value) || 0;
            const iniM = parseInt(row.querySelector('input[name="hora_ini_minutos[]"]').value) || 0;

            const finH = parseInt(row.querySelector('input[name="hora_fin_horas[]"]').value) || 0;
            const finM = parseInt(row.querySelector('input[name="hora_fin_minutos[]"]').value) || 0;

            const duracionHoras = row.querySelector('input[name="duracion_horas[]"]');
            const duracionMinutos = row.querySelector('input[name="duracion_minutos[]"]');

            const inicio = (iniH * 60) + iniM;
            const fin = (finH * 60) + finM;

            // Solo calcular si la hora final es mayor
            if (fin > inicio) {

                const diff = fin - inicio;

                const horas = Math.floor(diff / 60);
                const minutos = diff % 60;

                duracionHoras.value = horas;
                duracionMinutos.value = minutos;

            } else {

                duracionHoras.value = '00';
                duracionMinutos.value = '00';

            }
        }
    });

    $('#verCargaMultiTime').on('hidden.bs.modal', function (e) {
        document.getElementById('table-body-CPMT').innerHTML = '';
    });

    $(document).on('input', '.horaInPM', function () {
        let valor = parseInt($(this).val()) || 0;

        if (valor > 23) {
            $(this).val(23);
        }

        if (valor < 0) {
            $(this).val(0);
        }
    });

    $(document).on('input', '.minutoInPM', function () {
        let valor = parseInt($(this).val()) || 0;

        if (valor > 59) {
            $(this).val(59);
        }

        if (valor < 0) {
            $(this).val(0);
        }
    });
});

function addRow() {
    // console.log('addrow');
    const tableBody = document.getElementById("editableTableCPMT");
    const table = document.getElementById('editableTableCPMT').getElementsByTagName('tbody')[0];
    const rowCount = table.rows.length + 1;
    const row = table.insertRow();


    $.ajax({
        type: "post",
        url: '/orden/'+1+'/carga-multiple', 
        data: {
            id: 'hola',
        },
        success: function (response) {
            // console.log(response)
            let options = '';
            let opt_tec = '';

            response.forEach( element => {
                options += `<option value="${element.id_orden}">${element.orden}</option>`
            });

            row.innerHTML = `
                <td class="text-center">${rowCount}</td>
                <td>
                    <select class="form-select" name="orden[]" required>
                        <option selected="selected" value="">Seleccionar</option>
                        ${options}
                    </select>
                </td>
                <td>
                    <textarea name='observaciones[]' class="form-control" rows="10" cols="10" style="resize:none; width: 100%; height: 10vh"></textarea>
                </td>
                <td class="p-2">
                    <div class="input-group">
                        <input class="form-control horaInPM" name="hora_ini_horas[]" type="number"
                            min="0" max="23" value="00" onclick="this.select();">
                        <span class="input-group-text p-1">:</span>
                        <input class="form-control minutoInPM" name="hora_ini_minutos[]" type="number"
                            min="0" max="59" value="00" onclick="this.select();">
                    </div>
                </td>
                <td class="p-2">
                    <div class="input-group">
                        <input class="form-control horaInPM" name="hora_fin_horas[]" type="number"
                            min="0" max="23" value="00" onclick="this.select();">
                        <span class="input-group-text p-1">:</span>
                        <input class="form-control minutoInPM" name="hora_fin_minutos[]" type="number"
                            min="0" max="59" value="00" onclick="this.select();">
                    </div>
                </td>
                <td class="p-2">
                    <div class="input-group">
                        <input class="form-control horaInPM" name="duracion_horas[]" type="number"
                            min="0" value="00" onclick="this.select();" required>
                        <span class="input-group-text p-1">:</span>
                        <input class="form-control minutoInPM" name="duracion_minutos[]" type="number"
                            min="0" max="59" value="00" onclick="this.select();" required>
                    </div>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger delete-btn"><i class="fas fa-trash"></i></button>
                </td>
            `;

            // Agregar evento para eliminar fila
            row.querySelector(".delete-btn").addEventListener("click", () => {
                row.remove();

                // Reordenar los números de la primera celda de cada fila
                Array.from(table.rows).forEach((row, index) => {
                     row.cells[0].innerText = index + 1;
                });
            });
            
        },
        error: function (error) {
            console.log(error);
        }
    });

    return row;
}

function actOrdenes(ids){

        $.ajax({
            type: "post",
            url: '/orden/obtener-info-orden-mul',
            data: {
                id: ids,
            },
            success: function (response) {
                console.log(response)
                response.forEach(e => {
                    let fila = $('#example tbody tr[data-id="' + e.id_orden + '"]');
                    let rowIndex = table.row(fila).index();

                    table.cell(rowIndex, 9).data(e.total_horas ?? 'S/P').draw();

                });
            },
            error: function (error) {
                console.log(error);
            }
        });
}
