
<div class="row justify-content-center">
    <div class="row justify-content-center" >
        <button class="btn btn-primary w-100 my-auto" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProyectos{{$proyecto->id_servicio}}" aria-expanded="false" aria-controls="collapseProyectos{{$proyecto->id_servicio}}">
            Opciones <i class="fas fa-chevron-down m-auto"></i>
        </button>
    </div>
    <div class="collapse" data-bs-parent="#accordion" id="collapseProyectos{{$proyecto->id_servicio}}">
        
        <div class="row my-2 justify-content-center">
            <div class="col-12">
                <form method="GET" action="{{ route('proyectos.gestionar', $proyecto->id_servicio) }}" style="display:inline">
                <button type="submit" class="btn btn-success w-100">Gestionar</button>
                </form>
            </div>
        </div>
        @if ($servicios->isNotEmpty())
        <div class="row my-2 justify-content-center">
            <div class="col-12">
                <form method="GET" action="{{ route('proyecto.indexprefijo', $opcion) }}" style="display:inline" target="_blank">
                    @foreach ($servicios as $id)
                        <input class="input-filter" name="cod_serv[]" type="text" value="{{$id}}" hidden>
                    @endforeach
                <button type="submit" class="btn btn-info w-100">Servicios</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
