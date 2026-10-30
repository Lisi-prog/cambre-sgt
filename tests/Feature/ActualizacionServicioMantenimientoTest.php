<?php

namespace Tests\Feature;

use App\Http\Controllers\Ingenieria\Servicios\Partes\ParteAjusteController;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ActualizacionServicioMantenimientoTest extends TestCase
{
    /** @dataProvider estadosServicio */
    public function test_registra_estado_responsable_y_conserva_fecha_limite($nombreEstado, $idEstado): void
    {
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');

        Schema::create('estado', function (Blueprint $table) {
            $table->increments('id_estado');
            $table->string('nombre_estado');
        });
        Schema::create('actualizacion', function (Blueprint $table) {
            $table->increments('id_actualizacion');
            $table->string('descripcion');
            $table->date('fecha_limite')->nullable();
            $table->dateTime('fecha_carga')->nullable();
            $table->integer('id_estado');
            $table->integer('id_responsabilidad');
        });
        Schema::create('actualizacion_servicio', function (Blueprint $table) {
            $table->increments('id_actualizacion_servicio');
            $table->integer('id_actualizacion');
            $table->integer('id_servicio');
        });
        DB::table('estado')->insert(['id_estado' => $idEstado, 'nombre_estado' => $nombreEstado]);
        DB::table('actualizacion')->insert([
            'id_actualizacion' => 10, 'descripcion' => 'Anterior',
            'fecha_limite' => '2026-11-30', 'id_estado' => 1, 'id_responsabilidad' => 1,
        ]);
        DB::table('actualizacion_servicio')->insert(['id_actualizacion' => 10, 'id_servicio' => 20]);

        $metodo = new \ReflectionMethod(ParteAjusteController::class, 'actualizarEstadoServicio');
        $metodo->setAccessible(true);
        $metodo->invoke(new ParteAjusteController, 20, $nombreEstado, 'Cambio de tarea', 7);

        $this->assertDatabaseHas('actualizacion', [
            'id_actualizacion' => 11, 'id_estado' => $idEstado,
            'fecha_limite' => '2026-11-30', 'id_responsabilidad' => 7,
            'descripcion' => 'Cambio de tarea',
        ]);
        $this->assertDatabaseHas('actualizacion_servicio', ['id_actualizacion' => 11, 'id_servicio' => 20]);
        $this->assertSame(2, DB::table('actualizacion')->count());
    }

    public function estadosServicio(): array
    {
        return [['Revisar', 6], ['En proceso', 2]];
    }
}
