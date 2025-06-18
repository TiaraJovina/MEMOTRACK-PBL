@php
    $role = auth()->user()->role;
@endphp

<x-layout title="Tasks" role="{{ $role }}">
    <header class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Tasks</h2>
        <p class="text-gray-600 mt-2">
            {{ $role === 'Dosen' ? 'Create and manage course tasks.' : 'View and submit your assignments.' }}
        </p>
    </header>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Task List -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Task List</h3>
                @if ($role === 'Dosen')
                    <button onclick="openAddTaskModal()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add Task</button>
                @endif
            </div>

            <input type="text" id="searchTasks" placeholder="Search tasks..." class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-md">

            <ul id="taskList" class="space-y-2">
                @foreach ($tasks as $task)
                    <li class="p-3 bg-blue-50 rounded-md cursor-pointer"
                        onclick="selectTask('{{ $task->id }}', '{{ $task->title }}', `{{ $task->details }}`, '{{ $task->due_date }}')">
                        <span class="font-medium">{{ $task->title }}</span>
                        <span class="text-sm text-gray-500 block">Due: {{ $task->due_date }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Task Details -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-1">
            <h3 id="taskTitle" class="text-xl font-semibold mb-4">Task Details</h3>
            <p id="taskContent" class="text-gray-600">Select a task from the list to view its details.</p>

            <div class="mt-4">
                <form id="deleteForm" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

                @if ($role === 'Dosen')
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600" onclick="editTask()">Edit Task</button>
                    <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 ml-2" onclick="deleteTask()">Delete Task</button>
                @else
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600" onclick="openSubmitModal()">Submit Assignment</button>
                @endif
            </div>
        </div>
    </section>

    <!-- Add/Edit Modal -->
    @if ($role === 'Dosen')
    <div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-md">
            <h3 id="taskModalTitle" class="text-lg font-semibold mb-4">Add New Task</h3>
            <form id="taskForm" method="POST" action="{{ route('tasks.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="task_id" id="taskId">

                <div class="mb-4">
                    <label for="taskTitleInput" class="block mb-1">Task Title</label>
                    <input type="text" name="title" id="taskTitleInput" class="w-full px-4 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="taskDetailsInput" class="block mb-1">Details</label>
                    <textarea name="details" id="taskDetailsInput" class="w-full px-4 py-2 border rounded-md" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="taskDueDate" class="block mb-1">Due Date</label>
                    <input type="date" name="due_date" id="taskDueDate" class="w-full px-4 py-2 border rounded-md" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeTaskModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Submit Modal -->
    @if ($role === 'Mahasiswa')
    <div id="submitModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Submit Assignment</h3>
            <form method="POST" action="#" id="submitForm" enctype="multipart/form-data">
                @csrf
                <input type="file" name="files[]" multiple class="w-full mb-4 border px-4 py-2" accept=\".pdf,.doc,.docx\">
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeSubmitModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
        let selectedTaskId = null;

        function selectTask(id, title, details, dueDate) {
            selectedTaskId = id;

            document.getElementById('taskTitle').innerText = title;
            document.getElementById('taskContent').innerText = `${details}\nDue: ${dueDate}`;

            const submitForm = document.getElementById('submitForm');
            if (submitForm) {
                submitForm.action = `/tasks/${id}/submit`;
            }
        }

        function openAddTaskModal() {
            document.getElementById('taskModalTitle').innerText = 'Add New Task';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('taskForm').action = '{{ route('tasks.store') }}';

            // Kosongkan field
            document.getElementById('taskId').value = '';
            document.getElementById('taskTitleInput').value = '';
            document.getElementById('taskDetailsInput').value = '';
            document.getElementById('taskDueDate').value = '';

            document.getElementById('taskModal').classList.remove('hidden');
        }

        function editTask() {
            if (!selectedTaskId) return alert('Please select a task to edit');

            document.getElementById('taskModalTitle').innerText = 'Edit Task';
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('taskForm').action = `/tasks/${selectedTaskId}`;

            // Ambil nilai dari tampilan detail
            const title = document.getElementById('taskTitle').innerText;
            const fullDetails = document.getElementById('taskContent').innerText;

            const [details, dueText] = fullDetails.split('Due:');
            const dueDate = dueText ? dueText.trim() : '';

            document.getElementById('taskId').value = selectedTaskId;
            document.getElementById('taskTitleInput').value = title.trim();
            document.getElementById('taskDetailsInput').value = details.trim();
            document.getElementById('taskDueDate').value = dueDate;

            document.getElementById('taskModal').classList.remove('hidden');
        }

        function deleteTask() {
            if (!selectedTaskId) return alert('Please select a task to delete');

            if (confirm('Are you sure you want to delete this task?')) {
                const form = document.getElementById('deleteForm');
                form.action = `/tasks/${selectedTaskId}`;
                form.submit();
            }
        }

        function closeTaskModal() {
            document.getElementById('taskModal').classList.add('hidden');
        }

        function openSubmitModal() {
            if (!selectedTaskId) return alert('Please select a task to submit');
            document.getElementById('submitModal').classList.remove('hidden');
        }

        function closeSubmitModal() {
            document.getElementById('submitModal').classList.add('hidden');
        }

        function searchTasks() {
            const input = document.getElementById('searchTasks').value.toLowerCase();
            const list = document.getElementById('taskList').children;

            for (let i = 0; i < list.length; i++) {
                const item = list[i];
                const text = item.innerText.toLowerCase();
                item.style.display = text.includes(input) ? '' : 'none';
            }
        }

        // Trigger search on input
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchTasks');
            if (searchInput) {
                searchInput.addEventListener('input', searchTasks);
            }
        });
    </script>
</x-layout>
