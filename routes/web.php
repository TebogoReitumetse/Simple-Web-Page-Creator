<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\NavController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

// Public site
Route::get('/', [PageController::class, 'home'])->name('home');

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::post('pages/{page}/sections', [AdminPageController::class, 'addSection'])->name('pages.sections.store');
        Route::put('pages/{page}/sections/{section}', [AdminPageController::class, 'updateSection'])->name('pages.sections.update');
        Route::delete('pages/{page}/sections/{section}', [AdminPageController::class, 'deleteSection'])->name('pages.sections.destroy');
        Route::post('pages/{page}/sections/{section}/move', [AdminPageController::class, 'moveSection'])->name('pages.sections.move');
        Route::post('pages/{page}/sections/{section}/preview', [AdminPageController::class, 'previewSection'])->name('pages.sections.preview');

        Route::get('nav', [NavController::class, 'index'])->name('nav.index');
        Route::post('nav', [NavController::class, 'store'])->name('nav.store');
        Route::put('nav/{nav}', [NavController::class, 'update'])->name('nav.update');
        Route::delete('nav/{nav}', [NavController::class, 'destroy'])->name('nav.destroy');
        Route::post('nav/{nav}/move', [NavController::class, 'move'])->name('nav.move');

        Route::get('footer', [FooterController::class, 'index'])->name('footer.index');
        Route::post('footer', [FooterController::class, 'store'])->name('footer.store');
        Route::put('footer/{footer}', [FooterController::class, 'update'])->name('footer.update');
        Route::delete('footer/{footer}', [FooterController::class, 'destroy'])->name('footer.destroy');

        Route::resource('users', UserController::class)->except(['show']);

        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});

// Public catch-all page (must be last)
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('page.show');
