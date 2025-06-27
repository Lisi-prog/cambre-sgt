$(document).ready(function() {
    // $('#crearHdr').on('hidden.bs.modal', function (e) {
    //     document.getElementById('table-body').innerHTML = '';
    // });

    // $('#m-proy-ant').on('change', cargarOrdenesMec);

    // $('#m-ord-ant').on('change', cargarHdr);

    document.getElementById('addRow').addEventListener('click', (e) => {
        e.preventDefault();
        addRow();
    })
});

function addRow() {
    console.log('addrow');
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
            console.log(response)
            let options = '';
            let opt_tec = '';

            response.forEach( element => {
                options += `<option value="${element.id_orden}">${element.orden}</option>`
            });

            row.innerHTML = `
                <td class="text-center">${rowCount}</td>
                <td>
                    <select class="form-select" id="id_ord" required="" name="orden">
                        <option selected="selected" value="">Seleccionar</option>
                        ${options}
                    </select>
                </td>
                <td>
                    -
                </td>
                <td>
                    -
                </td>
                <td>
                    -
                </td>
                <td>
                    <input class="form-control" name="horas" type="text" readonly>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger delete-btn"><i class="fas fa-trash"></i></button>
                </td>
            `;

            /*
            response.forEach( element => {
                options += `<div class="custom-option-1" data-value="${element.orden}">${element.orden}</div>`;
            });

            row.innerHTML = `
                <td class="text-center">${rowCount}</td>
                <td>
                    <div class="dropdown-container my-auto">
                        <input type="text" class="styled-input form-select custom-input-1 input-ope" placeholder="Seleccionar" autocomplete="off" name="operacion[]" required>
                        <div class="dropdown-list-auto">
                            ${options}
                        </div>
                    </div>
                </td>
                <td>
                    -
                </td>
                <td>
                    -
                </td>
                <td>
                    -
                </td>
                <td>
                    -
                </td>
                <td class="text-center">
                    <button class="btn btn-danger delete-btn">Eliminar</button>
                </td>
            `;

            row.querySelectorAll(".dropdown-container").forEach(dropdown => {
                const customDropdown = new CustomDropdown(dropdown); // Guardamos la instancia
            }); */

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
    /*
    

    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtenerope', 
        data: {
            id: 'hola',
        },
        success: function (response) {
            let options = '';
            let opt_tec = '';
            response.operaciones.forEach((ope) => {
                options += `<div class="custom-option-1" data-value="${ope.nombre_operacion}">${ope.nombre_operacion}</div>`;
            });

            response.tecnicos.forEach((tec) => {
                opt_tec += `<div data-value="${tec.nombre_empleado}">${tec.nombre_empleado}</div>`;
            });

            // const row = document.createElement("tr");
            row.innerHTML = `
                <td class="text-center">${rowCount}</td>
                <td>
                    <div class="dropdown-container my-auto">
                        <input type="text" class="styled-input form-select custom-input-1 input-ope" placeholder="Seleccionar" autocomplete="off" name="operacion[]" required>
                        <div class="dropdown-list-auto">
                            ${options}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="dropdown-container my-auto">
                        <input type="text" class="styled-input form-select input-asig" placeholder="Seleccionar" autocomplete="off" name="tecnico[]">
                        <div class="dropdown-list-auto">
                            ${opt_tec}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="dropdown-container my-auto">
                        <input type="text" class="styled-input form-select input-maquina" placeholder="Seleccionar" autocomplete="off" name="maq[]" required>
                        <div class="dropdown-list-auto">
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger delete-btn">Eliminar</button>
                </td>
            `;

            // Aplicar el dropdown a la nueva fila
            row.querySelectorAll(".dropdown-container").forEach(dropdown => {
                const customDropdown = new CustomDropdown(dropdown); // Guardamos la instancia

                // Detectar cuando se selecciona una opción
                customDropdown.container.addEventListener("optionSelected", (e) => {
                    const option = e.detail.selectedOption;

                    if (option.classList.contains("custom-option-1")) {
                        const rowElement = customDropdown.container.closest("tr"); // Obtener la fila actual
                        const thirdInput = rowElement.querySelectorAll(".dropdown-container .styled-input")[2]; // Tercer input
                        thirdInput.value = '';
                        if (thirdInput) {
                            cargarMaquinas(customDropdown.input.value, thirdInput);
                        }
                    }
                });

                // Detectar cuando el valor cambia manualmente (al escribir y presionar Enter o perder foco)
                customDropdown.input.addEventListener("change", () => {
                    if (customDropdown.input.classList.contains("custom-input-1")) {
                        const rowElement = dropdown.closest("tr"); // Obtener la fila actual
                        const thirdInput = rowElement.querySelectorAll(".dropdown-container .styled-input")[2]; // Tercer input

                        if (thirdInput) {
                            cargarMaquinas(customDropdown.input.value, thirdInput);
                        }
                    }
                });
            });

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
    return row; */
}