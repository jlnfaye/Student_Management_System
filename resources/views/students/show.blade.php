@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-6 md:px-8 border-b border-gray-200 bg-indigo-50">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Student Details</h1>
                <a href="{{ route('students.index') }}"
                   class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Student Information -->
        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Personal Information -->
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-2xl">
                            {{ strtoupper($student->name[0] ?? 'U') }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $student->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $student->email }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Personal Information</h4>
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Age</dt>
                                <dd class="mt-1 text-gray-900">{{ $student->age }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Birthday</dt>
                                <dd class="mt-1 text-gray-900">{{ $student->formatted_birthday ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-gray-900">{{ $student->address ?? 'Not set' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Class Information -->
                <div class="bg-gray-50 p-6 rounded-xl self-start">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Class Information</h4>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Class</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ $student->class ? $student->class->name . ($student->class->section ? ' (' . $student->class->section . ')' : '') : 'Not assigned' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Section</dt>
                            <dd class="mt-1 text-gray-900">{{ $student->class->section ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="px-6 py-5 border-t border-gray-200 bg-gray-50 flex justify-end gap-4">
            <a href="{{ route('students.edit', $student) }}"
               class="px-6 py-2.5 bg-amber-100 text-amber-800 font-medium rounded-lg hover:bg-amber-200 transition">
                Edit Student
            </a>
            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2.5 bg-red-100 text-red-800 font-medium rounded-lg hover:bg-red-200 transition"
                        onclick="return confirm('Delete {{ addslashes($student->name) }}?')">
                    Delete Student
                </button>
            </form>
        </div>
    </div>
@endsection