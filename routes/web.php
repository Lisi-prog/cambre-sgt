<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Mail\ContactanosMailable;
use App\Mail\Solicitud\AceptarSolicitud;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//      return view('home');
// });

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('inicio');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//route::get('emailprueba', function (){
    /* try {
        $email = strval('lisandrosilvero@gmail.com');
        $response = Mail::to($email)->send(new AceptarSolicitud("Juan"));
        dump($response);
    } catch (\Throwable $th) {
        echo $th->getMessage();
    } */
    //return view('emails.Solicitud.aceptarSolicitud')->with(['codigo' => '100', 'name' => 'Lisandro Manuel Silvero']);
    // dump($response);
//});
