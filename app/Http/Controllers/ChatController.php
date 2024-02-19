<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Conversation;
use App\Models\Message; 
use App\Events\MessageSent; 


class ChatController extends Controller
{
    public function startChat(Request $request) {
        $buyerId = auth()->id();
        $sellerId = $request->seller_id;
    
        // check if past convo exist?
        $conversation = Conversation::where(function($query) use ($buyerId, $sellerId) {
            $query->where('user_one', $buyerId)->where('user_two', $sellerId);
        })->orWhere(function($query) use ($buyerId, $sellerId) {
            $query->where('user_one', $sellerId)->where('user_two', $buyerId);
        })->first();
    
        // else if, create a new convo
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one' => $buyerId,
                'user_two' => $sellerId
            ]);
        }
    
        return response()->json(['conversation_id' => $conversation->id]);
    }
    
    public function fetchMessages($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'body' => $request->body,
            'conversation_id' => $request->conversation_id,
            'user_id' => auth()->id(),
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function fetchConversation($conversationId)
    {
        $conversation = Conversation::with('messages')->find($conversationId);

        if (!$conversation) {
            return response()->json(['message' => 'Conversation not found'], 404);
        }

        return response()->json($conversation);
    }


}
