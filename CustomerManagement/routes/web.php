<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
Route::get('/', function () {
    return Inertia::render('Layout', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION, ]);
});
route::get('res',[CustomerController::class,"vbot"]);
route::get('chat',[CustomerController::class,"bot"]);
route::delete('/delete',[CustomerController::class,'deleteall']);
Route::post('/import', [CustomerController::class, 'import'])->name('import');
Route::put('/posts/{id}', [CustomerController::class, 'update'])->name('posts.update');
Route::get('/posts/export', [CustomerController::class, 'export']);
Route::delete('/posts/{id}', [CustomerController::class, 'destroy']);
route::get('/modal',[CustomerController::class,"userShow"]);
route::get('/View',[CustomerController::class,"Show"]);
route::get('/user',[CustomerController::class,"display"]);
route::post('/custreg',[CustomerController::class, 'custreg']);
Route::get('/hello',[CustomerController::class, 'index']);
Route::post('/register-user',[CustomerController::class,'create']);
Route::get('/Auth/Login',[CustomerController::class,'login']);
Route::post('/Auth/Login',[CustomerController::class, 'flogin']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
