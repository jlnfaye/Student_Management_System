@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Add Class</h1>
    <form action="{{ route('classes.store') }}" method="POST" class="max-w-md bg-white p-6 rounded-lg shadow">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Class Name</label>
            <input type="text" name="name" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Section</label>
            <input type="text" name="section" class="w-full p-2 border rounded">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Class</button>
    </form>
@endsection