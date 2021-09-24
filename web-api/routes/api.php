<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', 'AuthController@logout');
    Route::apiResource('feedbacks', 'FeedbackController');
    Route::apiResource('posts', 'PostController');
    Route::apiResource('post-photos', 'PostPhotoController');
    Route::apiResource('post-types', 'PostTypeController');
    Route::apiResource('reports', 'ReportController');
    Route::apiResource('tags', 'TagController');
    Route::apiResource('users', 'UserController');
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::apiResource('districts', 'DistrictController');
Route::apiResource('feedback-types', 'FeedbackTypeController');
Route::apiResource('report-conclusions', 'ReportConclusionController');
Route::apiResource('school-classes', 'SchoolClassController');
Route::apiResource('schools', 'SchoolController');
Route::apiResource('user-types', 'UserTypeController');

