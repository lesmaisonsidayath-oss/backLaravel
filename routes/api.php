<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api;
use App\Http\Controllers\Admin;

/*
|--------------------------------------------------------------------------
| Public API Routes (consumed by site_web, no auth required)
|--------------------------------------------------------------------------
*/

Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/properties', [Api\PropertyController::class, 'index']);
Route::get('/properties/{slug}', [Api\PropertyController::class, 'show']);

Route::get('/formations', [Api\FormationController::class, 'index']);
Route::get('/formations/{slug}', [Api\FormationController::class, 'show']);

Route::get('/blog', [Api\BlogPostController::class, 'index']);
Route::get('/blog/{slug}', [Api\BlogPostController::class, 'show']);

Route::get('/testimonials', [Api\TestimonialController::class, 'index']);

Route::get('/navigation', [Api\NavigationController::class, 'index']);

Route::get('/contact-settings', [Api\ContactSettingsController::class, 'show']);

Route::post('/contact-messages', [Api\ContactMessageController::class, 'store'])
    ->middleware('throttle:5,1');

/*
|--------------------------------------------------------------------------
| Admin API Routes (consumed by backoffice, auth required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'is_active'])->prefix('admin')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Dashboard (all roles)
    Route::get('/dashboard', [Admin\DashboardController::class, 'index']);

    // Properties (all roles: super_admin, admin, editeur)
    Route::apiResource('properties', Admin\PropertyController::class);
    Route::post('/properties/{id}/images', [Admin\PropertyController::class, 'uploadImages']);
    Route::delete('/properties/{id}/images/{imageId}', [Admin\PropertyController::class, 'deleteImage']);
    Route::patch('/properties/{id}/toggle-visibility', [Admin\PropertyController::class, 'toggleVisibility']);
    Route::patch('/properties/{id}/toggle-featured', [Admin\PropertyController::class, 'toggleFeatured']);

    // Restricted to super_admin + admin
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::apiResource('formations', Admin\FormationController::class);
        Route::apiResource('blog', Admin\BlogPostController::class);
        Route::apiResource('testimonials', Admin\TestimonialController::class);

        Route::apiResource('navigation', Admin\NavigationController::class);
        Route::post('/navigation/reorder', [Admin\NavigationController::class, 'reorder']);

        Route::get('/contact-settings', [Admin\ContactSettingsController::class, 'show']);
        Route::put('/contact-settings', [Admin\ContactSettingsController::class, 'update']);

        Route::get('/contact-messages', [Admin\ContactMessageController::class, 'index']);
        Route::get('/contact-messages/{id}', [Admin\ContactMessageController::class, 'show']);
        Route::patch('/contact-messages/{id}/read', [Admin\ContactMessageController::class, 'markRead']);
        Route::delete('/contact-messages/{id}', [Admin\ContactMessageController::class, 'destroy']);
    });

    // Super admin only
    Route::middleware('role:super_admin')->group(function () {
        Route::apiResource('users', Admin\UserController::class);
        Route::patch('/users/{id}/toggle-active', [Admin\UserController::class, 'toggleActive']);
    });
});
