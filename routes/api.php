<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UpdateRun;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    $token = $user->createToken(
        'api-token',
        ['*'],
        Carbon::now()->addHours(1)
    )->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->post('/createrun', [UpdateRun::class, 'store']);

Route::middleware('auth:sanctum')->post('/updatepos/{corrida}', [UpdateRun::class, 'updatePos']);

// Route::middleware('auth:sanctum')->post('/updaterun', [UpdateRun::class, 'update']);