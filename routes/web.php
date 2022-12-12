<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[AlbumController::class,'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // albums routes
    Route::get('select-status-delete/{id}', [AlbumController::class, 'status_delete'])->name('album.select-status-delete');
    Route::resource('albums', AlbumController::class);

    // images route
    Route::group(['middleware' => 'auth', 'prefix' => 'images', 'as' => 'images.'], function () {
        Route::get('create/{album_id}', [ImageController::class, 'create'])->name('create');
        Route::post('store/{album_id}', [ImageController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ImageController::class, 'edit'])->name('edit');
        Route::patch('update/{id}', [ImageController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [ImageController::class, 'destroy'])->name('destroy');

    }
    );

});


require __DIR__.'/auth.php';
