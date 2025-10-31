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
use App\Http\Controllers\Ingenieria\Activos\ActivoController;
use App\Http\Controllers\Ingenieria\Sector\SectorController;
use App\Http\Controllers\Ingenieria\Operacion\OperacionController;
use App\Http\Controllers\Ingenieria\Maquinaria\MaquinariaController;
use App\Http\Controllers\Ingenieria\Servicios\Proyectos\PrefijoProyectoController;

//Gestion de proyectos
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR']], function () {
    // RUTAS PROYECTOS
    Route::get('proyectos/gestionar/{id}', [ProyectoController::class, 'gestionar'])->name('proyectos.gestionar');
    Route::get('proyectos/costos/{id}', [ProyectoController::class, 'costos'])->name('proyectos.costos');
    Route::get('proyectos/actualizaciones/{id}', [ProyectoController::class, 'verActualizaciones'])->name('proyectos.actualizaciones');
    Route::post('/proyectos/obtener-proyecto/{id}', [ProyectoController::class, 'obtenerProyecto']);
    Route::post('/proyectos/obtener-ultima-actualizacion-servicio/{id}', [ProyectoController::class, 'obtenerUltimaActualizacion']);
    Route::post('proyectos/actualizar-prioridad', [ProyectoController::class, 'actualizarPrioridadServicio'])->name('proyectos.cambiarprioridad');
    Route::post('/proyectos/obtener-actualizaciones-proyecto/{id}', [ProyectoController::class, 'obtenerActualizacionesServicio']);
    Route::post('proyectos/guardar-actualizacion/{id}', [ProyectoController::class, 'guardarActualizacion'])->name('actualizacion.crear');
    Route::get('proyectos/obtener-proyecto-tipo/{id}', [ProyectoController::class, 'indexPorTipo'])->name('proyecto.indextipo');
    Route::get('proyectos/obtener-proyecto-prefijo/{opcion}', [ProyectoController::class, 'indexPorPrefijo'])->name('proyecto.indexprefijo');
    Route::get('proyectos/obtener-proyecto-tipo-activo', [ProyectoController::class, 'indexPorActivo'])->name('proyecto.indexactivo');
    Route::post('/proyectos/obtener-mayor-prefijo/{id}', [ProyectoController::class, 'obtenerMayorCodigoServicioPrefijo']);
    Route::post('/servicio/{id}/obtener-ord-tra-mec', [ProyectoController::class, 'obtenerOrdMecOrdTraUnServicio']);
    Route::post('/servicio/{id}/obtener-ord-man', [ProyectoController::class, 'obtenerOrdManUnServicio']);
    Route::resource('proyectos', ProyectoController::class);
    Route::resource('prefijo_proyecto', PrefijoProyectoController::class);
    // RUTAS ETAPAS
    Route::get('etapas/actualizaciones/{id}', [EtapaController::class, 'verActualizaciones'])->name('etapas.actualizaciones');
    Route::post('etapas/guardar-actualizacion/{id}', [EtapaController::class, 'guardarActualizacion'])->name('actualizacion-etapa.crear');
    Route::post('/etapas/obtener-actualizaciones-etapa/{id}', [EtapaController::class, 'obtenerActualizacionesEtapa']);
    Route::post('/etapa/obtener-una-etapa/{id}',[EtapaController::class, 'obtenerUnaEtapa']);
    Route::post('etapa/actualizar-etapa',[EtapaController::class, 'actualizarEtapa'])->name('etapa.actualizar');
    Route::post('etapa/etapas-de-servicio/{id}',[EtapaController::class, 'obtenerEtapasDeUnServicio'])->name('etapa.obtenerdeservicio');

    Route::resource('etapas', EtapaController::class);
    // RUTAS DE ORDENES
    
    Route::get('ordenes/{tipo_orden}', [OrdenController::class, 'obtenerOrdenes'])->name('ordenes.tipo');
    Route::get('orden/multiple-parte', [OrdenController::class, 'cargaMultipleParte'])->name('ordenes.multipleparte');
    Route::get('ordenes/mec/{id}/hdr', [OrdenController::class, 'ordenHDR'])->name('ordenes.hdr');
    Route::put('ordenes/mec/{id}/hdr/guardar', [OrdenController::class, 'guardar_hdr'])->name('hdr.crear');
    Route::put('ordenes/mec/{id}/hdr/editar', [OrdenController::class, 'editar_hdr'])->name('hdr.edit');
    Route::post('/orden/mec/hdr/obtenerope',[OrdenController::class, 'obtenerOperacionesyTecnicos']);
    Route::post('/orden/mec/hdr/obtenermaq',[OrdenController::class, 'obtenerMaquinas']);
     Route::post('/orden/mec/hdr/obtenertec',[OrdenController::class, 'obtenerTecnicos']);
    Route::post('/orden/mec/hdr/obtener-ope-hdr',[OrdenController::class, 'obtenerOperacionHdr']);
    Route::get('/orden/mec/hdr/imprimir/{id}',[OrdenController::class, 'imprimir_hdr'])->name('hojaderuta.pdf');
    Route::post('/orden/mec/hdr/obtener-hdr-ant/{id}',[OrdenController::class, 'obtenerHdrAnt']);
    Route::post('/orden/mec/hdr/obtener-orden-mec/{id}',[OrdenController::class, 'obtenerOrdMec']);
    Route::post('/orden/mec/hdr/obtener-hdr/{id}',[OrdenController::class, 'obtenerHdr']);
    Route::post('/orden/obtener-orden-act', [OrdenController::class, 'obtenerOrdenAct']);
    Route::post('/orden/mec/hdr/obtener-hdr-parte/{id}',[OrdenController::class, 'obtenerParteHdr']);
    Route::post('/orden/man/obtener-progreso/{id}',[OrdenController::class, 'obtenerProgresoOrdMan']);
    Route::get('ordenes/mec/operaciones', [OrdenController::class, 'index_hdr'])->name('ordenes.indexhdr');
    Route::post('orden/crear',[OrdenController::class, 'crearOrden'])->name('ordenes.crear');
    Route::get('orden/eliminar/{id_orden}', [OrdenController::class, 'eliminarOrden'])->name('orden.eliminar');
    Route::get('orden-mec/quitar/{id_orden}', [OrdenController::class, 'desvincularOrdenMec'])->name('orden.mec.quitar');
    Route::post('orden/editar', [OrdenController::class, 'editarOrden'])->name('orden.editar');
    Route::post('/orden/obtener-una-orden-etapa/{id}',[OrdenController::class, 'ObtenerOrdenTrabajo']);
    Route::post('/orden/obtener-orden-tra/{id}',[OrdenController::class, 'obtenerUnaOrdenDeLaVista']); //new
    Route::post('/orden/obtener-una-orden-mecanizado-etapa/{id}',[OrdenController::class, 'ObtenerOrdenMecanizado']);
    Route::post('/orden/obtener-estados-mecanizados',[OrdenController::class, 'obtenerEstadosMecanizados']);
    Route::post('/orden/obtener-orden-etapa/{id}',[OrdenController::class, 'obtenerOrdenesDeUnaEtapa']);
    Route::post('/orden/obtener-orden-etapa-tipo/{id}/{tipo}',[OrdenController::class, 'obtenerOrdenesDeUnaEtapaTipo']);
    Route::post('/orden/obtener-info-orden-mul',[OrdenController::class, 'obtenerInfoOrdenMultipleAct']);
    Route::post('/orden/obtener-tipo-orden',[OrdenController::class, 'obtenerTipoTrabajo']);
    Route::post('/orden/obtener-empleados',[OrdenController::class, 'obtenerEmpleadosActivos']);
    Route::post('/orden/obtener-estados',[OrdenController::class, 'obtenerEstados']);
    Route::post('/orden/obtener-supervisores',[OrdenController::class, 'obtenerSupervisores']);
    Route::post('/orden/ope/obtener-ope-man/{id}',[OrdenController::class, 'obtenerOpeMan']);
    Route::post('/orden/obtener-ope-man/activar',[OrdenController::class, 'activarOpeMan'])->name('ordenes.ordenman.validar');
    Route::post('/orden/obtener-estados-manufacturas',[OrdenController::class, 'obtenerEstadosManufacturas']);
    Route::post('/orden/obtener-estados-de/{opcion}',[OrdenController::class, 'listarTodosLosEstadosDe']);
    Route::post('/operacion/obtener-maquinas-ope-de/{opcion}',[OrdenController::class, 'listarTodasLasMaquinariasDe']);

    // Route::post('/orden/obtener-info-orden-mul',[OrdenController::class, 'obtenerInfoOrdenMultiple']);
    Route::post('/orden/obtener-info-ope-mul',[OrdenController::class, 'obtenerInfoOpeMultiple']);
    Route::post('/orden/obtener-info-ope-mul-act',[OrdenController::class, 'obtenerInfoOpeMultipleAct']);
    Route::post('/orden/obtener-mul-orden-act',[OrdenController::class, 'obtenerInfoOrdenMultipleAct']);
    Route::post('/orden/obtener-ordenes-etapa/{id}',[OrdenController::class, 'obtenerOrdenesDeTrabajoUnaEtapa']);
    Route::post('/ope-multiple/edit-multiple', [OrdenController::class, 'editMultipleOpe'])->name('ope.edit.multiple');
    Route::post('/ope-multiple/parte-multiple', [OrdenController::class, 'parteMultipleOpe'])->name('ope.parte.multiple');
    Route::get('orden/cargar-relaciones',[OrdenController::class, 'relacionarOrdenes']);
    Route::post('orden/relacionar',[OrdenController::class, 'guardarRelacionesOrdenes'])->name('ordenes.relacionar');
    Route::post('orden/validar-mecanizado',[OrdenController::class, 'validarOrdenMecanizado'])->name('ordenes.validarmecanizado');
    Route::post('/orden/{tipo}/carga-multiple', [OrdenController::class, 'obtenerOrdenesParaCargaMultiple']);
    Route::get('orden/manufactura_mecanizado/{id}', [OrdenController::class, 'verMecanizados'])->name('ordenes.manufacturamecanizado');
        //RUTAS PARTES
        Route::resource('partes', ParteController::class);
        Route::get('orden/partes/{id}/{tipo_orden}', [ParteController::class, 'indexOrden'])->name('orden.partes');
        Route::post('parte/obtener/{id}', [ParteController::class, 'obtenerPartesDeUnaOrden']);
        Route::post('parte-ope/obtener/{id}', [ParteController::class, 'obtenerPartesDeUnaOpe']);
        Route::post('parte/obtener-una/{id}', [ParteController::class, 'obtenerParte']);
        Route::post('parte-ope-hdr/obtener-una/{id}', [ParteController::class, 'obtenerParteOpeHdr']);
        Route::post('ope-hdr/obtener-estado/{id}', [ParteController::class, 'obtenerEstadoOpeHdr']);
        Route::post('parte/obtener-ultimo/{id}', [ParteController::class, 'ultimoParteOrden']);
        Route::get('/parte/prueba/email', [ParteController::class, 'pruebaEmail']);
        // Route::get('/parte/prueba/email-semanal', [ParteController::class, 'emailSemanal']);
        Route::post('/parte/guardar-o-act-parte', [ParteController::class, 'guardarActualizarParte'])->name('partes.guardar.act');
        Route::post('/parte/guardar-o-act-parte-ope', [ParteController::class, 'guardarActualizarParteOpe'])->name('partesope.guardar.act');
        Route::post('/parte/obtener-est-parte-ope', [ParteController::class, 'obtenerEstadoParteOpe']);
        Route::post('/parte-multiple/guardar-multiple', [ParteController::class, 'guardarMultipleParte'])->name('partes.guardar.multiple');
        Route::post('/parte-multiple/carga-multiple', [ParteController::class, 'cargaMultipleParte'])->name('partes.carga.multiple');
        Route::post('/orden/obtener-partes-orden/{id}',[OrdenController::class, 'obtenerPartesDeTrabajo']);
    Route::resource('ordenes', OrdenController::class);
    //------------------
    //MAQUINARIA Y ACTIVOS
    Route::post('maquinaria/obtener/{id}', [MaquinariaController::class, 'obtenerMaquinaria']);
    Route::post('/maquinaria/obtener-maquinarias', [MaquinariaController::class, 'obtenerMaquinarias']);
    Route::resource('maquinarias', MaquinariaController::class);
    Route::resource('activos', ActivoController::class);
    Route::resource('sectores', SectorController::class);
    Route::resource('operacion', OperacionController::class);

    Route::get('activo/tipo', [ActivoController::class, 'tipo_activo_index'])->name('tipo_activo.index');
    Route::post('activo/tipo/guardar', [ActivoController::class, 'tipo_activo_store'])->name('tipo_activo.store');
    Route::get('activo/tipo/editar/{id}', [ActivoController::class, 'tipo_activo_edit'])->name('tipo_activo.edit');
    Route::put('activo/tipo/actualizar/{id}', [ActivoController::class, 'tipo_activo_update'])->name('tipo_activo.update');
    Route::delete('activo/tipo/borrar/{id}', [ActivoController::class, 'tipo_activo_destroy'])->name('tipo_activo.destroy');

    Route::get('maquinaria/tipo', [MaquinariaController::class, 'tipo_maquinaria_index'])->name('tipo_maquinaria.index');
    Route::post('maquinaria/tipo/guardar', [MaquinariaController::class, 'tipo_maquinaria_store'])->name('tipo_maquinaria.store');
    Route::get('maquinaria/tipo/editar/{id}', [MaquinariaController::class, 'tipo_maquinaria_edit'])->name('tipo_maquinaria.edit');
    Route::put('maquinaria/tipo/actualizar/{id}', [MaquinariaController::class, 'tipo_maquinaria_update'])->name('tipo_maquinaria.update');
    Route::delete('maquinaria/tipo/borrar/{id}', [MaquinariaController::class, 'tipo_maquinaria_destroy'])->name('tipo_maquinaria.destroy');
 });

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR|VER-MENU-SOLICITUDES']], function () {
    Route::resource('s_s_i', ServicioDeIngenieriaController::class);
    Route::get('r_i/evaluar/{id}', [RequerimientoDeIngenieriaController::class, 'evaluar'])->name('ri.evaluar');
    Route::post('r_i/evaluar/aceptar/{id}/{opcion}', [ProyectoController::class, 'aceptar_solicitud'])->name('solicitud.aceptar');
    Route::post('/solicitud/obtener-datos-proyecto/{id}', [ProyectoController::class, 'obtener_progreso']);
    Route::get('p_m/evaluar/{id}', [PropuestaDeMejoraController::class, 'evaluar'])->name('pm.evaluar');
    Route::get('p_m/calificar/{id}', [PropuestaDeMejoraController::class, 'calificar'])->name('pm.calificar');
    Route::post('p_m/calificar/{id}/guardar', [PropuestaDeMejoraController::class, 'calificarGuardar'])->name('pm.calificar.guardar');
    Route::get('s_s_i/evaluar/{id}', [ServicioDeIngenieriaController::class, 'evaluar'])->name('ssi.evaluar');
    Route::get('r_i/rechazar/{id}', [RequerimientoDeIngenieriaController::class, 'rechazar'])->name('ri.rechazar');
    Route::get('p_m/rechazar/{id}', [PropuestaDeMejoraController::class, 'rechazar'])->name('pm.rechazar');
    Route::get('s_s_i/rechazar/{id}', [ServicioDeIngenieriaController::class, 'rechazar'])->name('ssi.rechazar');
    Route::resource('r_i', RequerimientoDeIngenieriaController::class);
    Route::resource('p_m', PropuestaDeMejoraController::class);
    Route::resource('proyectos', ProyectoController::class);
 });

