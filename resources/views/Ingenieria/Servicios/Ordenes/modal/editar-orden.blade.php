<!-- Modal -->
<div class="modal fade" id="editarOrdenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Orden</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'orden.editar', 'method' => 'POST', 'class' => 'formulario nuevo-editar-orden']) !!}
            <div class="modal-body" id="modal-body-editar-orden">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {{-- {!! Form::text('id_servicio', $orden->getEtapa->getServicio->id_servicio, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'id' => 'id_servicio',
                                            'hidden' => false
                                        ]) !!} --}}
                            {{-- {!! Form::text('tipo_orden', $orden->getOrdenDe->getTipoOrden(), [
                                    'class' => 'form-control',
                                    'id' => 'tipo-orden',
                                    'required'=> 'required',
                                    'hidden' => false
                                ]) !!} --}}
                            {!! Form::text('id_orden_edit', null, [
                                'class' => 'form-control',
                                'id' => 'id_orden_edit',
                                'required'=> 'required',
                                'hidden' => true
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('etapa_edit', "Etapa:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('etapa_edit', null, [
                                    'class' => 'form-control',
                                    'required',
                                    'readonly',
                                    'id' => 'etapa_edit'
                                ]) !!}
                            {{-- {!! Form::text('num_etapa', $orden->getEtapa->id_etapa, [
                                'class' => 'form-control',
                                'id' => 'num_etapa',
                                'required'=> 'required',
                                'hidden' => false
                            ]) !!} --}}
                        </div>
                    </div>
                </div>
                <div id="formulario-editar-orden">
                    
                </div>
            </div>
            <div id="alertOrd" class="mx-3">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btn-editar-orden">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>