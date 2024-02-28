<style>
.table {
    zoom: 100%;
}
table.dataTable tbody td {
    padding: 0px 10px;
}
.col-4 {
    padding: 5px;
}
.col-5 {
    padding: 5px;
}
</style>
@php
    $orden_de_trabajo = Config::get('myconfig.orden_de_trabajo');
@endphp
{{-- Ordenes de trabajo del proyecto --}}
<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_trabajo'>
    <div class="card">
        <div class="card-head">
            <br>
            <div class="d-flex justify-content-between">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                   {{-- <h5 id="label-orden-trabajo" class="text-center  my-auto">Orden de trabajo <i class="fas fa-caret-down"></i></h5> --}}
                   <h5 class="text-center  my-auto">Orden de trabajo</h5>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                        Nueva orden
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body" >
            <div class="table-responsive" id="tabla_de_ordenes_trabajo">
                <div>
                <table id="example" class="table table-hover mt-2" class="display">
                    <thead style="background-color: #558540">
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                        <th class="text-center" scope="col" style="color:#fff;width:17vh;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-trabajo">
                        @php 
                            $idCount = 0;
                        @endphp
                        @foreach ($proyecto->getEtapas as $etapa)
                            @foreach ($etapa->getOrden as $orden)
                                @if ($orden->getOrdenDe->getTipoOrden() == 1)
                                    <tr>    
                                        <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td>

                                        <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                        <td class= 'text-center' >{{$orden->getEstado()}}</td>
                                        
                                        <td class= 'text-center' >{{$orden->getSupervisor()}}</td>

                                        <td class= 'text-center' >{{$orden->getNombreResponsable()}}</td>

                                        {{-- <td class= 'text-center' >{{$orden->getPartes->sortByDesc('id_parte_trabajo')->first()->fecha_limite ? \Carbon\Carbon::parse($orden->getPartes->sortByDesc('id_parte_trabajo')->first()->fecha_limite ?? '')->format('d-m-Y') : '-'}}</td> --}}

                                        <td class= 'text-center' >{{$orden->getFechaLimite() ?? '-'}}</td>

                                        <td class= 'text-center' >{{$orden->getFechaFinalizacion()}}</td>

                                        <td class= 'text-center' >{{$orden->costo_estimado}}</td>
                                                
                                        <td class= 'text-center' >{{$orden->getCostoRealGuardado()}}</td>

                                        <td>
                                            <div class="row justify-content-center" >
                                                <div class="row justify-content-center" >
                                                    <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenTrabajo{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenTrabajo{{$idCount}}">
                                                        Opciones
                                                    </button>
                                                </div>
                                                <div class="collapse" id="collapseOrdenTrabajo{{$idCount}}">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarTrabajo({{$orden->id_orden}}, '{{$orden->nombre_orden}}')">
                                                                Editar
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, {{$orden->getOrdenDe->getTipoOrden()}})">
                                                                Partes
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            {!! Form::open(['method' => 'GET', 'route' => ['orden.eliminar', $orden->id_orden], 'style' => 'display:inline', 'onclick' => "return confirm('¿Está seguro que desea BORRAR la orden y sus partes?');"]) !!}
                                                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @php 
                                    $idCount += 1;
                                @endphp
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ------------- --}}

{{-- Ordenes de manufactura del proyecto --}}

