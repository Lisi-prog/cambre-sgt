<div class="modal fade" id="editarSintomasModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar Síntomas del Tipo Activo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'tipo_activo.set_sintomas', 'method' => 'PUT', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <h5>Síntomas Disponibles</h5>
                <table id="tabla_set_sintomas" class="table table-striped">
                    <thead>
                        <th class='text-center' style="color:#fff;">Asignar</th>
                        <th class='text-center' style="color:#fff;">Síntoma</th>
                        <th class='text-center' style="color:#fff;">Tipo de Sintoma</th>
                    </thead>
                    <tbody>                    
                        @foreach($ta->getSintomasSinUsar() as $sintoma_disponible)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        {!! Form::checkbox('sintomas[]', $sintoma_disponible->id_sintoma, false, ['class' => 'form-check-input', 'id' => 'sintoma_'.$sintoma_disponible->id_sintoma]) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        {!! Form::label('sintoma_'.$sintoma_disponible->id_sintoma, $sintoma_disponible->nombre_sintoma, ['class' => 'form-check-label']) !!}
                                    </div>
                                </td>
                                <td>{{$sintoma_disponible->getTipoSintoma->nombre_tipo_sintoma}}</td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
                {!! Form::hidden('id_tipo_activo', $ta->id_tipo_activo) !!}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>