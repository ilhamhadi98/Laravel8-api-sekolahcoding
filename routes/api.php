<?php

use App\Http\Controllers\ForumController;
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

Route::group(['middleware' => 'api'], function ($router) {

    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
        Route::post('register', 'RegisterController@register');
    });

    Route::apiResource('forums', 'ForumController');

    // forums/{{ idforum }}/comments/{{ idcomments }}
    Route::apiResource('forums.comments', 'ForumCommentController');

    // Filter by Category
    Route::get('forums/tag/{tag}', 'ForumController@filterTag');

    // User Profile
    Route::get('@{username}', 'UserController@show');
});
