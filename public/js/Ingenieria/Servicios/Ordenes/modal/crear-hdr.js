$(document).ready(function() {
    $('#crearHdr').on('hidden.bs.modal', function (e) {
        document.getElementById('table-body').innerHTML = '';
    });

    $('#verHdr').on('hidden.bs.modal', function (e) {
        document.getElementById('obser-fallo').hidden = true;
    });

    $('#m-proy-ant').on('change', cargarOrdenesMec);

    $('#m-ord-ant').on('change', cargarHdr);

    document.getElementById('addRow').addEventListener('click', (e) => {
        e.preventDefault();
        addRow();
    })

    document.getElementById('re_addRow').addEventListener('click', (e) => {
        e.preventDefault();
        addRowRe();
    })

    document.getElementById('edi_addRow').addEventListener('click', (e) => {
        e.preventDefault();
        addRowEdi();
    })
});

function addRow() {
    return new Promise((resolve, reject) => {
    const tableBody = document.getElementById("editableTable");
    const table = document.getElementById('editableTable').getElementsByTagName('tbody')[0];
    // const rowCount = tableBody.rows.length;
    const rowCount = table.rows.length + 1;
    const row = table.insertRow();

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
                        </div>
                    </div>
                </td>
                <td>
                    <div class="dropdown-container my-auto">
                        <input type="text" class="styled-input form-select input-maquina" placeholder="Seleccionar" autocomplete="off" name="maq[]">
                        <div class="dropdown-list-auto">
                        </div>
                    </div>
                </td>
                <td>
                    <div class= "input-group">
                        <input class="form-control" name="horas_ope[]" type="number" min="0" value="00" id="horas_maquina" required>
                        <span class="input-group-text">:</span>
                        <input class="form-control" name="minutos_ope[]" type="number" min="0" max="59" value="00" id="minutos_maquina" required>
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

                        const secondInput = rowElement.querySelectorAll(".dropdown-container .styled-input")[1]; // Segundo input
                        secondInput.value = '';

                        if (thirdInput) {
                            cargarMaquinas(customDropdown.input.value, thirdInput);
                        }

                        if (secondInput) {
                            cargarTecnicos(customDropdown.input.value, secondInput);
                        }
                    }
                });

                // Detectar cuando el valor cambia manualmente (al escribir y presionar Enter o perder foco)
                customDropdown.input.addEventListener("change", () => {
                    if (customDropdown.input.classList.contains("custom-input-1")) {
                        const rowElement = dropdown.closest("tr"); // Obtener la fila actual
                        const thirdInput = rowElement.querySelectorAll(".dropdown-container .styled-input")[2]; // Tercer input
                        const secondInput = rowElement.querySelectorAll(".dropdown-container .styled-input")[1]; // Segundo input

                        if (thirdInput) {
                            cargarMaquinas(customDropdown.input.value, thirdInput);
                        }

                        if (secondInput) {
                            cargarTecnicos(customDropdown.input.value, secondInput);
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
            resolve(row);
        },
        error: function (error) {
            console.log(error);
            reject(error);
        }
    });
    // return row;
    });
}

function addRowRe() {
    return new Promise((resolve, reject) => {
        const table = document.getElementById('re_editableTable').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length + 1;
        const row = table.insertRow();

        $.ajax({
            type: "post",
            url: '/orden/mec/hdr/obtenerope', 
            data: { id: 'hola' },
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
                            <input type="text" class="styled-input form-select input-maquina" placeholder="Seleccionar" autocomplete="off" name="maq[]">
                            <div class="dropdown-list-auto">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class= "input-group">
                            <input class="form-control input-hora-ope" name="horas_ope[]" type="number" min="0" value="00" id="horas_maquina" required>
                            <span class="input-group-text">:</span>
                            <input class="form-control input-minutos-ope" name="minutos_ope[]" type="number" min="0" max="59" value="00" id="minutos_maquina" required>
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

                resolve(row); // ✅ devolvemos la fila lista
            },
            error: function (error) {
                console.log(error);
                reject(error);
            }
        });
    });
}

function addRowEdi() {
    return new Promise((resolve, reject) => {
        const table = document.getElementById('edi_editableTable').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length + 1;
        const row = table.insertRow();

        $.ajax({
            type: "post",
            url: '/orden/mec/hdr/obtenerope', 
            data: { id: 'hola' },
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
                            <input type="text" class="styled-input form-select input-maquina" placeholder="Seleccionar" autocomplete="off" name="maq[]">
                            <div class="dropdown-list-auto">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class= "input-group">
                            <input class="form-control input-hora-ope" name="horas_ope[]" type="number" min="0" value="00" id="horas_maquina" required>
                            <span class="input-group-text">:</span>
                            <input class="form-control input-minutos-ope" name="minutos_ope[]" type="number" min="0" max="59" value="00" id="minutos_maquina" required>
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

                resolve(row);
            },
            error: function (error) {
                console.log(error);
                reject(error);
            }
        });
    });
}

function addRowTra() {
    return new Promise((resolve, reject) => {
        const table = document.getElementById('retra_retratableTable').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length + 1;
        const row = table.insertRow();

        $.ajax({
            type: "post",
            url: '/orden/mec/hdr/obtenerope', 
            data: { id: 'hola' },
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
                            <input type="text" class="styled-input form-select input-maquina" placeholder="Seleccionar" autocomplete="off" name="maq[]">
                            <div class="dropdown-list-auto">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class= "input-group">
                            <input class="form-control input-hora-ope" name="horas_ope[]" type="number" min="0" value="00" id="horas_maquina" required>
                            <span class="input-group-text">:</span>
                            <input class="form-control input-minutos-ope" name="minutos_ope[]" type="number" min="0" max="59" value="00" id="minutos_maquina" required>
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

                resolve(row);
            },
            error: function (error) {
                console.log(error);
                reject(error);
            }
        });
    });
}

function cargarMaquinas(operacion, targetInput) {
    const selectedOperation = operacion;

    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtenermaq', // Ruta para obtener las máquinas
        data: { nom_operacion: selectedOperation },
        success: function (response) {
            // console.log(response);
            
            // Obtener la lista del dropdown correspondiente al tercer input
            const dropdownList = targetInput.nextElementSibling;
            if (dropdownList && dropdownList.classList.contains("dropdown-list-auto")) {
                dropdownList.innerHTML = ""; // Limpiar opciones

                // Agregar nuevas opciones
                response.forEach((maq) => {
                    const div = document.createElement("div");
                    div.classList.add("dropdown-item");
                    div.textContent = maq.codigo_maquinaria;
                    div.dataset.value = maq.codigo_maquinaria;
                    dropdownList.appendChild(div);
                });

                // Volver a aplicar CustomDropdown para actualizar las opciones
                new CustomDropdown(targetInput.closest(".dropdown-container"));
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarTecnicos(operacion, targetInput) {
    const selectedOperation = operacion;

    $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtenertec', // Ruta para obtener los tecnicos
        data: { nom_operacion: selectedOperation },
        success: function (response) {
            // console.log(response);
            
            // Obtener la lista del dropdown correspondiente al tercer input
            const dropdownList = targetInput.nextElementSibling;
            if (dropdownList && dropdownList.classList.contains("dropdown-list-auto")) {
                dropdownList.innerHTML = ""; // Limpiar opciones

                // Agregar nuevas opciones
                response.forEach((maq) => {
                    const div = document.createElement("div");
                    div.classList.add("dropdown-item");
                    div.textContent = maq.nombre_empleado;
                    div.dataset.value = maq.nombre_empleado;
                    dropdownList.appendChild(div);
                });

                // Volver a aplicar CustomDropdown para actualizar las opciones
                new CustomDropdown(targetInput.closest(".dropdown-container"));
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function autocompletahdr(id_hdr) {
        if (id_hdr) {
            $.ajax({
                type: "post",
                url: '/orden/mec/hdr/obtener-hdr/'+id_hdr, // Ruta para obtener las máquinas
                data: { id: id_hdr },
                success: function (response) {
                    document.getElementById('m_ubi').value = response.ubicacion;
                    document.getElementById('m_cant').value = response.cantidad;
                    document.getElementById('m_ruta').value = response.ruta;
                    document.getElementById('m-obser').value = response.observaciones;
                    document.getElementById('table-body').innerHTML = '';
                    response.operaciones.forEach(function (op){
                        const nuevaFila = addRow();

                        // Esperar un breve momento para que la fila se agregue
                        setTimeout(() => {
                            nuevaFila.querySelector(".input-ope").value = op.operacion;
                            nuevaFila.querySelector(".input-asig").value = op.asignado;
                            nuevaFila.querySelector(".input-maquina").value = op.maquina == '-' ? null : op.maquina;
                        }, 100);
                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }else{
            document.getElementById('m_ubi').value = '';
            document.getElementById('m_cant').value = '';
            document.getElementById('m_ruta').value = '';
            document.getElementById('m-obser').value = '';
            document.getElementById('table-body').innerHTML = '';
        }
}

function mostrarFiltro(){
    let cuadro_filtro = document.getElementById("demo");
    if ($('#demo').is(":hidden")) {
        cuadro_filtro.hidden = false;
    }else{
        cuadro_filtro.hidden = true;
    }
}



function cargarOrdenesMec() {
    document.getElementById('m-ord-ant').innerHTML = '';
    document.getElementById('m-hdr-ant').innerHTML = '';
    let html_hdr = `<option value=''>Seleccionar</option>`;

    if (this.value) {
        $.ajax({
        type: "post",
        url: '/orden/mec/hdr/obtener-orden-mec/'+this.value, 
        data: {
            id: this.value,
        },
        success: function (response) {
            
            response.forEach(element => {
                html_hdr += `
                                     <option value="`+element.id_orden_mecanizado+`">`+element.nombre_orden+`</option> 
                                     `
            });
            document.getElementById('m-ord-ant').innerHTML += html_hdr;
        },
        error: function (error) {
            console.log(error);
        }
    });
    }
    
}

function cargarHdr() {

    document.getElementById('m-hdr-ant').innerHTML = '';

    let html_hdr = `<option value=''>Seleccionar</option>`;

    if (this.value) {
        $.ajax({
            type: "post",
            url: '/orden/mec/hdr/obtener-hdr-ant/'+this.value, 
            data: {
                id: this.value,
            },
            success: function (response) {
                response.forEach(element => {
                                    html_hdr += `
                                        <option value="`+element.id_hoja_de_ruta+`">Cod: `+element.id_hoja_de_ruta+` Fecha: `+element.fecha_carga
                                        +`</option> 
                                        `;
                });
                
                document.getElementById('m-hdr-ant').innerHTML += html_hdr;
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

}