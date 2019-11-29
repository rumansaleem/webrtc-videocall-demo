<?php

namespace App\Http\Controllers;

use App\VideoChat;
use Illuminate\Http\Request;

class VideoChatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id'
        ]);

        $chat = VideoChat::create();
        $chat->users()->sync([auth()->id(), $request->user_id]);

        return redirect()->back();
    }

    public function show(VideoChat $video_chat)
    {
        return view('video_chats.show', compact('video_chat'));
    }
}
