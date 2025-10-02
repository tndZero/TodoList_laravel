<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-200 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-2xl bg-white/90 rounded-2xl shadow-xl p-10 border border-blue-100 backdrop-blur-lg">
        <div class="flex flex-col items-center mb-8">
            <svg class="w-16 h-16 text-blue-500 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
            <h2 class="text-3xl font-extrabold text-blue-700 tracking-tight">Welcome to TodoList Main Page</h2>
        </div>
        <div class="mt-6 text-center text-lg text-gray-700">
            <p>This is your main dashboard. Start managing your tasks!</p>
        </div>
        <div class="mt-8 flex justify-center">
            <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                Login
            </a>
        </div>
        <div class="mt-8 flex justify-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-blue-600 hover:underline font-medium bg-transparent border-none p-0 m-0 cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
