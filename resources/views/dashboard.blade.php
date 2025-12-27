@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="text-gray-600 mt-1">Here's a quick overview of your student system</p>
            </div>
            <a href="{{ route('students.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg shadow-md hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Student
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Total Classes -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-[1.02]">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Classes</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ App\Models\SchoolClass::count() }}</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('classes.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-4 inline-block">
                        View all classes →
                    </a>
                </div>
            </div>

            <!-- Total Students -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-[1.02]">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Students</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ App\Models\Student::count() }}</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('students.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-4 inline-block">
                        View all students →
                    </a>
                </div>
            </div>

            <!-- You can add more stats cards here -->
            <!-- Example: Total Active Students -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-[1.02]">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active Students</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ App\Models\Student::whereNotNull('class_id')->count() }}</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">Students assigned to classes</p>
                </div>
            </div>

            <!-- Example: Recent Additions -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-[1.02]">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">New This Month</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ App\Models\Student::whereMonth('created_at', now()->month)->count() }}</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">Students added this month</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-10">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ route('students.create') }}"
                   class="flex flex-col items-center justify-center p-6 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition text-indigo-700">
                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Student
                </a>

                <a href="{{ route('classes.create') }}"
                   class="flex flex-col items-center justify-center p-6 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition text-indigo-700">
                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Add Class
                </a>

                <!-- Add more quick actions as needed -->
            </div>
        </div>

        <!-- Optional: Recent Activity or Summary -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Activity</h2>
            <p class="text-gray-600">No recent activity to display.</p>
            <!-- You can later add a list of recent students/classes here -->
        </div>
    </div>
@endsection