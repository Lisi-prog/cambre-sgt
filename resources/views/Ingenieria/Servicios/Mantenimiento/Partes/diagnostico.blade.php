<div class="modal fade" id="nuevoParteDiagnosticoModal" tabindex="-1" aria-labelledby="nuevoParteDiagnosticoModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex w-100 align-items-center">
                    <div>
                        <h1 class="modal-title fs-5">Parte Diagnóstico</h1>
                    </div>
                    <div class="ml-auto d-flex me-4">
                        <div class="form-group mb-0 p-0 d-flex align-items-center">
                            <label for="diagnostico_label" class="my-auto">Tipo: <strong>Diagnostico</strong></label>
                            <input id="diagnostico_label" disabled class="form-control" value="DIAGNÓSTICO" hidden>
                        </div>
                        <div class="form-group mb-0 p-0 ml-4 d-flex align-items-center">
                            <label for="herramental" class="my-auto">Activo: <strong></strong></label>
                            <input id="herramental" disabled class="form-control" hidden>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                
            </div>            
            {!! Form::open(['route' => 'parte_diagnostico.store', 'method' => 'POST']) !!}
            <div class="modal-body">
                <div class="d-flex">
                    <hr>
                    <div style="width: 15%;" class="form-group align-content-center d-flex flex-column">    
                        <hr>          
                        <div class="form-group mb-0">
                            <span class="obligatorio">*</span>
                            <label class="mr-2 form-label">A resolver: </label>
                        </div>          
                        <div>
                            <input onchange="checkSendNuevoParteDiagnostico()" id="Máquina" required class="ml-4"type="radio" name="a_resolver" value="Máquina"> <label for="Máquina"> Máquina</label>
                        </div>
                        <div>
                            <input onchange="checkSendNuevoParteDiagnostico()" id="Banco" required class="ml-4" type="radio" name="a_resolver" value="Banco"> <label for="Banco"> Banco</label>                       
                        </div>
                    </div>
                    <div style="width: 85%;" class="form-group">
                        <hr>
                        <label class="mr-2 form-label">Diagnosticos: </label>
                        <table class="table table-striped" id="tabla_diagnosticos" style="width: 100%;">
                            <thead>
                                <th class='text-center' style="color:#fff;">Nº</th>
                                <th class='text-center' style="color:#fff; width: 30%;"><span class="obligatorio mr-1">*</span>CATEGORÍA 5M</th>
                                <th class='text-center' style="color:#fff; width: 30%;"><span class="obligatorio mr-1">*</span>DIAGNÓSTICO</th>
                                <th class='text-center' style="color:#fff;">BORRAR</th>
                            </thead>
                            <tbody id="tabla_diagnosticos_body"></tbody>
                        </table>
                        <div class="d-flex w-100">
                            <button id="btnAgregarFilaDiagnostico" onclick="agregarDiagnostico()" class="ml-auto btn btn-success" type="button">Agregar Diagnóstico</button>
                        </div>
                    </div>
                </div>     
                <div class="d-flex">
                    <div style="width: 50%;" class="form-group">
                        <label for="observaciones_diagonstico">Observaciones:</label>       
                        <textarea style="resize:none; height: 10vh;" name="observacion" class="form-control" id="observaciones_diagonstico" placeholder="Observaciones"></textarea>   
                    </div>
                    <div style="width: 50%;" class="d-flex">
                        <div class="form-group ml-auto">
                            <span class="obligatorio">*</span>
                            <label>Horas:</label>
                            <input onchange="checkSendNuevoParteDiagnostico()" style="width: 170px;" id="horas" name="horas" required type="time" class="form-control">
                        </div>
                        <div class="form-group ml-2">
                            <span class="obligatorio">*</span>
                            <label>Fecha:</label>
                            <input onchange="checkSendNuevoParteDiagnostico()" style="width: 170px;" id="fecha" name="fecha" required type="date" class="form-control">
                        </div>                      
                    </div>
                </div>
                <input type="text" hidden id="id_orden" name="id_orden">                       
            </div>
            <div class="modal-footer">
                <div class="me-auto" id="label_ob_diagnostico">
                    (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                </div>
                <div class="form-group ml-auto align-items-bottom d-flex mb-0 mr-4">
                    <input type="checkbox" name="completado" onchange="checkSendNuevoParteDiagnostico()" id="completado_diagnostico" class="form-check-input mt-auto">
                    <label class="my-auto" for="completado_diagnostico">COMPLETADO</label>
                </div>
                <button id="btnGuardarNuevoParteDiagnostico" type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
