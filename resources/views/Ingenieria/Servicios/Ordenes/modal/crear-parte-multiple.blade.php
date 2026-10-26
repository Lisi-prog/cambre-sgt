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
                    <form method="POST" action="{{ route('partes.guardar.multiple') }}" class="formulario form-prevent-multiple-submits-3sec" id="npm-form-multi">
                @csrf
                    <input type="hidden" name="ids[]" value="" class="form-control" id="m-parte-multiple-ids">
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
                                <label for="observaciones" class="control-label fs-7" style="white-space: nowrap; ">Observaciones:</label>
                                <span class="obligatorio">*</span>
                                <textarea name='observaciones' id="npm-observaciones" maxlength="500" class="form-control" rows="54" cols="54" style="resize:none; height: 20vh" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label for="estado" class="control-label fs-7" style="white-space: nowrap;">Estado:</label>
                                <span class="obligatorio">*</span>

                                                                <select class="form-select" id="npm-m-ver-parte-estado" name="estado">

                                                                    <option selected="selected" value="">Seleccionar</option>

                                                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label for="fecha" class="control-label fs-7" style="white-space: nowrap;">Fecha:</label>
                                            <span class="obligatorio">*</span>
                                <input type="date" name="fecha" value="{{ old('fecha', \Carbon\Carbon::now()->format('Y-m-d')) }}" min="2023-01-01" max="{{ \Carbon\Carbon::now()->year . '-12-31' }}" id="npm-fecha" class="form-control" required>
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
                </form>
                </div>
            </div>

            <div id="alert-mp" class="mx-3">

            </div>

            <div class="modal-footer">
                <button type="submit" form="npm-form-multi" class="btn btn-success button-prevent-multiple-submits-3sec" id="">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>

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

            let valores = [...document.querySelectorAll('input[name="id_ordenes[]"]:checked')].map(input => input.value);
            let opcion = document.getElementById('opcion-tipo').value;

            $.ajax({
                type: "post",
                url: '/orden/obtener-mul-orden-act',
                data: {
                    id: valores,
                    opcion: opcion
                },
                success: function (response) {
                    response.forEach(e => {
                        let fila = $('#example tbody tr[data-id="' + e.id_orden + '"]');
                        let rowIndex = table.row(fila).index();

                        table.cell(rowIndex, 7).data(e.nombre_estado).draw();
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

  <script>
    function DeseleccionarTodo(){
        document.querySelectorAll('input[type="checkbox"][name="id_ordenes[]"]').forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }
</script>