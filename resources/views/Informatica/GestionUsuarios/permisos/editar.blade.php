@extends('layouts.app')

@section('titulo', 'Editar permiso')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Permiso</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-7">
                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <div class="card-body">
                        
                        {!! Form::model($permiso, ['method' => 'PATCH',
                        'style'=>'text-transform:uppercase;','route' => ['permisos.update', $permiso->id]]) !!} 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Nombre del Permiso:</label>                                    
                                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>       
                            </div>
                            <button type="submit" class="btn btn-success mr-2">Guardar</button>
                            <a href="{{ route('permisos.index') }}"class="btn btn-danger fo">Volver</a>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            var url = '{{route('permisos.index')}}';
            //url = url.replace(':id_servicio', id_servicio);
            document.getElementById('volver').href = url;
        });
    </script>
@endsection