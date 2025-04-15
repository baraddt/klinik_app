@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow">
            <h1 class="text-xl font-semibold mb-4">User</h1>

            <div class="flex justify-between items-center mb-6">
                <div class="relative w-1/3">
                    <input type="text" placeholder="search"
                        class="w-full pl-4 pr-10 py-2 rounded shadow text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        🔍
                    </div>
                </div>
                <div class="flex gap-2">
                    <button onclick="openModal('userModal', 'Tambah User')"
                        class="flex items-center gap-2 bg-green-400 text-white px-4 py-2 rounded hover:bg-green-500">
                        ➕ Tambah
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse" id="userTable">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3">ID</th>
                            <th class="text-left p-3">Nama</th>
                            <th class="text-left p-3">Email</th>
                            <th class="text-left p-3">Role</th>
                            <th class="text-left p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <tr id="noDataRow">
                            <td colspan="5" class="text-center p-4 text-gray-500">Data user kosong</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div id="userModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4" id="modalTitle">Tambah User</h2>
                <form id="formUser" method="POST" action="javascript:void(0)">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Nama</label>
                        <input type="text" id="nama_user"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" id="email"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Role</label>
                        <select id="role"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                            <option value="">-- Pilih Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
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
                    document.getElementById('nama_user').value = editingRow.querySelector('.nama-user').textContent;
                    document.getElementById('email').value = editingRow.querySelector('.email').textContent;
                    document.getElementById('role').value = editingRow.querySelector('.role').textContent;
                }
            }

            function closeModal() {
                document.querySelectorAll('.fixed.inset-0').forEach(modal => modal.classList.add('hidden'));
                document.getElementById('nama_user').value = '';
                document.getElementById('email').value = '';
                document.getElementById('role').value = '';
                editingRow = null;
            }

            document.getElementById('formUser').addEventListener('submit', function (e) {
                e.preventDefault();

                const namaUser = document.getElementById('nama_user').value;
                const email = document.getElementById('email').value;
                const role = document.getElementById('role').value;

                const table = document.getElementById('userTable').getElementsByTagName('tbody')[0];

                if (editingRow) {
                    editingRow.querySelector('.nama-user').textContent = namaUser;
                    editingRow.querySelector('.email').textContent = email;
                    editingRow.querySelector('.role').textContent = role;
                    closeModal();
                    updateTable(); 
                    return;
                }

                const newRow = table.insertRow();
                newRow.innerHTML = `
                <td class="p-3">#U${counter++}</td>
                <td class="p-3 nama-user">${namaUser}</td>
                <td class="p-3 email">${email}</td>
                <td class="p-3 role">${role}</td>
                <td class="p-3 flex gap-3">
                    <a href="#" onclick="editRow(this)" class="text-blue-500 hover:text-blue-700">✏️</a>
                    <a href="#" onclick="deleteRow(this)" class="text-red-500 hover:text-red-700">🗑️</a>
                </td>
                `;

                document.getElementById('nama_user').value = '';
                document.getElementById('email').value = '';
                document.getElementById('role').value = '';

                closeModal();
                updateTable(); 
            });

            function editRow(button) {
                editingRow = button.closest('tr');
                openModal('userModal', 'Edit User');
            }

            function deleteRow(button) {
                const row = button.closest('tr');
                row.remove();
                updateTable(); 
            }

            function updateTable() {
                const tableBody = document.getElementById('userTableBody');
                const noDataRow = document.getElementById('noDataRow');

                if (tableBody.rows.length > 0) {
                    noDataRow.classList.add('hidden'); 
                } else {
                    noDataRow.classList.remove('hidden'); 
            }
        </script>

    </div>
@endsection