<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Api\UpdateRun;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->post('/updaterun', [UpdateRun::class, 'update']);

// Route::middleware('auth:sanctum')->post('/updaterun', [UpdateRun::class, 'update']);