<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('head')
    </head>
    <body class="bg-gray-200 font-sans">
        @auth
        <div class="fixed top-0 inset-x-0 flex items-center justify-end py-2 px-6 leading-none">
            <img src="{{ Auth::user()->avatar(32) }}" alt="{{ $username = Auth::user()->name }}" class="w-8 h-8 rounded-full mr-2">
            <span class="mx-3">{{ $username }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mx-2 px-3 py-2 rounded bg-white border hover:bg-gray-100">Logout</button>
            </form>
        </div>
        @endauth
        @yield('content')
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
