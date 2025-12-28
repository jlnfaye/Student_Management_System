@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
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

        <form action="{{ isset($student) ? route('students.update', $student) : route('students.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="p-6 md:p-8 space-y-6">
            
            @csrf
            @if(isset($student)) @method('PUT') @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student ID (7 Digits)</label>
                <input type="number" 
                       name="student_id_number" 
                       value="{{ old('student_id_number', $student->student_id_number ?? '') }}" 
                       required
                       placeholder="1000001"
                       oninput="if(this.value.length > 7) this.value = this.value.slice(0, 7);"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition shadow-sm">
                <p class="text-xs text-gray-500 mt-1">Must be exactly 7 numbers.</p>
                @error('student_id_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student Photo</label>
                <div class="flex items-center space-x-6">
                    @if(isset($student) && $student->student_photo)
                        <div class="shrink-0">
                            <img class="h-16 w-16 object-cover rounded-full border border-gray-300" 
                                 src="{{ asset('storage/' . $student->student_photo) }}" 
                                 alt="Current Photo">
                        </div>
                    @endif
                    <input type="file" name="student_photo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg cursor-pointer">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $student->name ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition shadow-sm" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $student->email ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition shadow-sm" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Age *</label>
                    <input type="number" name="age" id="age" value="{{ old('age', $student->age ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition shadow-sm" required>
                </div>
                <div>
                    <label for="birthday" class="block text-sm font-medium text-gray-700 mb-2">Birthday</label>
                    <input type="date" name="birthday" id="birthday" value="{{ old('birthday', $student->birthday ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition shadow-sm">
                </div>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <textarea name="address" id="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition shadow-sm">{{ old('address', $student->address ?? '') }}</textarea>
            </div>

            <div>
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">Assign Class</label>
                <select name="class_id" id="class_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition shadow-sm">
                    <option value="">-- Select Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id', $student->class_id ?? '') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} {{ $class->section ? "({$class->section})" : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-6 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-md">
                    {{ isset($student) ? 'Update Student' : 'Save Student' }}
                </button>
            </div>
        </form>
    </div>
@endsection