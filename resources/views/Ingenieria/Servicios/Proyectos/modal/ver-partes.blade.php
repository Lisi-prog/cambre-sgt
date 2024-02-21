<!-- Modal -->
<div class="modal fade" id="verPartesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ver Partes</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="modal-body-ver-partes">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('etapa', 'Etapa:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('etapa', null, [
                                'class' => 'form-control',
                                'id' => 'mv-etapa',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('orden', 'Orden:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('orden', null, [
                                'class' => 'form-control',
                                'id' => 'mv-orden',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('estado', 'Estado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('estado', null, [
                                'class' => 'form-control',
                                'id' => 'mv-estado',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-striped">
                        <thead id="encabezado_tabla_parte">
                            <th class="text-center" scope="col" style="color:#fff;">Fecha</th>
                            <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                            <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                            <th class="text-center" scope="col" style="color:#fff;">Horas</th>
                            <th class="text-center" scope="col" style="color:#fff;">Observaciones</th>
                            <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                            <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        </thead>
                        <tbody id="body_ver_parte">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>