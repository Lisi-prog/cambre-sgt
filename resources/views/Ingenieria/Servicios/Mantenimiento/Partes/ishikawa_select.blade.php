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