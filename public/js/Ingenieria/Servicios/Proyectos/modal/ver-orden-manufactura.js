export default 
`<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="form-group"> 
            <label for="nom_orden" class="control-label" style="white-space: nowrap; ">ID-CONJUNTO:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control" name="nom_orden" type="text" id="input-nom_orden" readonly> 
        </div> 
    </div> 
</div> 
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
        <div class="form-group"> 
            <div class="form-group"> 
                <label for="responsable" class="control-label fs-7" style="white-space: nowrap;">Responsable:</label> 
                <span class="obligatorio">*</span> 
                <input class="form-control" name="responsable" type="text" id="input-responsable" readonly> 
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"> 
        <div class="form-group">
            <div class="form-group"> 
                <label for="revision" class="control-label fs-7" style="white-space: nowrap;">Revision:</label> 
                <span class="obligatorio">*</span> 
                <input class="form-control" name="revision" type="text" id="input-revision" readonly> 
            </div> 
        </div> 
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"> 
        <div class="form-group">
            <div class="form-group"> 
                <label for="cantidad" class="control-label fs-7" style="white-space: nowrap;">Cantidad:</label> 
                <span class="obligatorio">*</span> 
                <input class="form-control" name="cantidad" type="number" id="input-cantidad" readonly> 
            </div> 
        </div> 
    </div> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
        <div class="form-group"> 
            <label for="estado_man" class="control-label fs-7" style="white-space: nowrap;">Estado manufactura:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control" name="estado_man" type="text" id="input-estado_manufactura" readonly> 
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
            <span class="obligatorio">*</span>
            <input class="form-control" name="fec_ini" type="text" id="input-fec_inicio" readonly> 
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha limite:</label>
            <span class="obligatorio">*</span>
            <input class="form-control" name="revision" type="text" id="input-fec_req" readonly>
        </div>
        <div class="" hidden="">
            <input class="form-control" name="id_servicio" type="text" value="1">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            <label for="fec_fin" class="control-label fs-7" style="white-space: nowrap;">Fecha fin:</label>
            <span class="obligatorio">*</span>
            <input class="form-control" name="fec_fin" type="text" id="input_fecha_fin" readonly> 
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"> 
        <div class="form-group" hidden> 
            <label for="duracion_estimada" class="control-label" style="white-space: nowrap; ">Duracion estimada:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control" name="duracion_estimada" type="text" id="input-duracion_estimada" readonly> 
        </div>
    </div> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group"> 
            <label for="duracion_real" class="control-label" style="white-space: nowrap; ">Duracion real:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control" name="duracion_real" type="text" id="input-duracion_real" readonly> 
        </div>
    </div>
</div>
<div class="row">
        <div class="col-4">
            
        </div>
        <div class="col-4">
            <div class="form-group" hidden>
                <label for="costo_estimado" class="control-label" style="white-space: nowrap; ">Costo estimado:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-costo_estimado" readonly="" name="costo_estimado" type="text">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group" hidden>
                <label for="costo_real" class="control-label" style="white-space: nowrap; ">Costo real:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-costo_real" readonly="" name="costo_real" type="text">
            </div> 
        </div>
    </div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group"> 
            <label for="estado" class="control-label fs-7" style="white-space: nowrap;">Ruta de plano:</label> 
            <span class="obligatorio">*</span> 
            <input class="form-control" name="ruta_plano" type="text" id="input-ruta_plano" readonly> 
        </div>
    </div>
</div>
<div class="row">
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label for="observaciones" class="control-label" style="white-space: nowrap; ">Observaciones:</label> 
            <textarea id='input-observaciones' class="form-control" rows="54" cols="54" name="observaciones" style="resize:none; height: 20vh" readonly></textarea>
        </div>
    </div>
</div>
<div class="row">
        <label for="ultimo_parte" class="control-label" style="white-space: nowrap; ">Ultimo parte:</label>
        <div class="col-3">
            <div class="form-group">
                <label for="fecha_ultimo_parte" class="control-label" style="white-space: nowrap; ">Fecha:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-fecha_ultimo_parte" readonly="" name="fecha_ultimo_parte" type="text">
            </div> 
        </div>
        <div class="col-9">
            <div class="form-group">
                <label for="observacion" class="control-label" style="white-space: nowrap; ">Observacion:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-observacion" readonly="" name="observacion" type="text">
            </div> 
        </div>

        <div class="col-4">
            <div class="form-group">
                <label for="supervisor" class="control-label" style="white-space: nowrap; ">Supervisor:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-supervisor" readonly="" name="supervisor" type="text">
            </div> 
        </div> 
    </div>
`;