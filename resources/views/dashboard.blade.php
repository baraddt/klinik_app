@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-center mb-4">
                <p class="text-gray-700 text-lg">
                    klik role sesuai tugas dan funsionalitas
                </p>
            </div>
            <div class="flex justify-center gap-4 mb-6">
                <button onclick="window.location.href='{{ route('admin.laporan') }}'"
                    class="bg-gray-700 text-white px-6 py-3 rounded-lg hover:bg-gray-800 flex items-center gap-2 shadow-md">
                    📊 Admin
                </button>
                <button onclick="window.location.href='{{ route('pendaftaran') }}'"
                    class="bg-gray-700 text-white px-6 py-3 rounded-lg hover:bg-gray-800 flex items-center gap-2 shadow-md">
                    📝 Petugas Pendaftaran
                </button>
                <button onclick="window.location.href='{{ route('dokter.tindakan') }}'"
                    class="bg-gray-700 text-white px-6 py-3 rounded-lg hover:bg-gray-800 flex items-center gap-2 shadow-md">
                    ⚕️ Dokter
                </button>
                <button onclick="window.location.href='{{ route('kasir.pembayaran') }}'"
                    class="bg-gray-700 text-white px-6 py-3 rounded-lg hover:bg-gray-800 flex items-center gap-2 shadow-md">
                    💸 Kasir
                </button>
            </div>
        </div>
    </div>
@endsection