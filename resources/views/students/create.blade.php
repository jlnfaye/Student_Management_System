@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-6 md:px-8 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                    {{ isset($student) ? 'Edit Student' : 'Add New Student' }}
                </h1>
                <a href="{{ route('students.index') }}"
                   class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ isset($student) ? route('students.update', $student) : route('students.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @if(isset($student)) @method('PUT') @endif

            <!-- Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $student->name ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm"
                           placeholder="Enter full name" required>
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $student->email ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm"
                           placeholder="student@example.com" required>
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Age & Birthday -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-2">
                        Age <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="age" id="age" value="{{ old('age', $student->age ?? '') }}"
                           min="5" max="100"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm"
                           placeholder="Enter age" required>
                    @error('age') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="birthday" class="block text-sm font-medium text-gray-700 mb-2">
                        Birthday
                    </label>
                    <input type="date" name="birthday" id="birthday" value="{{ old('birthday', $student->birthday ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm">
                    @error('birthday') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    Address
                </label>
                <textarea name="address" id="address" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm"
                          placeholder="Enter full address">{{ old('address', $student->address ?? '') }}</textarea>
                @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Class -->
            <div>
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Assign Class
                </label>
                <select name="class_id" id="class_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm">
                    <option value="">-- Select Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id', $student->class_id ?? '') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} {{ $class->section ? "({$class->section})" : '' }}
                        </option>
                    @endforeach
                </select>
                @error('class_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="pt-6 flex justify-end">
                <button type="submit"
                        class="px-8 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-md">
                    {{ isset($student) ? 'Update Student' : 'Save Student' }}
                </button>
            </div>
        </form>
    </div>
@endsection