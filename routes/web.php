<?php

use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockTransactionController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('inventory.index');
    })->name('dashboard');

    Route::resource('inventory', InventoryItemController::class);

    Route::get('/stock/add', [StockTransactionController::class, 'createAddition'])
        ->name('stock.add');
    Route::post('/stock/add', [StockTransactionController::class, 'storeAddition'])
        ->name('stock.add.store');

    Route::get('/stock/deduct', [StockTransactionController::class, 'createDeduction'])
        ->name('stock.deduct');
    Route::post('/stock/deduct', [StockTransactionController::class, 'storeDeduction'])
        ->name('stock.deduct.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
