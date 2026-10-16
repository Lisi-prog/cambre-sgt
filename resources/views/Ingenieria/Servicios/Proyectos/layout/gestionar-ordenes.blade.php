<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_trabajo'>
    <div class="card">
        <div class="card-body" >
            <div class="card-title align-items-center" style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 12px;">
                <h5 class="text-center mb-0" style="grid-column: 2;">Orden de Trabajo</h5>
                <button type="button" class="btn btn-success" style="grid-column: 3; justify-self: end;" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                    Nueva Orden
                </button>
            </div>
            <hr>
            <table id="tablaOrdenTrabajo" class="table table-hover mt-2" class="display">
                <thead style="background-color: #558540"  id="cot"><tr>
                    <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                    <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                    <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Supervisor</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Responsable</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha limite</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                    <th class="text-center" scope="col" style="color:#fff;">Horas estimadas</th>
                    <th class="text-center" scope="col" style="color:#fff;">Horas reales</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:6vw;">Acciones</th>
                </tr></thead>
                <tbody id="cuadro-ordenes-trabajo"></tbody>
            </table>
        </div>
    </div>
</div>




<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_trabajo'>
    <div class="card">
        <div class="card-body">
            <div class="card-title align-items-center" style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 12px;">
                <h5 class="text-center mb-0" style="grid-column: 2;">Orden de Manufactura</h5>
            </div>
            <hr>
            <table id="tablaOrdenMan" class="table table-hover mt-2" class="display">
                <thead style="background-color: #982b37" id="comac"><tr>
                    <th class="text-center" scope="col" style="color:#fff;min-width:8vw">Orden</th>
                    <th class="text-center" scope="col" style="color:#fff;">Conjunto Superior</th>
                    <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                    <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                    <th class="text-center" scope="col" style="color:#fff;width:10vw">Progreso Mecanizado</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Supervisor</th>

                    <th class="text-center" scope="col" style="color:#fff; min-width:5vw">Fecha limite</th>
                    <th class="text-center" scope="col" style="color:#fff; min-width:5vw">Fecha finalizacion</th>
                    <th class="text-center" scope="col" style="color:#fff;">Horas estimadas</th>
                    <th class="text-center" scope="col" style="color:#fff;">Horas reales</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:6vw;">Acciones</th>
                </tr></thead>
                <tbody id="cuadro-ordenes-manufactura"></tbody>
            </table>
        </div>
    </div>
</div>




<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_trabajo'>
    <div class="card">
        <div class="card-body">
            <div class="card-title align-items-center" style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 12px;">
                <h5 class="text-center mb-0" style="grid-column: 2;">Orden de Mecanizado</h5>
            </div>
            <hr>
            <table id="tablaOrdenMec" class="table table-hover mt-2" class="display">
                <thead style="background-color: #d37c00" id="comec"><tr>
                    <th class="text-center" scope="col" style="color:#fff;min-width:6vw">Orden</th>
                    <th class="text-center" scope="col" style="color:#fff;">Manufactura</th>
                    <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                    <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Supervisor</th>

                    <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha limite</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                    <th class="text-center" scope="col" style="color:#fff;">Horas estimadas</th>
                    <th class="text-center" scope="col" style="color:#fff;">Horas reales</th>
                    <th class="text-center" scope="col" style="color:#fff;min-width:8vw;">Acciones</th>
                </tr></thead>
                <tbody id="cuadro-ordenes-mecanizado"></tbody>
            </table>
        </div>
    </div>
</div>






<script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>

<script type="module">
    import {cargarModalVerOrden, cargarModalEditarManufactura, cargarModalEditarMecanizado, cargarModalEditarTrabajo} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
    window.cargarModalVerOrden = cargarModalVerOrden;
    window.cargarModalEditarManufactura = cargarModalEditarManufactura;
    window.cargarModalEditarMecanizado = cargarModalEditarMecanizado;
    window.cargarModalEditarTrabajo = cargarModalEditarTrabajo;
</script>
