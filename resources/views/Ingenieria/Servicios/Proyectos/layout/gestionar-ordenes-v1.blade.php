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
                                    <label>Etapa:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('ot_etapa', this)">
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ote-ckb" name="filter" type="checkbox" value="ot_etapa" checked> (Seleccionar todo)</label>

                                    @foreach ($flt_eta_ord_tra as $item)
                                        <label><input class="input-filter ote-ckb flt_x_eta" name="ot_etapa" type="checkbox" value="{{$item}}" checked> {{$item}}</label>
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
                                    <label>Estados:</label> <input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('ot_est', this)">
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
                                    <label>Supervisor:</label> <input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('ot_sup', this)">
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ote-ckb" name="filter" type="checkbox" value="ot_sup" checked> (Seleccionar todo)</label>
                                    @foreach ($filtros['supervisores_trabajo'] as $supervisor)
                                        <label><input class="ote-ckb" name="ot_sup" type="checkbox" value="{{$supervisor}}" checked> {{$supervisor}}</label>
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
                                    <label>Responsable:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('ot_res', this)">
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ote-ckb" name="filter" type="checkbox" value="ot_res" checked> (Seleccionar todo)</label>
                                    @foreach ($filtros['responsables_trabajo'] as $responsable)
                                        <label><input class="ote-ckb" name="ot_res" type="checkbox" value="{{$responsable}}" checked> {{$responsable}}</label>
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
                        <th class="text-center" scope="col" style="color:#fff;">Horas estimadas</th>
                        <th class="text-center" scope="col" style="color:#fff;">Horas reales</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:6vw;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-trabajo">
                        @php 
                            $idCount = 0;
                        @endphp
                        @foreach ($ordenes_trabajo as $orden)
                            @if ($orden->id_estado < 9)
                                <tr>
                            @else
                                <tr style="display: none;">
                            @endif   
                                    <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                    <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->descripcion_etapa ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 16).'...' ?? "-"}} <i class="fas fa-eye"></i></abbr></td>
                                    
                                    <td class= 'text-center' >{{$orden->nombre_estado}}</td>
                                    
                                    <td class= 'text-center' >{{$orden->supervisor}}</td>

                                    <td class= 'text-center' >{{$orden->responsable}}</td>

                                    <td class= 'text-center' >{{$orden->fecha_limite}}</td>

                                    <td class= 'text-center' >{{$orden->fecha_finalizacion}}</td>

                                    <td class= 'text-center' >{{$orden->horas_estimada}}</td>
                                            
                                    <td class= 'text-center' >{{$orden->horas_real}}</td>

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
                                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarTrabajo({{$orden->id_orden}}, '{{$orden->descripcion_etapa}}')">
                                                            Editar
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, 1)">
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
                            @php 
                                $idCount += 1;
                            @endphp
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
                                    <label>Etapa:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('om_etapa', this)">
                                </div>
                                
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="om-ckb" name="filter" type="checkbox" value="om_etapa" checked> (Seleccionar todo)</label>

                                    @foreach ($flt_eta_ord_man as $item)
                                        <label><input class="input-filter om-ckb flt_x_eta" name="om_etapa" type="checkbox" value="{{$item}}" checked> {{$item}}</label>
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
                                    <label>Estados:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('om_est', this)">
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
                                    <label>Supervisor:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('om_sup', this)">
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="om-ckb" name="filter" type="checkbox" value="om_sup" checked> (Seleccionar todo)</label>
                                    @foreach ($filtros['supervisores_manufactura'] as $supervisor)
                                        <label><input class="om-ckb" name="om_sup" type="checkbox" value="{{$supervisor}}" checked> {{$supervisor}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Responsable:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('om_res', this)">
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="om-ckb" name="filter" type="checkbox" value="om_res" checked> (Seleccionar todo)</label>
                                    @foreach ($filtros['responsables_manufactura'] as $responsable)
                                        <label><input class="om-ckb" name="om_res" type="checkbox" value="{{$responsable}}" checked> {{$responsable}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
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
                        {{-- <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Responsable</th> --}}
                        <th class="text-center" scope="col" style="color:#fff; min-width:5vw">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff; min-width:5vw">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Horas estimadas</th>
                        <th class="text-center" scope="col" style="color:#fff;">Horas reales</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:6vw;">Acciones</th>                                                            
                    </thead>
                    <tbody id="cuadro-ordenes-manufactura">
                        @php 
                            $idCount = 0;
                        @endphp
                        @foreach ($ordenes_manufactura as $orden)
                            @if ($orden->id_estado < 5)
                                <tr>
                            @else
                                <tr style="display: none;">
                            @endif     

                                <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->descripcion_etapa ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 16).'...' ?? "-"}} <i class="fas fa-eye"></i></abbr></td>

                                <td class= 'text-center' >{{$orden->nombre_estado}}</td>

                                <td class= 'text-center' style="vertical-align: middle;">
                                    <div class="progress position-relative" style="background-color: #b2baf8; z-index:1">
                                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$orden->tot_mec_porcentaje}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            <span class="justify-content-center d-flex position-absolute w-100" style="color: #ffffff">{{$orden->tot_mec_completo}} / {{$orden->tot_mec}}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class= 'text-center' >{{$orden->supervisor}}</td>

                                {{-- <td class= 'text-center' >{{$orden->responsable}}</td> --}}

                                <td class= 'text-center' >{{$orden->fecha_limite}}</td>

                                <td class= 'text-center' >{{$orden->fecha_finalizacion}}</td>

                                <td class= 'text-center' >{{$orden->horas_estimada ?? '00:00'}}</td>
                                        
                                <td class= 'text-center' >{{$orden->horas_real ?? '00:00'}}</td>

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
                                                    <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#verProgOrdenManModal" onclick="cargarModalProgreso({{$orden->id_orden}})">
                                                        Progreso
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarManufactura({{$orden->id_orden}}, '{{$orden->descripcion_etapa}}')">
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
                                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, 2)">
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
                            @php 
                                $idCount += 1;
                            @endphp
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
                                    <label>Etapa:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('ome_etapa', this)">
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ome-ckb" name="filter" type="checkbox" value="ome_etapa" checked> (Seleccionar todo)</label>

                                    @foreach ($flt_eta_ord_mec as $item)
                                        <label><input class="input-filter ome-ckb flt_x_eta" name="ome_etapa" type="checkbox" value="{{$item}}" checked> {{$item}}</label>                                      
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
                                    <label>Estados:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('ome_est', this)">
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
                                    <label>Supervisor:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('ome_sup', this)">
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ome-ckb" name="filter" type="checkbox" value="ome_sup" checked> (Seleccionar todo)</label>
                                    @foreach ($filtros['supervisores_mecanizado'] as $supervisor)
                                        <label><input class="ome-ckb" name="ome_sup" type="checkbox" value="{{$supervisor}}" checked> {{$supervisor}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="row">
                        <div class="d-flex flex-row align-items-start justify-content-around">
                            <div class="card-body d-flex flex-column" style="height: 170px;">
                                <div class="">
                                    <label>Responsable:</label><input type="search" class="mx-2" placeholder="Buscar" onkeyup="fil_filtro('ome_res', this)">
                                </div>
                                <div class="d-flex flex-column overflow-auto">
                                    <label style="font-style: italic"><input class="ome-ckb" name="filter" type="checkbox" value="ome_res" checked> (Seleccionar todo)</label>
                                    @foreach ($filtros['responsables_mecanizado'] as $responsable)
                                        <label><input class="ome-ckb" name="ome_res" type="checkbox" value="{{$responsable}}" checked> {{$responsable}}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
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
                        {{-- <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Responsable</th> --}}
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:5vw">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Horas estimadas</th>
                        <th class="text-center" scope="col" style="color:#fff;">Horas reales</th>
                        <th class="text-center" scope="col" style="color:#fff;min-width:8vw;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-mecanizado">
                        @php
                            $idCount = 0;
                        @endphp
                        @foreach ($ordenes_mecanizado as $orden)
                            @if ($orden->id_estado < 5)
                                <tr>
                            @else
                                <tr style="display: none;">
                            @endif     
                                    <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                    <td class= 'text-center' >{{$orden->nombre_manufactura ?? '-'}}</td>

                                    <td class='text-center' style="vertical-align: middle;"><abbr title="{{$orden->descripcion_etapa ?? '-'}}" style="text-decoration:none; font-variant: none;">{{substr($orden->descripcion_etapa, 0, 6).'...' ?? "-"}} <i class="fas fa-eye"></i></abbr></td>

                                    <td class= 'text-center' >{{$orden->nombre_estado}}</td>

                                    <td class= 'text-center' >{{$orden->supervisor}}</td>

                                    {{-- <td class= 'text-center' >{{$orden->responsable}}</td> --}}

                                    <td class= 'text-center' >{{$orden->fecha_limite ?? '-'}}</td>

                                    <td class= 'text-center' >{{$orden->fecha_finalizacion}}</td>

                                    <td class= 'text-center' >{{$orden->horas_estimada}}</td>
                                            
                                    <td class= 'text-center' >{{$orden->horas_real}}</td>
                                    
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
                                                        {!! Form::open(['method' => 'GET', 'route' => ['ordenes.hdr', $orden->id_orden], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('HDR', ['class' => 'btn btn-info w-100']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editarOrdenModal" onclick="cargarModalEditarMecanizado({{$orden->id_orden}}, '{{$orden->descripcion_etapa}}')">
                                                            Editar
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}}, 3)">
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
                            @php
                            $idCount += 1;
                            @endphp
                        @endforeach
            
                    </tbody>
                </table>
            {{-- </div> --}}
        </div>
    </div>
</div>
{{-- ------------- --}}

{{-- Ordenes de mantenimiento del proyecto --}}

{{-- <div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_mantenimiento'>
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
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
{{-- ------------- --}}
<script type="module" src="{{ asset('js/Ingenieria/Servicios/Proyectos/modal/crear-form.js') }}"></script>
<script src="{{ asset('js/filter-to-filter.js') }}"></script>
<script type="module"> 
    import {cargarModalVerOrden, cargarModalEditarManufactura, cargarModalEditarMecanizado, cargarModalEditarTrabajo} from '../../js/Ingenieria/Servicios/Proyectos/modal/crear-form.js';
    window.cargarModalVerOrden = cargarModalVerOrden;
    window.cargarModalEditarManufactura = cargarModalEditarManufactura;
    window.cargarModalEditarMecanizado = cargarModalEditarMecanizado;
    window.cargarModalEditarTrabajo = cargarModalEditarTrabajo;
</script>
