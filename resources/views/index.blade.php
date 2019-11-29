@extends('layouts.master')
@section('content')
<div class="container mx-auto px-4 h-screen flex flex-col items-center justify-center">
    <div class="md:w-1/2 bg-white border rounded-lg shadow-md mb-12 overflow-hidden">
        <div class="border-b pt-4 pb-2 px-6">
            <h1 class="text-2xl">Create a Video Chat</h1>
        </div>
        <form class="px-6 py-2 bg-gray-100 flex leading-none"
            method="POST" action="{{ route('video_chats.store') }}">
            @csrf
            <select name="user_id" class="flex-1 bg-white px-3 py-2 border rounded">
                @foreach ($users as $id => $user)
                <option value="{{ $id }}">{{ $user }}</option>
                @endforeach
            </select>
            <button class="mx-2 px-3 py-2 rounded bg-blue-500 text-white hover:bg-blue-700">Create</button>
        </form>
    </div>
    <div class="md:w-1/2 bg-white border rounded-lg shadow-md overflow-hidden">
        <div class="border-b pt-4 pb-2 px-6">
            <h1 class="text-2xl">Start Chatting</h1>
        </div>
        <div class="px-6 py-2 bg-gray-100">
            @forelse($video_chats as $chat)
            <div class="my-2 px-4 py-2 rounded-lg flex items-center hover:bg-white hover:shadow">
                <img src="{{ $chat->users->first()->avatar() }}" alt="{{ $chat->users->first()->name }}" width="48" height="48"
                    class="bg-gray-400 h-12 w-12 rounded-full mr-6 overflow-hidden">
                <div>
                    <h2 class="text-xl font-bold tracking-wide mb-2">{{ $chat->users->first()->name }}</h2>
                    <div class="flex leading-none -mx-2">
                        <a href="{{ route('video_chats.initiate', $chat) }}" class="mx-2 px-3 py-2 rounded bg-gray-100 border hover:bg-gray-200">Initiate Call</a>
                        <a href="{{ route('video_chats.join', $chat) }}" class="mx-2 px-3 py-2 rounded bg-gray-100 border hover:bg-gray-200">Join Call</a>
                    </div>
                </div>
            </div>
            @empty
            <p class="my-2 px-4 py-2 text-center text-gray-500 font-bold">
                No chats found...
            </p>
            @endforelse
        </div>
    </div>
</div>
@endsection
