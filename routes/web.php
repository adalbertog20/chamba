<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'address'], function () {
    Route::post('/store', [AddressController::class, 'store'])->name('address.store');
    Route::put('/{address}/store', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/{address}/store', [AddressController::class, 'destroy'])->name('address.destroy');
});

Route::group(['prefix' => 'plan'], function () {
    Route::get('/', [PlanController::class, 'index'])->name('plan.index');
});

Route::middleware('auth')->get('/plans', [PlanController::class, 'index'])->name('plans.index');

require __DIR__ . '/auth.php';
