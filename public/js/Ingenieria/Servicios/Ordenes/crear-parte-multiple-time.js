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

    document.querySelector('#editableTableCPMT').addEventListener('input', function (e) {
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
    });

    $('#verCargaMultiTime').on('hidden.bs.modal', function (e) {
        document.getElementById('table-body-CPMT').innerHTML = '';
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
                    <textarea name='observaciones[]' class="form-control" rows="10" cols="10" style="resize:none; width: 40vh; height: 15vh"></textarea>
                </td>
                <td>
                    <input type="time" name="hora-ini[]" class="form-control" value="">
                </td>
                <td>
                    <input type="time" name="hora-fin[]" class="form-control" value="">
                </td>
                <td>
                    <input class="form-control" name="horas[]" type="time" value="00:00" required>
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
