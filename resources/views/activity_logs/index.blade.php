@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Activity History</h1>
                <p class="text-sm text-gray-600 mt-1">Full log of all system actions</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center gap-1">
                &larr; Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="divide-y divide-gray-100">
                @forelse($activities as $activity)
                    <div class="px-6 py-4 flex items-start hover:bg-gray-50 transition">
                        <div class="shrink-0 mr-4">
                            @if(str_contains($activity->action, 'Created'))
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                            @elseif(str_contains($activity->action, 'Updated'))
                                <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </div>
                            @elseif(str_contains($activity->action, 'Deleted'))
                                <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </div>
                            @else
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-bold text-gray-900">{{ $activity->action }}</p>
                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $activity->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-0.5">{{ $activity->description }}</p>
                            <div class="mt-1 flex items-center text-xs text-gray-400">
                                <span class="font-medium text-gray-500 mr-1">User:</span>
                                {{ $activity->user ? $activity->user->name : 'System' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        No activity found.
                    </div>
                @endforelse
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                {{ $activities->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection