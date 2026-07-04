<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskFlow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col selection:bg-indigo-500 selection:text-white">
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600 tracking-tight">
                            TaskFlow
                        </a>
                    </div>
                    @auth
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-indigo-600 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-indigo-500 text-sm font-medium transition-colors duration-200">Dashboard</a>
                        <a href="{{ route('tasks.index') }}" class="text-slate-600 hover:text-indigo-600 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-indigo-500 text-sm font-medium transition-colors duration-200">Tasks</a>
                    </div>
                    @endauth
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center text-white font-bold text-sm shadow-inner">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-slate-700 font-medium text-sm">{{ Auth::user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                            @csrf
                            <button type="submit" class="text-slate-500 hover:text-rose-600 font-medium text-sm transition-colors duration-200">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm transition-colors duration-200">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-4 py-2 rounded-full shadow-md shadow-indigo-200 transition-all duration-200 hover:-translate-y-0.5">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-10 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm flex items-center animate-fade-in" role="alert">
                    <svg class="w-5 h-5 mr-2 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="block sm:inline font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</body>
</html>
