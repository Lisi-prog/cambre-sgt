<div class="form-group">
    <label for="nombre_diagnostico">Nombre diagnóstico: <span class="obligatorio">*</span></label>
    <input type="text" name="nombre_diagnostico" id="nombre_diagnostico" class="form-control" maxlength="100" required autocomplete="off" style="text-transform: uppercase;" value="{{ old('nombre_diagnostico', isset($diagnostico) ? $diagnostico->nombre_diagnostico : '') }}">
</div>
<div class="form-group">
    <label for="id_diagnostico_categoria">Categoría: <span class="obligatorio">*</span></label>
    <select name="id_diagnostico_categoria" id="id_diagnostico_categoria" class="form-select form-control" required>
        <option value="">Seleccionar</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id_diagnostico_categoria }}" {{ old('id_diagnostico_categoria', isset($diagnostico) ? $diagnostico->id_diagnostico_categoria : '') == $categoria->id_diagnostico_categoria ? 'selected' : '' }}>{{ $categoria->nombre_diagnostico_categoria }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="explicacion">Explicación: <span class="obligatorio">*</span></label>
    <textarea name="explicacion" id="explicacion" class="form-control" rows="3" maxlength="200" required style="text-transform: uppercase; resize: none; height: 15vh;">{{ old('explicacion', isset($diagnostico) ? $diagnostico->explicacion : '') }}</textarea>
</div>
<div class="form-check">
    <input type="hidden" name="en_uso" value="0">
    <input type="checkbox" name="en_uso" id="en_uso" class="form-check-input" value="1" {{ old('en_uso', isset($diagnostico) ? $diagnostico->en_uso : true) ? 'checked' : '' }}>
    <label for="en_uso" class="form-check-label">En uso</label>
</div>

