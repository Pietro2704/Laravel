<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\EventController;

Route::get('/', [EventController::class, 'index']);

Route::post('/events', [EventController::class, 'store']);

Route::get('/events/{id}', [EventController::class, 'show']);

Route::delete('/events/{id}', [EventController::class, 'destroy']);

Route::get('/events/create', [EventController::class, 'create'])->middleware('auth');

Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');


/*
Route::get('enderecoWeb', function(){
    return view('nomeArquivo');
});
*/


/*
    PHP ARTISAN MAKE:CONTROLLER EventController
Route::get('enderecoWeb', [nomeClasse::class, 'nomeFunção']);
*/
