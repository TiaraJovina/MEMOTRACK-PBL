@php
    $role = 'dosen';
@endphp

<x-layout title="Schedules" role="{{$role}}">
    <!-- Schedules Header -->
    <header class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Schedules</h2>
        <p class="text-gray-600 mt-2">Manage your course schedules and upcoming events here.</p>
    </header>

    <!-- Schedules Layout -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Weekly Calendar Section -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Weekly Schedule</h3>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" onclick="openAddScheduleModal()">Add Schedule</button>
            </div>
            <div class="grid grid-cols-7 gap-1 text-center text-gray-600 text-sm">
                <div class="col-span-7">
                    <div id="calendarList" class="border-t border-gray-200 py-2">
                        <div class="bg-blue-50 p-2 rounded-md mb-2" onclick="selectSchedule('Sistem Operasi Lecture', 'Monday, 09:00 - 11:00, Room A-101')">
                            <span class="text-gray-900 font-medium">Sistem Operasi Lecture</span>
                            <span class="text-sm text-gray-500 block">Monday, 09:00 - 11:00</span>
                        </div>
                        <div class="bg-blue-50 p-2 rounded-md mb-2" onclick="selectSchedule('Pemrograman Web Tutorial', 'Wednesday, 13:00 - 15:00, Lab B-202')">
                            <span class="text-gray-900 font-medium">Pemrograman Web Tutorial</span>
                            <span class="text-sm text-gray-500 block">Wednesday, 13:00 - 15:00</span>
                        </div>
                        <div class="bg-blue-50 p-2 rounded-md mb-2" onclick="selectSchedule('Database Systems Review', 'Friday, 10:00 - 12:00, Room C-303')">
                            <span class="text-gray-900 font-medium">Database Systems Review</span>
                            <span class="text-sm text-gray-500 block">Friday, 10:00 - 12:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-1" style="background-image: linear-gradient(#e5e7eb 1px, transparent 1px); background-size: 100% 2rem;">
            <h3 id="scheduleTitle" class="text-xl font-semibold text-gray-900 mb-4 relative">
                Upcoming Events
                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-500" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 10%22 preserveAspectRatio=%22none%22%3E%3Cpath d=%22M0 5 Q 25 0 50 5 T 100 5%22 stroke=%22%23ef4444%22 stroke-width=%222%22 fill=%22none%22/%3E%3C/svg%3E'); background-size: 100% 100%;"></span>
            </h3>
            <input type="text" id="searchSchedules" placeholder="Search events..." class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="searchSchedules()">
            <ul id="scheduleList" class="space-y-2">
                <li class="p-3 bg-blue-50 rounded-md">
                    <span class="text-gray-900">Sistem Operasi Lecture</span>
                    <span class="text-sm text-gray-500 block">Monday, 09:00 - 11:00, Room A-101</span>
                </li>
                <li class="p-3 bg-blue-50 rounded-md">
                    <span class="text-gray-900">Pemrograman Web Tutorial</span>
                    <span class="text-sm text-gray-500 block">Wednesday, 13:00 - 15:00, Lab B-202</span>
                </li>
                <li class="p-3 bg-blue-50 rounded-md">
                    <span class="text-gray-900">Database Systems Review</span>
                    <span class="text-sm text-gray-500 block">Friday, 10:00 - 12:00, Room C-303</span>
                </li>
            </ul>
            <div class="mt-4">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" onclick="editSchedule()">Edit Event</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition ml-2" onclick="deleteSchedule()">Delete Event</button>
            </div>
        </div>
    </section>

    <!-- Add Schedule Modal -->
    <div id="addScheduleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Schedule</h3>
            <form>
                <div class="mb-4">
                    <label for="newScheduleTitle" class="block text-gray-600 mb-2">Event Title</label>
                    <input type="text" id="newScheduleTitle" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter event title" required>
                </div>
                <div class="mb-4">
                    <label for="newScheduleDetails" class="block text-gray-600 mb-2">Details</label>
                    <input type="text" id="newScheduleDetails" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Day, Time, Location" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition" onclick="closeAddScheduleModal()">Cancel</button>
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" onclick="addSchedule()">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Schedule Modal -->
    <div id="editScheduleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Schedule</h3>
            <form>
                <div class="mb-4">
                    <label for="editScheduleTitle" class="block text-gray-600 mb-2">Event Title</label>
                    <input type="text" id="editScheduleTitle" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter event title" required>
                </div>
                <div class="mb-4">
                    <label for="editScheduleDetails" class="block text-gray-600 mb-2">Details</label>
                    <input type="text" id="editScheduleDetails" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Day, Time, Location" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition" onclick="closeEditScheduleModal()">Cancel</button>
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" onclick="saveEditedSchedule()">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedScheduleTitle = null;

        function searchSchedules() {
            const input = document.getElementById('searchSchedules').value.toLowerCase();
            const scheduleList = document.getElementById('scheduleList').children;
            for (let i = 0; i < scheduleList.length; i++) {
                const title = scheduleList[i].querySelector('span').textContent.toLowerCase();
                scheduleList[i].style.display = title.includes(input) ? '' : 'none';
            }
        }

        function selectSchedule(title, details) {
            selectedScheduleTitle = title;
            document.getElementById('scheduleTitle').innerText = title;
            document.getElementById('scheduleList').innerHTML = `<li class="p-3 bg-blue-50 rounded-md"><span class="text-gray-900">${title}</span><span class="text-sm text-gray-500 block">${details}</span></li>`;
        }

        function openAddScheduleModal() {
            document.getElementById('addScheduleModal').classList.remove('hidden');
        }

        function closeAddScheduleModal() {
            document.getElementById('addScheduleModal').classList.add('hidden');
            document.getElementById('newScheduleTitle').value = '';
            document.getElementById('newScheduleDetails').value = '';
        }

        function addSchedule() {
            const title = document.getElementById('newScheduleTitle').value;
            const details = document.getElementById('newScheduleDetails').value;
            if (title && details) {
                const calendarList = document.getElementById('calendarList');
                const scheduleList = document.getElementById('scheduleList');
                const calendarItem = document.createElement('div');
                calendarItem.className = 'bg-blue-50 p-2 rounded-md mb-2';
                calendarItem.innerHTML = `<span class="text-gray-900 font-medium">${title}</span><span class="text-sm text-gray-500 block">${details}</span>`;
                calendarItem.onclick = () => selectSchedule(title, details);
                calendarList.prepend(calendarItem);
                const scheduleItem = document.createElement('li');
                scheduleItem.className = 'p-3 bg-blue-50 rounded-md';
                scheduleItem.innerHTML = `<span class="text-gray-900">${title}</span><span class="text-sm text-gray-500 block">${details}</span>`;
                scheduleList.prepend(scheduleItem);
                closeAddScheduleModal();
            }
        }

        function openEditScheduleModal() {
            if (!selectedScheduleTitle) {
                alert('Please select a schedule to edit.');
                return;
            }
            const selectedItem = Array.from(document.getElementById('scheduleList').children).find(
                li => li.querySelector('span').textContent === selectedScheduleTitle
            );
            if (selectedItem) {
                document.getElementById('editScheduleTitle').value = selectedScheduleTitle;
                document.getElementById('editScheduleDetails').value = selectedItem.querySelector('.text-sm').textContent;
                document.getElementById('editScheduleModal').classList.remove('hidden');
            }
        }

        function closeEditScheduleModal() {
            document.getElementById('editScheduleModal').classList.add('hidden');
            document.getElementById('editScheduleTitle').value = '';
            document.getElementById('editScheduleDetails').value = '';
        }

        function saveEditedSchedule() {
            const newTitle = document.getElementById('editScheduleTitle').value;
            const newDetails = document.getElementById('editScheduleDetails').value;
            if (newTitle && newDetails && selectedScheduleTitle) {
                const calendarList = document.getElementById('calendarList').children;
                const scheduleList = document.getElementById('scheduleList').children;
                for (let i = 0; i < calendarList.length; i++) {
                    if (calendarList[i].querySelector('span').textContent === selectedScheduleTitle) {
                        calendarList[i].innerHTML = `<span class="text-gray-900 font-medium">${newTitle}</span><span class="text-sm text-gray-500 block">${newDetails}</span>`;
                        calendarList[i].onclick = () => selectSchedule(newTitle, newDetails);
                    }
                }
                for (let i = 0; i < scheduleList.length; i++) {
                    if (scheduleList[i].querySelector('span').textContent === selectedScheduleTitle) {
                        scheduleList[i].innerHTML = `<span class="text-gray-900">${newTitle}</span><span class="text-sm text-gray-500 block">${newDetails}</span>`;
                    }
                }
                document.getElementById('scheduleTitle').innerText = newTitle;
                selectedScheduleTitle = newTitle;
                closeEditScheduleModal();
            }
        }

        function editSchedule() {
            openEditScheduleModal();
        }

        function deleteSchedule() {
            if (!selectedScheduleTitle) {
                alert('Please select a schedule to delete.');
                return;
            }
            if (confirm(`Are you sure you want to delete "${selectedScheduleTitle}"?`)) {
                const calendarList = document.getElementById('calendarList').children;
                const scheduleList = document.getElementById('scheduleList').children;
                for (let i = 0; i < calendarList.length; i++) {
                    if (calendarList[i].querySelector('span').textContent === selectedScheduleTitle) {
                        calendarList[i].remove();
                        break;
                    }
                }
                for (let i = 0; i < scheduleList.length; i++) {
                    if (scheduleList[i].querySelector('span').textContent === selectedScheduleTitle) {
                        scheduleList[i].remove();
                        break;
                    }
                }
                document.getElementById('scheduleTitle').innerText = 'Upcoming Events';
                document.getElementById('scheduleList').innerHTML = '<li class="p-3 bg-blue-50 rounded-md"><span class="text-gray-600">Select an event to view details.</span></li>';
                selectedScheduleTitle = null;
            }
        }
    </script>
</x-layout>