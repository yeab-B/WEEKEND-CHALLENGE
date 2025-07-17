<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dash', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



    Route::resource('permissions', PermissionController::class);
    Route::get('permissions', [PermissionController::class, 'index'])->name('admin.permission.index');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('admin.permission.create');
    Route::post('permissions', [PermissionController::class, 'store'])->name('admin.permission.store');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('admin.permission.edit');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('admin.permission.update');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('admin.permission.destroy');


require __DIR__.'/auth.php';
