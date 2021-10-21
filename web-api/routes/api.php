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

    Route::get('feedbacks', 'FeedbackController@index')->middleware('ismoderator');
    Route::get('feedbacks/{id}', 'FeedbackController@show')->middleware('ismoderator');
    Route::post('feedbacks', 'FeedbackController@store')->middleware('throttle:1,1');
    Route::put('feedbacks/{id}', 'FeedbackController@update')->middleware('ismoderator');
    Route::delete('feedbacks/{id}', 'FeedbackController@destroy')->middleware('ismoderator');

    Route::apiResource('post-photos', 'PostPhotoController');

    Route::get('reports', 'ReportController@index')->middleware('ismoderator');
    Route::get('reports/{id}', 'ReportController@show')->middleware('ismoderator');
    Route::post('reports', 'ReportController@store')->middleware('throttle:1,1');
    Route::put('reports/{id}', 'ReportController@update')->middleware('ismoderator');
    Route::delete('reports/{id}', 'ReportController@destroy')->middleware('ismoderator');

    // Route::apiResource('reports', 'ReportController');
    Route::apiResource('tags', 'TagController');
    // Route::apiResource('users', 'UserController');

    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show');
    Route::put('users/{id}', 'UserController@update')->middleware('ismoderator');
    Route::delete('users/{id}', 'UserController@destroy')->middleware('ismoderator');

    Route::apiResource('districts', 'DistrictController');
    Route::apiResource('feedback-types', 'FeedbackTypeController');
    Route::apiResource('report-conclusions', 'ReportConclusionController');
    Route::apiResource('school-classes', 'SchoolClassController');
    Route::apiResource('schools', 'SchoolController');
    Route::apiResource('user-types', 'UserTypeController');
    Route::apiResource('comments', 'CommentController');

    Route::get('comments', 'CommentController@index');
    Route::get('comments/{id}', 'CommentController@show');
    Route::post('comments', 'CommentController@store')->middleware('throttle:1,1');
    Route::put('comments/{id}', 'CommentController@update')->middleware('ismoderator');
    Route::delete('comments/{id}', 'CommentController@destroy')->middleware('ismoderator');

    // posts
    Route::get('posts', 'PostController@index');
    Route::get('posts/{id}', 'PostController@show');
    Route::post('posts', 'PostController@store')->middleware('throttle:1,1');
    Route::put('posts/{id}', 'PostController@update');
    Route::delete('posts/{id}', 'PostController@destroy');
    Route::post('posts/get-by-tags', 'PostController@getPostsByTags');

    Route::apiResource('post-types', 'PostTypeController');

    Route::post('image-upload', 'ImageUploadController@store');
    Route::post('get-profile-picture', 'ImageUploadController@getProfilePicture');

    Route::get('notifications', 'NotificationController@index');
    Route::post('mark-notification', 'NotificationController@markNotification');
});

Route::get('email/resend','VerificationController@resend')->name('verification.resend');
Route::get('email/is-verified', 'VerificationController@isUserVerified');

// Users
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::get('email/verify/{id}/{hash}','VerificationController@verify')->name('verification.verify');

Route::get('districts', 'DistrictController@index');
Route::get('districts/{id}', 'DistrictController@show');

Route::get('school-classes', 'SchoolClassController@index');
Route::get('school-classes/{id}', 'SchoolClassController@show');