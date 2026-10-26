<?php

namespace App\Services\Mantenimiento;

class ValidarTareasParte
{
    public static function validar(array $contexto, array $tareas, array $generales, bool $completo): array
    {
        foreach ($contexto['preventivas'] as $preventiva) {
            $enviadas = collect($generales)->where('tarea_mant', $preventiva['id_tarea_mantenimiento']);
            if ($enviadas->count() !== 1 || ($completo && empty($enviadas->first()['hecho']))) {
                throw new \InvalidArgumentException('Debe conservar y realizar todas las tareas preventivas seleccionadas para completar el parte.');
            }
        }
        foreach ($tareas as $tarea) {
            if (!collect($contexto['elementos'])->contains(function ($elemento) use ($tarea) {
                return ($tarea['tarea_mant'] ?? '') === $elemento['id_zona'].'-'.$elemento['id_zona_tarea'];
            })) {
                throw new \InvalidArgumentException('Seleccione un elemento y una zona tarea asociados al activo.');
            }
        }
        foreach ($generales as $tarea) {
            if (empty($tarea['tarea_mant']) || !collect(array_merge($contexto['preventivas'], $contexto['generales']))->contains('id_tarea_mantenimiento', $tarea['tarea_mant'])) {
                throw new \InvalidArgumentException('Seleccione una tarea de mantenimiento asociada al activo o a su tipo.');
            }
        }
        $todas = array_merge($tareas, $generales);
        if ($completo && (empty($todas) || collect($todas)->contains(function ($tarea) { return empty($tarea['hecho']); }))) {
            throw new \InvalidArgumentException('Debe realizar todas las tareas para completar el parte.');
        }
        return $todas;
    }
}
