<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Attachments;
use App\Models\Chatroom;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request, Chatroom $chatroom) {
        $message = Message::create([ 'chatroom_id' => $chatroom->id, 'user_id' => $request->user()->id, 'message' => $request->message, ]);
        if ($request->hasFile('attachment')) { $filePath = $request->file('attachment')->store('attachments');
            Attachments::create([ 'message_id' => $message->id, 'file_path' => $filePath, ]); } // Broadcast event to WebSocket
        broadcast(new \App\Events\MessageSent($chatroom, $message))->toOthers(); return response()->json(['status' => 'success', 'data' => $message]); }
    public function index(Request $request, Chatroom $chatroom) {
        $messages = Message::where('chatroom_id', $chatroom->id)->paginate(10);
        return response()->json(['status' => 'success', 'data' => $messages]);
    }
}
