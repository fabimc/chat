<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $limit = (int) $request->input('limit');
      $page = (int) $request->input('page');
      $chats = Chat::paginate($limit, ['*'], 'page', $page);

      $pagination = [
        'current_page' => $chats->currentPage(),
        'per_page' => $chats->perPage(),
        'page_count' => $chats->lastPage(),
        'total_count' => $chats->total(),
      ];

      $chatItems = $chats->items();

      $chatItems = collect($chatItems)->map(function ($item, $key) {
        $item->last_chat_message = $item->latestMessage($key);

        if ( ! is_null($item->last_chat_message )) {
          $item->last_chat_message->user = User::where('id', $item->last_chat_message->user_id)->select('id', 'name', 'email')->get();
          unset($item->last_chat_message->updated_at);
        }

        $item->users = $item->getUsers($key);
        return $item;
      });

      $response = [
        'data' => $chatItems,
        'meta' => $pagination
      ];

      return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      try {
        $user = collect(JWTAuth::toUser(JWTAuth::getToken()))
          ->only('id', 'name', 'email');

        $chatReq = $request->only('name', 'message');

        $chatId = Chat::insertGetId([
          'name' => $chatReq['name']
        ]);

        $messageId = Message::insertGetId([
          'message' => $chatReq['message'],
          'user_id' => $user['id'],
          'chat_id' => $chatId
        ]);

        $last_chat_message = Message::where('id', '=', $messageId)->get()->first();
        unset($last_chat_message->updated_at);
        $last_chat_message->user = $user;
        $data = [
          'id' => $chatId,
          'name' => $chatReq['name'],
          'users' => [
              $user
          ],
          'last_chat_message' => $last_chat_message
        ];

        $response = [
          'data' => $data,
          'meta' => json_decode ("{}")
        ];

        return $response;

      } catch (Exception $e) {
        return response()->json([
          'errors' => [
            'message' => 'Operation Failed',
            'errors' => [
              'generic' => 'Something went wrong'
            ]
          ]], 500);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $chatId)
    {
      $chatReq = $request->only('name');
      try {
        Chat::where('id', '=', $chatId)
          ->update([
            'name' => $chatReq['name']
          ]);

        $chat = new Chat();

        $user = collect(JWTAuth::toUser(JWTAuth::getToken()))
          ->only('id', 'name', 'email');

        $last_chat_message = $chat->latestMessage($chatId);

        if (! is_null($last_chat_message)) {
          unset($last_chat_message->updated_at);
          $last_chat_message->user = User::where('id', $last_chat_message->user_id)->select('id', 'name', 'email')->get();
        }

        $users = $chat->getUsers($chatId);

        $data = [
          'id' => $chatId,
          'name' => $chatReq['name'],
          'users' => $users,
          'last_chat_message' => $last_chat_message
        ];

        $response = [
          'data' => $data,
          'meta' => json_decode ("{}")
        ];

        return $response;

      } catch (Exception $e) {
        return response()->json([
          'errors' => [
            'message' => 'Operation Failed',
            'errors' => [
              'generic' => 'Something went wrong'
            ]
          ]], 500);
      }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
