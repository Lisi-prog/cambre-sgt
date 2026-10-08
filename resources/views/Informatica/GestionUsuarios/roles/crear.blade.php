@extends('layouts.app')

@section('titulo', 'Crear Rol')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Rol</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="card">
                    <div class="card-body">         
                        <form method="POST" action="{{route('roles.store')}}" class="form-prevent-multiple-submits">
                        @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Nombre del Rol:</label>    
                                        <input class="form-control" style="text-transform:uppercase" name="name" type="text" id="name">
                                    </div>
                                </div>       
                            </div>
                            <button type="submit" class="btn btn-success mr-2 button-prevent-multiple-submits">Guardar</button>
                            <a href="{{ route('roles.index') }}"class="btn btn-danger fo">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        var url = '{{route('roles.index')}}';
        //url = url.replace(':id_servicio', id_servicio);
        document.getElementById('volver').href = url;
    });
</script>
@endsection