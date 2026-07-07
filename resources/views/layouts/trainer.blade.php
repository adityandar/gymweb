<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GymFlow')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="min-h-full flex">
        <aside class="w-64 bg-indigo-900 text-white flex flex-col">
            <div class="p-6 text-xl font-bold border-b border-indigo-800">GymFlow</div>
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('trainer.dashboard') }}" class="block px-3 py-2 rounded hover:bg-indigo-800 {{ request()->routeIs('trainer.dashboard') ? 'bg-indigo-800' : '' }}">Dashboard</a>
                <a href="{{ route('trainer.workout-plans.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-800 {{ request()->routeIs('trainer.workout-plans.*') ? 'bg-indigo-800' : '' }}">Workout Plans</a>
                <a href="{{ route('trainer.classes.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-800 {{ request()->routeIs('trainer.classes.*') ? 'bg-indigo-800' : '' }}">My Classes</a>
            </nav>
            <div class="p-4 border-t border-indigo-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded hover:bg-indigo-800 text-indigo-300">Logout</button>
                </form>
            </div>
        </aside>
        <main class="flex-1 p-8 bg-gray-50 min-h-full">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
