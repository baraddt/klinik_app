@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow">
            <h1 class="text-xl font-semibold mb-4">Pendaftaran Pasien</h1>

            <div class="flex justify-between items-center mb-6">
                <div class="relative w-1/3">
                    <input type="text" placeholder="Cari Pasien"
                        class="w-full pl-4 pr-10 py-2 rounded shadow text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        🔍
                    </div>
                </div>
                <div class="flex gap-2">
                    <button onclick="openModal('patientModal', 'Tambah Pasien')"
                        class="flex items-center gap-2 bg-green-400 text-white px-4 py-2 rounded hover:bg-green-500">
                        ➕ Tambah
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse" id="patientTable">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3">ID Pasien</th>
                            <th class="text-left p-3">Nama</th>
                            <th class="text-left p-3">Email</th>
                            <th class="text-left p-3">Jenis Kunjungan</th>
                            <th class="text-left p-3">Tanggal Kunjungan</th>
                            <th class="text-left p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody id="patientTableBody">
                        <tr id="noDataRow">
                            <td colspan="6" class="text-center p-4 text-gray-500">Data pasien kosong</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div id="patientModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4" id="modalTitle">Tambah Pasien</h2>
                <form id="formPatient" method="POST" action="javascript:void(0)">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Pasien</label>
                        <input type="text" id="nama_pasien"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" id="email_pasien"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Jenis Kelamin</label>
                        <select id="jenis_kelamin"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Jenis Kunjungan</label>
                        <select id="jenis_kunjungan"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                            <option value="">-- Pilih Jenis Kunjungan --</option>
                            <option value="Konsultasi">Konsultasi</option>
                            <option value="Perawatan">Perawatan</option>
                            <option value="Kontrol">Kontrol</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Tanggal Kunjungan</label>
                        <input type="date" id="tanggal_kunjungan"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            let counter = 1; // Counter for ID
            let editingRow = null; 

            function openModal(id, title = '') {
                document.getElementById(id).classList.remove('hidden');
                if (title && document.getElementById('modalTitle')) {
                    document.getElementById('modalTitle').innerText = title;
                }

                if (editingRow) {
                    document.getElementById('nama_pasien').value = editingRow.querySelector('.nama-pasien').textContent;
                    document.getElementById('email_pasien').value = editingRow.querySelector('.email').textContent;
                    document.getElementById('jenis_kelamin').value = editingRow.querySelector('.jenis-kelamin').textContent;
                    document.getElementById('jenis_kunjungan').value = editingRow.querySelector('.jenis-kunjungan').textContent;
                    document.getElementById('tanggal_kunjungan').value = editingRow.querySelector('.tanggal-kunjungan').textContent;
                }
            }

            function closeModal() {
                document.querySelectorAll('.fixed.inset-0').forEach(modal => modal.classList.add('hidden'));
                document.getElementById('nama_pasien').value = '';
                document.getElementById('email_pasien').value = '';
                document.getElementById('jenis_kelamin').value = '';
                document.getElementById('jenis_kunjungan').value = '';
                document.getElementById('tanggal_kunjungan').value = '';
                editingRow = null;
            }

            document.getElementById('formPatient').addEventListener('submit', function (e) {
                e.preventDefault();

                const namaPasien = document.getElementById('nama_pasien').value;
                const email = document.getElementById('email_pasien').value;
                const jenisKelamin = document.getElementById('jenis_kelamin').value;
                const jenisKunjungan = document.getElementById('jenis_kunjungan').value;
                const tanggalKunjungan = document.getElementById('tanggal_kunjungan').value;

                const table = document.getElementById('patientTable').getElementsByTagName('tbody')[0];

                if (editingRow) {
                    editingRow.querySelector('.nama-pasien').textContent = namaPasien;
                    editingRow.querySelector('.email').textContent = email;
                    editingRow.querySelector('.jenis-kelamin').textContent = jenisKelamin;
                    editingRow.querySelector('.jenis-kunjungan').textContent = jenisKunjungan;
                    editingRow.querySelector('.tanggal-kunjungan').textContent = tanggalKunjungan;
                    closeModal();
                    updateTable(); 
                    return;
                }

                const newRow = table.insertRow();
                newRow.innerHTML = `
                <td class="p-3">#P${counter++}</td>
                <td class="p-3 nama-pasien">${namaPasien}</td>
                <td class="p-3 email">${email}</td>
                <td class="p-3 jenis-kelamin">${jenisKelamin}</td>
                <td class="p-3 jenis-kunjungan">${jenisKunjungan}</td>
                <td class="p-3 tanggal-kunjungan">${tanggalKunjungan}</td>
                <td class="p-3 flex gap-3">
                    <a href="#" onclick="editRow(this)" class="text-blue-500 hover:text-blue-700">✏️</a>
                    <a href="#" onclick="deleteRow(this)" class="text-red-500 hover:text-red-700">🗑️</a>
                </td>
                `;

                document.getElementById('nama_pasien').value = '';
                document.getElementById('email_pasien').value = '';
                document.getElementById('jenis_kelamin').value = '';
                document.getElementById('jenis_kunjungan').value = '';
                document.getElementById('tanggal_kunjungan').value = '';

                closeModal();
                updateTable();
            });

            function editRow(button) {
                editingRow = button.closest('tr');
                openModal('patientModal', 'Edit Pasien');
            }

            function deleteRow(button) {
                const row = button.closest('tr');
                row.remove();
                updateTable();
            }

            function updateTable() {
                const tableBody = document.getElementById('patientTableBody');
                const noDataRow = document.getElementById('noDataRow');

                if (tableBody.rows.length > 0) {
                    noDataRow.classList.add('hidden'); 
                } else {
                    noDataRow.classList.remove('hidden'); 
                }
            }
        </script>

    </div>
@endsection
