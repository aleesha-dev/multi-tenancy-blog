<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Tenants\RoleController;
use App\Http\Controllers\Tenants\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\Tenants\AuthController as TenantsAuthController;
use App\Http\Controllers\Tenants\BlogController;
use App\Http\Middleware\CheckMasterUser;
use App\Http\Middleware\Tenants\CheckUserRole;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;



Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('/tenants', [TenantController::class, 'store']);
});

Route::prefix('{tenant}')->middleware([InitializeTenancyByPath::class])->group(function () {

    Route::post('/login', [TenantsAuthController::class, 'login']);

    // Group routes that require authentication and role checking
    Route::middleware(['auth:api', CheckUserRole::class])->group(function () {
        Route::resource('/users', UserController::class);
        Route::resource('/roles', RoleController::class);

        // Force delete and restore for users
        Route::delete('/users/{user}/force-delete', [UserController::class, 'forceDelete']);
        Route::post('/users/{user}/restore', [UserController::class, 'restore']);
    });

    // Group routes for blogs that require authentication
    Route::middleware(['auth:api'])->group(function () {

        Route::post('/user/forgot-password', [TenantsAuthController::class, 'sendPasswordResetLink']);
        Route::post('/user/reset-password', [TenantsAuthController::class, 'resetPassword']);

        Route::resource('/blogs', BlogController::class);

        // Force delete and restore for blogs
        Route::delete('/blogs/{blog}/force-delete', [BlogController::class, 'forceDelete']);
        Route::post('/blogs/{blog}/restore', [BlogController::class, 'restore']);
    });
});
