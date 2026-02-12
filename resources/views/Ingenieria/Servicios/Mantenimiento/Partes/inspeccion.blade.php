<div class="modal fade" id="modalNuevoParteInspeccion" tabindex="-1" aria-labelledby="modalNuevoParteInspeccion" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Parte Inspección</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>            
            {!! Form::open(['route' => 'parte_inspeccion.store', 'method' => 'POST', 'id' => 'form_inspeccion_alta']) !!}
            <div class="modal-body">
                <div class="d-flex">
                    <div class="form-group">
                        <label>TIPO</label>
                        <input disabled class="form-control" value="INSPECCIÓN">
                    </div>
                    <div class="form-group ml-4">
                        <label>ACTIVO</label>
                        <input id="herramental_inspeccion" disabled class="form-control">
                    </div>
                    <div class="form-group ml-4">
                        <label>HORAS</label>
                        <input id="horas_inspeccion" name="horas" required type="time" class="form-control">
                    </div>
                    <div class="form-group ml-4">
                        <label>FECHA</label>
                        <input id="fecha_inspeccion" name="fecha" required type="date" class="form-control">
                    </div>
                    <div class="form-group ml-4" hidden>
                        <label>LEGAJO</label>
                        <input disabled class="form-control">
                    </div>
                </div>
                <hr>
                <input type="hidden" name="tareasPendientes" id="tareasPendientesInput">

                <table class="table table-striped w-100" id="tabla_inspecciones">
                    <thead>
                        <th class="text-center" scope="col" style="color:#fff;"></th>
                        <th class="text-center" scope="col" style="color:#fff;"></th>
                        <th class="text-center" scope="col" style="color:#fff;"></th>
                        <th class="text-center" scope="col" style="color:#fff;"></th>
                    </thead>
                    <tbody id="tabla_inspecciones_body">

                    </tbody>
                </table>       
                <input type="text" hidden id="id_orden_inspeccion" name="id_orden">                       
            </div>
            <div class="modal-footer">
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
