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
Route::post('/dash/update_display_name/{id}', [App\Http\Controllers\UserProfileController::class, 'updateDisplayName'])->name('dash.update_display_name');

