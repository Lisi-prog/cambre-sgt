<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Informatica\GestionUsuarios\PermisoController;
use App\Http\Controllers\Informatica\GestionUsuarios\RolController;
use App\Http\Controllers\Informatica\GestionUsuarios\UsuarioController;
use App\Http\Controllers\Informatica\EmpleadoController;

//Gestion de usuario
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-PERMISOS|VER-USUARIOS|VER-ROLES']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('permisos', PermisoController::class);
    Route::post('/permisos/buscar/{name}', [PermisoController::class, 'buscarpermisospornombre']);
    Route::get('usuario/permisos/{id}', [RolController::class, 'verPermisosxRol'])->name('roles.permisos');
    Route::post('usuario/permisos/{id}/guardar', [RolController::class, 'guardarPermisosxRol'])->name('roles.guardarpermisos');
    Route::post('/usuarios/buscarpermisosdelrol', [RolController::class, 'buscarpermisosdelrol']);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('empleados', EmpleadoController::class);
});

// Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-ROLES']], function () {
//     Route::resource('roles', RolController::class)
// });





// Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-VISTAS']], function () {
//     Route::get('/vistas/buscarvista', [VistaController::class, 'buscarvista']);
//     Route::post('/vistas/editarvista', [VistaController::class, 'updatevista'])->name('vistas.updatevista');
//     Route::resource('vistas', VistaController::class);
// });