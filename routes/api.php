<?php

use Illuminate\Http\Request;

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

Route::get('feedback-score', 'FeedbackController@score');

Route::resource('feedback', 'FeedbackController', ['only' => ['index', 'store', 'update']]);

Route::resource('area', 'AreaController', ['only' => ['index']]);

Route::resource('feedback-category', 'FeedbackCategoryController', ['only' => ['index']]);

Route::resource('fixing-stages', 'FixingStagesController', ['only' => ['index']]);
