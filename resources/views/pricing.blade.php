<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pricing - GymFlow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-gray-900">GymFlow</a>
            <nav class="flex items-center gap-6">
                <a href="/" class="text-gray-600 hover:text-gray-900">Home</a>
                <a href="{{ route('pricing') }}" class="text-gray-900 font-semibold">Pricing</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="py-20">
        <div class="max-w-5xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-center mb-4">Membership Plans</h1>
            <p class="text-gray-500 text-center mb-12">Choose the plan that fits your fitness journey.</p>

            <div class="grid grid-cols-3 gap-8">
                @foreach ($plans as $plan)
                <div class="border rounded-lg p-8 text-center hover:shadow-lg transition">
                    <h2 class="text-2xl font-bold mb-2">{{ $plan->name }}</h2>
                    <p class="text-gray-500 mb-4">{{ $plan->duration_months }} month(s)</p>
                    <p class="text-4xl font-bold text-blue-600 mb-2">Rp {{ number_format($plan->price, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-400 mb-6">Rp {{ number_format($plan->price / $plan->duration_months, 0, ',', '.') }}/month</p>
                    <p class="text-gray-500 text-sm mb-6">{{ $plan->description }}</p>
                    @auth
                        <form action="{{ route('checkout', $plan) }}" method="POST">
                            @csrf
                            <button class="w-full bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Choose Plan</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="block w-full bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Register to Join</a>
                    @endauth
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <footer class="bg-gray-100 py-8 border-t">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} GymFlow. All rights reserved.
        </div>
    </footer>
</body>
</html>
