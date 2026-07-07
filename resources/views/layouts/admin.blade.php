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
        <aside class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-6 text-xl font-bold border-b border-gray-700">GymFlow</div>
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">Dashboard</a>
                <a href="{{ route('admin.plans.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.plans.*') ? 'bg-gray-800' : '' }}">Membership Plans</a>
                <a href="{{ route('admin.members.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.members.*') ? 'bg-gray-800' : '' }}">Members</a>
                <a href="{{ route('admin.payments.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.payments.*') ? 'bg-gray-800' : '' }}">Payments</a>
                <a href="{{ route('admin.classes.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.classes.*') ? 'bg-gray-800' : '' }}">Classes</a>
                <a href="{{ route('admin.attendance.scan') }}" class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.attendance.*') ? 'bg-gray-800' : '' }}">Scan QR</a>
                <a href="{{ route('admin.reports.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-800' : '' }}">Reports</a>
                <a href="{{ route('admin.verifications.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.verifications.*') ? 'bg-gray-800' : '' }}">Verifications</a>
                <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-800' : '' }}">Settings</a>
            </nav>
            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-800 text-gray-400">Logout</button>
                </form>
            </div>
        </aside>
        <main class="flex-1 p-8 bg-gray-50 min-h-full">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
