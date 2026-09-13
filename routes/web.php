<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bateria01Controller;
use App\Http\Controllers\StaticUser;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\IndexPage;
use App\Http\Controllers\CsvImportController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Auth\ForcePasswordChangeController;

// Route::get('/', function () {
//     return view('index', [RankingController::class, 'index'])->name('.index');
// });

Route::get('/', [IndexPage::class, 'index'])->name('index');
Route::get('/team/{slug}', [RankingController::class, 'showTeam'])->name('ranking.public');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'password.change',
])->group(function () {
    Route::get('/dashboard', [StaticUser::class, 'index'])->name('dashboard');
    Route::get('/bateria01/{corrida}', [Bateria01Controller::class, 'index'])->name('bateria01.index');
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    Route::post('/ranking/update', [RankingController::class, 'update'])->name('ranking.update');
    Route::post('/ranking/destroy', [RankingController::class, 'destroy'])->name('ranking.destroy');

    Route::get('/password/change', [ForcePasswordChangeController::class, 'show'])->name('password.change');
    Route::post('/password/change', [ForcePasswordChangeController::class, 'update'])->name('password.change.update');

    Route::middleware('admin')->group(function () {
        Route::get('/corrida/import', [CsvImportController::class, 'create'])->name('corrida.import');
        Route::post('/corrida/import', [CsvImportController::class, 'store'])->name('corrida.import.store');
        Route::delete('/bateria01/{corrida}', [Bateria01Controller::class, 'destroy'])->name('bateria01.destroy');
        Route::get('/admin/members', [MemberController::class, 'index'])->name('admin.members.index');
        Route::get('/admin/members/create', [MemberController::class, 'create'])->name('admin.members.create');
        Route::post('/admin/members', [MemberController::class, 'store'])->name('admin.members.store');
        Route::get('/admin/members/{user}/edit', [MemberController::class, 'edit'])->name('admin.members.edit');
        Route::put('/admin/members/{user}', [MemberController::class, 'update'])->name('admin.members.update');
        Route::delete('/admin/members/{user}', [MemberController::class, 'destroy'])->name('admin.members.destroy');
    });

    Route::middleware('super.admin')->group(function () {
        Route::resource('admin/teams', TeamController::class)->names('admin.teams');
    });
});
// Route::get('/dashboard', [StaticUser::class, 'StaticUser'])->middleware(['auth'])->name('dashboard');
