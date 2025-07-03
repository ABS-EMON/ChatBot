<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {
        return response()->json(Chat::with('messages')->latest()->get());
    }

    public function store(Request $request)
    {
    $chat = Chat::create([
        'title' => $request->input('title', 'New Chat'),
    ]);

    // Don’t try to add a message yet — just return the chat
    return response()->json($chat->load('messages'));
    }

    public function storeMessage(Request $request, Chat $chat)
{
    $message = $chat->messages()->create([
        'role' => $request->input('role'),
        'content' => $request->input('content'),
    ]);

    return response()->json($message);
}
  public function update(Request $request, Chat $chat)
{
    $chat->update([
        'title' => $request->input('title'),
    ]);

    return response()->json($chat);
}



    public function addMessage(Request $request, Chat $chat)
    {
        $message = $chat->messages()->create([
            'role' => $request->input('role'),
            'content' => $request->input('content'),
        ]);

        $chat->touch();

        return response()->json($message);
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();
        return response()->json(['success' => true]);
    }
}
