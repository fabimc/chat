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

Route::post('auth/login', 'AuthenticateController@login');

Route::group([
    //'prefix' => '',
    'middleware' => 'auth:api',
], function () {

    // Authentication Routes...
    Route::get('auth/logout', 'AuthenticateController@logout');
    Route::get('users/current', 'AuthenticateController@user');
    Route::patch('users/current', 'AuthenticateController@update');
    Route::post('users', 'UserController@create');
    Route::get('chats', 'ChatController@index');
    Route::post('chats', 'ChatController@create');
    Route::patch('chats/{id}', 'ChatController@update');
    Route::get('chats/{id}/chat_messages', 'MessageController@index');
    Route::post('chats/{id}/chat_messages', 'MessageController@create');
});
