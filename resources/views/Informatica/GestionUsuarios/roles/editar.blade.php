@extends('layouts.app')

@section('titulo', 'Editar rol')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Rol</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{route('roles.update', $rol->id)}}" class="form-prevent-multiple-submits">
                        @csrf
                        @method('PATCH')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Nombre del Rol:</label>      
                                        <input class="form-control" style="text-transform:uppercase" name="name" type="text" id="name" value="{{$rol->name}}">
                                    </div>
                                </div>       
                            </div>
                            <button type="submit" class="btn btn-success mr-2">Guardar</button>
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
        document.getElementById('volver').href = url;
    });
</script>
@endsection