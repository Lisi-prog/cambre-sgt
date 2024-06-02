<!-- Modal -->
<div class="modal fade" id="editarParteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="titulo-parte">Editar Parte</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'partes.guardar.act', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits-3sec nuevo-editar-parte']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        {!! Form::text('id_orden', null, ['class' => 'form-control', 'hidden', 'id' => 'm-ver-parte-orden']) !!}
                        {!! Form::text('id_parte', null, ['class' => 'form-control', 'hidden', 'id' => 'm-id-parte']) !!}
                        {!! Form::text('editar', 0, ['class' => 'form-control', 'hidden', 'id' => 'm-editar']) !!}
                        <div class="form-group">
                            {!! Form::label('observaciones', 'Observaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <textarea name='observaciones' id="observaciones" class="form-control reset-input" maxlength="500" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('fec_limite', 'Fecha limite:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                            {!! Form::date('fecha_limite', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fec_limite',
                                'class' => 'form-control',
                                $editable
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('fecha', 'Fecha:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                            {!! Form::date('fecha', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fecha',
                                'class' => 'form-control reset-fecha'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group"> 
                            <label for="horas" class="control-label" style="white-space: nowrap; ">Horas hombre:</label> 
                            <span class="obligatorio">*</span> 
                            <div class= "input-group">
                                <input class="form-control reset-horas" name="horas" type="number" min="0" value="00" id="horas" required>
                                <span class="input-group-text">:</span>
                                <input class="form-control reset-horas" name="minutos" type="number" min="0" max="59" value="00" id="minutos" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>

                            <select class="form-select form-group" id="m-editar-parte-estado" name="estado" required> 
                                <option selected="selected" value="">Seleccionar</option> 
                                @foreach($estados as $estado)
                                    <option value="{{$estado->id_estado}}">{{$estado->nombre}}</option> 
                                @endforeach
                            </select> 

                        </div>
                    </div>
                </div>
            </div>
            <div id="alert" class="mx-3">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            
            {!! Form::close() !!}
        </div>
    </div>
</div>