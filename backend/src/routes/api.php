<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleLogController;
use App\Http\Controllers\VehicleTypesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::get('/user', [AuthController::class, 'index']);

Route::apiResource('/vehicle-type', VehicleTypesController::class);
Route::apiResource('/vehicle', VehicleController::class);
Route::get('/search', [VehicleController::class, 'search']);
Route::apiResource('/log', VehicleLogController::class);
Route::post('/start-month', [VehicleLogController::class, 'startMonth']);
Route::get('/visits', [VehicleLogController::class, 'visits']);

