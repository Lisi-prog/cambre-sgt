@extends('layouts.app')

@section('titulo', 'Editar usuario')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Usuario</h3>
        </div>

        {!! Form::model($user, ['method' => 'PATCH', 'class' => 'formulario','route' => ['usuarios.update', $user->id]]) !!} 

        <div class="section-body row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                @include('layouts.modal.mensajes')
                <div class="card">
                    <div class="card-body">

                        <div class="row ">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">

                                    {!! Form::label('Nombre :') !!}
                                    {!! Form::text('name', $user->name, ['type' => 'text', 'class' => 'form-control', 'placeholder' => '']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('email', 'E-mail :') !!}
                                    {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('password', 'Password :') !!}
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('confirm-password', 'Confirmar Password :') !!}
                                    {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="submit" class="btn btn-success mr-2">Guardar</button>
                                <a href="{{ route('usuarios.index') }}"class="btn btn-danger fo">Cancelar</a>
                                {{-- @can('CREAR-USUARIO')
                                {!! Form::button('Guardar', ['onclick' => 'clickSubmit()', 'class' => 'btn btn-warning mr-2']) !!}
                                {!! Form::submit('Guardar', ['id' => 'submit', 'class' => 'd-none']) !!}
                                {!! link_to_route(
                                    'usuarios.index',
                                    $title = 'Volver',
                                    $parameters = [],
                                    $attributes = ['class' => 'btn btn-secondary fo'],
                                ) !!}
                                @endcan --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                <div class="card">
                    <div class="card-body">

                        <div class="row ">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="card  border border-3 border-primary border-opacity-75 rounded">
                                    <div class="d-flex flex-row align-items-center justify-content-around ">
                                        <div>
                                            <h5 class="card-header m-0 p-0 ms-4">Permisos</h5>
                                        </div>
                                        <div
                                            class="d-flex flex-row col-xs-10 col-sm-8 col-md-10 align-items-center justify-content-end">
                                                <input id="buscarpermiso" type="text" class="form-control" placeholder="Buscar Permiso" aria-label="Recipient's username" aria-describedby="button-addon2" style ='text-transform:uppercase;' onkeyup = 'javascript:this.value=this.value.toUpperCase()'>
                                            {{-- {!! Form::text('nameper', null, [
                                                'placeholder' => 'Buscar',
                                                'class' => 'form-control col-sm-8 mr-2',
                                                'style' => 'text-transform:uppercase;',
                                                'onkeypress' => 'buscarpermisosnombre()',
                                                'id' => 'nameper',
                                            ]) !!} --}}
                                            {{-- {!! Form::button('Buscar', ['onclick' => 'buscarroles(1)', 'class' => 'btn btn-secondary']) !!} --}}
                                        </div>
                                    </div>

                                    <br>
                                    <h6 class="ms-3 card-title mb-0 ml-2">Seleccione los permisos que va a tener la persona:
                                    </h6>
                                    <div class="d-flex flex-row align-items-start justify-content-around mb-3">
                                        <div class="card-body ms-2 d-flex flex-column" id="lista_roles" style="height: 250px;width:50%">
                                            {{-- <div class="ms-auto d-flex align-items pb-3">
                                                {{ Form::checkbox('checkpermisos', null, false, ['id' => 'checkpermisos','onclick' => 'seleccionarpermisostodos()', 'class' => 'me-2 name']) }}
                                                <div>  Selec All</div>
                                            </div> --}}
                                            <div id="view-permisos-s" class="d-flex flex-column overflow-auto"
                                                style="height: 225px;">
                                                <br>
                                                {{-- @foreach ($permisos as $value)
                                                    <label
                                                        id="2{{ $value->name }}">{{ Form::checkbox('permisos10[]', $value->id, false, ['onclick' => 'agregarpermiso(' . $value->id . ',"' . $value->name . '",2)', 'class' => 'name permisos10 permisoscheck'.$value->id]) }}
                                                        {{ $value->name }}</label>
                                                @endforeach --}}
                                            </div>
                                        </div>

                                        <div class="card me-3  mt-3 " style="background-color: rgb(255, 255, 255);height: 225px; width:100% ">
                                            <h6 class="card-title ms-4 mt-4 pb-0 mb-2">Permisos</h6>
                                            <div class="overflow-auto">
                                                <div class="card-body d-flex flex-column pt-0" id="lista_permisos2">
                                                    @foreach ($userPermisos as $value)
                                                        <label id="p{{ $value->id}}"><input checked onclick="eliminarPermiso({{ $value->id }},'{{ $value->name }}')" class="name me-2 pcheck{{ $value->id }}" name="permisos[]" type="checkbox" value="{{ $value->id }}"> {{ $value->name }}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="card border border-3 border-danger border-opacity-75 rounded">
                                    <div class="d-flex flex-row align-items-center justify-content-around ">
                                        <div>
                                            <h5 class="card-header m-0 p-0 ms-4">Roles</h5>
                                        </div>
                                        <div
                                            class="d-flex flex-row col-xs-10 col-sm-8 col-md-10 align-items-center justify-content-end">
                                            {!! Form::text('namerol', null, [
                                                'placeholder' => 'Buscar rol',
                                                'class' => 'form-control col-sm-8 mr-2',
                                                'style' => 'text-transform:uppercase;',
                                                'onkeypress' => 'buscarroles(1)',
                                                'id' => 'namerol',
                                            ]) !!}
                                            {{-- {!! Form::button('Buscar', ['onclick' => 'buscarroles(1)', 'class' => 'btn btn-secondary']) !!} --}}
                                        </div>
                                    </div>
                                    <br>
                                    <h6 class="ms-3 card-title mb-0 ml-3">Seleccione los roles que va a tener la persona:
                                    </h6>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                            <div class="card-body " id="lista_roles">
                                                <div id="rolles">
                                                    @php
                                                        $bandera = false;
                                                    @endphp
                                                    <table >
                                                        <tbody id="radio" class="d-flex flex-column overflow-auto" style="height: 200px;width:200px">
                                                            @foreach ($roles as $val)
                                                                <tr id="trradio{{ $val->id }}">
                                                                    <td style="width: 90%"><label>
                                                                            {{ Form::radio('roless', $val->id, false, ['onclick' => 'buscarpermisos(' . $val->id . ');handleRadioClick(this)', 'id' => 'rr' . $val->id, 'class' => 'name ']) }}
                                                                            {{ $val->name }}</label></td>
                                                                    <td>
                                                                @foreach ($userRoles as $rol)
                                                                    @if ($val->name == $rol)
                                                                        {{ Form::checkbox('roles[]', $val->id, true, ['id' => 'r' . $val->id, 'onclick' => '', 'class' => 'name']) }}
                                                                        @php
                                                                            $bandera = true;
                                                                        @endphp
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                                @if (!$bandera)
                                                                    {{ Form::checkbox('roles[]', $val->id, false, ['id' => 'r' . $val->id, 'disabled' => 'disabled', 'onclick' => '', 'class' => 'name']) }}
                                                                @endif
                                                                @php
                                                                    $bandera = false;
                                                                @endphp
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="card mx-2  mt-3 "  style="background-color: rgb(255, 255, 255); height: 225px; width:98% ">
                                                {{-- <div class="ms-auto d-flex align-items-center me-3 mt-3">
                                                    {{ Form::checkbox('checkpermisosrol', null, false, ['id' => 'checkpermisosrol','onclick' => 'seleccionarpermisos()', 'class' => 'me-2 name']) }}
                                                    <div> Selec All</div></div> --}}

                                                <h6 class="card-title ms-4 ">Permisos</h6>
                                                <div class="overflow-auto ">
                                                    <div class="card-body m-0 p-0" id="lista_permisos" >
                                                        <div id="permisos" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {!! Form::close() !!}
        <script src="{{ asset('js/Informatica/GestionUsuarios/Usuario/editar-usuario.js') }}"></script>
    </section>
    <script>
        $(document).ready(function () {
            var url = '{{route('usuarios.index')}}';
            //url = url.replace(':id_servicio', id_servicio);
            document.getElementById('volver').href = url;
        });
    </script>
@endsection
