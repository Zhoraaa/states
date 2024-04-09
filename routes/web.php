<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::get('/', [PostController::class, "allPosts"])->name('home');

// Новости
Route::get('/news', [PostController::class, "postEditor"])->middleware('auth')->name('postNew');
Route::get('/news/{id}', [PostController::class, "seePost"])->name('seePost');
Route::get('/news/{id}/edit', [PostController::class, "postEditor"])->name('postEdit');
Route::get('/news/{id}/delete', [PostController::class, "postDelete"])->name('postDelete');
Route::post('/news/save', [PostController::class, "postSave"])->middleware('auth')->name('savePost');

// Лайки
Route::get('/news/{id}/react/{react}', [LikeController::class, "react"])->middleware('auth')->name('react');

// Комменты
Route::post('/news/{id}/comment', [CommentController::class, "commNew"])->middleware('auth')->name('commNew');
Route::get('/comm/{id}/delete', [CommentController::class, "commDel"])->middleware('auth')->name('commDel');

// Блокировка постов
Route::get('/news/{id}/block', [PostController::class, "block"])->middleware('auth')->name('block');

// Пользователи
Route::get('/user', function () { return view('user.perArea'); })->middleware('auth')->name("user");
Route::get('/user/auth', function () { return view('user.authPage'); })->middleware('guest')->name("auth");
Route::get('/user/reg', function () { return view('user.regPage'); })->middleware('guest')->name("reg");
Route::post('/user/exit', [UserController::class, "logOut"])->middleware('auth')->name("logout");
Route::post('/user/new', [UserController::class, "signUp"])->name("signUp");
Route::post('/user/auth', [UserController::class, "signIn"])->name("signIn");

// Админка
Route::get('/admin/usrRedaction', [AdminController::class, "usrRedaction"])->middleware('auth')->name('usrRedaction');
Route::post('/admin/doMod/{id}', [AdminController::class, "doMod"])->middleware('auth')->name('doMod');
Route::post('/admin/undoMod/{id}', [AdminController::class, "undoMod"])->middleware('auth')->name('undoMod');
Route::post('/admin/ban/{id}', [AdminController::class, "ban"])->middleware('auth')->name('ban');
Route::post('/admin/unban/{id}', [AdminController::class, "unban"])->middleware('auth')->name('unban');