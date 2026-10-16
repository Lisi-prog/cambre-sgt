
<div class="row justify-content-center">
    <div class="row justify-content-center" >
        <button class="btn btn-primary w-100 my-auto" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProyectos{{$proyecto->id_servicio}}" aria-expanded="false" aria-controls="collapseProyectos{{$proyecto->id_servicio}}">
            Opciones <i class="fas fa-chevron-down m-auto"></i>
        </button>
    </div>
    <div class="collapse" data-bs-parent="#accordion" id="collapseProyectos{{$proyecto->id_servicio}}">
        @can('MODIFICAR-PRIORIDAD-PROYECTO')
        <div class="row my-2 justify-content-center">
            <div class="col-12">
                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modificarPrioridadModal" onclick="cargarModalModif({{$proyecto->id_servicio}}, this)">
                    Prioridad
                </button>
            </div>
        </div>
        @endcan
        <div class="row my-2 justify-content-center">
            <div class="col-12">
                @if ($proyecto->id_subtipo_servicio != 6)
                    <a href="{{ route('proyectos.gestionar', [$proyecto->id_servicio, 'opcion' => $opcion]) }}" class="btn btn-success w-100">
                        Gestionar
                    </a>
                @else
                    <a href="{{ route('servicio_mantenimiento.gestionar', [$proyecto->id_servicio, 'opcion' => $opcion]) }}" class="btn btn-success w-100">
                        Gestionar
                    </a>
                @endif
            </div>
        </div>
        <div class="row my-2 justify-content-center">
            <div class="col-12">
                <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#verActualizacionModal" onclick="cargarModalActualizaciones({{$proyecto->id_servicio}})">
                    Actualizaciones
                </button>
            </div>
        </div>
    </div>
</div>
