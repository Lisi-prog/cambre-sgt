<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ingenieria\Activos\SintomasController;
use App\Http\Controllers\Ingenieria\Activos\TiposSintomasController;
use App\Http\Controllers\Ingenieria\Activos\ActivoController;
use App\Http\Controllers\Ingenieria\Solicitud\SSI\ServicioDeIngenieriaController;
use App\Http\Controllers\Ingenieria\Solicitud\SMA\MantenimientoDeActivoController;

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR']], function () {
    Route::put('tipo_activo/set_sintomas', [ActivoController::class, 'set_sintomas_tipo_activo'])->name('tipo_activo.set_sintomas');
    Route::delete('tipo_activo/destroy_sintoma/{id_sintoma}/{id_tipo_activo}', [ActivoController::class, 'destroy_sintoma_tipo_activo'])->name('tipo_activo.destroy_sintoma');
    Route::put('activo/set_sintomas', [ActivoController::class, 'set_sintomas_activo'])->name('activo.set_sintomas');
    Route::delete('activo/destroy_sintoma/{id_sintoma}/{id_activo}', [ActivoController::class, 'destroy_sintoma_activo'])->name('activo.destroy_sintoma');
    Route::resource('sintoma', SintomasController::class);
    Route::resource('tipo_sintoma', TiposSintomasController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR']], function () {
    Route::resource('s_m_a', MantenimientoDeActivoController::class);
    Route::get('s_m_a/{id}/ver-evaluar', [MantenimientoDeActivoController::class, 'ssi_man_ver_evaluar'])->name('ssi_man.ver.evaluar');
    Route::post('s_m_a/{id}/cargar-causas', [MantenimientoDeActivoController::class, 'sma_obtener_causas']);
});