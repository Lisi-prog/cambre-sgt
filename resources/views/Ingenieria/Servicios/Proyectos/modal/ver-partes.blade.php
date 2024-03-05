<!-- Modal -->
<div class="modal fade" id="verPartesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ver Partes</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="modal-body-ver-partes">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('etapa', 'Etapa:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('etapa', null, [
                                'class' => 'form-control',
                                'id' => 'mv-etapa',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('orden', 'Orden:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('orden', null, [
                                'class' => 'form-control',
                                'id' => 'mv-orden',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('estado', 'Estado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('estado', null, [
                                'class' => 'form-control',
                                'id' => 'mv-estado',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <table class="table table-striped">
                        <thead id="encabezado_tabla_parte">
                            <th class="text-center" scope="col" style="color:#fff;">Fecha</th>
                            <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                            <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                            <th class="text-center" scope="col" style="color:#fff;">Horas</th>
                            <th class="text-center" scope="col" style="color:#fff;">Observaciones</th>
                            <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                            <th id="column-maq" class="text-center" scope="col" style="color:#fff;" hidden>Maquina</th>
                            <th id="column-hora-maq" class="text-center" scope="col" style="color:#fff;" hidden>Hora maquina</th>
                            <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        </thead>
                        <tbody id="body_ver_parte">

                        </tbody>
                    </table>
                </div>
                <div class="row mb-2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <button type="button" class="btn btn-warning" onclick="verCargarParteModalParte()">Nuevo parte</button>
                    </div>
                </div>
                <div class="row" id="m-ver-parte-div" hidden>
                    {!! Form::open(['route' => 'partes.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
                    {!! Form::text('id_orden', null, ['class' => 'form-control', 'hidden', 'id' => 'm-ver-parte-orden']) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            {{-- {!! Form::text('id_orden',$orden->id_orden, ['class' => 'form-control', 'hidden']) !!} --}}
                            <div class="form-group">
                                {!! Form::label('observaciones', 'Observaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                <span class="obligatorio">*</span>
                                <textarea name='observaciones' id="observaciones" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            {!! Form::label('estado', 'Estado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            <select class="form-select" id="m-ver-parte-estado" name="estado">
                                <option selected="selected" value="">Seleccionar</option>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                {!! Form::label('fecha_limite', 'Fecha limite:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                            {{-- <span class="obligatorio">*</span> --}}
                                {!! Form::date('fecha_limite', null, [
                                    'min' => '2023-01-01',
                                    'max' => \Carbon\Carbon::now()->year . '-12',
                                    'id' => 'm-ver-parte-fecha-limite',
                                    'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                {!! Form::label('fecha', 'Fecha:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                            <span class="obligatorio">*</span>
                                {!! Form::date('fecha', \Carbon\Carbon::now(), [
                                    'min' => '2023-01-01',
                                    'max' => \Carbon\Carbon::now()->year . '-12',
                                    'id' => 'fecha',
                                    'class' => 'form-control',
                                    'required'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group"> 
                                <label for="horas" class="control-label" style="white-space: nowrap; ">Horas hombre:</label> 
                                <span class="obligatorio">*</span> 
                                <div class= "input-group">
                                    <input class="form-control" name="horas" type="number" min="0" value="00" id="horas" required>
                                    <span class="input-group-text">:</span>
                                    <input class="form-control" name="minutos" type="number" min="0" max="59" value="00" id="minutos" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="m-ver-parte-maquinaria">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
                <button type="submit" class="btn btn-success button-prevent-multiple-submits" id="m-ver-parte-orden-btn" hidden>Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>