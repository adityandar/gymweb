<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GymFlow')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="min-h-full flex flex-col">
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-900">GymFlow</a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Dashboard</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Membership</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Workout</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Classes</a>
                    <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 hover:text-gray-900">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </header>
        <main class="flex-1 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 py-8">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
