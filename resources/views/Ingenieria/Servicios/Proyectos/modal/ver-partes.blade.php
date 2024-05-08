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
                </div>
                    <div class="table-responsive tableFixHead">
                        <table class="table table-striped" id="verPartes" >
                            <thead id="encabezado_tabla_parte" style="background: #558540">
                                <th class="text-center" scope="col" style="color:#fff;">Cod.</th>
                                <th class="text-center" scope="col" style="color:#fff;">Fecha</th>
                                <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                                <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                <th class="text-center" scope="col" style="color:#fff;">Horas</th>
                                <th class="text-center" scope="col" style="color:#fff;">Observaciones</th>
                                <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                <th id="column-maq" class="text-center" scope="col" style="color:#fff;" hidden>Maquina</th>
                                <th id="column-hora-maq" class="text-center" scope="col" style="color:#fff;" hidden>Hora maquina</th>
                                <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                                <th class="text-center" scope="col" style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody id="body_ver_parte">

                            </tbody>
                        </table>
                    </div>
                <div class="row mb-2">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 my-2">
                        <button type="button" class="btn btn-warning" onclick="nuevoParte()">Nuevo parte</button>
                    </div>
                </div>             
                <div class="row rounded border border-3 border-warning" id="m-ver-parte-div">
                    <h5 class="text-center control-label pt-2" id="titulo-parte">Nuevo parte</h5>
                    {!! Form::open(['route' => 'partes.guardar.act', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits-3sec nuevo-editar-parte', 'id' => 'form-nuevo-parte']) !!}
                    {!! Form::text('id_orden', null, ['class' => 'form-control', 'hidden', 'id' => 'm-ver-parte-orden']) !!}
                    {!! Form::text('id_parte', null, ['class' => 'form-control', 'hidden', 'id' => 'm-id-parte']) !!}
                    {!! Form::text('editar', 0, ['class' => 'form-control', 'hidden', 'id' => 'm-editar']) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                                @role('SUPERVISOR')
                                    {!! Form::date('fecha_limite', null, [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'm-ver-parte-fecha-limite',
                                        'class' => 'form-control'
                                    ]) !!}
                                @else
                                    {!! Form::date('fecha_limite', null, [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'm-ver-parte-fecha-limite',
                                        'class' => 'form-control',
                                        'readonly'
                                    ]) !!}
                                @endrole
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

            <div id="alert" class="mx-3">
                
            </div>

            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
                <button type="submit" class="btn btn-success button-prevent-multiple-submits-3sec" id="m-ver-parte-orden-btn">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
            
            {{-- <div class="alert alert-success alert-dismissible fade show " role="alert">
                'Parte creado con exito'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}
        </div>
    </div>
</div>