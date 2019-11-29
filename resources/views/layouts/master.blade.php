<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack('head')
    </head>
    <body class="bg-gray-200 font-sans flex flex-col h-screen">
        @auth
        <div class="flex items-center py-1 px-2 leading-none">
            <img src="{{ Auth::user()->avatar(32) }}" alt="{{ $username = Auth::user()->name }}" class="w-8 h-8 rounded-full mr-2">
            <span class="mx-3">{{ $username }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mx-2 px-2 py-1 rounded bg-white border hover:bg-gray-100">Logout</button>
            </form>
        </div>
        @endauth
        @yield('content')
        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
