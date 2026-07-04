@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-10">
    <div class="w-full max-w-md bg-white p-10 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Welcome Back</h2>
            <p class="text-slate-500 text-sm mt-2">Sign in to continue to TaskFlow</p>
        </div>
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-slate-700 text-sm font-semibold mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm">
                @error('email')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="block text-slate-700 text-sm font-semibold mb-2">Password</label>
                <input id="password" type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm">
                @error('password')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500">
                    <label for="remember" class="ml-2 text-sm text-slate-600 font-medium">Remember Me</label>
                </div>
            </div>
            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 hover:-translate-y-0.5">
                    Sign In
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
