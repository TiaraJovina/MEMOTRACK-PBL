<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoTrack - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .login-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <!-- Login Section -->
    <section class="login-section w-full max-w-md mx-auto p-6 rounded-lg shadow-md bg-white">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-500">MemoTrack</h1>
            <h2 class="text-2xl font-semibold text-gray-900 mt-2">Login</h2>
        </div>
        
        <!-- Laravel Form Start -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-600 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your email" required>
            </div>
                <label for="password" class="block text-gray-600 mb-2">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter your password" required>
            </div>

            @if ($errors->any())
                <div class="text-red-500 text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Login
            </button>
        </form>
        <!-- Laravel Form End -->
        <p class="text-center text-gray-600 mt-4">
            Don't have an account? <a href="/register" class="text-blue-500 hover:underline">Daftar</a>
        </p>
        <p class="text-center text-gray-600 mt-2">
            Back to <a href="/index.html" class="text-blue-500 hover:underline">Home</a>
        </p>
    </section>
</body>
</html>
