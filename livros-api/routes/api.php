<?php

use App\Http\Controllers\AssuntoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\RelatorioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('livros', LivroController::class);
Route::apiResource('assuntos', AssuntoController::class);
Route::apiResource('autors', AutorController::class);
Route::get('/relatorio/pdf', [RelatorioController::class, 'gerarPDF']);