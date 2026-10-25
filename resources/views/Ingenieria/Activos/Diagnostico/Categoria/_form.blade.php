<div class="form-group">
    <label for="nombre_diagnostico_categoria">Nombre categoría: <span class="obligatorio">*</span></label>
    <input type="text" name="nombre_diagnostico_categoria" id="nombre_diagnostico_categoria" class="form-control" maxlength="100" required autocomplete="off" style="text-transform: uppercase;" value="{{ old('nombre_diagnostico_categoria', isset($categoria) ? $categoria->nombre_diagnostico_categoria : '') }}">
</div>

