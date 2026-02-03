<!-- Modal -->
<div class="modal fade" id="crearOrdenMecanizadoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Relacionar Orden Mecanizado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- {!! Form::open(['route' => 'ordenes.validarmecanizado', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!} --}}
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="det-tab" data-bs-toggle="tab" data-bs-target="#det_val" type="button" role="tab" onclick="">Nuevo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="det_adju_tab" data-bs-toggle="tab" data-bs-target="#det_adju" type="button" role="tab" onclick="">Existente</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="det_val" role="tabpanel">
                        {!! Form::open(['route' => 'ordenes.validarmecanizado', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                                <div class="form-group">
                                    {!! Form::label('id_orden_manuf', 'Id orden manufactura:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('id_orden_manuf', $orden_manufactura->id_orden_manufactura, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    {!! Form::text('id_orden', $orden_manufactura->getOrden->id_orden, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                                <div class="form-group">
                                    {!! Form::label('num_etapa', 'Id orden manufactura:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('num_etapa', $orden_manufactura->getorden->id_etapa, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                        </div>
                        <div id="formulario-crear-orden">
                            
                        </div>   
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="det_adju" role="tabpanel">
                        {!! Form::open(['route' => ['ordenes.relacionarmecanizado', $orden_manufactura->id_orden_manufactura], 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    {!! Form::label('ord_mec_lib', 'Orden de Mecanizado libre (Sin Orden de Manufactura asociado):', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('id_orden_mec', $ord_mec_sin_manufactura, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select form-control',
                                            'id' => 'id_orden_mec',
                                            'required'
                                        ]) !!}
                            </div>
                        </div>
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                                <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button>
                            </div>
                        </div>  
                        {!! Form::close() !!}   
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success button-prevent-multiple-submits">Guardar</button> --}}
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
