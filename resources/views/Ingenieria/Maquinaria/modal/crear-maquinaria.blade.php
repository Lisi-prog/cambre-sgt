<!-- Modal -->
<div class="modal fade" id="nuevaMaquinariaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Maquinaria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'maquinarias.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('codigo_maquinaria', 'Codigo maquinaria:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('codigo_maquinaria', null, [
                                'class' => 'form-control reset-input',
                                'required' => 'required',
                                'id' => 'codigo_maquinaria'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('alias_maquinaria', 'Alias maquinaria:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('alias_maquinaria', null, [
                                'class' => 'form-control reset-input',
                                'required' => 'required',
                                'id' => 'alias_maquinaria'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('id_tipo', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::select('id_tipo', $tipos, null, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select reset-input',
                                'id' => 'id_tipo'
                            ]) !!}
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <div class="form-group">
                            {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <textarea name='descripcion' id="descripcion" class="form-control reset-input" rows="54" cols="54" style="resize:none; height: 20vh"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('id_sector', 'Sector:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::select('id_sector', $sectores, null, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select reset-input',
                                'id' => 'id_sector'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('ope', 'Operaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                            <div class="d-flex flex-column overflow-auto"
                            style="height: 100px;">
                                @foreach ($operaciones as $op)
                                    <div class="form-check">
                                        <input name="operaciones[]" class="form-check-input" type="checkbox" value="{{$op->id_operacion}}" id="ope{{$op->id_operacion}}">
                                        <label class="form-check-label" for="ope{{$op->id_operacion}}">
                                        {{$op->nombre_operacion}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>