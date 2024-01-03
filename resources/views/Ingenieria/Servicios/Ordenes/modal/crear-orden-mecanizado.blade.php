<!-- Modal -->
<div class="modal fade" id="crearOrdenMecanizadoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Orden</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'ordenes.validarmecanizado', 'method' => 'POST', 'class' => 'formulario']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                        <div class="form-group">
                            {!! Form::label('id_orden_manuf', 'Id orden manufactura:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('id_orden_manuf', $orden_manufactura->id_orden_manufactura, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                        <div class="form-group">
                            {!! Form::label('num_etapa', 'Id orden manufactura:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('num_etapa', $orden_manufactura->getorden->id_etapa, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                        </div>
                    </div>
                </div>
                <div id="formulario">

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
