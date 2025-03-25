<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Question routes
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/show', [QuestionController::class, 'show'])->name('questions.show');
    Route::post('/questions/answer', [QuestionController::class, 'answer'])->name('questions.answer');
    Route::get('/questions/{question}/result', [QuestionController::class, 'result'])->name('questions.result');

    // Picture routes
    Route::get('/pictures', [PictureController::class, 'index'])->name('pictures.index');
    Route::get('/pictures/create', [PictureController::class, 'create'])->name('pictures.create');
    Route::post('/pictures', [PictureController::class, 'store'])->name('pictures.store');
    Route::get('/pictures/{picture}', [PictureController::class, 'show'])->name('pictures.show');
    Route::delete('/pictures/{picture}', [PictureController::class, 'destroy'])->name('pictures.destroy');

    // Rating routes
    Route::post('/pictures/{picture}/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');

    // Profile routes (already defined by Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
