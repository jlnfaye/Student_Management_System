@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden min-h-[500px]">
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

        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <form action="{{ route('students.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4" id="search-form">
                <div class="flex-1">
                    <input type="text" name="search" id="search-input" value="{{ $search ?? '' }}"
                           placeholder="Search by ID, name, or email..."
                           class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm">
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <select name="class_id" id="class-filter" class="px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} {{ $class->section ? "({$class->section})" : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div id="table-container">
            @include('students.partials.table')
        </div>
    </div>

    <div id="studentModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 overflow-hidden relative">
            <div id="modalContent">
                <div class="h-64 flex flex-col items-center justify-center text-gray-500 space-y-3">
                    <span class="font-medium">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- AUTO SEARCH SCRIPT ---
        const searchInput = document.getElementById('search-input');
        const classFilter = document.getElementById('class-filter');
        const tableContainer = document.getElementById('table-container');
        let timeout = null;

        // Function to fetch results via AJAX
        function fetchResults() {
            const search = searchInput.value;
            const classId = classFilter.value;
            
            // Build the URL
            const url = `{{ route('students.index') }}?search=${encodeURIComponent(search)}&class_id=${classId}`;

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                // Update only the table part
                tableContainer.innerHTML = html;
                // Re-activate buttons (Delete/View) for the new rows
                initTableListeners();
            })
            .catch(error => console.error('Error:', error));
        }

        // Listen for typing (wait 300ms before searching to avoid lag)
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(fetchResults, 300);
        });

        // Listen for Class dropdown change
        classFilter.addEventListener('change', fetchResults);
        // --------------------------

        // --- GENERAL TABLE SCRIPTS (Wrapped in a function so we can re-run them) ---
        function closeStudentModal() {
            document.getElementById('studentModal').classList.add('hidden');
        }

        function initTableListeners() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.student-checkbox');
            const bulkBtn = document.getElementById('bulk-delete-btn');

            if(selectAll) {
                selectAll.addEventListener('change', function() {
                    document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = this.checked);
                    toggleBulkButton();
                });
            }

            document.querySelectorAll('.student-checkbox').forEach(cb => {
                cb.addEventListener('change', toggleBulkButton);
            });

            function toggleBulkButton() {
                const checkboxes = document.querySelectorAll('.student-checkbox');
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                const btn = document.getElementById('bulk-delete-btn');
                if(btn) btn.disabled = !anyChecked;
            }
            toggleBulkButton();

            // Delete Button Logic
            document.querySelectorAll('.delete-student').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    Swal.fire({
                        title: 'Delete Student?',
                        text: `Permanently remove ${name}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `{{ route('students.destroy', 'ID') }}`.replace('ID', id);
                            form.innerHTML = `@csrf @method('DELETE')`;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // View Button Logic
            document.querySelectorAll('.view-student').forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    const modal = document.getElementById('studentModal');
                    const modalContent = document.getElementById('modalContent');
                    
                    modal.classList.remove('hidden');

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                    .then(response => response.json())
                    .then(data => {
                        let photoHtml = data.student_photo 
                            ? `<img src="${data.student_photo}" style="width: 120px; height: 120px; min-width: 120px; min-height: 120px;" class="rounded-full object-cover border-4 border-indigo-100 shadow-sm mx-auto">`
                            : `<div style="width: 120px; height: 120px;" class="rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-4xl font-bold border-4 border-indigo-100 shadow-sm mx-auto">${data.name.charAt(0).toUpperCase()}</div>`;
                        
                        let studentIdHtml = data.student_id_number 
                            ? `<p class="text-gray-500 font-bold text-sm mt-1">ID: ${data.student_id_number}</p>` : '';

                        modalContent.innerHTML = `
                            <div class="bg-white">
                                <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                    <h3 class="font-bold text-gray-700">Student Profile</h3>
                                    <button onclick="closeStudentModal()" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <div class="text-center mb-6">
                                        ${photoHtml}
                                        <h2 class="mt-4 text-2xl font-bold text-gray-800">${data.name}</h2>
                                        ${studentIdHtml}
                                        <p class="text-indigo-600 font-medium text-sm mt-1">${data.email}</p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 text-center"><div class="text-xs text-gray-500 uppercase font-bold">Age</div><div class="text-lg font-semibold text-gray-800">${data.age}</div></div>
                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 text-center"><div class="text-xs text-gray-500 uppercase font-bold">Class</div><div class="text-lg font-semibold text-gray-800">${data.class ? data.class.name : '-'}</div></div>
                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 col-span-2"><div class="text-xs text-gray-500 uppercase font-bold mb-1">Birthday</div><div class="text-gray-800 font-medium">${data.birthday || 'Not set'}</div></div>
                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 col-span-2"><div class="text-xs text-gray-500 uppercase font-bold mb-1">Address</div><div class="text-gray-800 font-medium break-words">${data.address || 'Not set'}</div></div>
                                    </div>
                                </div>
                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                                    <button onclick="closeStudentModal()" class="w-full py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">Close Profile</button>
                                </div>
                            </div>
                        `;
                    });
                });
            });
        }

        // Initialize listeners when page first loads
        initTableListeners();

        document.getElementById('studentModal').addEventListener('click', function(e) {
            if (e.target === this) closeStudentModal();
        });
    </script>
@endsection