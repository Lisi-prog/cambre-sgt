<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Informatica\GestionUsuarios\PermisoController;
use App\Http\Controllers\Informatica\GestionUsuarios\RolController;
use App\Http\Controllers\Informatica\GestionUsuarios\UsuarioController;
use App\Http\Controllers\Ingenieria\Servicios\Proyectos\ProyectoController;
use App\Http\Controllers\Ingenieria\Servicios\Etapas\EtapaController;
use App\Http\Controllers\Ingenieria\Servicios\Ordenes\OrdenController;
use App\Http\Controllers\Ingenieria\Servicios\Partes\ParteController;
use App\Http\Controllers\Ingenieria\Solicitud\SSI\ServicioDeIngenieriaController;
use App\Http\Controllers\Ingenieria\Solicitud\RI\RequerimientoDeIngenieriaController;
use App\Http\Controllers\Ingenieria\Solicitud\RSM\RequerimientoServicioMantenimientoController;
use App\Http\Controllers\Ingenieria\Solicitud\PM\PropuestaDeMejoraController;

//Gestion de proyectos
// Route::group(['middleware' => ['auth','role_or_permission:ADMIN']], function () {
    Route::get('proyectos/gestionar/{id}', [ProyectoController::class, 'gestionar'])->name('proyectos.gestionar');

    Route::get('proyectos/actualizaciones/{id}', [ProyectoController::class, 'verActualizaciones'])->name('proyectos.actualizaciones');
    
    Route::get('etapas/actualizaciones/{id}', [EtapaController::class, 'verActualizaciones'])->name('etapas.actualizaciones');
    Route::post('proyectos/guardar-actualizacion/{id}', [ProyectoController::class, 'guardarActualizacion'])->name('actualizacion.crear');
    Route::post('etapas/guardar-actualizacion', [EtapaController::class, 'guardarActualizacion'])->name('actualizacion-etapa.crear');
    Route::post('/etapas/obtener-actualizaciones-etapa/{id}', [EtapaController::class, 'obtenerActualizacionesEtapa']);
    Route::post('/proyectos/obtener-actualizaciones-proyecto/{id}', [ProyectoController::class, 'obtenerActualizacionesServicio']);
    Route::get('orden/manufactura_mecanizado/{id}', [OrdenController::class, 'verMecanizados'])->name('ordenes.manufacturamecanizado');

    Route::post('/proyectos/obtener-proyecto/{id}', [ProyectoController::class, 'obtenerProyecto']);
    Route::post('proyectos/actualizar-prioridad', [ProyectoController::class, 'actualizarPrioridadServicio'])->name('proyectos.cambiarprioridad');
    Route::post('orden/crear',[OrdenController::class, 'crearOrden'])->name('ordenes.crear');

    Route::get('orden/cargar-relaciones',[OrdenController::class, 'relacionarOrdenes']);

    Route::post('orden/validar-mecanizado',[OrdenController::class, 'validarOrdenMecanizado'])->name('ordenes.validarmecanizado');

    Route::post('/orden/obtener-tipo-orden',[OrdenController::class, 'obtenerTipoTrabajo']);
    Route::post('/orden/obtener-empleados',[OrdenController::class, 'obtenerEmpleados']);
    Route::post('/orden/obtener-estados',[OrdenController::class, 'obtenerEstados']);
    Route::post('/orden/obtener-supervisores',[OrdenController::class, 'obtenerSupervisores']);

    Route::post('/orden/obtener-estados-manufacturas',[OrdenController::class, 'obtenerEstadosManufacturas']);
    
    Route::post('/orden/obtener-estados-mecanizados',[OrdenController::class, 'obtenerEstadosMecanizados']);
    Route::post('/orden/obtener-orden-etapa/{id}',[OrdenController::class, 'obtenerOrdenesDeUnaEtapa']);

    Route::post('/etapa/obtener-una-etapa/{id}',[EtapaController::class, 'obtenerUnaEtapa']);
    Route::post('etapa/actualizar-etapa',[EtapaController::class, 'actualizarEtapa'])->name('etapa.actualizar');
    
    Route::post('/orden/obtener-una-orden-etapa/{id}',[OrdenController::class, 'ObtenerOrdenTrabajo']);
    Route::post('/orden/obtener-una-orden-mecanizado-etapa/{id}',[OrdenController::class, 'ObtenerOrdenMecanizado']);
    Route::post('/orden/obtener-partes-orden/{id}',[OrdenController::class, 'obtenerPartesDeTrabajo']);

    Route::get('orden/partes/{id}', [ParteController::class, 'indexOrden'])->name('orden.partes');

    Route::resource('proyectos', ProyectoController::class);
    Route::resource('etapas', EtapaController::class);
    Route::resource('ordenes', OrdenController::class);
    Route::resource('partes', ParteController::class);
// });

// Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR']], function () {
    Route::resource('s_s_i', ServicioDeIngenieriaController::class);
    Route::get('r_i/evaluar/{id}', [RequerimientoDeIngenieriaController::class, 'evaluar'])->name('ri.evaluar');
    Route::get('p_m/evaluar/{id}', [RequerimientoDeIngenieriaController::class, 'evaluar'])->name('pm.evaluar');
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

