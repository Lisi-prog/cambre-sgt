{{-- Ordenes de trabajo del proyecto --}}
                
<div class="col-xs-12 col-sm-12 col-md-12" id='cuadro_de_ordenes_de_trabajo'>
    <div class="card">
        <div class="card-head">
            <br>
            <div class="d-flex justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-center  my-auto">
                   {{-- <h5 id="label-orden-trabajo" class="text-center  my-auto">Orden de trabajo <i class="fas fa-caret-down"></i></h5> --}}
                   <h5 class="text-center  my-auto">Orden de trabajo</h5>
                </div>
            </div>
        </div>
        <div class="card-body" >
            <div class="table-responsive" id="tabla_de_ordenes_trabajo">
                <div>
                <table id="example" class="table table-hover mt-2" class="display">
                    <thead style="">
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-trabajo">
                        @foreach ($proyecto->getEtapas as $etapa)
                            @foreach ($etapa->getOrden as $orden)
                                @if ($orden->getOrdenDe->getTipoOrden() == 1)
                                    <tr>    
                                        <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td>

                                        <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                        <td class= 'text-center' >{{$orden->getEstado()}}</td>
                                        
                                        <td class= 'text-center' >{{$orden->getSupervisor()}}</td>

                                        <td class= 'text-center' >{{$orden->getNombreResponsable()}}</td>

                                        <td class= 'text-center' >{{\Carbon\Carbon::parse($orden->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite ?? '')->format('d-m-Y')}}</td>

                                        <td class= 'text-center' >{{$orden->getFechaFinalizacion()}}</td>

                                        <td class= 'text-center' >{{$orden->getCostoEstimado()}}</td>
                                                
                                        <td class= 'text-center' >{{$orden->getCostoReal()}}</td>

                                        <td class='text-center'>
                                            <div class="row my-2">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}})">
                                                        Ver partes
                                                    </button>
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
                    <thead style="">
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo estimado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Costo real</th>
                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Acciones</th>                                                            
                    </thead>
                    <tbody id="cuadro-ordenes-trabajo">
                        @foreach ($proyecto->getEtapas as $etapa)
                            @foreach ($etapa->getOrden as $orden)
                                @if ($orden->getOrdenDe->getTipoOrden() == 2)
                                    <tr>    
                                        <td class= 'text-center' >{{$etapa->descripcion_etapa}}</td>

                                        <td class= 'text-center' >{{$orden->nombre_orden}}</td>

                                        <td class= 'text-center' >{{$orden->getEstado()}}</td>

                                        <td class= 'text-center' >{{$orden->getSupervisor()}}</td>

                                        <td class= 'text-center' >{{$orden->getNombreResponsable()}}</td>

                                        <td class= 'text-center' >{{\Carbon\Carbon::parse($orden->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite ?? '')->format('d-m-Y')}}</td>

                                        <td class= 'text-center' >{{$orden->getFechaFinalizacion()}}</td>

                                        <td class= 'text-center' >{{$orden->getCostoEstimado()}}</td>
                                                
                                        <td class= 'text-center' >{{$orden->getCostoReal()}}</td>

                                        <td class= 'text-center' >
                                            <div class="row my-2">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}})">
                                                        Ver partes
                                                    </button>
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
                    <thead style="">
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
                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Acciones</th>                                                           
                    </thead>
                    <tbody id="cuadro-ordenes-trabajo">
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

                                        <td class= 'text-center' >{{$orden->getCostoEstimado()}}</td>
                                                
                                        <td class= 'text-center' >{{$orden->getCostoReal()}}</td>
                                        
                                        <td class='text-center'>
                                            <div class="row my-2">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}})">
                                                        Ver partes
                                                    </button>
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
                    <thead style="">
                        <th class="text-center" scope="col" style="color:#fff;">Etapa</th>
                        <th class="text-center" scope="col" style="color:#fff;">Orden</th>
                        <th class="text-center" scope="col" style="color:#fff;">Estado</th>
                        <th class="text-center" scope="col" style="color:#fff;">Supervisor</th>
                        <th class="text-center" scope="col" style="color:#fff;">Responsable</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha limite</th>
                        <th class="text-center" scope="col" style="color:#fff;">Fecha finalizacion</th>
                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Acciones</th>                                                           
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
                                            <div class="row my-2">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#verPartesModal" onclick="cargarModalVerPartes({{$orden->id_orden}})">
                                                        Ver partes
                                                    </button>
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

{{-- <script>
    $(function(){
        $('#label-orden-trabajo').on('click', mostrarTablaTrabajo);
    });

    const etiqueta = document.getElementById('label-orden-trabajo');

    etiqueta.addEventListener('mouseover', () => {
        etiqueta.style.cursor = 'pointer';
    });

    etiqueta.addEventListener('mouseout', () => {
        etiqueta.style.cursor = 'default';
    }); 

    function mostrarTablaTrabajo(){
        let cuadro_oculto_de_ordenes = document.getElementById('tabla_de_ordenes_trabajo');
        if ($('#tabla_de_ordenes_trabajo').is(":hidden")) {
            cuadro_oculto_de_ordenes.hidden = false;
        }else{
            cuadro_oculto_de_ordenes.hidden = true;
        }
    }
</script> --}}