@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Rol</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                    {!! Form::model($rol, ['method' => 'PATCH','route' => ['roles.update', $rol->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                                <div class="form-group">
                                    <label for="">Nombre del Rol:</label>                                    
                                    {!! Form::text('name', $rol->name, array('class' => 'form-control','style' => 'text-transform:uppercase')) !!}
                                </div>
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="{{ route('roles.index') }}"class="btn btn-danger fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection