<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-200 min-h-screen flex items-center justify-center">
    <div
        class="w-full max-w-3xl bg-white/90 rounded-2xl shadow-xl p-4 sm:p-8 md:p-10 border border-blue-100 backdrop-blur-lg mx-0 md:mx-8 lg:mx-16 xl:mx-32">
        <div class="flex flex-col items-center mb-8">
            <svg class="w-16 h-16 text-blue-500 mb-2" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
            </svg>
            <h2 class="text-3xl font-extrabold text-blue-700 tracking-tight">Welcome to TodoList Main Page</h2>
        </div>
        {{-- User name --}}
        @if (Auth::check())
            <div class="mb-6 text-center text-gray-700">
                ลงชื่อเข้าใช้งานโดย : <span class="font-semibold">{{ Auth::user()->name }}</span>
            </div>
        @endif

        <!-- Todo Form -->
        <form method="POST" action="{{ route('todos.store') }}" class="mb-8 flex gap-4 items-end">
            @csrf
            <div class="flex-1">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">สร้างรายการใหม่</label>

                <input type="text" name="content" id="content" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                    placeholder="สิ่งที่ต้องทำ.">

            </div>
            <button type="submit"
                class="mt-4 h-12 px-6 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center">+</button>

        </form>
        <!-- Todo Table -->
        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-[600px] bg-white rounded-lg shadow text-xs sm:text-sm">
                <thead>
                    <tr class="bg-blue-100 text-blue-700">
                        <th class="px-2 sm:px-4 py-2">#</th>
                        <th class="px-2 sm:px-4 py-2">รายการสิ่งที่ต้องทำ</th>
                        <th class="px-2 sm:px-4 py-2">สร้างโดย</th>
                        <th class="px-2 sm:px-4 py-2">สถานะ</th>
                        <th class="px-2 sm:px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todos as $todo)
                        <tr class="border-b">
                            <td class="px-4 py-2 align-top">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 align-top">
                                @if (Auth::id() === $todo->user_id)
                                    <!-- Edit form for own todo -->
                                    <form method="POST" action="{{ route('todos.update', $todo) }}"
                                        class="flex gap-2 items-center">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="content" value="{{ $todo->content }}"
                                            class="w-full px-2 py-1 border border-gray-300 rounded" />
                                        <button type="submit" class="text-blue-600 hover:underline">Save</button>
                                    </form>
                                @else
                                    {{ $todo->content }}
                                @endif
                            </td>
                            <td class="px-4 py-2 align-top">{{ $todo->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 align-top">
                                @if ($todo->completed)
                                    <span class="text-green-600 font-semibold">Done</span><br>
                                    <span class="text-xs text-gray-500">by {{ $todo->completer->name ?? '-' }}<br>
                                        @if ($todo->completed_at)
                                            {{ \Carbon\Carbon::parse($todo->completed_at)->format('Y-m-d H:i') }}
                                        @endif
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('todos.checklist', $todo) }}">
                                        @csrf
                                        <button type="submit"
                                            class="text-blue-600 hover:underline">ทำเครื่องหมายว่าสำเร็จ</button>
                                    </form>
                                @endif
                            </td>
                            <td class="px-4 py-2 align-top">
                                @if (Auth::id() === $todo->user_id)
                                    <form method="POST" action="{{ route('todos.destroy', $todo) }}"
                                        onsubmit="return confirm('Delete this todo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">ลบ</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4">
                                <!-- Comments Section -->
                                <div class="pl-4 border-l-2 border-blue-100">
                                    <div class="mb-2 font-semibold text-blue-700">Comments</div>
                                    @foreach ($todo->comments as $comment)
                                        <div class="mb-2 flex gap-2 items-start">
                                            <div class="font-medium text-sm text-blue-600">
                                                {{ $comment->user->name ?? '-' }}</div>
                                            <div class="flex-1">
                                                @if ($comment->content)
                                                    <div class="bg-gray-100 rounded px-2 py-1 inline-block">
                                                        {{ $comment->content }}</div>
                                                @endif
                                                @if ($comment->image_path)
                                                    <a href="{{ asset('storage/' . $comment->image_path) }}"
                                                        target="_blank" class="block mt-1">
                                                        <img src="{{ asset('storage/' . $comment->image_path) }}"
                                                            alt="comment image"
                                                            class="max-h-24 rounded border border-gray-200 shadow-sm">
                                                    </a>
                                                @endif
                                            </div>

                                        </div>
                                    @endforeach
                                    <!-- Add Comment Form -->
                                    <form method="POST" action="{{ route('comments.store', $todo) }}"
                                        enctype="multipart/form-data" class="flex gap-2 items-end mt-2">
                                        @csrf
                                        <input type="text" name="content" placeholder="เพิ่ม comment..."
                                            class="flex-1 px-2 py-1 border border-gray-300 rounded  sm:w-auto" />
                                        <label
                                            class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded cursor-pointer text-xs hover:bg-blue-200 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 002.828 2.828l6.586-6.586a2 2 0 00-2.828-2.828z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 5l3 3m-2 2l-3-3" />
                                            </svg>
                                            Attach Image
                                            <input type="file" name="image" accept="image/*" class="hidden" />
                                        </label>
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded cursor-pointer text-xs hover:bg-blue-200 transition">Comment</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (Auth::check())
            <div class="mt-8 flex justify-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:underline font-medium">Logout</button>
                </form>
            </div>
        @else
            {{-- Login --}}
            <div class="mt-8 text-center text-sm text-gray-500">
                <a href="{{ route('login.form') }}" class="text-blue-600 hover:underline font-medium">Login</a> to
                manage your todos.
            </div>
        @endif
    </div>
</body>

</html>
