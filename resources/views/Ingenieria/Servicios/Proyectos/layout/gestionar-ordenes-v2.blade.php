{{-- Ordenes del proyecto --}}
<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes' hidden>
    <div class="card">
        <div class="card-head">
            <br>
            <div class="d-flex justify-content-between">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 my-auto">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 mx-auto">
                            <select class="form-select" id="orden" name="orden">
                                <option selected="selected" value="">Seleecionar</option>
                                <option value="1">Ordenes de trabajo</option>
                                <option value="2">Ordenes de manufactura</option>
                                <option value="3">Ordenes de mecanizado</option>
                                <option value="4">Ordenes de mantenimiento</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input class="form-control" name="id_etapa" type="text" id="id_estapa" hidden>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                        Nueva orden
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div>
                <table id="tabladeordenes" class="table table-hover mt-2" class="display">
                    <thead style="">
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Tipo orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes">
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ------------- --}}

<script>
    $(function(){
        $('#orden').on('change', cambiarTablaOrdenes);
    });

    function cambiarTablaOrdenes(){
        let tabla = document.getElementById('cuadro-ordenes');
        let html_orden = '';
        let numero_etapa = document.getElementById("id_estapa");
        let id_etapa = numero_etapa.value;
        let tipo_orden = Number($(this).val());

        $.when($.ajax({
            type: "post",
            url: '/orden/obtener-orden-etapa-tipo/'+id_etapa+'/'+tipo_orden, 
            data: {
                id_etapa: id_etapa,
            },
            success: function (response) {
                let boton_ordenes = '';
                response.forEach(element => {
                if (element.numero_tipo == 2) {
                    boton_ordenes = `<div class="row my-2">
                                            <div class="col-12"> 
                                                <form method="GET" action="http://localhost:8080/orden/manufactura_mecanizado/`+element.id_orden+`" accept-charset="UTF-8" style="display:inline">
                                                    <input class="btn btn-danger w-100" type="submit" value="Agregar mecanizados">
                                                </form>
                                            </div> 
                                        </div>
                    `
                }
                
                html_orden += `<tr>
                                    <td class= "text-center"> `+element.etapa+`</td> 
                                    <td class= "text-center"> `+element.orden+`</td> 
                                    <td class= "text-center">`+element.tipo+`</td>
                                    <td class= "text-center">`+element.estado+`</td>
                                    <td class= "text-center">`+element.supervisor+`</td>
                                    <td class= "text-center">`+element.responsable+`</td> 
                                    <td class= "text-center">`+element.fecha_limite+`</td> 
                                    <td class= "text-center">`+element.fecha_finalizacion+`</td>
                                    <td class= "text-center">
                                        <div class="row my-2"> 
                                            <div class="col-12"> 
                                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#verOrdenModal" onclick="cargarModalVerOrden(`+element.id_orden+`,`+element.numero_tipo+`)">
                                                    Ver orden
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-12"> 
                                                <button type="button" class="btn btn-warning w-100" onclick="window.obtenerPartes(`+element.id_orden+`)">
                                                    Ver partes
                                                </button> 
                                            </div> 
                                        </div>`+boton_ordenes+` 
                                    </td> 
                                </tr>`;
                boton_ordenes = '';
            });
                tabla.innerHTML = html_orden;
            },
            error: function (error) {
                console.log(error);
            }
        }));
    }

</script>