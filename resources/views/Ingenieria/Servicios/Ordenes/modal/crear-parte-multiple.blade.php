<!-- Modal -->
<div class="modal fade" id="verCargaMulti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="npm-exampleModalLabel">Nuevo Parte Multiple</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="npm-modal-body-ver-partes">          
                <div class="row rounded" id="npm-m-ver-parte-div">
                    {!! Form::open(['route' => 'partes.guardar.multiple', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits-3sec', 'id' => 'npm-form']) !!}
                    {!! Form::text('ids[]', null, ['class' => 'form-control', 'hidden', 'id' => 'm-parte-multiple-ids']) !!}
                    <div class="row">
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div style="min-height: 300px; max-height: 300px; overflow-y: auto; overflow-x: auto;">
                                <table class="table table-hover">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Proyecto</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">orden</th>
                                        {{-- <th class="text-center" scope="col" style="color:#fff;width:10%;">Estado Orden</th> --}}
                                    </thead>
                                    <tbody id="npm_body_ord">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                {!! Form::label('observaciones', 'Observaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                <span class="obligatorio">*</span>
                                <textarea name='observaciones' id="npm-observaciones" maxlength="500" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                {!! Form::label('estado', 'Estado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                <select class="form-select" id="npm-m-ver-parte-estado" name="estado">
                                    <option selected="selected" value="">Seleccionar</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            {{-- <div class="form-group">
                                {!! Form::label('fecha_limite', 'Fecha limite:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                @role('SUPERVISOR')
                                    {!! Form::date('fecha_limite', null, [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'm-ver-parte-fecha-limite',
                                        'class' => 'form-control'
                                    ]) !!}
                                @else
                                    {!! Form::date('fecha_limite', null, [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'm-ver-parte-fecha-limite',
                                        'class' => 'form-control',
                                        'readonly'
                                    ]) !!}
                                @endrole
                            </div> --}}
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                {!! Form::label('fecha', 'Fecha:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                            <span class="obligatorio">*</span>
                                {!! Form::date('fecha', \Carbon\Carbon::now(), [
                                    'min' => '2023-01-01',
                                    'max' => \Carbon\Carbon::now()->year . '-12',
                                    'id' => 'npm-fecha',
                                    'class' => 'form-control',
                                    'required'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group"> 
                                <label for="horas" class="control-label" style="white-space: nowrap; ">Horas hombre:</label> 
                                <span class="obligatorio">*</span> 
                                <div class= "input-group">
                                    <input class="form-control" name="horas" type="number" min="0" value="00" id="npm-horas" required>
                                    <span class="input-group-text">:</span>
                                    <input class="form-control" name="minutos" type="number" min="0" max="59" value="00" id="npm-minutos" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="alert" class="mx-3">
                
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success button-prevent-multiple-submits-3sec" id="">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#verCargaMulti').on('hidden.bs.modal', function (e) {
            document.getElementById('npm-observaciones').value = '';
            document.getElementById('npm-m-ver-parte-estado').innerHTML = '<option selected="selected" value="">Seleccionar</option>';
            document.getElementById('npm-fecha').value = new Date().toISOString().split('T')[0];
            document.getElementById('npm-horas').value = '00';
            document.getElementById('npm-minutos').value = '00';
            document.getElementById('npm_body_ord').innerHTML = '';
        });
    });
  </script>