@php
    $preventiva = $tipo !== 'correctiva';
    $id = $tarea->id_tarea_mantenimiento;
    $inputId = $tipo.'_tarea_'.$id;
@endphp
<tr>
    <td>
        <div class="form-check">
            <input type="checkbox" name="tareas_mantenimiento[]" value="{{ $id }}" id="{{ $inputId }}"
                class="form-check-input {{ $preventiva ? 'check-tarea' : '' }}" data-id="{{ $id }}">
        </div>
    </td>
    <td>
        <div class="form-check">
            <label for="{{ $inputId }}" class="form-check-label">{{ $tarea->nombre_tarea }}</label>
        </div>
    </td>
    @if ($preventiva)
        <td><input type="number" name="duracion_{{ $id }}" class="form-control input-tarea w-100" data-id="{{ $id }}" placeholder="Días" disabled></td>
        <td><input type="number" name="cant_golpes_{{ $id }}" class="form-control input-tarea w-100" data-id="{{ $id }}" placeholder="Golpes" disabled></td>
        @if ($tipo === 'preventiva_activo')
            <td><input type="date" name="fecha_ultima_ejecucion_{{ $id }}" class="form-control input-tarea w-100" data-id="{{ $id }}" disabled></td>
        @endif
    @endif
</tr>
