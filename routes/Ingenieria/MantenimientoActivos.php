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
use App\Http\Controllers\Ingenieria\Servicios\Partes\ParteDiagnosticoController;
use App\Http\Controllers\Ingenieria\Servicios\Partes\ParteInspeccionController;
use App\Http\Controllers\Ingenieria\Servicios\Partes\ParteAjusteController;
use App\Http\Controllers\Ingenieria\Activos\ZonaController;



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
    Route::resource('parte_diagnostico', ParteDiagnosticoController::class);
    Route::get('get-parte-diagnostico/{id_orden}', [ParteDiagnosticoController::class, 'get_parte_diagnostico'])->name('get_parte_diagnostico');
    Route::post('procesar-parte-diagnostico', [ParteDiagnosticoController::class, 'procesar_parte_diagnostico'])->name('procesar_parte_diagnostico');
    Route::resource('parte_inspeccion', ParteInspeccionController::class);
    Route::get('get-tareas-por-activo/{id_activo}', [ParteInspeccionController::class, 'get_tareas_x_activo'])->name('get_tareas_x_activo');   
    Route::get('get-parte-inspeccion/{id_orden}', [ParteInspeccionController::class, 'get_parte_inspeccion'])->name('get_parte_inspeccion');   
    Route::post('procesar-parte-inspeccion', [ParteInspeccionController::class, 'procesar_parte_inspeccion'])->name('procesar_parte_inspeccion');
    Route::resource('parte_ajuste', ParteAjusteController::class);
    Route::get('get-pre-acciones-ajuste/{id_etapa}', [ParteAjusteController::class, 'get_pre_acciones_ajuste'])->name('get_acciones_ajuste');   
    Route::get('get-parte-ajuste/{id_orden}', [ParteAjusteController::class, 'get_parte_ajuste'])->name('get_parte_ajuste');   
    Route::post('procesar-parte-ajuste', [ParteAjusteController::class, 'procesar_parte_ajuste'])->name('procesar_parte_ajuste');   
    Route::resource('zona', ZonaController::class);
    });

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR']], function () {
    Route::resource('s_m_a', MantenimientoDeActivoController::class);
    Route::get('s_m_a/{id}/ver-evaluar', [MantenimientoDeActivoController::class, 'ssi_man_ver_evaluar'])->name('ssi_man.ver.evaluar');
    Route::post('s_m_a/{id}/cargar-causas', [MantenimientoDeActivoController::class, 'sma_obtener_causas']);
    Route::get('s_m_a/rechazar/{id}', [MantenimientoDeActivoController::class, 'rechazar'])->name('sma.rechazar');
    Route::get('s_m_a/aceptar/{id}', [MantenimientoDeActivoController::class, 'aceptar'])->name('sma.aceptar');
    Route::get('s_m_a/gestionar/{id}', [MantenimientoDeActivoController::class, 'gestionar'])->name('servicio_mantenimiento.gestionar');
});