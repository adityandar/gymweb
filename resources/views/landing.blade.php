<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GymFlow - Gym Membership Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-gray-900">GymFlow</a>
            <nav class="flex items-center gap-6">
                <a href="/" class="text-gray-600 hover:text-gray-900">Home</a>
                <a href="{{ route('pricing') }}" class="text-gray-600 hover:text-gray-900">Pricing</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        <section class="bg-gray-900 text-white py-24">
            <div class="max-w-4xl mx-auto text-center px-4">
                <h1 class="text-5xl font-bold mb-6">Manage Your Gym Smarter</h1>
                <p class="text-xl text-gray-300 mb-8">Membership, payments, attendance, and workout tracking — all in one place.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-blue-700">Get Started</a>
                    <a href="{{ route('pricing') }}" class="border border-white text-white px-8 py-3 rounded-lg text-lg hover:bg-white hover:text-gray-900">View Plans</a>
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Features</h2>
                <div class="grid grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="text-4xl mb-4">&#x1f4cb;</div>
                        <h3 class="text-lg font-semibold mb-2">Membership Plans</h3>
                        <p class="text-gray-500">Create and manage custom membership plans with flexible durations and pricing.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="text-4xl mb-4">&#x1f4b3;</div>
                        <h3 class="text-lg font-semibold mb-2">Online Payment</h3>
                        <p class="text-gray-500">Secure online payment integration. Members can pay anytime, anywhere.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="text-4xl mb-4">&#x1f4ca;</div>
                        <h3 class="text-lg font-semibold mb-2">Attendance Tracking</h3>
                        <p class="text-gray-500">QR-based check-in system. Track attendance in real-time.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-100 py-8 border-t">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} GymFlow. All rights reserved.
        </div>
    </footer>
</body>
</html>
