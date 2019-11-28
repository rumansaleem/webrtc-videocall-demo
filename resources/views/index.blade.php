@extends('layouts.master')
@section('content')
<div class="container mx-auto px-4 h-screen flex flex-col items-center justify-center">
    <div class="md:w-1/2 bg-white border rounded-lg shadow-md">
        <div class="border-b pt-4 pb-2 px-6">
            <h1 class="text-2xl">Peer to Peer Video Calling Application</h1>
        </div>
        <div class="px-6 py-2 bg-gray-100">
            @foreach($availableUsers as $user)
            <div class="my-2 px-4 py-2 rounded-lg flex items-center hover:bg-white hover:shadow">
                <img src="{{ $user->avatar() }}" alt="{{ $user->name }}" width="48" height="48"
                    class="bg-gray-400 h-12 w-12 rounded-full mr-6 overflow-hidden">
                <div>
                    <h2 class="text-xl font-bold tracking-wide mb-2">{{ $user->name }}</h2>
                    <div class="flex leading-none -mx-2">
                        <button class="mx-2 px-3 py-2 rounded bg-gray-100 border hover:bg-gray-200">Initiate Call</button>
                        <button class="mx-2 px-3 py-2 rounded bg-gray-100 border hover:bg-gray-200">Join Call</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
