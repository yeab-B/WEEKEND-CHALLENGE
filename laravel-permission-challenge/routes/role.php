<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;

// Role and Permission Routes
Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');

    Route::middleware('permission:create role')->group(function () {
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    });

    Route::middleware('permission:edit role')->group(function () {
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update');
    });

    Route::middleware('permission:delete role')->group(function () {
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });
});

// Permission Routes
Route::resource('permissions', PermissionController::class)->except(['create', 'show']);
Route::get('permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

// User Routes
Route::resource('users', UserController::class);
Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
Route::post('users/{id}/archived', [UserController::class, 'archive'])->name('users.archive');
