<!-- Modal -->
<div class="modal fade" id="verEditarMulti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="">Operacion - Carga Multiple</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="nom-modal-body-ver-ope">          
                <div class="row rounded" id="nom-m-ver-ope-div">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div style="min-height: 300px; max-height: 300px; overflow-y: auto; overflow-x: auto;">
                                <table class="table table-hover table-sm">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Proyecto</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Operacion</th>
                                    </thead>
                                    <tbody id="nom_body_ope">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="det-tab" data-bs-toggle="tab" data-bs-target="#parte-multi" type="button" role="tab" onclick="">Parte</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="det_adju_tab" data-bs-toggle="tab" data-bs-target="#editar-multi" type="button" role="tab" onclick="">Editar</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="parte-multi" role="tabpanel">
                            <div class="row rounded" id="npm-m-ver-parte-div">
                                {!! Form::open(['route' => 'ope.parte.multiple', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits-3sec parte-multi-ope', 'id' => 'npm-form-multi']) !!}
                                {!! Form::text('ids[]', null, ['class' => 'form-control', 'hidden', 'id' => 'm-parte-multiple-ids']) !!}
                                
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
                                            <select class="form-select" id="m-ver-parte-ope-estado" name="estado">
                                                {{-- <option selected="selected" value="">Seleccionar</option> --}}
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
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                        <button type="submit" class="btn btn-success button-prevent-multiple-submits-3sec">Guardar</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>  
                        </div>
                        <div class="tab-pane fade" id="editar-multi" role="tabpanel">
                            <div class="row">
                                <h6 class="mt-1 py-2 sub_titulo_m text-center">Editar Multiple</h6>
                                {!! Form::open(['route' => 'ope.edit.multiple', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits-3sec edit-multi-ope', 'id' => 'nom-form-multi']) !!}
                                {!! Form::text('ids[]', null, ['class' => 'form-control', 'hidden', 'id' => 'm-edit-multiple-ids']) !!}
                                <div class="row">
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        <div class="form-group">
                                            {!! Form::label('prioridad', 'Prioridad Operacion:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                            {!! Form::number('prioridad', null, [
                                                'class' => 'form-control',
                                                'min' => 1,
                                                'id' => 'nom_prioridad'
                                                ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                        <button type="submit" class="btn btn-success button-prevent-multiple-submits-3sec">Guardar</button>
                                    </div>
                                </div>
                                
                                {!! Form::close() !!}
                            </div>     
                        </div> 
                    </div>
                    
                </div>
            </div>

            <div id="alert-edit" class="mx-3">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            
        </div>
    </div>
</div>

<script>
    function DeseleccionarTodo(){
        document.querySelectorAll('input[type="checkbox"][name="id_ope[]"]').forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }
</script>

<script> 
    $(document).ready(function() {
        $('#verEditarMulti').on('hidden.bs.modal', function (e) {
            document.getElementById('nom_prioridad').value = '';

            let valores = [...document.querySelectorAll('input[name="id_ope[]"]:checked')].map(input => input.value);

            $.ajax({
                type: "post",
                url: '/orden/obtener-info-ope-mul-act',
                data: {
                    id: valores,
                },
                success: function (response) {
                    console.log(response)
                    response.forEach(e => {
                        let fila = $('#example tbody tr[data-id="' + e.id_ope_de_hdr + '"]');
                        let rowIndex = table.row(fila).index();

                        table.cell(rowIndex, 2).data(e.prioridad ?? 'S/P').draw();
                        table.cell(rowIndex, 8).data(e.nombre_estado_hdr).draw();

                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
            DeseleccionarTodo();
            document.getElementById('m-ver-parte-ope-estado').innerHTML = '';
        });
    });
  </script>