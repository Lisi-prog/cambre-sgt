<!-- Modal -->
<div class="modal fade" id="crearActEtaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear actualizacion etapa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => ['actualizacion-etapa.crear', $proyecto->id_servicio], 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits']) !!}
            <div class="modal-body">
                {!! Form::text('id_etapa', null, ['class' => 'form-control', 'hidden', 'id' => 'm_cae_id_etapa']) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('descripcion', "Descripcion:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('descripcion', null, ['class' => 'form-control', 'required', 'id' => 'descrip']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('estado', "Estado:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('id_estado', $estados, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-group',
                                    'id' => 'm-crear-act-eta-idestado',
                                    'required',
                                ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="form-group">
                            {!! Form::label('fecha_limite', 'Fecha limite:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                            {!! Form::date('fecha_limite', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'class' => 'form-control',
                                'id' => 'm-crear-act-eta-feclimite'
                            ]) !!}
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