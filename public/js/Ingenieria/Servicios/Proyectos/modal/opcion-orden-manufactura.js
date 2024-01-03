export default 
`<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"> 
        <div class="form-group"> 
            <label for="nom_orden" class="control-label" style="white-space: nowrap; ">Nombre orden de manufactura:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control" name="nom_orden" type="text" id="nom_orden" required> 
        </div> 
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="supervisor" class="control-label fs-7" style="white-space: nowrap;">Supervisor:</label> 
            <span class="obligatorio">*</span> 
            <select class="form-select form-group" id="cbx_supervisor" name="supervisor" required>
                <option selected="selected" value="">Seleccionar</option>
            </select>
        </div>
    </div> 
</div> 
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"> 
        <div class="form-group">
            <div class="form-group"> 
                <label for="revision" class="control-label fs-7" style="white-space: nowrap;">Revision:</label> 
                <span class="obligatorio">*</span> 
                <input class="form-control" name="revision" type="text" id="revision" required> 
            </div> 
        </div> 
    </div>
    <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
        <div class="form-group">
            <div class="form-group"> 
                <label for="cantidad" class="control-label fs-7" style="white-space: nowrap;">Cantidad:</label> 
                <span class="obligatorio">*</span> 
                <input class="form-control" name="cantidad" type="number" id="cantidad" required> 
            </div> 
        </div> 
    </div>  -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
        <div class="form-group"> 
            <label for="duracion_estimada" class="control-label" style="white-space: nowrap; ">Duracion estimada:</label> 
            <span class="obligatorio">*</span> 
            <div class= "input-group">
                <input class="form-control" name="horas_estimadas" type="number" min="0" value="00" id="horas_estimadas" required>
                <span class="input-group-text">:</span>
                <input class="form-control" name="minutos_estimados" type="number" min="0" max="59" value="00" id="minutos_estimados" required>
            </div>
        </div>
    </div> 
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        <div class="form-group"> 
            <div class="form-group"> 
                <label for="responsable" class="control-label fs-7" style="white-space: nowrap;">Responsable:</label> 
                <span class="obligatorio">*</span> 
                <select class="form-select form-group" id="cbx_responsable" name="responsable" required>
                    <option selected="selected" value="">Seleccionar</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
            <span class="obligatorio">*</span>
            <input min="2023-01-01" max="2023-12" id="fec_ini" class="form-control" name="fecha_ini" type="date" value="2023-12-12" required>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        <div class="form-group"> 
            <label for="estado" class="control-label fs-7" style="white-space: nowrap;">Estado manufactura:</label> 
            <span class="obligatorio">*</span> 
            <select class="form-select form-group" id="cbx_estado_man" name="estado_manufactura" required>
                <option selected="selected" value="">Seleccionar</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
            <span class="obligatorio">*</span>
            <input min="2023-01-01" max="2023-12" id="fec_req" class="form-control" name="fecha_req" type="date" value="2023-12-12" required>
        </div>
        <div class="" hidden="">
            <input class="form-control" name="id_servicio" type="text" value="1">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group"> 
            <label for="estado" class="control-label fs-7" style="white-space: nowrap;">Ruta de plano:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control" name="ruta_plano" type="text" id="ruta_plano" required> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label for="observaciones" class="control-label" style="white-space: nowrap; ">Observaciones:</label> 
            <textarea id='observaciones' class="form-control" rows="54" cols="54" name="observaciones" style="resize:none; height: 20vh" required></textarea>
        </div>
    </div>
</div>`;
    
    
    