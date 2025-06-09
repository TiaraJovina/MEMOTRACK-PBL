@php
    $role = session('role');
@endphp

<x-layout role="{{$role}}">
    <!-- Dashboard Header -->
    <header class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
            <p class="text-gray-600 mt-2">
                Welcome back, {{ ucfirst(session('role')) }}! Manage your courses, notes, and tasks here.
            </p>
    </header>

    <!-- Summary Section -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Active Courses</h3>
            <p class="text-2xl font-bold text-blue-500">3</p>
            <a href="/courses" class="text-blue-500 hover:underline mt-2 inline-block">View Courses</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Recent Notes</h3>
            <p class="text-2xl font-bold text-blue-500">5</p>
            <a href="/notes" class="text-blue-500 hover:underline mt-2 inline-block">View Notes</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pending Tasks</h3>
            <p class="text-2xl font-bold text-blue-500">2</p>
            <a href="/tasks" class="text-blue-500 hover:underline mt-2 inline-block">View Tasks</a>
        </div>
    </section>
    
    <!-- Recent Activity Section -->
    <section class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Activity</h3>
        <ul class="space-y-4">
            <li class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span class="text-gray-600">Added a new note to "Sistem Operasi" course.</span>
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span class="text-gray-600">Updated syllabus for "Pemrograman Web".</span>
            </li>
        </ul>
    </section>
</x-layout>
