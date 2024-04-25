@extends('layouts.app')

@section('titulo', 'Inicio')

@section('content')
    
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">CAMBRE SGI</h3>
        </div>
        <div class="section-body" >
            @include('layouts.modal.mensajes')
            <div style="display:flex;">
                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> --}}
                    {{-- <div class="row my-auto p-0"> --}}
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                            <div class="row"> --}}
                                <ul>
                                    <div style="display:flex; flex-direction:column;  ">
                                    @can('VER-MENU-SERVICIOS')
                                    <div class="row" style="margin-bottom:2vh">
                                        <li class="menu-hover card rounded-4 mx-2" style="height:150px; width:150px; margin:auto">
                                            <div class="m-auto rounded-4">
                                                <a class="nav-link" href="{{route('proyecto.indexprefijo', 2)}}" title="Proyectos">
                                                <div class="row m-auto text-center" style="">
                                                    <i class="fas fa-sitemap m-auto p-2" style="font-size:1.2em;"></i>
                                                </div>
                                                <div class="m-auto " style="">
                                                    {!! Form::label('proyectos', 'Proyectos', ['class' => 'text-center fs-7 my-auto']) !!}
                                                    {{-- 'style' => 'font-size:0.9em;' --}}
                                                </div>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="menu-hover card rounded-4 mx-2" style="display: flex;height:150px; width:150px;margin:auto">
                                            <div class=" m-auto rounded-4" style="">
                                                <a class="nav-link" href="{{route('proyecto.indexprefijo', 3)}}" title="Servicio de ingenieria">
                                                <div class="row m-auto text-center" style="">
                                                    <i class="fas fa-tape m-auto p-2" style="font-size:1.2em;"></i>
                                                </div>
                                                <div class="row m-auto" style="">
                                                    {!! Form::label('ssi', 'SSI', ['class' => 'text-center fs-7 my-auto', 'style' => '']) !!}
                                                </div>
                                                </a>
                                            </div>
                                        </li>
        
                                        <li class="menu-hover card rounded-4 mx-2" style="display: flex; height:150px; width:150px; margin:auto">
                                            <div class=" m-auto rounded-4" style="">
                                                <a class="nav-link" href="{{route('proyecto.indexprefijo', 4)}}" title="Mejora continua">
                                                <div class="row m-auto text-center" style="">
                                                    <i class="fas fa-star m-auto p-2" style="font-size:1.2em;"></i>
                                                </div>
                                                <div class="row m-auto" style="">
                                                    {!! Form::label('tmc', 'TMC', ['class' => 'text-center fs-7 my-auto', 'style' => '']) !!}
                                                </div>
                                                </a>
                                            </div>
                                        </li>
                                    </div>
                                    @endcan
                                    @can('VER-MENU-ORDENES')
                                    <div class="row" style="margin-bottom:2vh">
                                        <li class="menu-hover card rounded-4 mx-2" style="display: flex;height:150px; width:150px; margin:auto">
                                            <div class=" m-auto rounded-4" style="">
                                                <a class="nav-link" href="{{route('ordenes.tipo', 1)}}" title="Trabajo">
                                                <div class="row m-auto text-center" style="">
                                                    <i class="fas fa-tasks m-auto p-2" style="font-size:1.2em;"></i>
                                                </div>
                                                <div class="row m-auto" style="">
                                                    {!! Form::label('trabajo', 'Trabajo', ['class' => 'text-center fs-7 my-auto', 'style' => '']) !!}
                                                </div>
                                                </a>
                                            </div>
                                        </li>
        
                                        <li class="menu-hover card rounded-4 mx-2" style="display: flex; height:150px; width:150px; margin:auto">
                                            <div class=" m-auto rounded-4" style="">
                                                <a class="nav-link" href="{{route('ordenes.tipo', 2)}}" title="Manufactura">
                                                <div class="row m-auto text-center" style="">
                                                    <i class="fas fa-ruler-combined m-auto p-2" style="font-size:1.2em;"></i>
                                                </div>
                                                <div class="row m-auto" style="">
                                                    {!! Form::label('manufactura', 'Manufactura', ['class' => 'text-center my-auto', 'style' => '']) !!}
                                                </div>
                                                </a>
                                            </div>
                                        </li>
                                        {{-- Iconos del mismo tamaño agregando min-width: 8% a los card --}}
                                        <li class="menu-hover card rounded-4 mx-2" style="display: flex; height:150px; width:150px; margin:auto"> 
                                            <div class=" m-auto rounded-4" style="">
                                                <a class="nav-link" href="{{route('ordenes.tipo', 3)}}" title="Mecanizado">
                                                <div class="row m-auto text-center" style="">
                                                    <i class="fas fa-screwdriver m-auto p-2" style="font-size:1.2em;"></i>
                                                </div>
                                                <div class="row m-auto" style="">
                                                    {!! Form::label('mecanizado', 'Mecanizado', ['class' => 'text-center my-auto', 'style' => '']) !!}
                                                </div>
                                                </a>
                                            </div>
                                        </li>
                                    </div>
                                    @endcan
                                    </div>
                                </ul>
                            {{-- </div>
                            
                        </div> --}}
                    {{-- </div> --}}
                {{-- </div> --}}

                {{-- <div class="card col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row my-auto">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <ul class="p-0 my-3">
                                @can('VER-MENU-SERVICIOS')
                                <li style="display: inline-block;">
                                    <div class="menu-hover m-auto rounded-4">
                                        <a class="nav-link" href="{{route('proyecto.indexprefijo', ['PROY', 'Proyectos'])}}" title="Proyectos">
                                        <div class="row m-auto text-center" style="">
                                            <i class="fas fa-sitemap m-auto p-2" style="font-size:1.2em;"></i>
                                        </div>
                                        <div class="row m-auto" style="">
                                            {!! Form::label('proyectos', 'Proyectos', ['class' => 'text-center fs-7 my-auto']) !!}
                                            {{-- 'style' => 'font-size:0.9em;'
                                        </div>
                                        </a>
                                    </div>
                                </li>

                                <li style="display: inline-block;">
                                    <div class="menu-hover m-auto rounded-4">
                                        <a class="nav-link" href="{{route('proyecto.indexprefijo', ['SSI', 'Servicio de ingenieria'])}}" title="Servicio de ingenieria">
                                        <div class="row m-auto text-center" style="">
                                            <i class="fas fa-tape m-auto p-2" style="font-size:1.2em;"></i>
                                        </div>
                                        <div class="row m-auto" style="">
                                            {!! Form::label('ssi', 'SSI', ['class' => 'text-center fs-7 my-auto', 'style' => '']) !!}
                                        </div>
                                        </a>
                                    </div>
                                </li>

                                <li style="display: inline-block;">
                                    <div class="menu-hover m-auto rounded-4">
                                        <a class="nav-link" href="{{route('proyecto.indexprefijo', ['TMC', 'Mejora continua'])}}" title="Mejora continua">
                                        <div class="row m-auto text-center" style="">
                                            <i class="fas fa-star m-auto p-2" style="font-size:1.2em;"></i>
                                        </div>
                                        <div class="row m-auto" style="">
                                            {!! Form::label('tmc', 'TMC', ['class' => 'text-center fs-7 my-auto', 'style' => '']) !!}
                                        </div>
                                        </a>
                                    </div>
                                </li>
                                @endcan
                                @can('VER-MENU-ORDENES')
                                <li style="display: inline-block;">
                                    <div class="menu-hover m-auto rounded-4">
                                        <a class="nav-link" href="{{route('ordenes.tipo', 1)}}" title="Trabajo">
                                        <div class="row m-auto text-center" style="">
                                            <i class="fas fa-tasks m-auto p-2" style="font-size:1.2em;"></i>
                                        </div>
                                        <div class="row m-auto" style="">
                                            {!! Form::label('trabajo', 'Trabajo', ['class' => 'text-center fs-7 my-auto', 'style' => '']) !!}
                                        </div>
                                        </a>
                                    </div>
                                </li>

                                <li style="display: inline-block;">
                                    <div class="menu-hover m-auto rounded-4">
                                        <a class="nav-link" href="{{route('ordenes.tipo', 2)}}" title="Manufactura">
                                        <div class="row m-auto text-center" style="">
                                            <i class="fas fa-ruler-combined m-auto p-2" style="font-size:1.2em;"></i>
                                        </div>
                                        <div class="row m-auto" style="">
                                            {!! Form::label('manufactura', 'Manufactura', ['class' => 'text-center my-auto', 'style' => '']) !!}
                                        </div>
                                        </a>
                                    </div>
                                </li>

                                <li style="display: inline-block;">
                                    <div class="menu-hover m-auto rounded-4">
                                        <a class="nav-link" href="{{route('ordenes.tipo', 3)}}" title="Mecanizado">
                                        <div class="row m-auto text-center" style="">
                                            <i class="fas fa-screwdriver m-auto p-2" style="font-size:1.2em;"></i>
                                        </div>
                                        <div class="row m-auto" style="">
                                            {!! Form::label('mecanizado', 'Mecanizado', ['class' => 'text-center my-auto', 'style' => '']) !!}
                                        </div>
                                        </a>
                                    </div>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        @role('SUPERVISOR')
            @php
                $es_sup = 1;
            @endphp
        @else
            @php
                $es_sup = 0;
            @endphp
        @endrole
        <script>
            
            $(document).ready( function () {
                let es_super = {{$es_sup}};
                if (es_super) {
                    document.getElementById('ayudin').hidden = false;
                    let nombreArchivo = 'supervisor';
                    var url = '{{url('/')}}';
                    $.when($.ajax({
                        type: "post",
                        url: '/documentacion/obtener/'+nombreArchivo, 
                        data: {
                            nombreArchivo: nombreArchivo,
                        },
                        success: function (response) {
                            document.getElementById('ayudin').href = "{{url('/')}}"+'/'+response;
                        },
                        error: function (error) {
                            // console.log(error);
                        }
                    }));
                }
            });
        </script>

    </section>
    
@endsection
