@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow">
            <h1 class="text-xl font-semibold mb-4">Transaksi Tindakan & Obat</h1>
            <div class="mb-6">
                <label for="pasien" class="block text-gray-700">Pilih Pasien</label>
                <select id="pasien" onchange="tampilkanRiwayat(this.value)"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                    <option value="">-- Pilih Pasien --</option>
                    <option value="1">Asep</option>
                    <option value="2">Alan</option>
                    <option value="3">Fikri</option>
                    <option value="4">Paul</option>
                    <option value="5">Gordon</option>
                </select>
            </div>

            <div id="riwayatKunjungan" class="mb-6 hidden">
                <h2 class="font-semibold text-lg mb-2">Riwayat Kunjungan</h2>
                <ul id="listKunjungan" class="list-disc pl-5">
                </ul>
            </div>

            <div class="mb-6">
                <label for="tindakan" class="block text-gray-700">Tindakan Medis</label>
                <textarea id="tindakan" rows="4"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                    placeholder="Masukkan tindakan medis..."></textarea>
            </div>

            <div class="mb-6">
                <label for="obat" class="block text-gray-700">Obat yang Diberikan</label>
                <textarea id="obat" rows="4"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                    placeholder="Masukkan obat yang diberikan..."></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="resetForm()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button type="button" onclick="simpanTindakan()"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-4">Riwayat Tindakan & Obat</h2>
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3">Pasien</th>
                            <th class="text-left p-3">Tindakan Medis</th>
                            <th class="text-left p-3">Obat</th>
                            <th class="text-left p-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody id="riwayatTindakan">
                        <tr id="noDataRow">
                            <td colspan="4" class="text-center p-4 text-gray-500">Data riwayat tindakan kosong</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const pasienData = {
            1: {
                nama: 'Asep',
                riwayat: [
                    { tanggal: '2025-03-01', keluhan: 'Demam tinggi' },
                    { tanggal: '2025-03-10', keluhan: 'Batuk dan pilek' },
                ]
            },
            2: {
                nama: 'Alan',
                riwayat: [
                    { tanggal: '2025-02-15', keluhan: 'Sakit kepala' },
                ]
            },
            3: {
                nama: 'Fikri',
                riwayat: [
                    { tanggal: '2025-03-05', keluhan: 'Nyeri perut' },
                    { tanggal: '2025-04-02', keluhan: 'Mual-mual' },
                ]
            },
            4: {
                nama: 'Paul',
                riwayat: [
                    { tanggal: '2025-01-20', keluhan: 'Pusing' },
                    { tanggal: '2025-04-10', keluhan: 'Nyeri punggung' },
                ]
            },
            5: {
                nama: 'Gordon',
                riwayat: [
                    { tanggal: '2025-03-12', keluhan: 'Batuk kering' },
                ]
            }
        };

        function tampilkanRiwayat(pasienId) {
            const riwayatKunjunganDiv = document.getElementById('riwayatKunjungan');
            const listKunjungan = document.getElementById('listKunjungan');
            riwayatKunjunganDiv.classList.remove('hidden');

            if (pasienId) {
                listKunjungan.innerHTML = ''; 
                const pasien = pasienData[pasienId];
                pasien.riwayat.forEach((kunjungan) => {
                    const li = document.createElement('li');
                    li.innerHTML = `<strong>${kunjungan.tanggal}</strong>: ${kunjungan.keluhan}`;
                    listKunjungan.appendChild(li);
                });
            }
        }

        let tindakanData = []; 
        function simpanTindakan() {
            const pasien = document.getElementById('pasien').value;
            const tindakan = document.getElementById('tindakan').value;
            const obat = document.getElementById('obat').value;
            const tanggal = new Date().toLocaleDateString();

            if (pasien && tindakan && obat) {
                const tindakanObj = {
                    pasien: pasien,
                    tindakan: tindakan,
                    obat: obat,
                    tanggal: tanggal
                };

                tindakanData.push(tindakanObj); 

                resetForm();

                updateRiwayat();
            } else {
                alert('Semua data harus diisi!');
            }
        }

        function resetForm() {
            document.getElementById('pasien').value = '';
            document.getElementById('tindakan').value = '';
            document.getElementById('obat').value = '';
        }

        function updateRiwayat() {
            const riwayatTindakanTable = document.getElementById('riwayatTindakan');
            const noDataRow = document.getElementById('noDataRow');
            riwayatTindakanTable.innerHTML = ''; 

            if (tindakanData.length > 0) {
                noDataRow.classList.add('hidden'); 

                tindakanData.forEach((item) => {
                    const row = riwayatTindakanTable.insertRow();
                    row.innerHTML = `
                                <td class="p-3">Pasien ${item.pasien}</td>
                                <td class="p-3">${item.tindakan}</td>
                                <td class="p-3">${item.obat}</td>
                                <td class="p-3">${item.tanggal}</td>
                            `;
                });
            } else {
                noDataRow.classList.remove('hidden'); 
            }
        }
    </script>
@endsection