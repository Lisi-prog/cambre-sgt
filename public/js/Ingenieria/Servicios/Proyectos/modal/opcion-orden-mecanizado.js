export default 
`<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"> 
        <div class="form-group"> 
            <label for="nom_orden" class="control-label" style="white-space: nowrap; ">ID-PIEZA:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control reset-input" name="nom_orden" type="text" id="nom_orden" required> 
        </div> 
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="supervisor" class="control-label fs-7" style="white-space: nowrap;">Supervisor:</label> 
            <span class="obligatorio">*</span> 
            <select class="form-select form-group reset-input" id="cbx_supervisor" name="supervisor" required>
                <option selected="selected" value="">Seleccionar</option>
            </select>
        </div>
    </div>
</div> 
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
        <div class="form-group">
            <div class="form-group"> 
                <label for="revision" class="control-label fs-7" style="white-space: nowrap;">Revision:</label> 
                <span class="obligatorio">*</span> 
                <input class="form-control reset-input" name="revision" type="text" id="revision" required> 
            </div> 
        </div> 
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
        <div class="form-group">
            <div class="form-group"> 
                <label for="cantidad" class="control-label fs-7" style="white-space: nowrap;">Cantidad:</label> 
                <span class="obligatorio">*</span> 
                <input class="form-control reset-input" name="cantidad" type="number" id="cantidad" required> 
            </div> 
        </div> 
    </div> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
        <div class="form-group">
            <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
            <span class="obligatorio">*</span>
            <input min="2023-01-01" max="2023-12" id="fec_ini" class="form-control reset-fecha" name="fecha_ini" type="date" value="2023-12-12" required>
        </div>
    </div> 
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        <div class="form-group"> 
            <label for="estado" class="control-label fs-7" style="white-space: nowrap;">Estado mecanizado:</label> 
            <span class="obligatorio">*</span> 
            <select class="form-select form-group reset-input" id="cbx_estado_mec" name="estado_mecanizado" required>
                <option selected="selected" value="">Seleccionar</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
            <span class="obligatorio">*</span>
            <input min="2023-01-01" max="2023-12" id="fec_req" class="form-control reset-fecha" name="fecha_req" type="date" value="2023-12-12" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group"> 
            <label for="estado" class="control-label fs-7" style="white-space: nowrap;">Ruta de plano:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control reset-input" name="ruta_plano" type="text" id="ruta_plano" required> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label for="observaciones" class="control-label" style="white-space: nowrap; ">Observaciones:</label> 
            <textarea id='observaciones' class="form-control reset-input" rows="54" cols="54" name="observaciones" style="resize:none; height: 20vh"></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <div class="form-group">
            <label for="ord-tra-asoc" class="control-label" style="white-space: nowrap; ">Orden de Trabajo COMPAR:</label> 
            <select class="form-control form-select" id="ord-tra-asoc" name="ord-tra-asoc" placeholder="Seleccionar.." autocomplete="off">
                
            </select>
        </div>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <div class="form-group">
            <label for="ord-mec-asoc" class="control-label" style="white-space: nowrap; ">Orden de Mecanizado Asociado:</label>
            <select class="form-control form-select" id="ord-mec-asoc" name="ord-mec-asoc" placeholder="Seleccionar.." autocomplete="off">
                
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <label class="control-label" style="white-space: nowrap; ">Adicional:</label> 
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="esRetrabajo" name="esRetrabajo">
                <label class="form-check-label" for="esRetrabajo">
                    Es un retrabajo.
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="esModificacion" name="esModificacion">
                <label class="form-check-label" for="esModificacion">
                    Es una modificacion.
                </label>
            </div>
        </div>
    </div>
</div>`;