@php
    $role = auth()->user()->role;
@endphp

<x-layout title="Notes" role="{{ $role }}">
    <!-- Notes Header -->
    <header class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Notes</h2>
        <p class="text-gray-600 mt-2">Organize and review your course notes here.</p>
    </header>

    <!-- Notes Layout -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Note List Section -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-1">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Your Notes</h3>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" onclick="openAddNoteModal()">Add Note</button>
            </div>

            <ul id="noteList" class="space-y-2">
                @forelse ($notes as $note)
                    <li
                        class="p-3 bg-blue-50 rounded-md cursor-pointer hover:bg-blue-100 transition"
                        onclick='selectNote(@json($note))'
                    >
                        <span class="text-gray-900">{{ $note->title }}</span>
                        <span class="text-sm text-gray-500 block">Created: {{ $note->created_at->format('Y-m-d') }}</span>
                    </li>
                @empty
                    <li class="text-gray-500">No notes yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- Note Preview Section -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-2 relative" style="background-image: linear-gradient(#e5e7eb 1px, transparent 1px); background-size: 100% 2rem;">
            <h3 id="noteTitle" class="text-xl font-semibold text-gray-900 mb-4 relative">
                Select a note
                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-500" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 10%22 preserveAspectRatio=%22none%22%3E%3Cpath d=%22M0 5 Q 25 0 50 5 T 100 5%22 stroke=%22%23ef4444%22 stroke-width=%222%22 fill=%22none%22/%3E%3C/svg%3E'); background-size: 100% 100%;"></span>
            </h3>
            <p id="noteContent" class="text-gray-600 leading-loose" style="line-height: 2rem;">Click a note from the list to view its details.</p>

            <!-- Tombol Edit dan Hapus -->
            <div id="noteActions" class="mt-4 hidden space-x-2">
                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" onclick="openEditNoteModal()">Edit</button>

                <form id="deleteNoteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">Delete Note</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Add Note Modal -->
    <div id="addNoteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Note</h3>
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="newNoteTitle" class="block text-gray-600 mb-2">Title</label>
                    <input type="text" name="title" id="newNoteTitle" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="newNoteContent" class="block text-gray-600 mb-2">Content</label>
                    <textarea name="content" id="newNoteContent" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md" required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md" onclick="closeAddNoteModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Note Modal -->
    <div id="editNoteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Note</h3>
            <form id="editNoteForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="editNoteTitle" class="block text-gray-600 mb-2">Title</label>
                    <input type="text" name="title" id="editNoteTitle" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="editNoteContent" class="block text-gray-600 mb-2">Content</label>
                    <textarea name="content" id="editNoteContent" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md" required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md" onclick="closeEditNoteModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedNoteId = null;

        function openAddNoteModal() {
            document.getElementById('addNoteModal').classList.remove('hidden');
        }

        function closeAddNoteModal() {
            document.getElementById('addNoteModal').classList.add('hidden');
            document.getElementById('newNoteTitle').value = '';
            document.getElementById('newNoteContent').value = '';
        }

        function openEditNoteModal() {
            const notes = @json($notes);
            const selected = notes.find(n => n.id === selectedNoteId);
            if (selected) {
                document.getElementById('editNoteTitle').value = selected.title;
                document.getElementById('editNoteContent').value = selected.content;
                document.getElementById('editNoteForm').action = `/notes/${selected.id}`;
                document.getElementById('editNoteModal').classList.remove('hidden');
            }
        }

        function closeEditNoteModal() {
            document.getElementById('editNoteModal').classList.add('hidden');
        }

        function selectNote(note) {
            selectedNoteId = note.id;
            document.getElementById('noteTitle').innerText = note.title;
            document.getElementById('noteContent').innerText = note.content;

            const form = document.getElementById('deleteNoteForm');
            form.action = `/notes/${note.id}`;
            document.getElementById('noteActions').classList.remove('hidden');
        }
    </script>
</x-layout>
