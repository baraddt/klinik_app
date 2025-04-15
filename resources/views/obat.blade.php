@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow">
            <h1 class="text-xl font-semibold mb-4">Obat</h1>

            <div class="flex justify-between items-center mb-6">
                <div class="relative w-1/3">
                    <input type="text" placeholder="search"
                        class="w-full pl-4 pr-10 py-2 rounded shadow text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        🔍
                    </div>
                </div>
                <div class="flex gap-2">
                    <button onclick="openModal('obatModal', 'Tambah Obat')"
                        class="flex items-center gap-2 bg-green-400 text-white px-4 py-2 rounded hover:bg-green-500">
                        ➕ Tambah
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse" id="obatTable">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3">ID</th>
                            <th class="text-left p-3">Nama Obat</th>
                            <th class="text-left p-3">Harga</th>
                            <th class="text-left p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody id="obatTableBody">
                        <tr id="noDataRow">
                            <td colspan="4" class="text-center p-4 text-gray-500">Data obat kosong</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div id="obatModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4" id="modalTitle">Tambah Obat</h2>
                <form id="formObat" method="POST" action="javascript:void(0)">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Obat</label>
                        <input type="text" id="nama_obat"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Harga</label>
                        <input type="number" id="harga"
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
            let counter = 1; 
            let editingRow = null; 

            function openModal(id, title = '') {
                document.getElementById(id).classList.remove('hidden');
                if (title && document.getElementById('modalTitle')) {
                    document.getElementById('modalTitle').innerText = title;
                }

                if (editingRow) {
                    document.getElementById('nama_obat').value = editingRow.querySelector('.nama-obat').textContent;
                    document.getElementById('harga').value = editingRow.querySelector('.harga').textContent;
                }
            }

            function closeModal() {
                document.querySelectorAll('.fixed.inset-0').forEach(modal => modal.classList.add('hidden'));
                document.getElementById('nama_obat').value = '';
                document.getElementById('harga').value = '';
                editingRow = null;
            }

            document.getElementById('formObat').addEventListener('submit', function (e) {
                e.preventDefault();

                const namaObat = document.getElementById('nama_obat').value;
                const harga = document.getElementById('harga').value;

                const table = document.getElementById('obatTable').getElementsByTagName('tbody')[0];

                if (editingRow) {
                    editingRow.querySelector('.nama-obat').textContent = namaObat;
                    editingRow.querySelector('.harga').textContent = harga;
                    closeModal();
                    updateTable(); 
                    return;
                }

                const newRow = table.insertRow();
                newRow.innerHTML = `
            <td class="p-3">#O${counter++}</td>
            <td class="p-3 nama-obat">${namaObat}</td>
            <td class="p-3 harga">${harga}</td>
            <td class="p-3 flex gap-3">
                <a href="#" onclick="editRow(this)" class="text-blue-500 hover:text-blue-700">✏️</a>
                <a href="#" onclick="deleteRow(this)" class="text-red-500 hover:text-red-700">🗑️</a>
            </td>
            `;

                document.getElementById('nama_obat').value = '';
                document.getElementById('harga').value = '';

                closeModal();
                updateTable();
            });

            function editRow(button) {
                editingRow = button.closest('tr');
                openModal('obatModal', 'Edit Obat');
            }

            function deleteRow(button) {
                const row = button.closest('tr');
                row.remove();
                updateTable(); 
            }

            function updateTable() {
                const tableBody = document.getElementById('obatTableBody');
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