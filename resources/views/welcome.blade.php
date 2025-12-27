<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Student System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-inter antialiased">
    <!-- Navbar -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                    S
                </div>
                <span class="text-2xl font-bold text-gray-900">Student System</span>
            </div>
            <div class="space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">Login</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        Register
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600 font-medium transition">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Manage Your Students <br class="hidden sm:block">Effortlessly
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 mb-10 max-w-3xl mx-auto">
                    A simple, powerful, and secure student management system for schools and educators.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    @guest
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white font-medium text-lg rounded-xl hover:bg-indigo-700 transition shadow-lg">
                            Get Started - Register
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center px-8 py-4 border-2 border-indigo-600 text-indigo-600 font-medium text-lg rounded-xl hover:bg-indigo-50 transition">
                            Already have an account? Login
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white font-medium text-lg rounded-xl hover:bg-indigo-700 transition shadow-lg">
                            Go to Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-white py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Why Choose Student System?</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition">
                        <div class="flex justify-center mb-6">
                            <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">Student Management</h3>
                        <p class="text-gray-600 text-center">Add, edit, and track students with ease.</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition">
                        <div class="flex justify-center mb-6">
                            <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">Class Organization</h3>
                        <p class="text-gray-600 text-center">Create and manage classes efficiently.</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition">
                        <div class="flex justify-center mb-6">
                            <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">Secure & Reliable</h3>
                        <p class="text-gray-600 text-center">Built with Laravel for safety and performance.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Footer -->
        <div class="bg-indigo-600 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Get Started?</h2>
                <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90">
                    Join thousands of educators managing students smarter.
                </p>
                @guest
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center px-10 py-4 bg-white text-indigo-600 font-medium text-lg rounded-xl hover:bg-gray-100 transition shadow-lg">
                        Sign Up Now
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-10 py-4 bg-white text-indigo-600 font-medium text-lg rounded-xl hover:bg-gray-100 transition shadow-lg">
                        Go to Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Student System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>