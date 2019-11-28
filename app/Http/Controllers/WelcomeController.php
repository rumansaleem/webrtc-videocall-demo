<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        return view('index', [
            'availableUsers' => User::where('id', '<>', Auth::id())->get()
        ]);
    }
}
