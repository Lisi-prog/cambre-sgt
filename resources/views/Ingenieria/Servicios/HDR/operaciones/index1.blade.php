@extends('layouts.app')
@section('titulo', 'Operaciones de hdr')
@section('content')
<table id="example" class="table table-striped table-bordered w-100">
    <thead>
        <tr>
            <th>Prioridad</th>
            <th>Servicio</th>
            <th>Operación</th>
            <th>Estado</th>
            <th>Máquina</th>
            <th>Acciones</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function () { 
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('hdr.operaciones.datatable') }}",
                dataSrc: function (json) {
                    console.log('Respuesta completa del server:', json);
                    console.log('Filas:', json.data);
                    return json.data; // IMPORTANTE
                }
            },
            pageLength: 25,
            order: [],
            columns: [
                { data: 'prioridad', name: 'prioridad' },
                { data: 'codigo_servicio', name: 'codigo_servicio' },
                { data: 'nombre_operacion', name: 'nombre_operacion' },
                { data: 'nombre_estado_hdr', name: 'nombre_estado_hdr' },
                // { data: 'codigo_maquinaria', name: 'codigo_maquinaria' },
                { data: 'acciones', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection