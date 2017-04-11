<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $chatId)
    {
      $limit = (int) $request->input('limit');
      $page = (int) $request->input('page');

      try {
        $messages = Message::where('chat_id', $chatId)
          ->latest()
          ->paginate($limit, ['*'], 'page', $page);

        $pagination = [
          'current_page' => $messages->currentPage(),
          'per_page' => $messages->perPage(),
          'page_count' => $messages->lastPage(),
          'total_count' => $messages->total(),
        ];

        $messageItems = $messages->items();

        $messageItems = collect($messageItems)->map(function ($item, $key) {
          unset($item->updated_at);
          $item->user = User::where('id', $item->user_id)->select('id', 'name', 'email')
            ->get()
            ->first();
          return $item;
        });

        $response = [
          'data' => $messageItems,
          'meta' => $pagination
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $chatId)
    {
      try {
        $user = collect(JWTAuth::toUser(JWTAuth::getToken()))
          ->only('id', 'name', 'email');

        $messageReq = $request->only('message');

        $messageId = Message::insertGetId([
          'message' => $messageReq['message'],
          'user_id' => $user['id'],
          'chat_id' => $chatId
        ]);

        $message = Message::where('id', $messageId)
          ->get()
          ->first();

        unset($message->updated_at);

        $message->user = $user;

        $response = [
          'data' => $message,
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
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
