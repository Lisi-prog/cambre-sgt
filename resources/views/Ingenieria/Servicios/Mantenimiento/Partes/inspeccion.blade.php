<div class="modal fade" id="modalNuevoParteInspeccion" tabindex="-1" aria-labelledby="modalNuevoParteInspeccion" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex w-100 align-items-center">
                    <div>
                        <h1 class="modal-title fs-5">Parte Inspección</h1>
                    </div>
                    <div class="ml-auto d-flex me-4">
                        <div class="form-group mb-0 p-0 d-flex align-items-center">
                            <label for="diagnostico_label" class="my-auto">Tipo: <strong>Inspección</strong></label>
                            <input id="inspeccion_label" disabled class="form-control" value="INSPECCIÓN" hidden>
                        </div>
                        <div class="form-group mb-0 p-0 ml-4 d-flex align-items-center">
                            <label for="herramental" class="my-auto">Activo: <strong id="nombreActivoInspeccion"></strong></label>
                            <input id="herramental_inspeccion" disabled class="form-control" hidden>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>            
            {!! Form::open(['route' => 'parte_inspeccion.store', 'method' => 'POST', 'id' => 'form_inspeccion_alta']) !!}
            <div class="modal-body">
                                <hr>
                <input type="hidden" name="tareasPendientes" id="tareasPendientesInput">

                <table class="table table-striped w-100" id="tabla_inspecciones">
                    <thead>
                        <th class="text-center" scope="col" style="color:#fff;"></th>
                        <th class="text-center" scope="col" style="color:#fff;"></th>
                        <th class="text-center" scope="col" style="color:#fff;"></th>
                        <th class="text-center" scope="col" style="color:#fff;"></th>
                        <th class="text-center" scope="col" style="color:#fff;"></th>
                    </thead>
                    <tbody id="tabla_inspecciones_body">

                    </tbody>
                </table>       
                <input type="text" hidden id="id_orden_inspeccion" name="id_orden">        
                <div class="d-flex">                    
                    <div class="form-group ml-auto mb-0 pb-0">
                        <label>Horas:</label>
                        <input id="horas_inspeccion" style="width: 170px;" name="horas" required type="time" class="form-control">
                    </div>
                    <div class="form-group ml-4 mb-0 pb-0">
                        <label>Fecha:</label>
                        <input id="fecha_inspeccion" style="width: 170px;" name="fecha" required type="date" class="form-control">
                    </div>
                </div>
                <input type="text" hidden name="nombre_proyecto" id="nombre_proyecto_inspeccion">
            </div>
            <div class="modal-footer">
                <span id="span_aviso_mecanizado" style="display: none;" class="text-warning">Se recomienda crear una orden de mecanizado.</span>
                <div class="form-group ml-auto mb-0 mr-4">
                    <input type="checkbox" disabled id="completado_inspeccion" class="form-check-input">
                    <input hidden type="checkbox"  name="completo"  id="completado_inspeccion_value" class="form-check-input">
                    <label for="completado_inspeccion">COMPLETADO</label>
                </div> 
                <button id="btnGuardarNuevoParteInspeccion" type="submit" class="btn btn-success">Guardar</button>
                <div id="previewAceptarInspeccionReview" style="width: 90%;">
                    <div class="d-flex justify-content-center">
                        <button onclick="procesarInspeccion('aceptar')" type="button" style="width: 200px;" class="btn btn-success">Aceptar Inspección</button>
                        <button onclick="procesarInspeccion('rechazar')" type="button" style="width: 200px;" class="btn btn-danger ml-2">Rechazar Inspección</button>
                    </div>
                </div>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
