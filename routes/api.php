<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CepController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ceps', [CepController::class, 'index']);
Route::get('/ceps/{id}', [CepController::class, 'show']);
Route::post('/ceps', [CepController::class, 'store']);
Route::put('/ceps/{id}', [CepController::class, 'update']);
Route::delete('/ceps/{id}', [CepController::class, 'destroy']);
Route::get('/ceps/search/{cep}', [CepController::class, 'search']);
