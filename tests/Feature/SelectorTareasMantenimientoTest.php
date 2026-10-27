<?php

namespace Tests\Feature;

use Tests\TestCase;

class SelectorTareasMantenimientoTest extends TestCase
{
    public function test_selector_admite_tareas_sin_zona_ni_ejecucion(): void
    {
        $html = view('Ingenieria.Servicios.Mantenimiento.Partes.ishikawa_select', [
            'acciones' => collect(),
            'zonas' => collect(),
            'maquinas' => collect(),
            'elementos' => collect(),
            'tareas_mantenimiento' => collect([(object) [
                'id_activo' => null,
                'id_tipo_activo' => null,
                'id_tarea_mantenimiento' => 7,
                'nombre_tarea' => 'Verificar mantenimiento',
                'getZonaTarea' => null,
                'getEjecucion' => null,
            ]]),
        ])->render();

        $this->assertStringContainsString('value="7">Verificar mantenimiento</option>', $html);
    }
}
