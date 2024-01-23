@extends('layouts.app')

@section('titulo', 'Crear permiso')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Permiso</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">         

                    {!! Form::open(array('route' => 'permisos.store','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                                <div class="form-group">
                                    <label for="">Nombre del Permiso:</label>                                    
                                    {!! Form::text('name', null, array('class' => 'form-control','style' => 'text-transform:uppercase')) !!}
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
@endsection