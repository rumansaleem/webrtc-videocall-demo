<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $users = User::where('id', '<>', Auth::id())->get()->pluck('name', 'id');

        $video_chats = Auth::user()->video_chats()
            ->with(['users' => function($q) {
                $q->where('users.id', '<>', Auth::id());
            }])->get();

        return view('index', compact('video_chats', 'users'));
    }
}
