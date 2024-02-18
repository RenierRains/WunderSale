<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function fetchMessages(Request $request, $userId)
    {
        $messages = Message::where(function($q) use ($userId) {
            $q->where('from_user_id', auth()->id());
            $q->where('to_user_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('from_user_id', $userId);
            $q->where('to_user_id', auth()->id());
        })->get();

        return response()->json($messages);
    }

public function sendMessage(Request $request)
    {
        $message = auth()->user()->messagesSent()->create([
            'to_user_id' => $request->user_id,
            'body' => $request->message
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
