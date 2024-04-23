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

{{-- Ordenes de trabajo del proyecto --}}
<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_trabajo'>
    <div class="card">
        <div class="card-head">
            <br>
            <div class="d-flex justify-content-between">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                    <h5 class="text-center my-auto" onclick="mostrarFiltro('flt_ord_tra')" style="cursor: pointer;">Orden de trabajo <i class="fas fa-filter"></i></h5>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                        Nueva orden
                    </button>
                </div>
            </div>
        </div>
        <div class="card-head" id="flt_ord_tra" hidden>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Etapa:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ote-ckb" name="filter" type="checkbox" value="ot_etapa" checked> (Seleccionar todo)</label>

                                    @foreach ($flt_eta_ord_tra as $item)
                                        <label><input class="input-filter ote-ckb" name="ot_etapa" type="checkbox" value="{{$item}}" checked> {{$item}}</label>
                                    @endforeach
                                    
                                    {{-- @foreach ($proyecto->getEtapas as $etapa)
                                        @foreach ($etapa->getOrden as $orden)
                                            @if ($orden->getOrdenDe->getTipoOrden() == 1)
                                                <label><input class="input-filter ote-ckb" name="ot_etapa" type="checkbox" value="{{$orden->getEtapa->descripcion_etapa}}" checked> {{$orden->getEtapa->descripcion_etapa}}</label>
                                            @endif
                                        @endforeach
                                    @endforeach --}}
                                    {{-- @foreach ($proyecto->getEtapas as $etapa)
                                        <label><input class="input-filter ote-ckb" name="ot_etapa" type="checkbox" value="{{$etapa->descripcion_etapa}}" checked> {{$etapa->descripcion_etapa}}</label>
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Estados:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ote-ckb" name="filter" type="checkbox" value="ot_est" checked> (Seleccionar todo)</label>
                                    @foreach ($flt_estados as $estado)
                                        @if ($estado->id_estado < 9)
                                            <label><input class="ote-ckb" name="ot_est" type="checkbox" value="{{$estado->nombre_estado}}" checked> {{$estado->nombre_estado}}</label>
                                        @else
                                            <label><input class="ote-ckb" name="ot_est" type="checkbox" value="{{$estado->nombre_estado}}"> {{$estado->nombre_estado}}</label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Supervisor:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ote-ckb" name="filter" type="checkbox" value="ot_sup" checked> (Seleccionar todo)</label>
                                    @foreach ($flt_supervisores as $supervisor)
                                        <label><input class="ote-ckb" name="ot_sup" type="checkbox" value="{{$supervisor->nombre_empleado}}" checked> {{$supervisor->nombre_empleado}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Responsable:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ote-ckb" name="filter" type="checkbox" value="ot_res" checked> (Seleccionar todo)</label>
                                    @foreach ($flt_responsables as $responsable)
                                        <label><input class="ote-ckb" name="ot_res" type="checkbox" value="{{$responsable->nombre_empleado}}" checked> {{$responsable->nombre_empleado}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="card-body" >
            {{-- <div class="table-responsive tableFixHead" style="max-height: 400px" id="tabla_de_ordenes_trabajo" > --}}
                <table id="tablaOrdenTrabajo" class="table table-hover mt-2" class="display">
                    <thead style="background-color: #558540"  id="cot">
                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:6vw;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-trabajo">
                        @php 
                            $idCount = 0;
                        @endphp
                        @foreach ($proyecto->getEtapas as $etapa)
                            @foreach ($etapa->getOrden as $orden)
                                @if ($orden->getOrdenDe->getTipoOrden() == 1)
                                @if ($orden->getIdEstado() < 9)
                                    <tr>
                                @else
                                    <tr style="display: none;">
                                @endif   
                                        <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                        <td class='text-center' style="vertical-align: middle;"><abbr title="{{$etapa->descripcion_etapa ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($etapa->descripcion_etapa, 0, 16).'...' ?? "-"}} <i class="fas fa-eye"></i></abbr></td>

                                        {{-- <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td> --}}
                                        
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
                                                <div class="collapse" data-bs-parent="#cuadro-ordenes-trabajo" id="collapseOrdenTrabajo{{$idCount}}">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarTrabajo({{$orden->id_orden}}, '{{$orden->getEtapa->descripcion_etapa}}')">
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
            {{-- </div> --}}
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
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-center  my-auto">
                    <h5 class="text-center  my-auto" onclick="mostrarFiltro('flt_ord_man')" style="cursor: pointer;">Orden de manufactura <i class="fas fa-filter"></i></h5>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-2">
                    {{-- <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                        Nueva orden trabajo
                    </button> --}}
                </div>
            </div>
        </div>
        <div class="card-head" id="flt_ord_man" hidden>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Etapa:</label>
                                </div>
                                
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="om-ckb" name="filter" type="checkbox" value="om_etapa" checked> (Seleccionar todo)</label>

                                    @foreach ($flt_eta_ord_man as $item)
                                        <label><input class="input-filter om-ckb" name="om_etapa" type="checkbox" value="{{$item}}" checked> {{$item}}</label>
                                    @endforeach

                                    {{-- @foreach ($proyecto->getEtapas as $etapa)
                                        @foreach ($etapa->getOrden as $orden)
                                            @if ($orden->getOrdenDe->getTipoOrden() == 2)
                                                <label><input class="input-filter om-ckb" name="om_etapa" type="checkbox" value="{{$orden->getEtapa->descripcion_etapa}}" checked> {{$orden->getEtapa->descripcion_etapa}}</label>
                                            @endif
                                        @endforeach
                                    @endforeach --}}
                                    {{-- @foreach ($proyecto->getEtapas as $etapa)
                                        <label><input class="input-filter ote-ckb" name="ot_etapa" type="checkbox" value="{{$etapa->descripcion_etapa}}" checked> {{$etapa->descripcion_etapa}}</label>
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Estados:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="om-ckb" name="filter" type="checkbox" value="om_est" checked> (Seleccionar todo)</label>
                                    @foreach ($flt_estados_man as $estado)
                                        @if ($estado->id_estado_manufactura < 5)
                                            <label><input class="om-ckb" name="om_est" type="checkbox" value="{{$estado->nombre_estado_manufactura}}" checked> {{$estado->nombre_estado_manufactura}}</label>
                                        @else
                                            <label><input class="om-ckb" name="om_est" type="checkbox" value="{{$estado->nombre_estado_manufactura}}"> {{$estado->nombre_estado_manufactura}}</label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Supervisor:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="om-ckb" name="filter" type="checkbox" value="om_sup" checked> (Seleccionar todo)</label>
                                    @foreach ($flt_supervisores as $supervisor)
                                        <label><input class="om-ckb" name="om_sup" type="checkbox" value="{{$supervisor->nombre_empleado}}" checked> {{$supervisor->nombre_empleado}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Responsable:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="om-ckb" name="filter" type="checkbox" value="om_res" checked> (Seleccionar todo)</label>
                                    @foreach ($flt_responsables as $responsable)
                                        <label><input class="om-ckb" name="om_res" type="checkbox" value="{{$responsable->nombre_empleado}}" checked> {{$responsable->nombre_empleado}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="card-body">
            {{-- <div class="table-responsive tableFixHead"> --}}
                <table id="tablaOrdenMan" class="table table-hover mt-2" class="display">
                    <thead style="background-color: #982b37" id="comac">
                        <th class="text-center" scope="col" style="color:#fff;min-width:8vw">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;width:10vw">Progreso Mecanizado</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff; min-width:5vw">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff; min-width:5vw">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:6vw;">Acciones</th>                                                            
                    </thead>
                    <tbody id="cuadro-ordenes-manufactura">
                        @php 
                            $idCount = 0;
                        @endphp
                        @foreach ($proyecto->getEtapas as $etapa)
                            @foreach ($etapa->getOrden as $orden)
                                @if ($orden->getOrdenDe->getTipoOrden() == 2)
                                    @if ($orden->getIdEstado() < 5)
                                        <tr>
                                    @else
                                        <tr style="display: none;">
                                    @endif     
                                        {{-- <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td> --}}

                                        <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                        <td class='text-center' style="vertical-align: middle;"><abbr title="{{$etapa->descripcion_etapa ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($etapa->descripcion_etapa, 0, 16).'...' ?? "-"}} <i class="fas fa-eye"></i></abbr></td>

                                        <td class= 'text-center' >{{$orden->getEstado()}}</td>

                                        <td class= 'text-center' style="vertical-align: middle;">
                                            <div class="progress position-relative" style="background-color: #b2baf8; z-index:1">
                                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$orden->getOrdenDe->getOrdenesMecanizadoRealizadasPorcentaje()}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$orden->getOrdenDe->getOrdenesMecanizadoRealizadas()}}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class= 'text-center' >{{$orden->getSupervisor()}}</td>

                                        <td class= 'text-center' >{{$orden->getNombreResponsable()}}</td>

                                        {{-- <td class= 'text-center' >{{\Carbon\Carbon::parse($orden->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite ?? '')->format('d-m-Y')}}</td> --}}

                                        <td class= 'text-center' >{{$orden->getFechaLimite() ?? '-'}}</td>

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
                                                <div class="collapse" data-bs-parent="#cuadro-ordenes-manufactura"id="collapseOrdenManufactura{{$idCount}}">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarManufactura({{$orden->id_orden}}, '{{$orden->getEtapa->descripcion_etapa}}')">
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
            {{-- </div> --}}
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
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-center  my-auto">
                    <h5 class="text-center  my-auto" onclick="mostrarFiltro('flt_ord_mec')" style="cursor: pointer;">Orden de mecanizado <i class="fas fa-filter"></i></h5>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-2">
                    {{-- <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOrdenModal">
                        Nueva orden trabajo
                    </button> --}}
                </div>
            </div>
        </div>
        <div class="card-head" id="flt_ord_mec" hidden>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Etapa:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ome-ckb" name="filter" type="checkbox" value="ome_etapa" checked> (Seleccionar todo)</label>

                                    @foreach ($flt_eta_ord_mec as $item)
                                        <label><input class="input-filter ome-ckb" name="ome_etapa" type="checkbox" value="{{$item}}" checked> {{$item}}</label>                                      
                                    @endforeach

                                    {{-- @foreach ($proyecto->getEtapas as $etapa)
                                        @foreach ($etapa->getOrden as $orden)
                                            @if ($orden->getOrdenDe->getTipoOrden() == 3)
                                                <label><input class="input-filter ome-ckb" name="ome_etapa" type="checkbox" value="{{$orden->getEtapa->descripcion_etapa}}" checked> {{$orden->getEtapa->descripcion_etapa}}</label>
                                            @endif
                                        @endforeach
                                    @endforeach --}}
                                    {{-- @foreach ($proyecto->getEtapas as $etapa)
                                        <label><input class="input-filter ote-ckb" name="ot_etapa" type="checkbox" value="{{$etapa->descripcion_etapa}}" checked> {{$etapa->descripcion_etapa}}</label>
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Estados:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ome-ckb" name="filter" type="checkbox" value="ome_est" checked> (Seleccionar todo)</label>
                                    @foreach ($flt_estados_mec as $estado)
                                        @if ($estado->id_estado_mecanizado < 6)
                                            <label><input class="ome-ckb" name="ome_est" type="checkbox" value="{{$estado->nombre_estado_mecanizado}}" checked> {{$estado->nombre_estado_mecanizado}}</label>
                                        @else
                                            <label><input class="ome-ckb" name="ome_est" type="checkbox" value="{{$estado->nombre_estado_mecanizado}}"> {{$estado->nombre_estado_mecanizado}}</label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Supervisor:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ome-ckb" name="filter" type="checkbox" value="ome_sup" checked> (Seleccionar todo)</label>
                                    @foreach ($flt_supervisores as $supervisor)
                                        <label><input class="ome-ckb" name="ome_sup" type="checkbox" value="{{$supervisor->nombre_empleado}}" checked> {{$supervisor->nombre_empleado}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Responsable:</label>
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ome-ckb" name="filter" type="checkbox" value="ome_res" checked> (Seleccionar todo)</label>
                                    @foreach ($flt_responsables as $responsable)
                                        <label><input class="ome-ckb" name="ome_res" type="checkbox" value="{{$responsable->nombre_empleado}}" checked> {{$responsable->nombre_empleado}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="card-body">
            {{-- <div class="table-responsive tableFixHead"> --}}
                <table id="tablaOrdenMec" class="table table-hover mt-2" class="display">
                    <thead style="background-color: #d37c00" id="comec">
                        <th class="text-center" scope="col" style="color:#fff;min-width:6vw">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Manufactura</th>
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:8vw;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-mecanizado">
                        @php
                            $idCount = 0;
                        @endphp
                        @foreach ($proyecto->getEtapas as $etapa)
                            @foreach ($etapa->getOrden as $orden)
                                @if ($orden->getOrdenDe->getTipoOrden() == 3)
                                @if ($orden->getIdEstado() < 6)
                                    <tr>
                                @else
                                    <tr style="display: none;">
                                @endif     
                                        <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                        <td class= 'text-center' >{{$orden->getOrdenMecanizado->getOrdenManufactura->getOrden->nombre_orden ?? '-'}}</td>

                                        <td class='text-center' style="vertical-align: middle;"><abbr title="{{$etapa->descripcion_etapa ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($etapa->descripcion_etapa, 0, 6).'...' ?? "-"}} <i class="fas fa-eye"></i></abbr></td>

                                        <td class= 'text-center' >{{$orden->getEstado()}}</td>

                                        <td class= 'text-center' >{{$orden->getSupervisor()}}</td>

                                        <td class= 'text-center' >{{$orden->getNombreResponsable()}}</td>

                                        {{-- <td class= 'text-center' >{{\Carbon\Carbon::parse($orden->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite ?? '')->format('d-m-Y')}}</td> --}}

                                        <td class= 'text-center' >{{$orden->getFechaLimite() ?? '-'}}</td>

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
                                                <div class="collapse" data-bs-parent="#cuadro-ordenes-mecanizado" id="collapseOrdenMecanizado{{$idCount}}">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarMecanizado({{$orden->id_orden}}, '{{$orden->getEtapa->descripcion_etapa}}')">
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
            {{-- </div> --}}
        </div>
    </div>
</div>
{{-- ------------- --}}

{{-- Ordenes de mantenimiento del proyecto --}}

<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_mantenimiento'>
    <div class="card">
        <div class="card-head">
            <br>
            <div class="d-flex justify-content-between">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-center  my-auto">
                    <h5 class="text-center  my-auto">Orden de mantenimiento</h5>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-2">
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
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;width:17vw;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-mantenimiento">
                        {{-- @foreach ($proyecto->getEtapas as $etapa)
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
                        @endforeach --}}
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
