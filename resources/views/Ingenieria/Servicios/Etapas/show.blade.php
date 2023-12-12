@extends('layouts.app')
@section('content')
<style>
     .tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        height: 500px; /* gives an initial height of 200px to the table */
      }
      .tableFixHead thead th {
        position: sticky; /* make the table heads sticky */
        top: 0px; /* table head will be placed from the top of the table and sticks to it */
      }
      #viv table {
        border-collapse: collapse; /* make the table borders collapse to each other */
        width: 100%;
      }
      /* #viv th,
      #viv td {
        padding: 8px 16px;
        border: 1px solid #ccc;
      }*/
      #viv th {
        background: #ee9b27;
      }
</style>
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Ver Etapa</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion del Requerimiento de ingenieria --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Etapa</h5></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('id_etapa', "ID:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('id_etapa', $etapa, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}

                                        {{-- {!! Form::text('fecha_carga',\Carbon\Carbon::parse($Req_ing->getSolicitud->fecha_carga)->format('d-m-Y H:i:s'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!} --}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="form-group">
                                        {!! Form::label('nom_etapa', 'Nombre etapa:', ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_etapa', $etapa, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    {!! Form::label('desc_etapa', "Descripcion de la etapa:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <textarea id='desc_etapa' class="form-control" rows="54" cols="54" style="resize:none; height: 30vh; width: 108vh" readonly>{{$etapa}}</textarea>
                                </div>
                                {{-- @if (!is_null($Req_ing->getSolicitud->descripcion_urgencia))
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        {!! Form::label('descrip_urg', "Descripcion urgencia:", ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <textarea id='descrip_urg' class="form-control" rows="54" cols="54" style="resize:none; height: 40vh" readonly>{{$Req_ing->getSolicitud->descripcion_urgencia ?? ''}}</textarea>
                                    </div>
                                @endif --}}
                                <div class="table-responsive">
                                    <table class="table table-striped mt-2" id="example">
                                        <thead style="height:50px;">
                                            {{-- <th class='text-center' style="color:#fff;">Prioridad</th> --}}
                                            {{-- <th class='text-center' style="color:#fff;">Fecha</th> --}}
                                            <th class='ml-3 text-center' style="color:#fff;">ID</th>
                                            <th class='text-center' style="color:#fff;">Nombre</th>
                                            <th class='text-center' style="color:#fff;">Tipo etapa</th>
                                            {{-- <th class='text-center' style="color:#fff;">Tipo etapa</th> --}}
                                            <th class='text-center' style="color:#fff;">Lider</th>
                                            <th class='text-center' style="color:#fff;">Estado</th>
                                            <th class='text-center' style="color:#fff;">Fecha inicio</th>
                                            <th class='text-center' style="color:#fff;">Fecha limite</th>
                                            <th class='text-center' style="color: #fff;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            {{--@foreach ($etapas as $etapa)
                                                <tr>
                                                    <td class='text-center' style="vertical-align: middle;">{{$etapa->codigo_servicio}}</td>
        
                                                    <td class='text-center' style="vertical-align: middle;">{{$etapa->nombre_servicio}}</td>
        
                                                    <td class='text-center' style="vertical-align: middle;">{{$etapa->getSubTipoServicio->nombre_subtipo_servicio}}</td>
        
                                                    <td class='text-center' style="vertical-align: middle;">{{$etapa->getResponsabilidad->getEmpleado->nombre_empleado}}</td>
        
                                                    <td class='text-center' style="vertical-align: middle;">{{$etapa->getPrioridad->nombre_prioridad}}</td>
        
                                                    <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($etapa->getPrioridad->fecha_inicio)->format('d-m-Y')}}</td>
        
                                                    <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($etapa->getPrioridad->fecha_limite)->format('d-m-Y')}}</td>
        
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['etapas.show', $etapa->id_servicio], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Ver', ['class' => 'btn btn-danger w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                            <div class="col-6">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['etapas.show', $etapa->id_servicio], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Evaluar', ['class' => 'btn btn-warning w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </td>
        {{--
                                                    @if (is_null($Ri->getSolicitud->fecha_requerida))
                                                    <td class='text-center' style="vertical-align: middle;">Sin fecha</td>
                                                    @else
                                                        <td class='text-center' style="vertical-align: middle;">{{\Carbon\Carbon::parse($Ri->getSolicitud->fecha_requerida)->format('d-m-Y')}}</td>
                                                    @endif
                                                    
        
                                                    <td class='text-center' style="vertical-align: middle;">{{$Ri->getSolicitud->getEstadoSolicitud->nombre_estado_solicitud}}</td>
        
                                                    <td class='text-center' style="vertical-align: middle;">{{$Ri->getSolicitud->getPrioridadSolicitud->nombre_prioridad_solicitud}}</td>
        
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-6">{!! Form::open(['method' => 'GET', 'route' => ['ri.evaluar', $Ri->id_requerimiento_de_ingenieria], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-danger w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                            <div class="col-6">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['ri.evaluar', $Ri->id_requerimiento_de_ingenieria], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Evaluar', ['class' => 'btn btn-warning w-100']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </td> 
                                                </tr>
                                            @endforeach--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                {{-- ------------- --}}


                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        {{-- (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong> --}}
                                    </div>
                                    <div class="p-1">
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => 'etapas.index', 'style' => '']) !!}
                                        {!! Form::submit('Volver', ['class' => 'btn btn-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{{-- @include('layouts.modal.confirmation') --}}
@endsection

@section('js')

@endsection