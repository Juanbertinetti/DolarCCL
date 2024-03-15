<?php

use App\Http\Controllers\LogBQController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


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

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/inicio', function () {
    return view('inicio');
});*/

Route::get('/inicio', [ ApiController::class, 'index' ]);

Route::get('/inicio/prueba', [ ApiController::class, 'conectarBigQuery' ]);

Route::get('/dolar/bigQuery/index', [ ApiController::class, 'indexBigQuery' ]);

Route::put('/dolar/bigQuery/update', [ ApiController::class, 'updateBigQuery' ]);

Route::get('/dolar/log/update', [ LogBQController::class, 'insertarDatosDesdeBigQuery']);
