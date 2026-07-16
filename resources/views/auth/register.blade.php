@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-6">
    <div class="w-full max-w-md bg-white p-10 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Create an Account</h2>
            <p class="text-slate-500 text-sm mt-2">Join TaskFlow and organize your life</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-slate-700 text-sm font-semibold mb-2">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm">
                @error('name')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-slate-700 text-sm font-semibold mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm">
                @error('email')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="block text-slate-700 text-sm font-semibold mb-2">Password</label>
                <input id="password" type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm">
                @error('password')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-slate-700 text-sm font-semibold mb-2">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm">
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 hover:-translate-y-0.5">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
