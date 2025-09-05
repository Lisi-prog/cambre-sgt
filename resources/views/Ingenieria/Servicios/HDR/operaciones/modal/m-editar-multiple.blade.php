<!-- Modal -->
<div class="modal fade" id="verEditarMulti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="">Editar Operacion Multiple</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="nom-modal-body-ver-ope">          
                <div class="row rounded" id="nom-m-ver-ope-div">
                    {!! Form::open(['route' => 'ope.edit.multiple', 'method' => 'POST', 'class' => 'formulario form-prevent-multiple-submits-3sec edit-multi-ope', 'id' => 'nom-form-multi']) !!}
                    {!! Form::text('ids[]', null, ['class' => 'form-control', 'hidden', 'id' => 'm-edit-multiple-ids']) !!}
                    <div class="row">
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div style="min-height: 300px; max-height: 300px; overflow-y: auto; overflow-x: auto;">
                                <table class="table table-hover">
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
                </div>
            </div>

            <div id="alert-edit" class="mx-3">
                
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

                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
            DeseleccionarTodo();
        });
    });
  </script>