@php
    $role = 'mahasiswa';
@endphp

<x-layout role="{{$role}}">
    <!-- Dashboard Header -->
    <header class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
        <p class="text-gray-600 mt-2">Welcome back, Dosen! Manage your courses, notes, and tasks here.</p>
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

   <section class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Activity</h3>
    <ul class="space-y-4">
        @foreach($activities as $activity)
            <li class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-gray-600">
                    {{ $activity->description }}
                    @if($activity->subject)
                        on {{ class_basename($activity->subject_type) }}: {{ $activity->subject->name ?? 'N/A' }}
                    @endif
                    by {{ $activity->causer->name ?? 'System' }}
                </span>
            </li>
        @endforeach
    </ul>
</section>
