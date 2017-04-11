<?php

namespace App;

use App\Message;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
  public function messages()
  {
    return $this->hasMany(Message::class);
  }

  public function latestMessage($chatId)
  {
    return Message::where('chat_id', $chatId)
      ->latest()
      ->first();
  }

  public function getUsers($chatId)
  {
    return User::join('messages', 'messages.user_id', '=', 'users.id')
      ->join('chats', function ($join) use( &$chatId) {
        $join->on('messages.chat_id', '=', 'chats.id')
          ->where('chats.id', '=', $chatId);
      })
      ->select('users.id', 'users.name', 'users.email')
      ->get();
  }

  public function addMessage($message)
  {
    $this->messages()->create(compact('message'));
  }
}
