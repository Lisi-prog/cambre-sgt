<!-- Modal -->
<div class="modal fade" id="crearHdr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Hoja de Ruta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::model($orden, ['method' => 'PUT', 'route' => ['hdr.crear', $orden->getOrdenDe->id_orden_mecanizado], 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('hdr_ant', 'HDR anteriores:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::select('hdr_ant', [], null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'hdr_ant'
                                        ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('m_id_pieza', 'ID PIEZA:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_id_pieza', $orden->nombre_orden, [
                                'class' => 'form-control reset-input',
                                'readonly',
                                'id' => 'm_id_pieza'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('m_confec', 'Confeccionó:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {{-- <span class="obligatorio">*</span> --}}
                            {!! Form::text('m_confec',  $orden->getSupervisor(), [
                                'class' => 'form-control reset-input',
                                'readonly',
                                'id' => 'm_confec'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <div class="form-group">
                            {!! Form::label('m_ubi', 'Ubicación/es:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_ubi', null, [
                                'class' => 'form-control reset-input',
                                'required',
                                'id' => 'm_ubi'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('m_cant', 'Cantidad:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('m_cant', null, [
                                'class' => 'form-control reset-input',
                                'required',
                                'id' => 'm_cant'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('m_fec_carga', 'Fecha:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::date('m_fec_carga', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'm_fec_carga',
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('ope', 'Operaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <table class="table table-striped mt-2" id="editableTable">
                                <thead>
                                  <tr>
                                    <th class='text-center' style="color:#fff;">N°</th>
                                    <th class='text-center' style="color:#fff;">Operación</th>
                                    <th class='text-center' style="color:#fff;">Asignado</th>
                                    <th class='text-center' style="color:#fff;">Máquina</th>
                                    <th class='text-center' style="color:#fff;">Acciones</th>
                                  </tr>
                                </thead>
                                <tbody id="table-body">
                                </tbody>
                            </table>
                              
                              <!-- Botón para agregar filas -->
                              <button id="addRow" class="btn btn-primary mt-3">Agregar Fila</button>                        
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('observaciones', 'Observaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <textarea name='observaciones' id="observaciones0" class="form-control reset-input" maxlength="500" rows="54" cols="54" style="resize:none; height: 20vh"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                        <div class="form-group">
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('archivo', 'Adjuntar Archivo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::file('archivo', array('class' => 'form-control', 'type' => 'file', 'id' => "inputGroupFile03", 'aria-describedby' => 'inputGroupFileAddon03', 'aria-label' => 'Upload', 'required')) !!}
                            {{-- <input type="file" class="form-control" name="archivo" required> --}}
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('m_ruta', 'Ruta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('m_ruta', null, [
                                'class' => 'form-control reset-input',
                                'id' => 'm_ruta'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    // document.getElementById("addRow").addEventListener("click", addRow(e));
    document.getElementById('addRow').addEventListener('click', (e) => {
        e.preventDefault();
        addRow();
    })

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
                            <input type="text" class="styled-input form-select custom-input-1" placeholder="Seleccionar" autocomplete="off" name="operacion[]" required>
                            <div class="dropdown-list-auto">
                                ${options}
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown-container my-auto">
                            <input type="text" class="styled-input form-select" placeholder="Seleccionar" autocomplete="off" name="tecnico[]">
                            <div class="dropdown-list-auto">
                                ${opt_tec}
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown-container my-auto">
                            <input type="text" class="styled-input form-select" placeholder="Seleccionar" autocomplete="off" name="maq[]" required>
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
                    customDropdown.options.forEach(option => {
                        option.addEventListener("click", () => {
                            if (option.classList.contains("custom-option-1")) {
                                const rowElement = dropdown.closest("tr"); // Obtener la fila actual
                                const thirdInput = rowElement.querySelectorAll(".dropdown-container .styled-input")[2]; // Tercer input
                                thirdInput.value = '';
                                if (thirdInput) {
                                    cargarMaquinas(customDropdown.input.value, thirdInput);
                                }
                            }
                        });
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

</script>