<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('forgot-password', [ForgotPasswordController::class, 'forgot'])->name('password.email');

Route::get('reset-password/', [ForgotPasswordController::class, 'reset'])->name('password.reset');