Route::get('no_au/solicitud_servicio_ingenieria', [ServicioDeIngenieriaController::class, 'crearAlt'])->name('ssi.sa.crear');
Route::post('no_au/solicitud_servicio_ingenieria/guardar', [ServicioDeIngenieriaController::class, 'guardarAlt'])->name('ssi.sa.guardar');

Route::get('no_au/requerimiento_ingenieria', [RequerimientoDeIngenieriaController::class, 'crearAlt'])->name('ri.sa.crear');
Route::post('no_au/requerimiento_ingenieria/guardar', [RequerimientoDeIngenieriaController::class, 'guardarAlt'])->name('ri.sa.guardar');

Route::get('no_au/requerimiento_servicio_mantenimiento', [RequerimientoServicioMantenimientoController::class, 'crearAlt'])->name('rsm.sa.crear');
Route::post('no_au/requerimiento_servicio_mantenimiento/guardar', [RequerimientoServicioMantenimientoController::class, 'guardarAlt'])->name('rsm.sa.guardar');

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|TECNICO']], function () {
     // RUTAS DE ORDENES
     Route::resource('ordenes', OrdenController::class);
     Route::get('orden/multiple-parte', [OrdenController::class, 'cargaMultipleParte'])->name('ordenes.multipleparte');
     Route::get('ordenes/{tipo_orden}', [OrdenController::class, 'obtenerOrdenes'])->name('ordenes.tipo');
     Route::post('orden/crear',[OrdenController::class, 'crearOrden'])->name('ordenes.crear');
     Route::get('orden/eliminar/{id_orden}', [OrdenController::class, 'eliminarOrden'])->name('orden.eliminar');
     Route::post('orden/editar', [OrdenController::class, 'editarOrden'])->name('orden.editar');
     Route::post('/orden/obtener-una-orden-etapa/{id}',[OrdenController::class, 'ObtenerOrdenTrabajo']);
     Route::post('/orden/obtener-una-orden-mecanizado-etapa/{id}',[OrdenController::class, 'ObtenerOrdenMecanizado']);
     Route::post('/orden/obtener-estados-mecanizados',[OrdenController::class, 'obtenerEstadosMecanizados']);
     Route::post('/orden/obtener-orden-etapa/{id}',[OrdenController::class, 'obtenerOrdenesDeUnaEtapa']);
     Route::post('/orden/obtener-orden-etapa-tipo/{id}/{tipo}',[OrdenController::class, 'obtenerOrdenesDeUnaEtapaTipo']);
     Route::post('/orden/obtener-tipo-orden',[OrdenController::class, 'obtenerTipoTrabajo']);
     Route::post('/orden/obtener-empleados',[OrdenController::class, 'obtenerEmpleadosActivos']);
     Route::post('/orden/obtener-estados',[OrdenController::class, 'obtenerEstados']);
     Route::post('/orden/obtener-supervisores',[OrdenController::class, 'obtenerSupervisores']);
     Route::post('/orden/obtener-estados-manufacturas',[OrdenController::class, 'obtenerEstadosManufacturas']);
     Route::post('/orden/obtener-estados-de/{opcion}',[OrdenController::class, 'listarTodosLosEstadosDe']);
     Route::post('/orden/obtener-ordenes-etapa/{id}',[OrdenController::class, 'obtenerOrdenesDeTrabajoUnaEtapa']);
     Route::post('/orden/mec/hdr/obtener-hdr-parte/{id}',[OrdenController::class, 'obtenerParteHdr']);
     Route::get('ordenes/mec/operaciones', [OrdenController::class, 'index_hdr'])->name('ordenes.indexhdr');
     Route::post('/operacion/obtener-maquinas-ope-de/{opcion}',[OrdenController::class, 'listarTodasLasMaquinariasDe']);
     Route::post('/orden/obtener-info-ope-mul-act',[OrdenController::class, 'obtenerInfoOpeMultipleAct']);
     Route::post('ope-hdr/obtener-estado/{id}', [ParteController::class, 'obtenerEstadoOpeHdr']);
     Route::post('/parte/guardar-o-act-parte-ope', [ParteController::class, 'guardarActualizarParteOpe'])->name('partesope.guardar.act');
     Route::post('parte-ope/obtener/{id}', [ParteController::class, 'obtenerPartesDeUnaOpe']);
    //  Route::post('/orden/obtener-info-orden-mul',[OrdenController::class, 'obtenerInfoOrdenMultipleAct']);
     Route::get('orden/cargar-relaciones',[OrdenController::class, 'relacionarOrdenes']);
     Route::post('orden/relacionar',[OrdenController::class, 'guardarRelacionesOrdenes'])->name('ordenes.relacionar');
     Route::post('orden/validar-mecanizado',[OrdenController::class, 'validarOrdenMecanizado'])->name('ordenes.validarmecanizado');
     Route::get('orden/manufactura_mecanizado/{id}', [OrdenController::class, 'verMecanizados'])->name('ordenes.manufacturamecanizado');
     Route::post('etapa/etapas-de-servicio/{id}',[EtapaController::class, 'obtenerEtapasDeUnServicio'])->name('etapa.obtenerdeservicio');
     Route::post('/orden/{tipo}/carga-multiple', [OrdenController::class, 'obtenerOrdenesParaCargaMultiple']);
         //RUTAS PARTES
        Route::resource('partes', ParteController::class);
        Route::get('partes/ver/{tipo_orden}', [ParteController::class, 'obtenerPartes'])->name('partes.tipo');
        Route::get('orden/partes/{id}/{tipo_orden}', [ParteController::class, 'indexOrden'])->name('orden.partes');
        Route::get('parte/{id}/logs', [ParteController::class, 'obtenerLogs'])->name('parte.logs');
        Route::post('parte/obtener/{id}', [ParteController::class, 'obtenerPartesDeUnaOrden']);
        Route::post('parte/obtener-una/{id}', [ParteController::class, 'obtenerParte']);
        Route::post('parte/obtener-ultimo/{id}', [ParteController::class, 'ultimoParteOrden']);
        Route::post('/parte/guardar-o-act-parte', [ParteController::class, 'guardarActualizarParte'])->name('partes.guardar.act');
        Route::post('/parte-multiple/carga-multiple', [ParteController::class, 'cargaMultipleParte'])->name('partes.carga.multiple');
        Route::post('/orden/obtener-partes-orden/{id}',[OrdenController::class, 'obtenerPartesDeTrabajo']);

     //------------------
});