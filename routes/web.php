<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/all', [HomeController::class, 'allCategories'])->name('home.all');

Route::get('/admin', [AdminController::class, 'index'])->middleware('can:admin.index')->name('admin.index');

Route::prefix('admin')->group(function () {
    Route::resource('articles', ArticleController::class)->except('show')->names('articles');
    Route::resource('categories', CategoryController::class)->except('show')->names('categories');
    Route::resource('comments', CommentController::class)->except('index')->names('comments');
    Route::resource('users', UserController::class)->except('create', 'store', 'show')->names('users');
    Route::resource('roles', RoleController::class)->except('show')->names('roles');
});

Route::get('/articles', [HomeController::class, 'index'])->name('articles.index');
Route::resource('articles', ArticleController::class)->except('show')->names('articles');
Route::resource('categories', CategoryController::class)->except('show')->names('categories');
Route::resource('comments', CommentController::class)->only('index', 'destroy')->names('comments');
Route::resource('profiles', ProfileController::class)->only('edit', 'update', 'show')->names('profiles');

//Ver articulos
Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');

//Ver articulos por categorias:
Route::get('category/{category}', [CategoryController::class, 'detail'])->name('categories.detail');

//Guardar comentarios:
Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');

Auth::routes();