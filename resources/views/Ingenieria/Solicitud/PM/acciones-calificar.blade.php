
<div class="row justify-content-center">
    <div class="row justify-content-center" >
        <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePMA{{$Pm->id_propuesta_de_mejora}}" aria-expanded="false" aria-controls="collapsePMA{{$Pm->id_propuesta_de_mejora}}">
            Opciones
        </button>
    </div>
    <div class="collapse" data-bs-parent="#accordionPmACali" id="collapsePMA{{$Pm->id_propuesta_de_mejora}}">
        <div class="row my-2">
            <div class="col-12">
                <form method="GET" action="{{ route('pm.calificar', $Pm->id_propuesta_de_mejora) }}" style="display:inline">
                    <button type="submit" class="btn btn-success w-100">Calificar</button>
                </form>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-12">
                <form method="GET" action="{{ route('p_m.edit', $Pm->id_propuesta_de_mejora) }}" style="display:inline">
                    <button type="submit" class="btn btn-warning w-100">Editar</button>
                </form>
            </div>
        </div>
    </div>
</div>
