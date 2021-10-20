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

/**
 * User Profile
 */
Route::get('/dash/{id}', [App\Http\Controllers\UserProfileController::class, 'index'])->name('dash');
Route::post('/dash/update_profile/{id}', [App\Http\Controllers\UserProfileController::class, 'updateProfile'])->name('dash.update_profile');

/**
 * Tattoos
 */
Route::get('/tattoo/upload', [App\Http\Controllers\TattooController::class, 'index'])->name('tattoo.upload');
Route::post('/tattoo/upload/store', [App\Http\Controllers\TattooController::class, 'store'])->name('tattoo.upload-store');