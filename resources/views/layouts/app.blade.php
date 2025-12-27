<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="h-full font-inter bg-gray-50 antialiased">

<!-- ================= ROOT GRID ================= -->
<div class="min-h-screen grid grid-cols-1 md:grid-cols-[18rem_1fr]">

    <!-- ================= SIDEBAR ================= -->
    <aside class="hidden md:flex flex-col bg-white border-r border-gray-200 shadow-sm">

        <!-- Logo -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                    S
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Student System</h1>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 mt-6 px-4 space-y-2">

            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-3 rounded-xl transition
               {{ request()->routeIs('dashboard')
                   ? 'bg-indigo-50 text-indigo-700 font-semibold'
                   : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2 7-7 7 7" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('students.index') }}"
               class="flex items-center px-4 py-3 rounded-xl transition
               {{ request()->routeIs('students.*')
                   ? 'bg-indigo-50 text-indigo-700 font-semibold'
                   : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4a4 4 0 100 8 4 4 0 000-8zM3 20a9 9 0 0118 0" />
                </svg>
                Students
            </a>

            <a href="{{ route('classes.index') }}"
               class="flex items-center px-4 py-3 rounded-xl transition
               {{ request()->routeIs('classes.*')
                   ? 'bg-indigo-50 text-indigo-700 font-semibold'
                   : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Classes
            </a>

        </nav>

        <!-- Profile -->
        <div class="p-6 border-t bg-gray-50">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold">
                    {{ strtoupper(auth()->user()->name[0] ?? 'U') }}
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate max-w-[180px]">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-50 text-red-700 rounded-lg py-2 hover:bg-red-100 text-sm font-medium">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- ================= MAIN ================= -->
    <div class="flex flex-col min-w-0">

        <!-- Mobile Header -->
        <header class="md:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b shadow-sm">
            <div class="flex justify-between items-center px-4 py-3">
                <span class="font-semibold">Student System</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 text-sm">Logout</button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 bg-gray-50 pt-16 md:pt-0 overflow-x-hidden">

            <div class="max-w-7xl mx-auto px-4 py-6 md:px-8 lg:px-12 w-full">

                <!-- FLASH -->
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-600 p-4 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-600 p-4 rounded-lg">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- PAGE CONTENT -->
                @yield('content')

            </div>

        </main>

    </div>
</div>

</body>
</html>
