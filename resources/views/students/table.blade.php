@if($students->count() > 0)
    <form action="{{ route('students.bulkDestroy') }}" method="POST" id="bulk-delete-form">
        @csrf
        <div class="w-full">
            <table class="w-full table-fixed text-center">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-4 w-12 align-middle">
                            <input type="checkbox" id="select-all" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 mx-auto">
                        </th>
                        <th class="px-2 py-4 text-sm font-semibold text-gray-700 w-24 align-middle">Student ID</th>
                        <th class="px-2 py-4 text-sm font-semibold text-gray-700 w-20 align-middle">Photo</th>
                        <th class="px-2 py-4 text-sm font-semibold text-gray-700 w-32 align-middle">Name</th>
                        <th class="px-2 py-4 text-sm font-semibold text-gray-700 w-48 align-middle">Email</th>
                        <th class="px-2 py-4 text-sm font-semibold text-gray-700 w-16 align-middle">Age</th>
                        <th class="px-2 py-4 text-sm font-semibold text-gray-700 w-32 align-middle">Birthday</th>
                        <th class="px-2 py-4 text-sm font-semibold text-gray-700 w-64 align-middle">Address</th>
                        <th class="px-2 py-4 text-sm font-semibold text-gray-700 w-24 align-middle">Class</th>
                        <th class="px-4 py-4 text-sm font-semibold text-gray-700 w-48 align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($students as $student)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 align-middle">
                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="student-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 mx-auto">
                            </td>
                            <td class="px-2 py-4 text-sm text-gray-900 font-bold align-middle">
                                {{ $student->student_id_number ?? $student->id }}
                            </td>
                            <td class="px-2 py-4 align-middle">
                                <div class="flex justify-center">
                                    @if($student->student_photo)
                                        <img src="{{ asset('storage/' . $student->student_photo) }}" alt="{{ $student->name }}" style="width: 36px; height: 36px; min-width: 36px; min-height: 36px;" class="rounded-full object-cover border border-gray-200 shadow-sm">
                                    @else
                                        <div style="width: 36px; height: 36px;" class="rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs border border-indigo-200">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 py-4 text-sm font-medium text-gray-900 align-middle truncate" title="{{ $student->name }}">{{ $student->name }}</td>
                            <td class="px-2 py-4 text-sm text-gray-600 align-middle truncate" title="{{ $student->email }}">{{ $student->email }}</td>
                            <td class="px-2 py-4 text-sm text-gray-600 align-middle">{{ $student->age }}</td>
                            <td class="px-2 py-4 text-sm text-gray-600 align-middle whitespace-nowrap">{{ $student->birthday ? \Carbon\Carbon::parse($student->birthday)->format('d M Y') : '-' }}</td>
                            <td class="px-2 py-4 text-sm text-gray-600 align-middle break-words leading-tight">{{ $student->address ?? '-' }}</td>
                            <td class="px-2 py-4 text-sm text-gray-600 align-middle">{{ $student->class ? $student->class->name : '-' }}</td>
                            <td class="px-4 py-4 text-sm font-medium whitespace-nowrap align-middle">
                                <div class="flex justify-center items-center gap-2">
                                    <button type="button" class="text-indigo-600 hover:text-indigo-800 view-student" data-id="{{ $student->id }}" data-url="{{ route('students.show', $student) }}">View</button>
                                    <a href="{{ route('students.edit', $student) }}" class="text-amber-600 hover:text-amber-800">Edit</a>
                                    <button type="button" class="text-red-600 hover:text-red-800 delete-student" data-id="{{ $student->id }}" data-name="{{ addslashes($student->name) }}">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-5 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50">
            <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-sm" id="bulk-delete-btn" disabled>Delete Selected</button>
            <div class="text-sm text-gray-600">
                {{ $students->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </form>
@else
    <div class="text-center py-24 bg-gray-50">
        <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4a2 2 0 00-2 2v3H10v-3a2 2 0 00-2-2H4" />
        </svg>
        <h3 class="mt-6 text-2xl font-medium text-gray-900">No students yet</h3>
        <p class="mt-3 text-gray-600 text-lg">Add your first student to get started.</p>
        <div class="mt-8">
            <a href="{{ route('students.create') }}" class="inline-flex items-center px-10 py-4 bg-indigo-600 text-white font-medium text-lg rounded-xl hover:bg-indigo-700 transition shadow-lg">Add Student</a>
        </div>
    </div>
@endif