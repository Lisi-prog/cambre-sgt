<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Mail\ContactanosMailable;
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

// route::get('emailprueba', function (){
//     try {
//         $response = Mail::to('lisandrosilvero@gmail.com')->send(new ContactanosMailable("Juan"));
//     } catch (\Throwable $th) {
//         echo $th->getMessage();
//     }

//     // dump($response);
// });
