<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/resep/{slug}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/resep-baru', [RecipeController::class, 'create'])->name('recipes.create');
Route::post('/resep', [RecipeController::class, 'store'])->name('recipes.store');
Route::get('/resep/{slug}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
Route::put('/resep/{slug}', [RecipeController::class, 'update'])->name('recipes.update');
Route::delete('/resep/{slug}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
Route::post('/resep/{slug}/like', [RecipeController::class, 'like'])->name('recipes.like');

Route::get('/kategori', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/kategori', [CategoryController::class, 'store'])->name('categories.store');
Route::delete('/kategori/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');