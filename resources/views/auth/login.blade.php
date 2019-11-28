@extends('layouts.master')
@section('title', ' | Login')

@section('content')
<div class="container mx-auto px-4 h-screen flex flex-col items-center justify-center">
    <div class="md:w-1/2 bg-white border rounded-lg shadow-md">
        <div class="border-b pt-4 pb-2 px-6">
            <h1 class="text-2xl">Login</h1>
        </div>
        <form id="login-form" action="/login" method="POST" class="px-6 py-2 bg-gray-100">
            @csrf
            <div class="mb-4">
                <label for="" class="inline-block w-full text-gray-600 text-xs font-bold tracking-wide uppercase mb-1">Email</label>
                <input type="email" name="email" placeholder="Email" class="w-full px-3 py-1 border rounded focus:border-blue-500 hover:border-blue-600" required autofocus>
            </div>
            <div class="mb-4">
                <label for="" class="inline-block w-full text-gray-600 text-xs font-bold tracking-wide uppercase mb-1">Password</label>
                <input type="password" name="password" placeholder="Password" class="w-full px-3 py-1 border rounded focus:border-blue-500 hover:border-blue-600" required>
            </div>
            <div class="pt-2 pb-4">
                <button type="submit"
                    form="login-form"
                    class="w-full px-3 py-1 border rounded bg-blue-500 border-blue-500 hover:bg-blue-700 hover:border-blue-700 text-white font-bold">
                    Login
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
