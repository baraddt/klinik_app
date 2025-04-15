<!-- resources/views/layouts/app.blade.php -->
@vite('resources/css/app.css')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Sistem infromasi Klinik</title>
</head>

<body class="bg-gray-100 text-base min-h-screen">

    <nav class="bg-white text-base shadow px-8 py-4 flex justify-between items-center">
        <div class="font-semibold text-lg">
            Sistem Informasi Klinik
        </div>
        <ul class="flex space-x-8 text-sm">
            <li><a href="{{ url('/') }}" class="hover:text-blue-600">Dashboard</a></li>
            <li><a href="{{ url('/wilayah') }}" class="hover:text-blue-600">Wilayah</a></li>
            <li><a href="{{ url('/user') }}" class="hover:text-blue-600">User</a></li>
            <li><a href="{{ url('/pegawai') }}" class="hover:text-blue-600">Pegawai</a></li>
            <li><a href="{{ url('/tindakan') }}" class="hover:text-blue-600">Tindakan</a></li>
            <li><a href="{{ url('/obat') }}" class="hover:text-blue-600">Obat</a></li>
        </ul>
    </nav>

    <main class="p-8">
        @yield('content')
    </main>

</body>

</html>