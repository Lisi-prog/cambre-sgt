<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ingenieria\Activos\SintomasController;
use App\Http\Controllers\Ingenieria\Activos\TiposSintomasController;
use App\Http\Controllers\Ingenieria\Activos\ActivoController;
use App\Http\Controllers\Ingenieria\Solicitud\SSI\ServicioDeIngenieriaController;
use App\Http\Controllers\Ingenieria\Solicitud\SMA\MantenimientoDeActivoController;
use App\Http\Controllers\Ingenieria\Activos\Ishikawa\IshikawaCategoriaController;
use App\Http\Controllers\Ingenieria\Activos\Ishikawa\IshikawaCausaController;
use App\Http\Controllers\Ingenieria\Activos\Tarea\TareaEjecucionController;
use App\Http\Controllers\Ingenieria\Activos\Tarea\TareaMantenimientoController;
use App\Http\Controllers\Ingenieria\Activos\Tarea\ZonaTareaController;



Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR']], function () {
    Route::put('tipo_activo/set_sintomas', [ActivoController::class, 'set_sintomas_tipo_activo'])->name('tipo_activo.set_sintomas');
    Route::delete('tipo_activo/destroy_sintoma/{id_sintoma}/{id_tipo_activo}', [ActivoController::class, 'destroy_sintoma_tipo_activo'])->name('tipo_activo.destroy_sintoma');
    Route::put('activo/set_sintomas', [ActivoController::class, 'set_sintomas_activo'])->name('activo.set_sintomas');
    Route::delete('activo/destroy_sintoma/{id_sintoma}/{id_activo}', [ActivoController::class, 'destroy_sintoma_activo'])->name('activo.destroy_sintoma');
    Route::put('tipo_activo/set_tareas_mantenimiento', [ActivoController::class, 'set_tareas_mantenimiento_tipo_activo'])->name('tipo_activo.set_tareas_mantenimiento');
    Route::delete('tipo_activo/destroy_tarea_mantenimiento/{id_tarea_mant}/{id_tipo_activo}', [ActivoController::class, 'destroy_tarea_mantenimiento_tipo_activo'])->name('tipo_activo.destroy_tarea_mantenimiento');
    Route::put('activo/set_tareas_mantenimiento', [ActivoController::class, 'set_tareas_mantenimiento_activo'])->name('activo.set_tareas_mantenimiento');
    Route::delete('activo/destroy_tarea_mantenimiento/{id_tarea_mant}/{id_activo}', [ActivoController::class, 'destroy_tarea_mantenimiento_activo'])->name('activo.destroy_tarea_mantenimiento');
    Route::resource('sintoma', SintomasController::class);
    Route::resource('tipo_sintoma', TiposSintomasController::class);
    Route::resource('ishikawa_causa', IshikawaCausaController::class);
    Route::resource('ishikawa_categoria', IshikawaCategoriaController::class);
    Route::resource('tarea_ejecucion', TareaEjecucionController::class);
    Route::resource('tarea_mantenimiento', TareaMantenimientoController::class);
    Route::resource('zona_tarea', ZonaTareaController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR']], function () {
    Route::resource('s_m_a', MantenimientoDeActivoController::class);
    Route::get('s_m_a/{id}/ver-evaluar', [MantenimientoDeActivoController::class, 'ssi_man_ver_evaluar'])->name('ssi_man.ver.evaluar');
    Route::post('s_m_a/{id}/cargar-causas', [MantenimientoDeActivoController::class, 'sma_obtener_causas']);
    Route::get('s_m_a/rechazar/{id}', [MantenimientoDeActivoController::class, 'rechazar'])->name('sma.rechazar');
    Route::get('s_m_a/aceptar/{id}', [MantenimientoDeActivoController::class, 'aceptar'])->name('sma.aceptar');
    Route::get('s_m_a/gestionar/{id}', [MantenimientoDeActivoController::class, 'gestionar'])->name('servicio_mantenimiento.gestionar');
});