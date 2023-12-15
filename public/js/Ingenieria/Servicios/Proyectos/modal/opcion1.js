export default `<div class="row"> 
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
    <div class="form-group"> 
        <label for="nom_orden" class="control-label" style="white-space: nowrap; ">Nombre orden de trabajo:</label> 
        <span class="obligatorio">*</span> 
        <input class="form-control" name="nom_orden" type="text" id="nom_orden" required> 
    </div> 
</div> 
</div> 
<div class="row"> 
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"> 
    <div class="form-group">
        <div class="form-group"> 
            <label for="tipo_orden_trabajo" class="control-label fs-7" style="white-space: nowrap;">Tipo de orden trabajo:</label> 
            <span class="obligatorio">*</span> 
            <select class="form-select form-group" id="tipo_orden_trabajo" name="tipo_orden_trabajo" required> 
                <option selected="selected" value="">Seleccionar</option> 
                <option value="5">Externo</option> 
                <option value="4">Gestion</option> 
                <option value="2">Herramental</option>
                <option value="3">Procesos</option>
                <option value="1">Producto</option>
            </select> 
        </div> 
    </div> 
</div> 
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
    <div class="form-group"> 
        <div class="form-group"> 
            <label for="responsable" class="control-label fs-7" style="white-space: nowrap;">Responsable:</label> 
            <span class="obligatorio">*</span> 
            <select class="form-select form-group" id="responsable" name="responsable" required>
                <option selected="selected" value="">Seleccionar</option>
                <option value="1">Alejandro Virgillo</option>
            </select>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
    <div class="form-group">
        <label for="fec_ini" class="control-label fs-7" style="white-space: nowrap;">Fecha inicio:</label>
        <span class="obligatorio">*</span>
        <input min="2023-01-01" max="2023-12" id="fec_ini" class="form-control" name="fecha_ini" type="date" value="2023-12-12" required>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
    <div class="form-group"> 
        <label for="estado" class="control-label fs-7" style="white-space: nowrap;">Estado:</label> 
        <span class="obligatorio">*</span> 
        <select class="form-select form-group" id="estado" name="id_estado" required>
            <option selected="selected" value="">Seleccionar</option>
            <option value="1">Cancelado</option>
            <option value="2">Completo</option>
            <option value="3">Continua</option>
            <option value="4">En proceso</option>
            <option value="5">Externo</option>
            <option value="6">Espera</option>
            <option value="7">Revisar</option>
            <option value="8">Pausa</option>
            <option value="9">Problema</option>
        </select>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
    <div class="form-group">
        <label for="fec_req" class="control-label fs-7" style="white-space: nowrap;">Fecha requerida:</label>
        <span class="obligatorio">*</span>
        <input min="2023-01-01" max="2023-12" id="fec_req" class="form-control" name="fecha_req" type="date" value="2023-12-12" required>
    </div>
    <div class="" hidden="">
        <input class="form-control" name="id_servicio" type="text" value="1">
    </div>
</div>
</div>`;
    
    
    