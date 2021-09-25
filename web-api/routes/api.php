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

// Protected Routes:
Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', 'AuthController@logout');

    Route::apiResource('feedbacks', 'FeedbackController');
    Route::apiResource('posts', 'PostController');
    Route::apiResource('post-photos', 'PostPhotoController');
    Route::apiResource('post-types', 'PostTypeController');
    Route::apiResource('reports', 'ReportController');
    Route::apiResource('tags', 'TagController');
    Route::apiResource('users', 'UserController');

    // Districts
    Route::post('districts', 'DistrictController@store');
    Route::put('districts/{id}', 'DistrictController@update');
    Route::delete('districts/{id}', 'DistrictController@destroy');

    // Feedback Types
    Route::post('feedback-types', 'FeedbackTypeController@store');
    Route::put('feedback-types/{id}', 'FeedbackTypeController@update');
    Route::delete('feedback-types/{id}', 'FeedbackTypeController@destroy');

    // Report Conclusions
    Route::post('report-conclusions', 'ReportConclusionController@store');
    Route::put('report-conclusions/{id}', 'ReportConclusionController@update');
    Route::delete('report-conclusions/{id}', 'ReportConclusionController@destroy');

    // School Classes
    Route::post('school-classes', 'SchoolClassController@store');
    Route::put('school-classes/{id}', 'SchoolClassController@update');
    Route::delete('school-classes/{id}', 'SchoolClassController@destroy');

    // Schools
    Route::post('schools', 'SchoolController@store');
    Route::put('schools/{id}', 'SchoolController@update');
    Route::delete('schools/{id}', 'SchoolController@destroy');

    // User Types
    Route::post('user-types', 'UserTypeController@store');
    Route::put('user-types/{id}', 'UserTypeController@update');
    Route::delete('user-types/{id}', 'UserTypeController@destroy');
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

// Districts
Route::get('districts', 'DistrictController@index');
Route::get('districts/{id}', 'DistrictController@show');

// Feedback Types
Route::get('feedback-types', 'FeedbackTypeController@index');
Route::get('feedback-types/{id}', 'FeedbackTypeController@show');

// Report Conclusions
Route::get('report-conclusions', 'ReportConclusionController@index');
Route::get('report-conclusions/{id}', 'ReportConclusionController@show');

// School Classes
Route::get('school-classes', 'SchoolClassController@index');
Route::get('school-classes/{id}', 'SchoolClassController@show');

// Schools
Route::get('schools', 'SchoolController@index');
Route::get('schools/{id}', 'SchoolController@show');

// User Types
Route::get('user-types', 'UserTypeController@index');
Route::get('user-types/{id}', 'UserTypeController@show');

