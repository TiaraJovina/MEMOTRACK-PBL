<x-layout title="Profile" role="{{ $user->role }}">
    <!-- Profile Header -->
    <header class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Profile</h2>
        <p class="text-gray-600 mt-2">View and update your personal information.</p>
    </header>

    <!-- Profile Layout -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Information -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">User Information</h3>
                <button 
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition" 
                    onclick="openEditProfileModal()"
                >
                    Edit Profile
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label><strong>Username</strong></label>
                    <p id="profileName" class="text-gray-900">{{ $user->username }}</p>
                </div>
                <div>
                    <label><strong>Email</strong></label>
                    <p id="profileEmail" class="text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <label><strong>Role</strong></label>
                    <p id="profileRole" class="text-gray-900">{{ ucfirst($user->role) }}</p>
                </div>
                <div>
                    <label><strong>Bio</strong></label>
                    <p id="profileBio" class="text-gray-900">{{ $user->bio ?? 'No bio yet.' }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Summary -->
        <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-1" style="background-image: linear-gradient(#e5e7eb 1px, transparent 1px); background-size: 100% 2rem;">
            <h3 class="text-xl font-semibold text-gray-900 mb-4 relative">
                Profile Summary
                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-500" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 10%22 preserveAspectRatio=%22none%22%3E%3Cpath d=%22M0 5 Q 25 0 50 5 T 100 5%22 stroke=%22%23ef4444%22 stroke-width=%222%22 fill=%22none%22/%3E%3C/svg%3E'); background-size: 100% 100%;"></span>
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-600">Courses Enrolled</p>
                    <p class="text-2xl font-bold text-blue-500">{{ $user->role === 'dosen' ? '3' : '5' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Notes Created</p>
                    <p class="text-2xl font-bold text-blue-500">12</p>
                </div>
                <div>
                    <p class="text-gray-600">Tasks Completed</p>
                    <p class="text-2xl font-bold text-blue-500">{{ $user->role === 'dosen' ? 'N/A' : '8' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Profile</h3>
            <form id="editProfileForm" onsubmit="event.preventDefault(); saveProfile();">
                <div class="mb-4">
                    <label for="editName" class="block text-gray-600 mb-2">Username</label>
                    <input 
                        type="text" 
                        id="editName" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        placeholder="Enter your username" 
                        value="{{ $user->username }}" 
                        required
                    >
                </div>
                <div class="mb-4">
                    <label for="editEmail" class="block text-gray-600 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="editEmail" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        placeholder="Enter your email" 
                        value="{{ $user->email }}" 
                        required
                    >
                </div>
                <div class="mb-4">
                    <label for="editBio" class="block text-gray-600 mb-2">Bio</label>
                    <textarea 
                        id="editBio" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        placeholder="Enter your bio" 
                        rows="4"
                    >{{ $user->bio ?? '' }}</textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button 
                        type="button" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition" 
                        onclick="closeEditProfileModal()"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditProfileModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
        }

        function closeEditProfileModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
        }

        function saveProfile() {
            const name = document.getElementById('editName').value.trim();
            const email = document.getElementById('editEmail').value.trim();
            const bio = document.getElementById('editBio').value.trim();

            if (!name || !email) {
                alert('Please fill in all required fields.');
                return;
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Please enter a valid email address.');
                return;
            }

            fetch("{{ route('profile.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    username: name,
                    email: email,
                    bio: bio
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('profileName').innerText = name;
                document.getElementById('profileEmail').innerText = email;
                document.getElementById('profileBio').innerText = bio || 'No bio yet.';
                closeEditProfileModal();
                alert(data.message);
            })
            .catch(error => {
                if (error.errors) {
                    alert(Object.values(error.errors).flat().join('\n'));
                } else {
                    alert('Failed to update profile.');
                }
            });
        }
    </script>
</x-layout>
