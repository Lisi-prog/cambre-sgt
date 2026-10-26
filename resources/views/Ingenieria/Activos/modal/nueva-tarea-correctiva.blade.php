<button type="button" class="btn btn-success mb-3" onclick="mostrarNuevaTarea('nueva-tarea-correctiva')">
    + Nueva tarea
</button>
<div id="nueva-tarea-correctiva" class="nueva-tarea-form mb-3 d-none">
    {!! Form::label('nombre_tarea_nueva', 'Nombre tarea:') !!}
    {!! Form::text('nombre_tarea_nueva', null, [
        'class' => 'form-control',
        'placeholder' => 'Nombre de la tarea',
        'maxlength' => 200
    ]) !!}
    <div class="mt-3 text-end">
        <button type="button" class="btn btn-primary" onclick="guardarNuevaTarea(this)">
            Guardar nueva tarea
        </button>
    </div>
</div>
