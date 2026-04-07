<div id="ishikawa_causa_div">   
    @foreach($ishikawa_causas as $causa)
        <option data-ishikawa-categoria="{{ $causa->id_ishikawa_categoria }}"  value="{{ $causa->id_ishikawa_causa }}">{{ $causa->nombre_causa }}</option>
    @endforeach
</div>
<div id="ishikawa_categoria_div">   
    @foreach($ishikawa_categorias as $categoria)
        <option value="{{ $categoria->id_ishikawa_categoria }}">{{ $categoria->nombre_categoria }}</option>
    @endforeach
</div>
<div id="accion_select_div">
    @foreach ($acciones as $accion)
        <option value="{{ $accion->id_accion_tarea }}">{{ $accion->nombre_accion }}</option>
    @endforeach
</div>
<div id="zona_select_div">
    @foreach ($zonas as $zona)
        <option value="{{ $zona->id_zona }}">{{ $zona->nombre_zona }}</option>
    @endforeach
</div>
<div id="maquina_select_div">
    @foreach ($maquinas as $maquina)
        <option value="{{ $maquina->id_maquinaria }}">{{ $maquina->alias_maquinaria }}</option>
    @endforeach
</div>
<div  id="tarea_mantenimiento">
    @foreach ($tareas_mantenimiento as $tarea)
        <option data-activo="{{ $tarea->id_activo }}" data-tipo="{{ $tarea->id_tipo_activo }}" value="{{ $tarea->id_tarea_mantenimiento }}">{{ $tarea->nombre_tarea }}</option>
    @endforeach
</div >