<!-- Modal -->
<div class="modal fade" id="crearParteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Parte</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'partes.store', 'method' => 'POST', 'class' => 'formulario']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        {!! Form::text('id_orden',$orden->id_orden, ['class' => 'form-control', 'hidden']) !!}
                        <div class="form-group">
                            {!! Form::label('observaciones', 'Observaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            <textarea name='observaciones' id="observaciones" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                        </div>
                        {{-- <div class="form-group">
                            {!! Form::label('num_etapa', "Etapa:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('num_etapa', $etapas, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-group',
                                    'required',
                                    'id' => 'num_etapa'
                                ]) !!}
                        </div> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('fec_limite', 'Fecha limite:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                            {!! Form::date('fecha_limite', $orden->getFechaLimite(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fec_ini',
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
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group"> 
                            <label for="horas" class="control-label" style="white-space: nowrap; ">Horas:</label> 
                            <span class="obligatorio">*</span> 
                            <div class= "input-group">
                                <input class="form-control" name="horas" type="number" min="0" value="00" id="horas" required>
                                <span class="input-group-text">:</span>
                                <input class="form-control" name="minutos" type="number" min="0" max="59" value="00" id="minutos" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @switch($orden->getOrdenDe->getTipoOrden())
                        @case(1)
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('estado', $estados, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-group',
                                            'required',
                                            'id' => 'estado'
                                        ]) !!}
                                </div>
                            </div>
                            @break
                        @case(2)
                            
                            @break
                        @default
                        
                    @endswitch
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        {{-- <div class="form-group">
                            {!! Form::label('num_etapa', "Etapa:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('num_etapa', $etapas, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-group',
                                    'required',
                                    'id' => 'num_etapa'
                                ]) !!}
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>