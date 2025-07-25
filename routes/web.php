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

Route::get('/', function () {
    return view('construcao');
});

Route::get('/pagina', function () {
    return view('pagina');
});

// Ou se você preferir retornar apenas um texto simples
// Route::get('/pagina', function () {
//     return 'Esta página existe!';
// });