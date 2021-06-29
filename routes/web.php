
<!-- 
Route::resource('/',WelcomeController::class);

// Route::get('/', function () {
//      return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';  -->


<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::resource('/',WelcomeController::class);
// Route::get('post/{id}', [PostController::class, 'index']);
// Route::resource('post', PostController::class, ['except' => ['index',
// 'create']]);


Route::get('search', [PostController::class, 'search']);
Route::delete('Comment/{comment_id}/destroy', [PostController::class, 'destroyComment']);
Route::put('Comment/{comment_id}/update', [PostController::class, 'updateComment']);
Route::get('post/{id}', [PostController::class, 'index']);
Route::resource('post',PostController::class);


Route::get('user/{id}', [UserController::class, 'index']);
Route::resource('user',UserController::class);

Route::get('message/{id}', [MessageController::class, 'showMessage']);
Route::get('message/new/{id}', [MessageController::class, 'sendMessage']);
Route::resource('messages',MessageController::class);

Route::get('lang/{locale}',LanguageController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';  

