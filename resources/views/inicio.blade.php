@extends('layouts.app')

@section('titulo', 'Inicio')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">CAMBRE SGI</h3>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="card col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 p-2" style="">
                            <div class="menu-hover m-auto rounded-4" style="width: 70%">
                                <a class="nav-link" href="{{route('proyecto.indexprefijo', ['PROY', 'Proyectos'])}}" title="Proyectos">
                                <div class="row m-auto text-center" style="">
                                    <i class="fas fa-sitemap m-auto p-2" style="font-size:3.2em;"></i>
                                </div>
                                <div class="row m-auto" style="">
                                    {!! Form::label('proyectos', 'Proyectos', ['class' => 'text-center fs-7 my-auto']) !!}
                                    {{-- 'style' => 'font-size:0.9em;' --}}
                                </div>
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 p-2" style="">
                            <div class="menu-hover m-auto rounded-4" style="width: 70%">
                                <a class="nav-link" href="{{route('proyecto.indexprefijo', ['SSI', 'Servicio de ingenieria'])}}" title="Servicio de ingenieria">
                                <div class="row m-auto text-center" style="">
                                    <i class="fas fa-tape m-auto p-2" style="font-size:3.2em;"></i>
                                </div>
                                <div class="row m-auto" style="">
                                    {!! Form::label('ssi', 'SSI', ['class' => 'text-center fs-7 my-auto', 'style' => '']) !!}
                                </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 p-2" style="">
                            <div class="menu-hover m-auto rounded-4" style="width: 70%">
                                <a class="nav-link" href="{{route('proyecto.indexprefijo', ['TMC', 'Mejora continua'])}}" title="Mejora continua">
                                <div class="row m-auto text-center" style="">
                                    <i class="fas fa-star m-auto p-2" style="font-size:3.2em;"></i>
                                </div>
                                <div class="row m-auto" style="">
                                    {!! Form::label('tmc', 'TMC', ['class' => 'text-center fs-7 my-auto', 'style' => '']) !!}
                                </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 p-2" style="">
                            <div class="menu-hover m-auto rounded-4" style="width: 70%">
                                <a class="nav-link" href="{{route('ordenes.tipo', 1)}}" title="Trabajo">
                                <div class="row m-auto text-center" style="">
                                    <i class="fas fa-tasks m-auto p-2" style="font-size:3.2em;"></i>
                                </div>
                                <div class="row m-auto" style="">
                                    {!! Form::label('trabajo', 'Trabajo', ['class' => 'text-center fs-7 my-auto', 'style' => '']) !!}
                                </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 p-2" style="">
                            <div class="menu-hover m-auto rounded-4" style="width: 70%">
                                <a class="nav-link" href="{{route('ordenes.tipo', 2)}}" title="Manufactura">
                                <div class="row m-auto text-center" style="">
                                    <i class="fas fa-ruler-combined m-auto p-2" style="font-size:3.2em;"></i>
                                </div>
                                <div class="row m-auto" style="">
                                    {!! Form::label('manufactura', 'Manufactura', ['class' => 'text-center my-auto', 'style' => '']) !!}
                                </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 p-2" style="">
                            <div class="menu-hover m-auto rounded-4" style="width: 70%">
                                <a class="nav-link" href="{{route('ordenes.tipo', 3)}}" title="Mecanizado">
                                <div class="row m-auto text-center" style="">
                                    <i class="fas fa-screwdriver m-auto p-2" style="font-size:3.2em;"></i>
                                </div>
                                <div class="row m-auto" style="">
                                    {!! Form::label('mecanizado', 'Mecanizado', ['class' => 'text-center my-auto', 'style' => '']) !!}
                                </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection