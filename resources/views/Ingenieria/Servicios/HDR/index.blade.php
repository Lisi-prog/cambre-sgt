@extends('layouts.app')
@section('titulo', 'Hoja de Ruta')
@section('content') 
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
</style>
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Hoja de Ruta</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')

                {{-- Informacion del proyecto --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                {!! Form::label('orden', "Orden:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('tipo', "Tipo:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('tipo', $orden->getOrdenDe->getNombreTipoOrden() ?? '', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('nombre-orden', "Nombre:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nombre-orden', $orden->nombre_orden, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('responsable', "Responsable:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('responsable', $orden->getNombreResponsable(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('supervisor', "Supervisor:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('supervisor', $orden->getSupervisor(), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Hoja de ruta --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 my-auto text-center">
                                    <h5 class="text-center">Hojas de Ruta</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearHdr">
                                        Nuevo
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="example" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Codigo</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Fecha</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:25%;">Observaciones</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Acciones</th>                                                           
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($orden->getPartes as $parte)
                                        <tr>
                                            <td class= 'text-center' style="vertical-align: middle;">{{$parte->id_parte}}</td>

                                            <td class= 'text-center'style="vertical-align: middle;">{{$parte->observaciones}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">{{$parte->fecha}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">{{ $parte->fecha_limite ?? '-'}}</td>

                                            
                                            <td class= 'text-center' style="vertical-align: middle;">{{$parte->getParteDe->getNombreEstado()}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">{{$parte->horas}}

                                            @if ($orden->getOrdenDe->getTipoOrden() == 3)
                                                <td class= 'text-center' style="vertical-align: middle;">{{$parte->getParteDe->getParteMecxMaq->first()->getMaquinaria->codigo_maquinaria ?? '-'}}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{$parte->getParteDe->getParteMecxMaq->first()->horas_maquina ?? '-'}}</td>
                                            @endif
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Hoja de ruta --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 my-auto text-center">
                                    <h5 class="text-center">Operaciones</h5>
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-2">
                                    <button type="button" class="btn btn-success col-9" data-bs-toggle="modal" data-bs-target="#crearOpe">
                                        Nuevo
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table id="example" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Cod. HDR</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">N°</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Fecha</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Asignado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%">Maquina</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%">Operacion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%">Estado</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Horas</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Medidas</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($orden->getPartes as $parte)
                                        <tr>
                                            <td class= 'text-center' style="vertical-align: middle;">{{$parte->id_parte}}</td>

                                            <td class= 'text-center'style="vertical-align: middle;">{{$parte->observaciones}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">{{$parte->fecha}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">{{ $parte->fecha_limite ?? '-'}}</td>

                                            
                                            <td class= 'text-center' style="vertical-align: middle;">{{$parte->getParteDe->getNombreEstado()}}</td>

                                            <td class= 'text-center' style="vertical-align: middle;">{{$parte->horas}}

                                            @if ($orden->getOrdenDe->getTipoOrden() == 3)
                                                <td class= 'text-center' style="vertical-align: middle;">{{$parte->getParteDe->getParteMecxMaq->first()->getMaquinaria->codigo_maquinaria ?? '-'}}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{$parte->getParteDe->getParteMecxMaq->first()->horas_maquina ?? '-'}}</td>
                                            @endif
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}
                
            </div>
        </div>
    </section>
    @include('Ingenieria.Servicios.HDR.modal.crear-hdr')
    @include('Ingenieria.Servicios.HDR.modal.crear-ope')
    <script>
        $(document).ready(function () {
            let tipo_orden = document.getElementById('tipo_orden').value;
            var url = '{{route('ordenes.tipo',':tipo_orden')}}';
            url = url.replace(':tipo_orden', tipo_orden);
            document.getElementById('volver').href = url;
            $('#example').DataTable({
                language: {
                        lengthMenu: 'Mostrar _MENU_ registros por pagina',
                        zeroRecords: 'No se ha encontrado registros',
                        info: 'Mostrando pagina _PAGE_ a _PAGES_ de _TOTAL_',
                        infoEmpty: 'No se ha encontrado registros',
                        infoFiltered: '(Filtrado de _MAX_ registros totales)',
                        search: 'Buscar',
                        paginate:{
                            first:"Prim.",
                            last: "Ult.",
                            previous: 'Ant.',
                            next: 'Sig.',
                        },
                    },
                    order: [[0, 'asc']],
                    "pageLength": 25
            });
        });
    </script>
@endsection
