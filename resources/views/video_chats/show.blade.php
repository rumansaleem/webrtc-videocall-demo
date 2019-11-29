@extends('layouts.master')
@section('content')
    <div class="container mx-auto px-4">
        <div class="flex h-screen">
            <div class="flex-1 remote-video-area bg-black">
                <video id="remote-video"
                class="mx-auto bg-gray-500 h-full"></video>
            </div>
            <div class="w-64 flex flex-col">
                <div id="log-area" class="flex-1 pt-16 px-4">
                    <p>
                        <button id="ping-btn" class="px-2 py-1 bg-gray-100 border rounded">ping</button>
                    </p>
                </div>
                <div class="local-video-area bg-black">
                    <video id="local-video" class="bg-gray-400 w-full"></video>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/webrtc.js') }}"></script>
@endpush
