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

   
