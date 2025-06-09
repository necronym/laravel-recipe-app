<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;

Route::get('/', [RecipeController::class, 'index'])->name('home');

Route::get('/dashboard', [ProfileController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');


// PUBLIC
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');

// AUTHENTICATED
Route::middleware(['auth'])->group(function () {
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
});

// PUBLIC
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// Comments
Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
});

// Ratings
Route::middleware(['auth'])->group(function () {
    Route::post('/recipes/{recipe}/rate', [RatingController::class, 'store'])->name('ratings.store');
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
});

// User Profiles for Public Viewing
Route::get('/users/{id}', [ProfileController::class, 'publicProfile'])->name('user.profile');

Route::middleware(['auth'])->group(function () {
    Route::delete('/admin/ban/{user}', [AdminController::class, 'ban'])->name('admin.ban');
});

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
