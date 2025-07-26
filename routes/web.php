<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\HomeController;

// Public routes
Route::get('/', [ApplicationController::class, 'create'])->name('application.form');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/applications/search', [ApplicationController::class, 'search'])->name('applications.search');
Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');

// Authentication routes
Auth::routes(['register' => false]);

// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::prefix('applications')->group(function () {
        Route::get('/', [ApplicationController::class, 'index'])->name('admin.applications.index');
        Route::get('/create', [ApplicationController::class, 'create'])->name('applications.create');
        Route::get('/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
        Route::delete('/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::get('/{application}/pdf', [ApplicationController::class, 'downloadPDF'])->name('applications.downloadPDF');
        Route::get('/export', [ApplicationController::class, 'export'])->name('applications.export');
    });
});