<?php

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
    return redirect(route('albums.index'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function()
{

    Route::resource('albums', App\Http\Controllers\GalleryController::class);

    Route::patch('/images/move/{album}', [App\Http\Controllers\GalleryController::class, 'changeAlbum'])->name('move.photos');

    Route::post('/images/{album}', [App\Http\Controllers\ImageController::class, 'store'])->name('album.upload');
    Route::delete('/images/{image}', [App\Http\Controllers\ImageController::class, 'destroy'])->name('images.desrtoy');
}
);

