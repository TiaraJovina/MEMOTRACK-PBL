<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoTrack - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .register-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <!-- Register Section -->
    <section class="register-section w-full max-w-md mx-auto p-6 rounded-lg shadow-md bg-white">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-500">MemoTrack</h1>
            <h2 class="text-2xl font-semibold text-gray-900 mt-2">Register</h2>
        </div>

        {{-- Tampilkan pesan error --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Register --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="username" class="block text-gray-600 mb-2">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your username" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-600 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your email" required>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-600 mb-2">Role</label>
                <select id="role" name="role" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-600 mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Daftar</button>
        </form>

        <p class="text-center text-gray-600 mt-4">
            Already have an account? <a href="/login" class="text-blue-500 hover:underline">Login</a>
        </p>
        <p class="text-center text-gray-600 mt-2">
            Back to <a href="/" class="text-blue-500 hover:underline">Home</a>
        </p>
    </section>
</body>
</html>
