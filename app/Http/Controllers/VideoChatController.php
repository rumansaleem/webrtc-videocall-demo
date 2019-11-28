<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoChatController extends Controller
{
    public function show() {
        return view('video_chats.show');
    }
}
