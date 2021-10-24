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
    Route::get('is-moderator', 'AuthController@isModerator');
    Route::get('is-sheriff', 'AuthController@isSheriff');
    Route::get('get-user', 'AuthController@getUserByToken');

    Route::get('feedbacks', 'FeedbackController@index')->middleware('ismoderator');
    Route::get('feedbacks/{id}', 'FeedbackController@show')->middleware('ismoderator');
    Route::post('feedbacks', 'FeedbackController@store')->middleware('throttle:1,1');
    Route::put('feedbacks/{id}', 'FeedbackController@update')->middleware('ismoderator');
    Route::delete('feedbacks/{id}', 'FeedbackController@destroy')->middleware('ismoderator');

    Route::get('post-photos', 'PostPhotoController@index');
    Route::get('post-photos/{id}', 'PostPhotoController@show');
    Route::post('post-photos', 'PostPhotoController@store');
    Route::put('post-photos/{id}', 'PostPhotoController@update');
    Route::delete('post-photos/{id}', 'PostPhotoController@destroy');

    Route::get('reports', 'ReportController@index')->middleware('ismoderator');
    Route::get('reports/{id}', 'ReportController@show')->middleware('ismoderator');
    Route::post('reports', 'ReportController@store')->middleware('throttle:1,1');
    Route::put('reports/{id}', 'ReportController@update')->middleware('ismoderator');
    Route::delete('reports/{id}', 'ReportController@destroy')->middleware('ismoderator');

    Route::get('tags', 'TagController@index');
    Route::get('tags/{id}', 'TagController@show');
    Route::post('tags', 'TagController@store')->middleware('ismoderator');
    Route::put('tags/{id}', 'TagController@update')->middleware('ismoderator');
    Route::delete('tags/{id}', 'TagController@destroy')->middleware('ismoderator');

    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show');
    Route::get('recent-activity/{id}', 'UserController@getRecentActivity');
    Route::put('users/{id}', 'UserController@update')->middleware('ismoderator');
    Route::delete('users/{id}', 'UserController@destroy')->middleware('ismoderator');

    Route::post('districts', 'DistrictController@store')->middleware('ismoderator');
    Route::put('districts/{id}', 'DistrictController@update')->middleware('ismoderator');
    Route::delete('districts/{id}', 'DistrictController@destroy')->middleware('ismoderator');

    Route::get('feedback-types', 'FeedbackTypeController@index');
    Route::get('feedback-types/{id}', 'FeedbackTypeController@show');
    Route::post('feedback-types', 'FeedbackTypeController@store')->middleware('ismoderator');
    Route::put('feedback-types/{id}', 'FeedbackTypeController@update')->middleware('ismoderator');
    Route::delete('feedback-types/{id}', 'FeedbackTypeController@destroy')->middleware('ismoderator');

    Route::get('report-conclusions', 'ReportConclusionController@index')->middleware('ismoderator');
    Route::get('report-conclusions/{id}', 'ReportConclusionController@show')->middleware('ismoderator');
    Route::post('report-conclusions', 'ReportConclusionController@store')->middleware('ismoderator');
    Route::put('report-conclusions/{id}', 'ReportConclusionController@update')->middleware('ismoderator');
    Route::delete('report-conclusions/{id}', 'ReportConclusionController@destroy')->middleware('ismoderator');

    Route::post('school-classes', 'SchoolClassController@store')->middleware('ismoderator');
    Route::put('school-classes/{id}', 'SchoolClassController@update')->middleware('ismoderator');
    Route::delete('school-classes/{id}', 'SchoolClassController@destroy')->middleware('ismoderator');

    Route::get('schools', 'SchoolController@index');
    Route::get('schools/{id}', 'SchoolController@show');
    Route::post('schools', 'SchoolController@store')->middleware('ismoderator');
    Route::put('schools/{id}', 'SchoolController@update')->middleware('ismoderator');
    Route::delete('schools/{id}', 'SchoolController@destroy')->middleware('ismoderator');

    Route::get('user-types', 'UserTypeController@index');
    Route::get('user-types/{id}', 'UserTypeController@show');
    Route::post('user-types', 'UserTypeController@store')->middleware('ismoderator');
    Route::put('user-types/{id}', 'UserTypeController@update')->middleware('ismoderator');
    Route::delete('user-types/{id}', 'UserTypeController@destroy')->middleware('ismoderator');

    Route::get('comments', 'CommentController@index');
    Route::get('comments/{id}', 'CommentController@show');
    Route::post('comments', 'CommentController@store')->middleware('throttle:1,1');
    Route::put('comments/{id}', 'CommentController@update')->middleware('ismoderator');
    Route::delete('comments/{id}', 'CommentController@destroy')->middleware('ismoderator');

    // posts
    Route::get('posts', 'PostController@index');
    Route::get('posts/{id}', 'PostController@show');
    // Route::post('posts', 'PostController@store')->middleware('throttle:1,1');
    Route::post('posts', 'PostController@store');
    Route::put('posts/{id}', 'PostController@update');
    Route::delete('posts/{id}', 'PostController@destroy');
    Route::post('posts/get-by-tags', 'PostController@getPostsByTags');

    Route::get('post-types', 'PostTypeController@index');
    Route::get('post-types/{id}', 'PostTypeController@show');
    Route::post('post-types', 'PostTypeController@store');
    Route::put('post-types/{id}', 'PostTypeController@update')->middleware('ismoderator');
    Route::delete('post-types/{id}', 'PostTypeController@destroy')->middleware('ismoderator');

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