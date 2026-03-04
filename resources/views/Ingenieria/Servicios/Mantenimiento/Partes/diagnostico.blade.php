<div class="modal fade" id="nuevoParteDiagnosticoModal" tabindex="-1" aria-labelledby="nuevoParteDiagnosticoModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Parte Diagnóstico</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>            
            {!! Form::open(['route' => 'parte_diagnostico.store', 'method' => 'POST']) !!}
            <div class="modal-body">
                <div class="d-flex">
                    <div class="form-group">
                        <label>TIPO</label>
                        <input disabled class="form-control" value="DIAGNÓSTICO">
                    </div>
                    <div class="form-group ml-4">
                        <label>ACTIVO</label>
                        <input id="herramental" disabled class="form-control">
                    </div>
                </div>
                <div>
                    <div class="form-group align-content-center">                        
                        <span class="obligatorio">*</span>
                        <label class="mr-2">A RESOLVER: </label>
                        <input onchange="checkSendNuevoParteDiagnostico()" required type="radio" name="a_resolver" value="Máquina"> Máquina
                        <input onchange="checkSendNuevoParteDiagnostico()" required class="ml-2" type="radio" name="a_resolver" value="Banco"> Banco                        
                    </div>
                </div>     
                <label for="observaciones_diagonstico">OBSERVACIONES:</label>       
                <textarea name="observacion" class="form-control" id="observaciones_diagonstico" placeholder="Observaciones"></textarea>   
                <hr>
                <div class="d-flex justify-content-between align-content-center">
                    <div style="width: 80%">
                        <table class="table table-striped" id="tabla_diagnosticos">
                            <thead>
                                <th class='text-center' style="color:#fff;">Nº</th>
                                <th class='text-center' style="color:#fff; width: 30%;"><span class="obligatorio mr-1">*</span>CATEGORÍA 5M</th>
                                <th class='text-center' style="color:#fff; width: 30%;"><span class="obligatorio mr-1">*</span>DIAGNÓSTICO</th>
                                <th class='text-center' style="color:#fff;">BORRAR</th>
                            </thead>
                            <tbody id="tabla_diagnosticos_body"></tbody>
                        </table>
                        <div class="d-flex">
                    <button id="btnAgregarFilaDiagnostico" onclick="agregarDiagnostico()" class="ml-auto btn btn-success" type="button">Agregar Diagnóstico</button>
                </div>  
                    </div>                    
                    <div style="width: 15%">
                        <div class="d-flex flex-column justify-content-between">
                            <div class="form-group">
                                <span class="obligatorio">*</span>
                                <label>HORAS</label>
                                <input onchange="checkSendNuevoParteDiagnostico()" id="horas" name="horas" required type="time" class="form-control">
                            </div>
                            <div class="form-group">
                                <span class="obligatorio">*</span>
                                <label>FECHA</label>
                                <input onchange="checkSendNuevoParteDiagnostico()" id="fecha" name="fecha" required type="date" class="form-control">
                            </div>
                            <div class="form-group" hidden>
                                <label>LEGAJO</label>
                                <input disabled class="form-control">
                            </div>
                        </div>
                    </div>
                </div>  
                <input type="text" hidden id="id_orden" name="id_orden">                       
            </div>
            <div class="modal-footer">
                <div class="me-auto" id="label_ob_diagnostico">
                    (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                </div>
                <div class="form-group m-auto">
                    <input type="checkbox" onchange="checkSendNuevoParteDiagnostico()" id="completado_diagnostico" class="form-check-input">
                    <label for="completado">COMPLETADO</label>
                </div>
                <button id="btnGuardarNuevoParteDiagnostico" type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <div id="previewAceptarReview" style="width: 100%;">
                    <hr>
                    <div class="d-flex justify-content-center">
                        <button onclick="procesarDiagnostico('aceptar')" type="button" style="width: 200px;" class="btn btn-success">Aceptar Diagnóstico</button>
                        <button onclick="procesarDiagnostico('rechazar')" type="button" style="width: 200px;" class="btn btn-danger ml-2">Rechazar Diagnóstico</button>
                    </div>
                </div>
                {!! Form::close() !!}
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
