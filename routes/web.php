<?php

use Illuminate\Support\Facades\Route;

// with actions
use App\Http\Controllers\Actions\GetUserProfile;
use App\Http\Controllers\Actions\UpdateUser;
use App\Http\Controllers\Actions\DeleteUser;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // with actions
    Route::get('/profile', GetUserProfile::class)->name('profile.edit');
    Route::patch('/profile', UpdateUser::class)->name('profile.update');
    Route::delete('/profile', DeleteUser::class)->name('profile.destroy');
});

require __DIR__ . '/auth.php';
