<!-- Modal -->
<style>
    #encabezado_tabla_parte th {
        background: #558540;
    }
</style>
<div class="modal fade" id="verPartesOpeHdrModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ver Partes Operaciones</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="modal-body-ver-partes">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('operacion', 'Operacion:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('operacion', null, [
                                'class' => 'form-control',
                                'id' => 'mv-operacion',
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
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('ord_mec', 'Orden Mecanizado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('etapa', null, [
                                'class' => 'form-control',
                                'id' => 'mv-ord-mec',
                                'readonly'
                            ]) !!}
                        </div>
                    </div>
                </div>
                    <div class="table-responsive tableFixHead">
                        <table class="table table-sm table-striped" id="verPartes" >
                            <thead id="encabezado_tabla_parte" style="background: #558540">
                                <th class="text-center" scope="col" style="color:#fff;">Cod.</th>
                                <th class="text-center" scope="col" style="color:#fff;">Fecha</th>
                                {{-- <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th> --}}
                                <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                                <th class="text-center" scope="col" style="color:#fff;">Horas</th>
                                <th class="text-center" scope="col" style="color:#fff;">Horas Maquina</th>
                                <th class="text-center" scope="col" style="color:#fff;">Observaciones</th>
                                <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                                <th class="text-center" scope="col" style="color:#fff;">Medidas</th>
                                <th class="text-center" scope="col" style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody id="body_ver_parte_ope">
                                
                            </tbody>
                        </table>
                    </div>
                <div class="row mb-2">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 my-2">
                        <button type="button" class="btn btn-warning" onclick="nuevoParte()">Nuevo parte</button>
                    </div>
                </div>             
                <div class="row rounded border border-3 border-warning" id="m-ver-parte-div">
                    <h5 class="text-center control-label pt-2" id="titulo-parte">Nuevo parte</h5>
                    {!! Form::open(['route' => 'partesope.guardar.act', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits-3sec nuevo-editar-parte', 'id' => 'form-nuevo-parte']) !!}
                    {!! Form::text('id_op', null, ['class' => 'form-control', 'hidden', 'id' => 'm-id-ope-hdr']) !!}
                    {!! Form::text('id_parte_ope_hdr', null, ['class' => 'form-control', 'hidden', 'id' => 'm-id-parte-ope']) !!}
                    {!! Form::text('editar', 0, ['class' => 'form-control', 'hidden', 'id' => 'm-editar']) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                {!! Form::label('observaciones', 'Observaciones:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                <span class="obligatorio">*</span>
                                <textarea name='observaciones' id="observaciones" maxlength="500" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                {!! Form::label('estado', 'Estado:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <span class="obligatorio">*</span>
                                <select class="form-select" id="m-ver-parte-estado" name="estado">
                                    <option selected="selected" value="">Seleccionar</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                {!! Form::label('fecha', 'Fecha:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                            <span class="obligatorio">*</span>
                                {!! Form::date('fecha', \Carbon\Carbon::now(), [
                                    'min' => '2023-01-01',
                                    'max' => \Carbon\Carbon::now()->year . '-12',
                                    'id' => 'fecha',
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
                                    <input class="form-control" name="horas" type="number" min="0" value="00" id="horas" onclick="this.select()" required>
                                    <span class="input-group-text">:</span>
                                    <input 
                                        class="form-control" 
                                        name="minutos" 
                                        type="number" 
                                        @role('TECNICO') 
                                            min="1" 
                                        @else 
                                            min="0" 
                                        @endrole 
                                        max="59" 
                                        value="00" 
                                        id="minutos"
                                        onclick="this.select()"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class ='row'> 
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                {!! Form::label('maquina', "Maquina:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!} <span class="obligatorio">*</span>
                                <select class="form-select form-group" id="m-ver-parte-maquina" name="maquina" required>
                                    <option selected="selected" value="">Seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group"> 
                                <label for="horas_maquina" class="control-label" style="white-space: nowrap; ">Horas maquina:</label> 
                                <div class= "input-group">
                                    <input class="form-control" name="horas_maquina" type="number" min="0" value="00" id="horas_maquina" onclick="this.select()" required>
                                    <span class="input-group-text">:</span>
                                    <input 
                                        class="form-control" 
                                        name="minutos_maquina" 
                                        type="number" 
                                        @role('TECNICO') 
                                            min="1" 
                                        @else 
                                            min="0" 
                                        @endrole  
                                        max="59" 
                                        value="00" 
                                        id="minutos_maquina"
                                        onclick="this.select()"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <div class="form-group">
                                {!! Form::label('arch_cam', 'Ruta Archivo CAM:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                {!! Form::text('ruta_cam', null, [
                                    'class' => 'form-control',
                                    'id' => 'mv-arch-cam'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" id="section-medida">
                            <div class="form-group">
                                {!! Form::label('medida', 'Medidas:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;']) !!}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=1 id="checkDefaultMed" name="medidas">
                                    <label class="form-check-label" for="checkDefaultMed">
                                    Comprobado
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="alert" class="mx-3">
                
            </div>

            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
                <button type="submit" class="btn btn-success button-prevent-multiple-submits-3sec" id="m-ver-parte-orden-btn">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script src="{{ asset('js/Ingenieria/Servicios/Ordenes/modal/m-ver-partes-ope.js') }}"></script>