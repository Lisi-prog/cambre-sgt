<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Informatica\GestionUsuarios\PermisoController;
use App\Http\Controllers\Informatica\GestionUsuarios\RolController;

//Gestion de usuario
// Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-PERMISOS']], function () {
//     Route::resource('permisos', PermisoController::class);
// });

// Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-ROLES']], function () {
//     Route::resource('roles', RolController::class)
// });

Route::resource('roles', RolController::class);
Route::resource('permisos', PermisoController::class);

// Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-VISTAS']], function () {
//     Route::get('/vistas/buscarvista', [VistaController::class, 'buscarvista']);
//     Route::post('/vistas/editarvista', [VistaController::class, 'updatevista'])->name('vistas.updatevista');
//     Route::resource('vistas', VistaController::class);
// });