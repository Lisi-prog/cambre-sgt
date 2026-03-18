<div class="modal fade" id="modalNuevoParteAjuste" tabindex="-1" aria-labelledby="modalNuevoParteAjuste" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex w-100">
                    <div>
                        <h1 class="modal-title fs-5">Parte Ajuste</h1>
                    </div>
                    <div class="ml-auto d-flex me-4">
                        <div class="form-group mb-0 p-0 d-flex align-items-center">
                            <label for="diagnostico_label" class="my-auto">Tipo: <strong>Ajuste</strong></label>
                            <input id="ajuste_label" disabled class="form-control" value="AJUSTE" hidden>
                        </div>
                        <div class="form-group mb-0 p-0 ml-4 d-flex align-items-center">
                            <label for="herramental" class="my-auto">Activo: <strong></strong></label>
                            <input id="herramental_ajuste" disabled class="form-control" hidden>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>            
            {!! Form::open(['route' => 'parte_ajuste.store', 'method' => 'POST', 'id' => 'form_ajuste_alta']) !!}
            <div class="modal-body">                
                <hr>
                <table class="table table-striped w-100" id="tabla_ajustes">
                    <thead>
                        <th class="text-center" scope="col" style="color:#fff;">TAREA</th>
                        <th class="text-center" scope="col" style="color:#fff;">ACCIÓN</th>
                        <th class="text-center" scope="col" style="color:#fff;">ZONA</th>
                        <th class="text-center" scope="col" style="color:#fff;">MÁQUINA</th>
                        <th class="text-center" scope="col" style="color:#fff;">HECHO</th>
                    </thead>
                    <tbody id="tabla_ajustes_body">

                    </tbody>
                </table>       
                <div class="d-flex">
                    <button id="btnRowNuevoAjuste" onclick="agregarNuevoAjusteRow()" type="button" class="btn btn-success ml-auto">Agregar Ajuste</button>
                </div>
                <input type="text" hidden name="nombre_proyecto" id="nombre_proyecto_ajuste">
                <input type="text" hidden id="id_orden_ajuste" name="id_orden">         
                <div class="d-flex mt-4">
                    <div class="form-group ml-auto mb-0 pb-0">
                        <label>Horas:</label>
                        <input id="horas_ajuste" name="horas" style="width: 170px;" required type="time" class="form-control">
                    </div>
                    <div class="form-group ml-4 mb-0 pb-0">
                        <label>Fecha:</label>
                        <input id="fecha_ajuste" name="fecha" style="width: 170px;" required type="date" class="form-control">
                    </div>
                </div>              
            </div>
            <div class="modal-footer">
                <div class="form-group ml-auto mr-2 align-items-bottom mb-0 mr-4">
                    <input type="checkbox" name="completado" id="completado_ajuste" class="form-check-input">
                    <label for="completado_ajuste">COMPLETADO</label>
                </div>
                <button id="btnGuardarNuevoParteAjuste" type="submit" class="btn btn-success">Guardar</button>
                <div id="previewAceptarAjusteReview" style="width: 90%;">
                    <div class="d-flex justify-content-center">
                        <button onclick="procesarAjuste('aceptar')" type="button" style="width: 200px;" class="btn btn-success">Aceptar Ajuste</button>
                        <button onclick="procesarAjuste('rechazar')" type="button" style="width: 200px;" class="btn btn-danger ml-2">Rechazar Ajuste</button>
                    </div>
                </div>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            <input type="text" hidden id="bandera_refabricar">
            {!! Form::close() !!}
        </div>
    </div>
</div>
