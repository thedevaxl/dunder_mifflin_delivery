<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MuseumController;

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

Route::post('/login', [AuthController::class, 'login']);


Route::get('/museums', [MuseumController::class, 'index']);
Route::get('/museum', [MuseumController::class, 'search']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/museum', [MuseumController::class, 'store']);
    Route::post('/museums/import', [MuseumController::class, 'import']);
});