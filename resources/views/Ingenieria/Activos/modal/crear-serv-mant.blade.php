<!-- Modal -->
<div class="modal fade" id="crearServicioMantModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Servicio Mantenimiento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 {{-- {!! Form::open(['method' => 'GET', 'route' => ['sma.aceptar', $Ssi->id_solicitud], 'style' => '', 'id' => 'form-serv-mant']) !!} --}}
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('codigo_proyecto', 'Codigo proyecto:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('codigo_proyecto', null, [
                                        'class' => 'form-control',
                                        'style' => 'text-transform:uppercase',
                                        'id' => 'codigo_serv_mant',
                                        'disabled'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <div class="form-group">
                                    {!! Form::label('nombre_proyecto', "Nombre proyecto:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nombre_proyecto', null, [
                                        'class' => 'form-control',
                                        'style' => 'text-transform:uppercase',
                                        'id' => 'nombre_serv_mant',
                                        'disabled'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('lider', 'Lider:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::select('lider', $empleados, Auth::user()->getEmpleado->id_empleado, [
                                        'placeholder' => 'Seleccionar',
                                        'class' => 'form-select form-control',
                                        'id' => 'lider_serv_mant'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('activo_proyecto', 'Activo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('activo_proyecto', null, [
                                            'class' => 'form-control',
                                            'style' => 'text-transform:uppercase',
                                            'id' => 'activo_serv_mant',
                                            'disabled'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('tipo_proyecto', 'Tipo:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('tipo_proyecto', 'Servicio de Mantenimiento', [
                                        'class' => 'form-control',
                                        'style' => 'text-transform:uppercase',
                                        'id' => 'tipo_proy_serv_mant',
                                        'disabled'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
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
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('fec_req', 'Fecha requerida:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                    <span class="obligatorio">*</span>
                                    {!! Form::date('fecha_req', \Carbon\Carbon::parse()->format('Y-m-d'), [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'fec_req',
                                        'class' => 'form-control'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                {!! Form::label('tar_prev', 'Tareas Preventivas Pendientes:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                <table class="table table-striped mt-2 table-sm" id="example">
                                    <thead>
                                        <th class='text-center' style="color:#fff;">Asignar</th>
                                        <th class='text-center' style="color:#fff;">Tarea</th>
                                        <th class='text-center' style="color:#fff;">Ejecucion</th>
                                        <th class='text-center' style="color:#fff;">Zona</th>
                                    </thead>
                                    <tbody id="tareas-prev">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- {!! Form::close() !!} --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits" id="btn-guardar">Aceptar y crear servicio</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Activo/crear-serv-mant.js') }}"></script>