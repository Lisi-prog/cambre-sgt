<div class="modal fade" id="nuevoParteDiagnosticoModal" tabindex="-1" aria-labelledby="nuevoParteDiagnosticoModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Parte Diagnóstico</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>            
            <div class="modal-body">
                <div class="d-flex">
                    <div class="form-group">
                        <label>TIPO</label>
                        <input disabled class="form-control" value="DIAGNÓSTICO">
                    </div>
                    <div class="form-group ml-4">
                        <label>HERRAMENTAL</label>
                        <input id="herramental" disabled class="form-control">
                    </div>
                </div>
                <div>
                    <div class="form-group align-content-center">
                        <label class="mr-2">A RESOLVER: </label>
                        <input required type="radio" name="a_resolver" value="Máquina"> Máquina
                        <input required class="ml-2" type="radio" name="a_resolver" value="Banco"> Banco
                    </div>
                </div>                
                <hr>
                <div class="d-flex justify-content-between align-content-center">
                    <div style="width: 80%">
                        <table class="table table-striped" id="tabla_diagnosticos">
                            <thead>
                                <th class='text-center' style="color:#fff;">Nº</th>
                                <th class='text-center' style="color:#fff;">5M</th>
                                <th class='text-center' style="color:#fff;">DIAGNÓSTICO</th>
                                <th class='text-center' style="color:#fff;">BORRAR</th>
                            </thead>
                            <tbody id="tabla_diagnosticos_body"></tbody>
                        </table>
                        <div class="d-flex">
                    <button onclick="agregarDiagnostico()" class="ml-auto btn btn-success" type="button">Agregar Diagnóstico</button>
                </div>  
                    </div>                    
                    <div style="width: 15%">
                        <div class="d-flex flex-column justify-content-between">
                            <div class="form-group">
                                <label>HORAS</label>
                                <input required type="time" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>FECHA</label>
                                <input required type="date" class="form-control">
                            </div>
                            <div class="form-group" hidden>
                                <label>LEGAJO</label>
                                <input disabled class="form-control">
                            </div>
                        </div>
                    </div>
                </div>                         
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
