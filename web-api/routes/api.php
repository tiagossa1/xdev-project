<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('districts', 'DistrictController');
Route::apiResource('feedbacks', 'FeedbackController');
Route::apiResource('feedback_types', 'FeedbackTypeController');
Route::apiResource('posts', 'PostController');
Route::apiResource('post_photos', 'PostPhotoController');
Route::apiResource('post_types', 'PostTypeController');
Route::apiResource('report_conclusions', 'ReportConclusionController');
Route::apiResource('reports', 'ReportController');
Route::apiResource('school_classes', 'SchoolClassController');
Route::apiResource('schools', 'SchoolController');
Route::apiResource('tags', 'TagController');
Route::apiResource('users', 'UserController');
Route::apiResource('user_types', 'UserTypeController');

