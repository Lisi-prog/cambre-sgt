<!-- Modal -->
<div class="modal fade" id="crearOpe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Operaciones</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'ordenes.validarmecanizado', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}

            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                        <div class="form-group">
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" hidden>
                        <div class="form-group">
                            
                        </div>
                    </div>
                </div>
                <div id="formulario-crear-orden">
                    
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
