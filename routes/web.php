<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers;

Route::get('/', Controllers\IndexController::class)
    ->name('home');

Route::get('dashboard', Controllers\DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::redirect('settings', '/settings/profile')
    ->middleware(['auth'])
    ->name('settings.index');

Route::get('settings/profile', [Controllers\Settings\ProfileController::class, 'edit'])
    ->middleware(['auth'])
    ->name('settings.profile.edit');

Route::patch('settings/profile', [Controllers\Settings\ProfileController::class, 'update'])
    ->middleware(['auth'])
    ->name('settings.profile.update');

Route::delete('settings/profile', [Controllers\Settings\ProfileController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('settings.profile.destroy');

Route::get('settings/password', [Controllers\Settings\PasswordController::class, 'edit'])
    ->middleware(['auth'])
    ->name('settings.password.edit');

Route::put('settings/password', [Controllers\Settings\PasswordController::class, 'update'])
    ->middleware('throttle:6,1')
    ->name('user-password.update');

Route::get('settings/two-factor', Controllers\Settings\TwoFactorAuthenticationController::class)
    ->middleware(['auth'])
    ->name('settings.two-factor.show');

Route::get('settings/appearance', Controllers\Settings\AppearanceController::class)
    ->middleware(['auth'])
    ->name('settings.appearance.edit');
