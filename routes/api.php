<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\CostSharesStoreRequest;
use App\Http\Resources\CostSharesResource;
use App\Models\CostShare;

// use App\Http\Controllers\Api\CostSharesController;

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

Route::middleware('api_token')->middleware('validate_calc')->apiResource('costshares', CostSharesController::class); //

