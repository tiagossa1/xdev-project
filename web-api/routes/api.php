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
    Route::post('change-password', 'AuthController@changePassword');

    Route::apiResource('feedbacks', 'FeedbackController');

    Route::apiResource('post-photos', 'PostPhotoController');

    Route::apiResource('reports', 'ReportController');
    Route::apiResource('tags', 'TagController');
    Route::apiResource('users', 'UserController');
    Route::apiResource('districts', 'DistrictController');
    Route::apiResource('feedback-types', 'FeedbackTypeController');
    Route::apiResource('report-conclusions', 'ReportConclusionController');
    Route::apiResource('school-classes', 'SchoolClassController');
    Route::apiResource('schools', 'SchoolController');
    Route::apiResource('user-types', 'UserTypeController');
    Route::apiResource('comments', 'CommentController');
    Route::apiResource('posts', 'PostController');
    Route::apiResource('post-types', 'PostTypeController');

    Route::post('image-upload', 'ImageUploadController@store');
    Route::post('get-profile-picture', 'ImageUploadController@getProfilePicture');
    // Route::apiResource('image-upload', 'ImageUploadController');

    Route::get('notifications', 'NotificationController@index');
});

// Users
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

/*
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
*/

Route::get('districts', 'DistrictController@index');
Route::get('districts/{id}', 'DistrictController@show');

Route::get('school-classes', 'SchoolClassController@index');
Route::get('school-classes/{id}', 'SchoolClassController@show');

Route::post('getTotalPostsByUserId', 'PostController@getTotalPostsByUserId');

// TEMPORÁRIO!!!! acrescentar ao middleware
// Route::apiResource('posts', 'PostController');
// Route::apiResource('post-types', 'PostTypeController');


