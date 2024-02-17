export default 
`<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"> 
        <div class="form-group"> 
            <label for="nom_orden_edit" class="control-label" style="white-space: nowrap; ">Nombre orden de mecanizado:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control" name="nom_orden_edit" type="text" id="nom_orden_edit" required> 
        </div> 
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="supervisor_edit" class="control-label fs-7" style="white-space: nowrap;">Supervisor:</label> 
            <span class="obligatorio">*</span> 
            <select class="form-select form-group" id="cbx_supervisor_edit" name="supervisor_edit" required>
                <option selected="selected" value="">Seleccionar</option>
            </select>
        </div>
    </div>
</div> 
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
        <div class="form-group">
            <div class="form-group"> 
                <label for="revision_edit" class="control-label fs-7" style="white-space: nowrap;">Revision:</label> 
                <span class="obligatorio">*</span> 
                <input class="form-control" name="revision_edit" type="text" id="revision_edit" required> 
            </div> 
        </div> 
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
        <div class="form-group">
            <div class="form-group"> 
                <label for="cantidad_edit" class="control-label fs-7" style="white-space: nowrap;">Cantidad:</label> 
                <span class="obligatorio">*</span> 
                <input class="form-control" name="cantidad_edit" type="number" id="cantidad_edit" required> 
            </div> 
        </div> 
    </div> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
        <div class="form-group"> 
            <label for="duracion_estimada" class="control-label" style="white-space: nowrap; ">Duracion estimada:</label> 
            <span class="obligatorio">*</span> 
            <div class= "input-group">
                <input class="form-control" name="horas_estimadas_edit" type="number" min="0" value="00" id="horas_estimadas_edit" required>
                <span class="input-group-text">:</span>
                <input class="form-control" name="minutos_estimados_edit" type="number" min="0" max="59" value="00" id="minutos_estimados_edit" required>
            </div>
        </div>
    </div> 
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        <div class="form-group"> 
            <div class="form-group"> 
                <label for="responsable_edit" class="control-label fs-7" style="white-space: nowrap;">Responsable:</label> 
                <span class="obligatorio">*</span> 
                <select class="form-select form-group" id="cbx_responsable_edit" name="responsable_edit" required>
                    <option selected="selected" value="">Seleccionar</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="fecha_ini_edit" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
            <span class="obligatorio">*</span>
            <input min="2023-01-01" max="2023-12" id="fec_ini_edit" class="form-control" name="fecha_ini_edit" type="date" value="2023-12-12" required>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        <div class="form-group"> 
            <label for="estado_mecanizado_edit" class="control-label fs-7" style="white-space: nowrap;">Estado mecanizado:</label> 
            <span class="obligatorio">*</span> 
            <select class="form-select form-group" id="cbx_estado_mec_edit" name="estado_mecanizado_edit" required>
                <option selected="selected" value="">Seleccionar</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="fecha_req_edit" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
            <span class="obligatorio">*</span>
            <input min="2023-01-01" max="2023-12" id="fec_req_edit" class="form-control" name="fecha_req_edit" type="date" value="2023-12-12" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group"> 
            <label for="ruta_plano_edit" class="control-label fs-7" style="white-space: nowrap;">Ruta de plano:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control" name="ruta_plano_edit" type="text" id="ruta_plano_edit" required> 
        </div>
    </div>
</div>
<div class="row">
    <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label for="observaciones_edit" class="control-label" style="white-space: nowrap; ">Observaciones:</label> 
            <textarea id='observaciones_edit' class="form-control" rows="54" cols="54" name="observaciones_edit" style="resize:none; height: 20vh" required></textarea>
        </div>
    </div> -->
</div>`;
    
    
    