<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  $name = 'Chat';
  $resources = [
      'POST /api/auth/login',
      'GET /api/auth/logout',
      'POST /api/users',
      'GET /api/users/current',
      'PATCH /api/users/current',
      'GET /api/chats{?page,limit}' ,
      'POST /api/chats',
      'PATCH /api/chats/{id}',
      'GET /api/chats/{id}/chat_messages{?page,limit}',
      'POST /api/chats/{id}/chat_messages'
  ];
  return view('welcome', compact('name', 'resources'));
});
