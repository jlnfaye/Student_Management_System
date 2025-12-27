@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-6 md:px-8 border-b border-gray-200 bg-indigo-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Manage Classes</h1>
                <p class="text-sm text-gray-600 mt-1">View, add, and manage all classes in the system</p>
            </div>
            <a href="{{ route('classes.create') }}"
               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl shadow-md hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Class
            </a>
        </div>

        <!-- Classes Table -->
        @if($classes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">S.No</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Class Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Section</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Creation Date</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($classes as $class)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    {{ $class->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $class->section ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $class->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-4">
                                    <a href="{{ route('classes.edit', $class) }}" class="text-amber-600 hover:text-amber-800 font-medium transition">Edit</a>
                                    <button type="button" class="text-red-600 hover:text-red-800 font-medium transition delete-class" data-id="{{ $class->id }}" data-name="{{ addslashes($class->name) }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-5 border-t border-gray-200 flex justify-center bg-gray-50">
                {{ $classes->links('pagination::tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-24 bg-gray-50">
                <svg class="w-20 h-20 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="mt-6 text-2xl font-medium text-gray-900">No classes yet</h3>
                <p class="mt-3 text-gray-600 text-lg">Get started by adding your first class.</p>
                <div class="mt-8">
                    <a href="{{ route('classes.create') }}"
                       class="inline-flex items-center px-10 py-4 bg-indigo-600 text-white font-medium text-lg rounded-xl hover:bg-indigo-700 transition shadow-lg">
                        Add Your First Class
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Delete Confirmation with SweetAlert -->
    <script>
        document.querySelectorAll('.delete-class').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Delete Class?',
                    text: `You are about to delete "${name}". This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('classes.destroy', 'ID') }}`.replace('ID', id);
                        form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection