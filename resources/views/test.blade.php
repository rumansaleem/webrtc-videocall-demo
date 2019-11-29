@extends('layouts.master')
@section('content')
    <div class="container mx-auto px-4">
        <div class="flex flex-col h-screen">
            <div id="log-area" class="flex-1 p-6 pt-10 bg-white border m-1">
            </div>
            <p class="py-2">
                <button id="ping-btn" class="px-2 py-1 bg-gray-100 border rounded">ping</button>
            </p>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/webrtc.js') }}"></script>
@endpush
