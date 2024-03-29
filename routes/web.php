<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class,'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Posts
    Route::get('/post/create',[PostController::class, 'create'])->name('post.create');
    Route::post('/post/create',[PostController::class, 'store']);
    Route::get('/post/edit{post}',[PostController::class, 'edit'])->name('post.edit');
    Route::post('/post/edit{post}',[PostController::class, 'update'])->name('post.update');
    Route::delete('/post/delete{post}',[PostController::class, 'destroy'])->name('post.delete');
    Route::get('/post{post}/detail',[PostController::class, 'detail'])->name('post.detail');

    //Comments
    Route::post('post{post}/comment/create',[CommentController::class, 'store'])->name('comment.store');
    Route::get('/comment{comment}/edit',[CommentController::class, 'edit'])->name('comment.edit');
    Route::post('/comment{comment}/edit',[CommentController::class, 'update']);
    Route::delete('/comment{comment}/delete',[CommentController::class, 'destroy'])->name('comment.delete');
});

require __DIR__.'/auth.php';
