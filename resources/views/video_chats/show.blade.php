@extends('layouts.master')
@push('head')
<style>
    @media screen and (max-width: 768px) {
        #log-area {
            transform: translateY(90%);
            transition: transform 0.4s;
        }
        #log-area:hover {
            transform: translateY(0);
        }
    }
</style>
@endpush
@section('content')
<div class="relative flex-1 flex flex-col md:flex-row h-full">
    <div class="flex-1 bg-black">
        <video id="remote-video"
        class="mx-auto bg-gray-900 max-h-screen max-w-full object-cover"></video>
    </div>
    <div class="absolute right-0 bottom-0 mb-4 mr-4 bg-black">
        <video id="local-video" class="bg-gray-800 h-48 object-fit-cover" ></video>
    </div>
    <div id="log-area" class="md:static md:w-64 md:h-64 absolute inset-x-0 bottom-0 px-4 h-32 overflow-y-auto bg-white shadow">
    </div>
</div>
@endsection
@push('scripts')
<script>
    window.Laravel.channelName = 'VideoChats.' + {{ $video_chat->id }};
    window.Laravel.isInitiator = {{ json_encode(Route::is('video_chats.initiate')) }};
</script>
<script src="{{ asset('js/webrtc.js') }}"></script>
@endpush
