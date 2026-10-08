@extends('layouts.app')

@section('titulo', 'Asignar permisos')

@section('content')

<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <h4 class="titulo page__heading my-auto">Asignar Permisos al Rol: {{$rol->name}}</h4>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h6>Seleccione los permisos que para el rol:</h6>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border-end">
                                <h6 class="">Permisos Asignados:</h6>
                                <div class="d-flex flex-column overflow-auto" style="height: 225px;">
                                    <form id="form-permisos" method="POST" action="{{route('roles.guardarpermisos', $rol->id)}}" class="form-prevent-multiple-submits validar">
                                    @csrf
                                        <div class="card-body d-flex flex-column pt-0" id="permisosAsignados">
                                            @foreach($permisosAsignados as $permisoAsignado)
                                                <label id="per{{$permisoAsignado->id}}"><input checked onclick="eliminarPermiso('{{$permisoAsignado->id}}')" class="pe{{$permisoAsignado->id}}" name="permisos[]" type="checkbox" value="{{$permisoAsignado->id}}"> {{$permisoAsignado->name}}</label> 
                                            @endforeach
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <h6 class="">Permisos:</h6>
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
                        </div>
                        <div class="row">
                            <div class="d-flex">
                                <div class="p-2 flex-grow-1"></div>
                                <div class="p-2"><button type="submit" form="form-permisos" class="btn btn-success m-auto">Guardar</button></div>
                                <div class="p-2"><a href="{{ route('roles.index') }}"class="btn btn-danger">Cancelar</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/Informatica/GestionUsuarios/Rol/asignar-rol.js') }}?v={{ filemtime(public_path('js/Informatica/GestionUsuarios/Rol/asignar-rol.js')) }}"></script>
<script>
    $(document).ready(function () {
        var url = '{{route('roles.index')}}';
        document.getElementById('volver').href = url;
    });
</script>
@endsection
