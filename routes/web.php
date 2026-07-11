<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QrController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, \App\Http\Middleware\SetLocale::LOCALES, true), 404);
    session(['locale' => $locale]);

    return redirect(url()->previous() ?: route('home'));
})->name('lang.switch');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Standalone QR code generator — intentionally NOT linked from the portfolio nav.
// Reachable only via its direct URL.
Route::get('/qr', [QrController::class, 'index'])->name('qr');
