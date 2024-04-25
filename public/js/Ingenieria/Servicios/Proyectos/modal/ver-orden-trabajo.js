export default `
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label for="orden" class="control-label" style="white-space: nowrap; ">Orden:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-orden" readonly="" name="nom_orden" type="text">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="tipo" class="control-label" style="white-space: nowrap; ">Tipo:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-tipo" readonly="" name="tipo" type="text">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="estado" class="control-label" style="white-space: nowrap; ">Estado:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-estado" readonly="" name="estado" type="text">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="responsable" class="control-label" style="white-space: nowrap; ">Responsable:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-responsable" readonly="" name="responsable" type="text">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label for="fecha_inicio" class="control-label" style="white-space: nowrap; ">Fecha inicio:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-fec_inicio" readonly="" name="fecha_inicio" type="text">
            </div>                        
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="fecha_limite" class="control-label" style="white-space: nowrap; ">Fecha limite:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-fec_limite" readonly="" name="fecha_limite" type="text">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="fecha_fin_real" class="control-label" style="white-space: nowrap; ">Fecha fin:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-fec_fin" readonly="" name="fecha_inicio" type="text">
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="duracion_estimada" class="control-label" style="white-space: nowrap; ">Duracion estimada:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-duracion_estimada" readonly="" name="duracion_estimada" type="text">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="duracion_real" class="control-label" style="white-space: nowrap; ">Duracion real:</label>
                <span class="obligatorio">*</span>
                <input class="form-control" id="input-duracion_real" readonly="" name="duracion_real" type="text">
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
                <label for="observaciones" class="control-label" style="white-space: nowrap; ">Descripción:</label> 
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
    </div>`;
