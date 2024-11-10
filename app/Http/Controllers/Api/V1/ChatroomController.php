<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Chatroom;
use App\Models\UserChatroom;
use Illuminate\Http\Request;

class ChatroomController extends Controller
{
public function create(Request $request) {
    $chatroom = Chatroom::create($request->all());
    return response()->json(['status' => 'success', 'data' => $chatroom]);
}
    public function index(Request $request) {
    $chatrooms = Chatroom::paginate(10);
    return response()->json(['status' => 'success', 'data' => $chatrooms]);
}
    public function enter(Request $request, Chatroom $chatroom) {
    if ($chatroom->users()->count() < $chatroom->max_members) {
        UserChatroom::create([ 'user_id' => $request->user()->id, 'chatroom_id' => $chatroom->id, ]);
        return response()->json(['status' => 'success', 'message' => 'Entered chatroom']); }
    return response()->json(['status' => 'error', 'message' => 'Chatroom is full']);
  }
    public function leave(Request $request, Chatroom $chatroom) {
    UserChatroom::where([ 'user_id' => $request->user()->id, 'chatroom_id' => $chatroom->id, ])->delete();
    return response()->json(['status' => 'success', 'message' => 'Left chatroom']);
   }

}
