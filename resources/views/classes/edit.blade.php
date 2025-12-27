@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-6 md:px-8 border-b border-gray-200 bg-indigo-50">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Edit Class</h1>
                <a href="{{ route('classes.index') }}"
                   class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('classes.update', $class) }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Class Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Class Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $class->name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm"
                       placeholder="Enter class name" required>
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Section -->
            <div>
                <label for="section" class="block text-sm font-medium text-gray-700 mb-2">
                    Section (optional)
                </label>
                <input type="text" name="section" id="section" value="{{ old('section', $class->section) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm"
                       placeholder="e.g., A, B, C">
                @error('section') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="pt-6 flex justify-end">
                <button type="submit"
                        class="px-8 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-md">
                    Update Class
                </button>
            </div>
        </form>
    </div>
@endsection