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

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::apiResource('districts', 'DistrictController');
});

Route::apiResource('feedbacks', 'FeedbackController');
Route::apiResource('feedback_types', 'FeedbackTypeController');
Route::apiResource('posts', 'PostController');
Route::apiResource('post-photos', 'PostPhotoController');
Route::apiResource('post-types', 'PostTypeController');
Route::apiResource('report-conclusions', 'ReportConclusionController');
Route::apiResource('reports', 'ReportController');
Route::apiResource('school-classes', 'SchoolClassController');
Route::apiResource('schools', 'SchoolController');
Route::apiResource('tags', 'TagController');
Route::apiResource('users', 'UserController');
Route::apiResource('user-types', 'UserTypeController');

