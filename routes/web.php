<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JsonController;

Route::get('/check-theme', function (Request $request) {
    $theme = $request->cookie('theme', 'not set');

    return "Your preferred theme is: " . $theme;
});

Route::get('/', [JsonController::class, 'index']);

Route::resource('students', StudentController::class);

Route::get('/register', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/register', [RegistrationController::class, 'store'])->name('registration.store');