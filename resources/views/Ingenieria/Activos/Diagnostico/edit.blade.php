@extends('layouts.app')

@section('titulo', 'Editar Diagnóstico')

@section('content')
<section class="section">
    <div class="section-header">
        <h5 class="titulo page__heading my-auto">Editar Diagnóstico</h5>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Editar'])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('diagnostico.update', $diagnostico->id_diagnostico) }}" class="formulario form-prevent-multiple-submits">
                            @csrf
                            @method('PUT')
                            @include('Ingenieria.Activos.Diagnostico._form')
                            <div class="d-flex align-items-center pt-3">
                                <div class="me-auto">(<span class="obligatorio">*</span>) Obligatorio</div>
                                <button type="submit" class="btn btn-success me-1 button-prevent-multiple-submits">Guardar</button>
                                <a href="{{ route('diagnostico.index') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        document.getElementById('volver').href = @json(route('diagnostico.index'));
    });
</script>
@endsection

