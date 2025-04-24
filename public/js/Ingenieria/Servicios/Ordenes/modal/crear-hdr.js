$(document).ready(function() {
    $('#crearHdr').on('hidden.bs.modal', function (e) {
        document.getElementById('table-body').innerHTML = '';
    });

    $('#m-proy-ant').on('change', cargarOrdenesMec);

    $('#m-ord-ant').on('change', cargarHdr);

    document.getElementById('addRow').addEventListener('click', (e) => {
        e.preventDefault();
        addRow();
    })
});

function addRow() {
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
    return row;
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

function autocompletahdr(id_hdr) {
        // console.log(id_hdr)

        if (id_hdr) {
            $.ajax({
                type: "post",
                url: '/orden/mec/hdr/obtener-hdr/'+id_hdr, // Ruta para obtener las máquinas
                data: { id: id_hdr },
                success: function (response) {
                    // console.log(response);
                    document.getElementById('m_ubi').value = response.ubicacion;
                    document.getElementById('m_cant').value = response.cantidad;
                    document.getElementById('m_ruta').value = response.ruta;
                    document.getElementById('m-obser').value = response.observaciones;
                    document.getElementById('table-body').innerHTML = '';
                    response.operaciones.forEach(function (op){
                        // console.log(op);
                        const nuevaFila = addRow();

                        // Esperar un breve momento para que la fila se agregue
                        setTimeout(() => {
                            // console.log(nuevaFila)
                            nuevaFila.querySelector(".input-ope").value = op.operacion;
                            nuevaFila.querySelector(".input-asig").value = op.asignado;
                            nuevaFila.querySelector(".input-maquina").value = op.maquina;
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

function editarParte(id){
    document.getElementById('titulo-parte').innerHTML = 'Editar parte cod: '+id;
    document.getElementById('m-ver-parte-div').className = document.getElementById('m-ver-parte-div').className.replace( /(?:^|\s)border-warning(?!\S)/g , ' border-primary');

    $.when($.ajax({
        type: "post",
        url: '/parte/obtener-una/'+id, 
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            document.getElementById('observaciones').value = response.observaciones;
            document.getElementById('m-ver-parte-estado').value = response.estado;
            document.getElementById('fecha').value = response.fecha;
            document.getElementById('m-ver-parte-fecha-limite').value = response.fecha_limite;

            [hora, minutos] = response.horas.split(':');

            document.getElementById('horas').value = hora;
            document.getElementById('minutos').value = minutos;
            document.getElementById('m-editar').value = 1;
            document.getElementById('m-id-parte').value = response.id_parte;

            if (es_super === 0) {
                document.getElementById('m-ver-parte-fecha-limite').readonly = true;
            }
        },
        error: function (error) {
            console.log(error);
        }
    }));
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