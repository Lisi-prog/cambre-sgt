<?php

namespace Tests\Unit;

use App\Services\Mantenimiento\ValidarTareasParte;
use PHPUnit\Framework\TestCase;

class ValidarTareasParteTest extends TestCase
{
    public function test_permite_tareas_sin_zona_ni_ejecucion(): void
    {
        $contexto = ['elementos' => [], 'preventivas' => [], 'generales' => [
            ['id_tarea_mantenimiento' => 7, 'id_zona_tarea' => null, 'id_ejecucion' => null],
        ]];
        $tareas = [['tarea_mant' => 7, 'hecho' => 'on']];
        $this->assertSame($tareas, ValidarTareasParte::validar($contexto, [], $tareas, true));
    }

    public function test_permite_guardar_preventiva_pendiente_sin_completar_parte(): void
    {
        $contexto = ['elementos' => [], 'preventivas' => [['id_tarea_mantenimiento' => 7]], 'generales' => []];
        $tareas = [['tarea_mant' => 7]];
        $this->assertSame($tareas, ValidarTareasParte::validar($contexto, [], $tareas, false));
    }

    public function test_impide_completar_parte_con_preventiva_sin_realizar(): void
    {
        $contexto = ['elementos' => [], 'preventivas' => [['id_tarea_mantenimiento' => 7]], 'generales' => []];
        $this->expectException(\InvalidArgumentException::class);
        ValidarTareasParte::validar($contexto, [], [['tarea_mant' => 7]], true);
    }
}
