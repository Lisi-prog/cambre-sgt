<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Informatica\GestionUsuarios\PermisoController;
use App\Http\Controllers\Informatica\GestionUsuarios\RolController;
use App\Http\Controllers\Informatica\GestionUsuarios\UsuarioController;
use App\Http\Controllers\Ingenieria\Servicios\Proyectos\ProyectoController;
use App\Http\Controllers\Ingenieria\Servicios\Etapas\EtapaController;
use App\Http\Controllers\Ingenieria\Servicios\Ordenes\OrdenController;
use App\Http\Controllers\Ingenieria\Solicitud\SSI\ServicioDeIngenieriaController;
use App\Http\Controllers\Ingenieria\Solicitud\RI\RequerimientoDeIngenieriaController;
use App\Http\Controllers\Ingenieria\Solicitud\RSM\RequerimientoServicioMantenimientoController;
use App\Http\Controllers\Ingenieria\Solicitud\PM\PropuestaDeMejoraController;

//Gestion de proyectos
// Route::group(['middleware' => ['auth','role_or_permission:ADMIN']], function () {
    Route::get('proyectos/gestionar/{id}', [ProyectoController::class, 'gestionar'])->name('proyectos.gestionar');
    Route::resource('proyectos', ProyectoController::class);
    Route::resource('etapas', EtapaController::class);
    Route::resource('ordenes', OrdenController::class);
// });

// Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR']], function () {
    Route::resource('s_s_i', ServicioDeIngenieriaController::class);
    Route::get('r_i/evaluar/{id}', [RequerimientoDeIngenieriaController::class, 'evaluar'])->name('ri.evaluar');
    Route::resource('r_i', RequerimientoDeIngenieriaController::class);
    Route::resource('p_m', PropuestaDeMejoraController::class);
    Route::resource('proyectos', ProyectoController::class);
// });

Route::get('no_au/solicitud_servicio_ingenieria', [ServicioDeIngenieriaController::class, 'crearAlt'])->name('ssi.sa.crear');
Route::post('no_au/solicitud_servicio_ingenieria/guardar', [ServicioDeIngenieriaController::class, 'guardarAlt'])->name('ssi.sa.guardar');

Route::get('no_au/requerimiento_ingenieria', [RequerimientoDeIngenieriaController::class, 'crearAlt'])->name('ri.sa.crear');
Route::post('no_au/requerimiento_ingenieria/guardar', [RequerimientoDeIngenieriaController::class, 'guardarAlt'])->name('ri.sa.guardar');

Route::get('no_au/requerimiento_servicio_mantenimiento', [RequerimientoServicioMantenimientoController::class, 'crearAlt'])->name('rsm.sa.crear');
Route::post('no_au/requerimiento_servicio_mantenimiento/guardar', [RequerimientoServicioMantenimientoController::class, 'guardarAlt'])->name('rsm.sa.guardar');

