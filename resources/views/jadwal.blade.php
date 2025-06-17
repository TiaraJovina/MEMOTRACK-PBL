@php
    $role = auth()->user()->role;
@endphp

<x-layout title="Schedules" role="{{$role}}">
    <!-- Header -->
    <header class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Schedules</h2>
        <p class="text-gray-600 mt-2">Manage your course schedules and upcoming events here.</p>
    </header>

    <!-- Main Layout -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calendar -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Weekly Schedule</h3>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" onclick="openAddScheduleModal()">Add Schedule</button>
            </div>
            <div class="grid grid-cols-7 gap-1 text-center text-gray-600 text-sm">
                <div class="col-span-7">
                    <div class="border-t border-gray-200 py-2">
                        @foreach ($jadwals as $jadwal)
                            <div class="bg-blue-50 p-2 rounded-md mb-2 cursor-pointer" onclick="selectSchedule('{{ $jadwal->id }}', '{{ $jadwal->title }}', '{{ $jadwal->description }}', '{{ $jadwal->scheduled_at }}')">
                                <span class="text-gray-900 font-medium">{{ $jadwal->title }}</span>
                                <span class="text-sm text-gray-500 block">{{ $jadwal->description }}, {{ $jadwal->scheduled_at }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Sidebar -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-1" style="background-image: linear-gradient(#e5e7eb 1px, transparent 1px); background-size: 100% 2rem;">
            <h3 id="scheduleTitle" class="text-xl font-semibold text-gray-900 mb-4 relative">
                Upcoming Events
                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-500" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 10%22 preserveAspectRatio=%22none%22%3E%3Cpath d=%22M0 5 Q 25 0 50 5 T 100 5%22 stroke=%22%23ef4444%22 stroke-width=%222%22 fill=%22none%22/%3E%3C/svg%3E'); background-size: 100% 100%;"></span>
            </h3>
            <input type="text" id="searchSchedules" placeholder="Search events..." class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="searchSchedules()">
            <ul id="scheduleList" class="space-y-2">
                @foreach ($jadwals as $jadwal)
                    <div class="bg-blue-50 p-2 rounded-md mb-2 cursor-pointer" onclick="selectSchedule('{{ $jadwal->id }}', '{{ $jadwal->title }}', '{{ $jadwal->description }}', '{{ $jadwal->scheduled_at }}')">
                        <span class="text-gray-900 font-medium">{{ $jadwal->title }}</span>
                        <span class="text-sm text-gray-500 block">{{ $jadwal->description }}, {{ $jadwal->scheduled_at }}</span>
                    </div>
                @endforeach
            </ul>
            <div class="mt-4">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" onclick="openEditScheduleModal()">Edit Event</button>

                <form id="deleteJadwalForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition ml-2" onclick="return confirm('Are you sure you want to delete this event?')">Delete Event</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Add Modal -->
    <div id="addScheduleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Schedule</h3>
            <form method="POST" action="{{ route('jadwal.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-600 mb-2">Event Title</label>
                    <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-600 mb-2">Description</label>
                    <input type="text" name="description" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="scheduled_at" class="block text-gray-600 mb-2">Scheduled Time</label>
                    <input type="datetime-local" name="scheduled_at" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeAddScheduleModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editScheduleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Schedule</h3>
            <form id="editScheduleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-600 mb-2">Event Title</label>
                    <input type="text" name="title" id="editScheduleTitle" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 mb-2">Description</label>
                    <input type="text" name="description" id="editScheduleDescription" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 mb-2">Scheduled Time</label>
                    <input type="datetime-local" name="scheduled_at" id="editScheduleTime" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md" onclick="closeEditScheduleModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedId = null;

        function openAddScheduleModal() {
            document.getElementById('addScheduleModal').classList.remove('hidden');
        }

        function closeAddScheduleModal() {
            document.getElementById('addScheduleModal').classList.add('hidden');
        }

        function openEditScheduleModal() {
            if (!selectedId) return alert("Please select a schedule to edit.");
            const form = document.getElementById('editScheduleForm');
            form.action = `/jadwal/${selectedId}`;
            document.getElementById('editScheduleModal').classList.remove('hidden');
        }

        function closeEditScheduleModal() {
            document.getElementById('editScheduleModal').classList.add('hidden');
        }

        function selectSchedule(id, title, description, scheduled_at) {
            selectedId = id;
            document.getElementById('scheduleTitle').innerText = title;
            document.getElementById('editScheduleTitle').value = title;
            document.getElementById('editScheduleDescription').value = description;
            document.getElementById('editScheduleTime').value = scheduled_at;

            const deleteForm = document.getElementById('deleteJadwalForm');
            deleteForm.action = `/jadwal/${id}`;
        }

        function searchSchedules() {
            const input = document.getElementById('searchSchedules').value.toLowerCase();
            const list = document.getElementById('scheduleList').children;
            for (let i = 0; i < list.length; i++) {
                const item = list[i];
                const text = item.innerText.toLowerCase();
                item.style.display = text.includes(input) ? '' : 'none';
            }
        }
    </script>
</x-layout>
