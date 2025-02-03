<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bateria01Controller;
use App\Http\Controllers\StaticUser;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [StaticUser::class, 'index'])->name('dashboard');
});
// Route::get('/dashboard', [StaticUser::class, 'StaticUser'])->middleware(['auth'])->name('dashboard');
Route::get('/bateria01/{corrida}', [Bateria01Controller::class, 'index'])->name('bateria01.index');
