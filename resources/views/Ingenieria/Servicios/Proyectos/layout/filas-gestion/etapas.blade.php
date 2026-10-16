<td class= 'text-center' style="vertical-align: middle;">{{$etapa->descripcion_etapa}}</td>
<td class= 'text-center' style="vertical-align: middle;">{{$etapa->nombre_estado}}</td>
<td class= 'text-center' style="vertical-align: middle;">{{$etapa->responsable}}</td>
<td class= 'text-center' style="vertical-align: middle;">{{$etapa->fecha_inicio}}</td>
<td class= 'text-center' style="vertical-align: middle;">{{$etapa->fecha_limite}}</td>
<td class= 'text-center' style="vertical-align: middle;">{{$etapa->fecha_finalizacion}}</td>
<td class= 'text-center' style="vertical-align: middle;">{{$etapa->fecha_ult_act}}</td>
<td class= 'text-center' style="vertical-align: middle;">{{$etapa->horas_estimada}}</td>
<td class= 'text-center' style="vertical-align: middle;">{{$etapa->horas_real}}</td>
<td class='text-center' style="vertical-align: middle;">
    <div class="row justify-content-center">
        <div class="row justify-content-center">
            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEtapa{{$etapa->id_etapa}}" aria-expanded="false" aria-controls="collapseEtapa{{$etapa->id_etapa}}">
                Opciones <i class="fas fa-filter" hidden></i>
            </button>
        </div>
        <div class="collapse" data-bs-parent="#accordion" id="collapseEtapa{{$etapa->id_etapa}}">
            <div class="row ">
                <div class="col-12">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarEtapaModal" onclick="cargarModalEditarEtapa({{$etapa->id_etapa}})">
                        Editar
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verActEtapaOrdenModal" onclick="mostrarActEtapaAlt({{$etapa->id_etapa}})">
                        Actualizaciones
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-info w-100" name="flt-for-eta" value="{{$etapa->descripcion_etapa}}">
                        Filtro
                    </button>
                </div>
            </div>
            
        </div>
    </div>
</td>
