@extends('layouts.app')

@section('titulo', 'Asignar permisos')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            {{-- <h3 class="page__heading">Empresa - Rubro - Asignar</h3> --}}
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                <h4 class="titulo my-auto">Asignar Permisos a Roles</h4>    
            </div>
            <div class="col-lg-5 my-auto">
            </div>
            <div class="col-lg-2 my-auto">
                {{-- <a href="{{ route('rubros.empresa') }}" class="btn btn-dark my-1" Style="width: 80%">Volver</a> --}}
            </div> 
            {{-- {{$rubrosAsignadosLista}} --}}
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="pb-2">Rol: {{$rol->name}} </h5>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
                                    <input id="buscarpermiso" name="permisos" type="text" class="form-control" placeholder="Buscar Permiso" aria-label="Recipient's username" aria-describedby="button-addon2">
                                </div>
                                {{-- <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 my-auto">
                                    {!! Form::submit('Buscar', ['class' => 'btn btn-primary mr-2']) !!}
                                </div> --}}
                            </div>
                            <div class="row pt-3">
                                <h6>Seleccione los permisos que tiene el rol:</h6>
                            </div>
                            <div class="row">
                                <div class="d-flex flex-row align-items-start justify-content-around mb-3 w-100">
                                    <div class="card-body ms-2 d-flex flex-column" style="height: 250px;width:60%">
                                        <div class="">
                                            <label>Permisos:</label>
                                        </div>
                                        <div id="permisosParaAsignar" class="d-flex flex-column overflow-auto" style="height: 225px;">
                                            @foreach($permisos as $permiso)
                                                @php
                                                    $bandera = array_search($permiso->id, $listaPermisos);
                                                    
                                                    if(in_array($permiso->id, $listaPermisos)){
                                                        $bandera = true;
                                                    }else{
                                                        $bandera = false;
                                                    }

                                                @endphp
                                                
                                                @if ($bandera)
                                                    <label id='{{$permiso->id}}'><input checked onclick="agregarPermiso('{{$permiso->id}}','{{$permiso->name}}')" class="radiockeck{{$permiso->id}}" name="" type="checkbox" value="{{$permiso->id}}"> {{$permiso->name}} </label>
                                                @else
                                                    <label id='{{$permiso->id}}'><input onclick="agregarPermiso('{{$permiso->id}}','{{$permiso->name}}')" class="radiockeck{{$permiso->id}}" name="" type="checkbox" value="{{$permiso->id}}"> {{$permiso->name}} </label>
                                                @endif
                                                
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="card me-3  mt-3 " style="background-color: rgb(255, 255, 255);height: 225px; width:100% ">
                                        <h6 class="card-title ms-4 mt-4 pb-0 mb-2">Permisos Asignados</h6>
                                        {!! Form::open([
                                            'method' => 'POST',
                                            'route' => ['roles.guardarpermisos', $rol->id],
                                            'style' => 'display:inline',
                                            'class' => 'validar'
                                        ]) !!}
                                        <div class="overflow-auto">
                                            <div class="card-body d-flex flex-column pt-0" id="permisosAsignados">
                                                @foreach($permisosAsignados as $permisoAsignado)
                                                    <label id="per{{$permisoAsignado->id}}"><input checked onclick="eliminarPermiso('{{$permisoAsignado->id}}')" class="pe{{$permisoAsignado->id}}" name="permisos[]" type="checkbox" value="{{$permisoAsignado->id}}"> {{$permisoAsignado->name}}</label> 
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-5">
    
                                    </div>
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col-12">
                                                {!! Form::submit('Guardar', ['class' => 'btn btn-success m-auto', 'style' => 'width: 40%']) !!}
                                                {!! Form::close() !!} 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex">
                                        <div class="ms-auto">
                                            <a href="{{ route('roles.index') }}"class="btn btn-primary">Volver</a>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                                        
                        </div>
                    </div>  
                </div>     
            </div>
        </div>
    </section>

    <script src="{{ asset('js/Informatica/GestionUsuarios/Rol/asignar-rol.js') }}"></script>
    <script>
        $(document).ready(function () {
            var url = '{{route('roles.index')}}';
            //url = url.replace(':id_servicio', id_servicio);
            document.getElementById('volver').href = url;
        });
    </script>
@endsection