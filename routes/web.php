<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bateria01Controller;
use App\Http\Controllers\StaticUser;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\IndexPage;

// Route::get('/', function () {
//     return view('index', [RankingController::class, 'index'])->name('.index');
// });

Route::get('/', [IndexPage::class, 'index'])->name('index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [StaticUser::class, 'index'])->name('dashboard');
    Route::get('/bateria01/{corrida}', [Bateria01Controller::class, 'index'])->name('bateria01.index');
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    Route::post('/ranking/update', [RankingController::class, 'update'])->name('ranking.update');
    Route::post('/ranking/destroy', [RankingController::class, 'destroy'])->name('ranking.destroy');

});
// Route::get('/dashboard', [StaticUser::class, 'StaticUser'])->middleware(['auth'])->name('dashboard');
