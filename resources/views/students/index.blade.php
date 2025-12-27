@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Students</h1>
                <p class="text-sm text-gray-600 mt-1">Manage all student records</p>
            </div>
            <a href="{{ route('students.create') }}"
               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl shadow-md hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Student
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <form action="{{ route('students.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Search by name or email..."
                           class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm">
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <select name="class_id" class="px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} {{ $class->section ? "({$class->section})" : '' }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="px-8 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-sm">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        @if($students->count() > 0)
            <form action="{{ route('students.bulkDestroy') }}" method="POST" id="bulk-delete-form">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" id="select-all" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                    <a href="?sort=id&direction={{ $direction == 'asc' ? 'desc' : 'asc' }}" class="flex items-center gap-1 hover:text-indigo-700">
                                        ID
                                        @if($sort == 'id')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $direction == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                    <a href="?sort=name&direction={{ $direction == 'asc' ? 'desc' : 'asc' }}" class="flex items-center gap-1 hover:text-indigo-700">
                                        Name
                                        @if($sort == 'name')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $direction == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                    <a href="?sort=age&direction={{ $direction == 'asc' ? 'desc' : 'asc' }}" class="flex items-center gap-1 hover:text-indigo-700">
                                        Age
                                        @if($sort == 'age')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $direction == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Birthday</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Address</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Class</th>
                                <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($students as $student)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="student-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $student->id }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $student->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $student->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $student->age }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $student->formatted_birthday ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $student->address ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $student->class ? $student->class->name : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                                        <button type="button" class="text-indigo-600 hover:text-indigo-800 view-student" data-id="{{ $student->id }}" data-url="{{ route('students.show', $student) }}">
                                            View
                                        </button>
                                        <a href="{{ route('students.edit', $student) }}" class="text-amber-600 hover:text-amber-800">Edit</a>
                                        <button type="button" class="text-red-600 hover:text-red-800 delete-student" data-id="{{ $student->id }}" data-name="{{ addslashes($student->name) }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bulk Actions & Pagination -->
                <div class="px-6 py-5 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50">
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-sm" id="bulk-delete-btn" disabled>
                        Delete Selected
                    </button>
                    <div class="text-sm text-gray-600">
                        {{ $students->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </form>
        @else
            <!-- Empty State -->
            <div class="text-center py-24 bg-gray-50">
                <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4a2 2 0 00-2 2v3H10v-3a2 2 0 00-2-2H4" />
                </svg>
                <h3 class="mt-6 text-2xl font-medium text-gray-900">No students yet</h3>
                <p class="mt-3 text-gray-600 text-lg">Add your first student to get started.</p>
                <div class="mt-8">
                    <a href="{{ route('students.create') }}"
                       class="inline-flex items-center px-10 py-4 bg-indigo-600 text-white font-medium text-lg rounded-xl hover:bg-indigo-700 transition shadow-lg">
                        Add Student
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- View Student Modal -->
    <div id="studentModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full mx-4 overflow-hidden transform transition-all scale-95">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                <h3 class="text-xl font-bold text-gray-900">Student Details</h3>
                <button type="button" class="text-gray-500 hover:text-gray-700 close-modal focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-8 bg-white">
                <div id="modalContent" class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-800">
                    <!-- Content loaded via JS -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button type="button" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition close-modal">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    <script>
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.student-checkbox');
        const bulkBtn = document.getElementById('bulk-delete-btn');

        // Select All
        selectAll?.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            toggleBulkButton();
        });

        // Individual checkboxes
        checkboxes.forEach(cb => {
            cb.addEventListener('change', toggleBulkButton);
        });

        function toggleBulkButton() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            bulkBtn.disabled = !anyChecked;
            if (selectAll) {
                selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
            }
        }

        // Initial check
        toggleBulkButton();

        // SweetAlert for Single Delete
        document.querySelectorAll('.delete-student').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${name}. This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('students.destroy', 'ID') }}`.replace('ID', id);
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

        // SweetAlert for Bulk Delete
        document.getElementById('bulk-delete-btn')?.addEventListener('click', function(e) {
            e.preventDefault();

            const checkedCount = document.querySelectorAll('input[name="student_ids[]"]:checked').length;
            if (checkedCount === 0) return;

            Swal.fire({
                title: 'Delete Selected Students?',
                text: `You are about to delete ${checkedCount} student(s). This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete them!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('bulk-delete-form').submit();
                }
            });
        });

        // Modal Functionality (unchanged)
        const modal = document.getElementById('studentModal');
        const modalContent = document.getElementById('modalContent');
        const closeModalButtons = document.querySelectorAll('.close-modal');

        document.querySelectorAll('.view-student').forEach(button => {
            button.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    modalContent.innerHTML = `
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-3 border-b pb-2">Personal Information</h4>
                                    <p class="mb-2"><span class="font-medium">Name:</span> ${data.name}</p>
                                    <p class="mb-2"><span class="font-medium">Email:</span> ${data.email}</p>
                                    <p class="mb-2"><span class="font-medium">Age:</span> ${data.age}</p>
                                    <p class="mb-2"><span class="font-medium">Birthday:</span> ${data.birthday || 'Not set'}</p>
                                    <p><span class="font-medium">Address:</span> ${data.address || 'Not set'}</p>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-3 border-b pb-2">Class Information</h4>
                                    <p><span class="font-medium">Class:</span> ${data.class ? data.class.name + (data.class.section ? ' (' + data.class.section + ')' : '') : 'Not assigned'}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    modalContent.innerHTML = '<p class="text-red-600 font-medium">Error loading student details.</p>';
                    modal.classList.remove('hidden');
                });
            });
        });

        closeModalButtons.forEach(btn => {
            btn.addEventListener('click', () => modal.classList.add('hidden'));
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) modal.classList.add('hidden');
        });
    </script>
@endsection