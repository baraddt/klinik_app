<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Klinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Login Klinik</h2>

        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Email"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Login
            </button>
        </form>

        @if ($errors->any())
            <div class="text-red-600 mt-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif
    </div>

</body>

</html>