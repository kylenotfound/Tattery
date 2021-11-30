<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/explore', [App\Http\Controllers\ExploreController::class, 'index'])->name('explore');

/**
 * User Profile
 */
Route::get('/dash/{id}', [App\Http\Controllers\UserController::class, 'index'])->name('dash');
Route::post('/dash/update_profile/{id}', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('dash.update_profile');
Route::post('/dash/{id}/delete', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('user.delete');

/**
 * User Settings
 */
Route::get('/{id}/settings', [App\Http\Controllers\UserAccountSettingsController::class, 'index'])->name('user.settings');

/**
 * Search
 */

Route::get('/search', [App\Http\Controllers\SearchController::class, 'returnUserSearch'])->name('search');


/**
 * Tattoos
 */
Route::get('/tattoo/upload', [App\Http\Controllers\TattooController::class, 'index'])->name('tattoo.upload');
Route::post('/tattoo/upload/store', [App\Http\Controllers\TattooController::class, 'store'])->name('tattoo.upload-store');
Route::post('/tattoo/delete/{id}', [App\Http\Controllers\TattooController::class, 'delete'])->name('tattoo.delete');

/**
 * Like a Tattoo
 */
Route::post('/like/{id}', [App\Http\Controllers\LikeController::class, 'like'])->name('tattoo.like');
Route::post('/unlike/{id}', [App\Http\Controllers\LikeController::class, 'unlike'])->name('tattoo.unlike');
