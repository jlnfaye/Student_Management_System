<aside id="sidebar" class="bg-gray-800 text-white w-64 min-h-screen flex flex-col fixed md:relative transition-all duration-300 z-10" :class="{ 'w-20': collapsed }">
    <div class="flex items-center justify-between p-4">
        <span class="text-xl font-bold" :class="{ 'hidden': collapsed }">Student Manager</span>
        <button @click="collapsed = !collapsed" class="md:hidden">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
    <nav class="flex-1">
        <ul>
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-4 hover:bg-gray-700">
                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h-3a1 1 0 01-1-1V10" /></svg>
                    <span :class="{ 'hidden': collapsed }">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('students.index') }}" class="flex items-center p-4 hover:bg-gray-700">
                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span :class="{ 'hidden': collapsed }">Students</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="p-4 border-t">
        <div class="flex items-center">
            <img src="https://via.placeholder.com/40" alt="Profile" class="rounded-full mr-3">
            <span :class="{ 'hidden': collapsed }">{{ auth()->user()->name }}</span>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="flex items-center w-full hover:bg-gray-700 p-2">
                <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span :class="{ 'hidden': collapsed }">Logout</span>
            </button>
        </form>
    </div>
</aside>