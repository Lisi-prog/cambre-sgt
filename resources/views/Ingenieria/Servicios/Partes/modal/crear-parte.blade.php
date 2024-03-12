<!-- Modal -->
<div class="modal fade" id="crearParteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Parte</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'partes.store', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
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

                <div class="row">
                    @php
                        $orden_de_trabajo = Config::get('myconfig.orden_de_trabajo');
                        $orden_de_manufactura = Config::get('myconfig.orden_de_manufactura');
                        $orden_de_mecanizado = Config::get('myconfig.orden_de_mecanizado');
                    @endphp
                    @switch($orden->getOrdenDe->getTipoOrden())
                        @case($orden_de_trabajo)
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    @if ($editarEstado)
                                        {!! Form::select('estado', $estados, $orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getIdEstado(), [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-group',
                                            'required',
                                            'id' => 'estado'
                                        ]) !!} 
                                    @else
                                        {!! Form::text('est', $orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getNombreEstado(), ['class' => 'form-control', 'disabled']) !!}
                                        {!! Form::text('estado', $orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getIdEstado(), ['class' => 'form-control', 'hidden']) !!}
                                    @endif
                                    
                                </div>
                            </div>
                            @break
                        @case($orden_de_manufactura)
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <span class="obligatorio">*</span>
                                    @if ($editarEstado)
                                        {!! Form::select('estado', $estados_manufactura, $orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getIdEstado(), [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-group',
                                            'required',
                                            'id' => 'estado'
                                        ]) !!}
                                    @else
                                        {!! Form::text('est', $orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getNombreEstado(), ['class' => 'form-control', 'disabled']) !!}
                                        {!! Form::text('estado', $orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getIdEstado(), ['class' => 'form-control', 'hidden']) !!}
                                    @endif
                                </div>
                            </div>
                            @break
                            @case($orden_de_mecanizado)
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group" >
                                        {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        @if ($editarEstado)
                                            {!! Form::select('estado', $estados_mecanizado, $orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getIdEstado(), [
                                                'placeholder' => 'Seleccionar',
                                                'class' => 'form-select form-group',
                                                'required',
                                                'id' => 'estado'
                                            ]) !!}
                                        @else
                                            {!! Form::text('est', $orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getNombreEstado(), ['class' => 'form-control', 'disabled']) !!}
                                            {!! Form::text('estado', $orden->getPartes->sortByDesc('id_parte')->first()->getParteDe->getIdEstado(), ['class' => 'form-control', 'hidden']) !!}
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                            <div class ='row'> 
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('maquina', "Maquina:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::select('maquina', $maquinas, null, [
                                                'placeholder' => 'Seleccionar',
                                                'class' => 'form-select form-group',
                                                'id' => 'maquina'
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group"> 
                                        <label for="horas_maquina" class="control-label" style="white-space: nowrap; ">Horas maquina:</label> 
                                        <div class= "input-group">
                                            <input class="form-control" name="horas_maquina" type="number" min="0" value="00" id="horas_maquina" required>
                                            <span class="input-group-text">:</span>
                                            <input class="form-control" name="minutos_maquina" type="number" min="0" max="59" value="00" id="minutos_maquina" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>