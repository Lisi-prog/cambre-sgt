<!-- Modal -->
<div class="modal fade" id="crearOrdenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Orden</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'etapas.store', 'method' => 'POST', 'class' => 'formulario']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('tipo_orden', "Tipo orden:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('tipo_orden', [1 => 'Orden de trabajo', 2 => 'Orden de manufactura', 5 => 'Orden de mecanizado',4 => 'Orden de mantenimiento'], null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-group',
                                    'id' => 'selected-tipo-orden'
                                ]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('num_etapa', "Etapa:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::select('num_etapa', $etapas, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-group',
                                    'id' => 'num_etapa'
                                ]) !!}
                        </div>
                    </div>
                </div>
                <div id="formulario">

                </div>
                {{--<div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('nom_orden', "Nombre orden de trabajo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <span class="obligatorio">*</span>
                            {!! Form::text('nom_orden', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('tipo_orden_trabajo', 'Tipo de orden trabajo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::select('tipo_orden_trabajo', $tipo_orden, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-group',
                                    'id' => 'tipo_orden_trabajo'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('responsable', 'Responsable:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                {!! Form::select('responsable', $empleados, null, [
                                    'placeholder' => 'Seleccionar',
                                    'class' => 'form-select form-group',
                                    'id' => 'responsable'
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('fec_ini', 'Fecha inicio:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                            {!! Form::date('fecha_ini', \Carbon\Carbon::now(), [
                                'min' => '2023-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fec_ini',
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                        <div class="" hidden>
                            {!! Form::text('id_servicio', $proyecto->id_servicio, ['class' => 'form-control']) !!}
                        </div>
                    </div> 
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>