<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alumni\GuestController;
use App\Http\Controllers\Alumni\RegistrationController;
use App\Http\Controllers\Shared\PasswordResetLinkController;
use App\Http\Controllers\Shared\AuthenticatedSessionController;

Route::middleware('guest')->group(function () {
    Route::get('terms-and-privacy', [GuestController::class, 'showTermsAndPrivacy'])->name('terms.privacy');

    // LOGIN
    Route::prefix('alumni/login')->group(function () {
        Route::get('/', [AuthenticatedSessionController::class, 'showAlumniLogin'])->name('alumni.login');
        Route::post('/', [AuthenticatedSessionController::class, 'login'])->name('alumni.login.submit');
    });

    Route::prefix('admin/login')->group(function () {
        Route::get('/', [AuthenticatedSessionController::class, 'showAdminLogin'])->name('admin.login');
        Route::post('/', [AuthenticatedSessionController::class, 'login'])->name('admin.login.submit');
    });

    // FORGOT PASSWORD
    Route::prefix('forgot-password')->group(function () {
        Route::get('/', [PasswordResetLinkController::class, 'showForgotPassword'])->name('password.email');
        Route::post('/', [PasswordResetLinkController::class, 'sendOtp'])->name('forgot.send');
    });

    Route::prefix('verification-code')->group(function () {
        Route::get('/', [PasswordResetLinkController::class, 'showVerifyCode'])->name('password.code');
        Route::get('/', [PasswordResetLinkController::class, 'showVerificationForm'])->name('verification.form');
        Route::post('/', [PasswordResetLinkController::class, 'verifyOtp'])->name('verification.verify');
    });

    Route::prefix('new-password')->group(function () {
        Route::get('/', [PasswordResetLinkController::class, 'showNewPasswordForm'])->name('password.new');
        Route::post('/', [PasswordResetLinkController::class, 'resetPassword'])->name('password.reset');
    });

    // REGISTRATION
    Route::prefix('alumni/register')->group(function () {
        Route::prefix('personal-information')->group(function () {
            Route::get('/', [RegistrationController::class, 'showPersonalForm'])->name('register.personal');
            Route::post('/', [RegistrationController::class, 'storePersonal'])->name('register.personal.submit');
        });

        Route::prefix('education-background')->group(function () {
            Route::get('/', [RegistrationController::class, 'showEducationForm'])->name('register.education');
            Route::post('/', [RegistrationController::class, 'storeEducation'])->name('register.education.submit');
        });

        Route::prefix('career-information')->group(function () {
            Route::get('/', [RegistrationController::class, 'showCareerForm'])->name('register.employment');
            Route::post('/', [RegistrationController::class, 'storeCareer'])->name('register.employment.submit');
        });

        Route::prefix('credentials')->group(function () {
            Route::get('/', [RegistrationController::class, 'showCredentialsForm'])->name('register.credentials');
            Route::post('/', [RegistrationController::class, 'storeCredentials'])->name('register.credentials.submit');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::post('alumni/logout', [AuthenticatedSessionController::class, 'logout'])->name('alumni.logout');
    Route::post('admin/logout', [AuthenticatedSessionController::class, 'logout'])->name('admin.logout');
});
