<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ingenieria\Activos\SintomasController;
use App\Http\Controllers\Ingenieria\Activos\TiposSintomasController;

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SUPERVISOR']], function () {
    Route::resource('sintoma', SintomasController::class);
    Route::resource('tipo_sintoma', TiposSintomasController::class);
});