<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_trabajo'>
    <div class="card">
        <div class="card-head">
            <br>
            <div class="d-flex justify-content-between">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                    <h5 class="text-center  my-auto">Orden de manufactura</h5>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                    {{-- <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                        Nueva orden trabajo
                    </button> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div>
                <table id="example" class="table table-hover mt-2" class="display">
                    <thead style="background-color: #982b37">
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Progreso Mecanizado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                        <th class="text-center" scope="col" style="color:#fff;width:17vh;">Acciones</th>                                                            
                    </thead>
                    <tbody id="cuadro-ordenes-trabajo">
                        @php 
                            $idCount = 0;
                        @endphp
                        @foreach ($proyecto->getEtapas as $etapa)
                            @foreach ($etapa->getOrden as $orden)
                                @if ($orden->getOrdenDe->getTipoOrden() == 2)
                                    <tr>    
                                        <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td>

                                        <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                        <td class= 'text-center' >{{$orden->getEstado()}}</td>

                                        <td class= 'text-center' style="vertical-align: middle;">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$orden->getOrdenDe->getOrdenesMecanizadoRealizadasPorcentaje()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><span style="color: #ffffff">{{$orden->getOrdenDe->getOrdenesMecanizadoRealizadas()}}</span></div>
                                            </div>
                                        </td>

                                        <td class= 'text-center' >{{$orden->getSupervisor()}}</td>

                                        <td class= 'text-center' >{{$orden->getNombreResponsable()}}</td>

                                        <td class= 'text-center' >{{\Carbon\Carbon::parse($orden->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite ?? '')->format('d-m-Y')}}</td>

                                        <td class= 'text-center' >{{$orden->getFechaFinalizacion()}}</td>

                                        <td class= 'text-center' >{{$orden->costo_estimado}}</td>
                                                
                                        <td class= 'text-center' >{{$orden->getCostoRealGuardado()}}</td>

                                        <td>
                                            <div class="row justify-content-center" >
                                                <div class="row justify-content-center" >
                                                    <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenManufactura{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenManufactura{{$idCount}}">
                                                        Opciones
                                                    </button>
                                                </div>
                                                <div class="collapse" id="collapseOrdenManufactura{{$idCount}}">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarManufactura({{$orden->id_orden}}, '{{$orden->nombre_orden}}')">
                                                                Editar
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-12">
                                                            {!! Form::open(['method' => 'GET', 'route' => ['ordenes.manufacturamecanizado', $orden->id_orden], 'style' => '']) !!}
                                                                {!! Form::submit('Agregar mecanizado', ['class' => 'btn btn-success w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, {{$orden->getOrdenDe->getTipoOrden()}})">
                                                                Partes
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-12">
                                                            {!! Form::open(['method' => 'GET', 'route' => ['orden.eliminar', $orden->id_orden], 'style' => 'display:inline', 'onclick' => "return confirm('¿Está seguro que desea BORRAR la orden y sus partes?');"]) !!}
                                                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @php 
                                    $idCount += 1;
                                @endphp
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ------------- --}}

{{-- Ordenes de mecanizado del proyecto --}}

<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_trabajo'>
    <div class="card">
        <div class="card-head">
            <br>
            <div class="d-flex justify-content-between">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                    <h5 class="text-center  my-auto">Orden de mecanizado</h5>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                    {{-- <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                        Nueva orden trabajo
                    </button> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div>
                <table id="example" class="table table-hover mt-2" class="display">
                    <thead style="background-color: #d37c00">
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Manufactura</th>
                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                        <th class="text-center" scope="col" style="color:#fff;width:17vh;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-trabajo">
                        @php
                            $idCount = 0;
                        @endphp
                        @foreach ($proyecto->getEtapas as $etapa)
                            @foreach ($etapa->getOrden as $orden)
                                @if ($orden->getOrdenDe->getTipoOrden() == 3)
                                    <tr>    
                                        <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td>

                                        <td class= 'text-center' >{{$orden->getOrdenMecanizado->getOrdenManufactura->getOrden->nombre_orden ?? '-'}}</td>

                                        <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                        <td class= 'text-center' >{{$orden->getEstado()}}</td>

                                        <td class= 'text-center' >{{$orden->getSupervisor()}}</td>

                                        <td class= 'text-center' >{{$orden->getNombreResponsable()}}</td>

                                        <td class= 'text-center' >{{\Carbon\Carbon::parse($orden->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite ?? '')->format('d-m-Y')}}</td>

                                        <td class= 'text-center' >{{$orden->getFechaFinalizacion()}}</td>

                                        <td class= 'text-center' >{{$orden->costo_estimado}}</td>
                                                
                                        <td class= 'text-center' >{{$orden->getCostoRealGuardado()}}</td>
                                        
                                        <td class='text-center'>
                                            <div class="row justify-content-center" >
                                                <div class="row justify-content-center" >
                                                    <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrdenMecanizado{{$idCount}}" aria-expanded="false" aria-controls="collapseOrdenMecanizado{{$idCount}}">
                                                        Opciones
                                                    </button>
                                                </div>
                                                <div class="collapse" id="collapseOrdenMecanizado{{$idCount}}">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarMecanizado({{$orden->id_orden}}, '{{$orden->nombre_orden}}')">
                                                                Editar
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, {{$orden->getOrdenDe->getTipoOrden()}})">
                                                                Partes
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            {!! Form::open(['method' => 'GET', 'route' => ['orden.eliminar', $orden->id_orden], 'style' => 'display:inline', 'onclick' => "return confirm('¿Está seguro que desea BORRAR la orden y sus partes?');"]) !!}
                                                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @php
                                $idCount += 1;
                                @endphp
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ------------- --}}

{{-- Ordenes de mantenimiento del proyecto --}}

<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_trabajo'>
    <div class="card">
        <div class="card-head">
            <br>
            <div class="d-flex justify-content-between">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                    <h5 class="text-center  my-auto">Orden de mantenimiento</h5>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                    {{-- <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                        Nueva orden trabajo
                    </button> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div>
                <table id="example" class="table table-hover mt-2" class="display">
                    <thead style="background-color: #5e4879">
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;width:17vh;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-trabajo">
                        @foreach ($proyecto->getEtapas as $etapa)
                            @foreach ($etapa->getOrden as $orden)
                                @if ($orden->getOrdenDe->getTipoOrden() == 4)
                                    <tr>    
                                        <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td>

                                        <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                        <td class= 'text-center' >{{$orden->getEstado()}}</td>

                                        <td class= 'text-center' >{{$orden->getNombreResponsable()}}</td>

                                        <td class='text-center'>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-primary w-100" onclick="window.crearCuadrOrdenes({{$etapa->id_etapa}})">
                                                        Editar
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, {{$orden->getOrdenDe->getTipoOrden()}})">
                                                        Partes
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    {!! Form::open(['method' => 'GET', 'route' => ['orden.eliminar', $orden->id_orden], 'style' => 'display:inline', 'onclick' => "return confirm('¿Está seguro que desea BORRAR la orden y sus partes?');"]) !!}
                                                            {!! Form::submit('Eliminar', ['class' => 'btn btn-danger w-100']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ------------- --}}
<script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
<script type="module"> 
    import {cargarModalVerOrden, cargarModalEditarManufactura, cargarModalEditarMecanizado, cargarModalEditarTrabajo} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
    window.cargarModalVerOrden = cargarModalVerOrden;
    window.cargarModalEditarManufactura = cargarModalEditarManufactura;
    window.cargarModalEditarMecanizado = cargarModalEditarMecanizado;
    window.cargarModalEditarTrabajo = cargarModalEditarTrabajo;
</script>
