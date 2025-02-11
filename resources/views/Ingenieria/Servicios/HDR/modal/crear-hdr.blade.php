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
                                <tbody>
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
    document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('editableTable').getElementsByTagName('tbody')[0];
    
    // Agregar una nueva fila
    document.getElementById('addRow').addEventListener('click', (e) => {
    e.preventDefault();
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
                options += `<option value="${ope.id_operacion}">${ope.nombre_operacion}</option>`;
            });

            response.tecnicos.forEach((tec) => {
                opt_tec += `<option value="${tec.id_empleado}">${tec.nombre_empleado}</option>`;
            });

            row.innerHTML = `
                <td contenteditable="false" class="text-center">${rowCount}</td>
                <td contenteditable="true">
                    <select class="form-control m-0 opt-ope" style="" name="operacion[]" required>
                        <option value="">Seleccionar</option>
                        ${options}
                    </select>
                </td>
                <td contenteditable="true">
                    <select class="form-control" name="tecnico[]">
                        <option value="">Seleccionar</option>
                        ${opt_tec}
                    </select>
                </td>
                <td contenteditable="true">
                    <select class="form-control opt-maq" id="opt_maq" name="maq[]" required>
                        <option value="">Seleccionar</option>
                    </select>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm deleteRow">Eliminar</button>
                </td>
            `;

            // Obtener el combobox del primer select (operaciones)
            const optOpe = row.querySelector('.opt-ope');
            const optMaq = row.querySelector('.opt-maq');

            // Agregar evento de cambio al primer select
            optOpe.addEventListener('change', function () {
                const selectedOperation = this.value;

                // Hacer una nueva solicitud AJAX para obtener las máquinas basadas en la operación seleccionada
                $.ajax({
                    type: "post",
                    url: '/orden/mec/hdr/obtenermaq', // Ruta para obtener las máquinas
                    data: { id_operacion: selectedOperation },
                    success: function (response) {
                        console.log(response)
                        // Limpiar las opciones actuales
                        optMaq.innerHTML = `<option value="">Seleccionar</option>`;
                        
                        // Agregar las nuevas opciones al combobox
                        response.forEach((maq) => {
                            optMaq.innerHTML += `<option value="${maq.id_maquinaria}">${maq.codigo_maquinaria}</option>`;
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
});


    // Eliminar una fila
    table.addEventListener('click', (e) => {
        if (e.target.classList.contains('deleteRow')) {
            const row = e.target.closest('tr');
            row.remove();

            // Reordenar los números
            Array.from(table.rows).forEach((row, index) => {
                row.cells[0].innerText = index + 1;
            });
        }
    });

    // Guardar datos (Enviar al servidor)
    /* document.getElementById('saveData').addEventListener('click', () => {
        const rows = Array.from(table.rows).map(row => {
            return {
                numero: row.cells[0].innerText,
                operacion: row.cells[1].innerText,
                asignado: row.cells[2].innerText,
                maquina: row.cells[3].innerText,
                medidas: row.cells[4].innerText,
            };
        });

        // Enviar datos al servidor
        fetch('/save-operations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ operations: rows }),
        })
        .then(response => response.json())
        .then(data => {
            alert('Datos guardados exitosamente.');
        })
        .catch(error => console.error('Error:', error));
    }); */
});

</script>