@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow">
            <h1 class="text-xl font-semibold mb-4">Pembayaran Tagihan Pasien</h1>

            <div class="mb-6">
                <label for="pasien" class="block text-gray-700">Pilih Pasien</label>
                <select id="pasien" onchange="tampilkanTagihan(this.value)"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                    <option value="">-- Pilih Pasien --</option>
                    <option value="1">Asep</option>
                    <option value="2">Alan</option>
                    <option value="3">Fikri</option>
                    <option value="4">Deni</option>
                    <option value="5">Dadan</option>
                </select>
            </div>

            <div id="tagihanPasien" class="mb-6 hidden">
                <h2 class="font-semibold text-lg mb-2">Tagihan Pasien</h2>
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3">Tindakan Medis</th>
                            <th class="text-left p-3">Obat</th>
                            <th class="text-left p-3">Biaya</th>
                        </tr>
                    </thead>
                    <tbody id="tagihanDetails">
                    </tbody>
                </table>
            </div>

            <div id="totalPembayaran" class="mb-6 hidden">
                <h2 class="font-semibold text-lg mb-2">Total Pembayaran</h2>
                <div class="flex justify-between items-center">
                    <span class="text-xl font-semibold">Total:</span>
                    <span id="totalAmount" class="text-xl font-semibold">Rp. 0</span>
                </div>
            </div>

            <div id="pembayaranForm" class="mb-6 hidden">
                <h2 class="font-semibold text-lg mb-2">Pembayaran</h2>
                <div class="flex justify-between items-center">
                    <label for="bayar" class="text-lg">Jumlah Bayar:</label>
                    <input type="number" id="bayar" class="border rounded px-3 py-2 w-1/2"
                        placeholder="Masukkan jumlah bayar" />
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="resetForm()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="button" onclick="prosesPembayaran()"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Selesaikan Pembayaran</button>
                </div>
            </div>

            
            <div id="statusPembayaran" class="hidden mt-6">
                <h2 class="font-semibold text-lg mb-2">Status Pembayaran</h2>
                <p id="status" class="text-green-500 text-lg font-semibold">Pembayaran selesai.</p>
            </div>
        </div>
    </div>

    <script>
   
        const pasienData = {
            1: {
                nama: 'Asep',
                tagihan: [
                    { tindakan: 'Pemeriksaan Umum', obat: 'Paracetamol', biaya: 50000 },
                    { tindakan: 'Rontgen', obat: 'Amoxicillin', biaya: 150000 }
                ]
            },
            2: {
                nama: 'Alan',
                tagihan: [
                    { tindakan: 'Pemeriksaan Gigi', obat: 'Ibuprofen', biaya: 120000 }
                ]
            },
            3: {
                nama: 'Fikri',
                tagihan: [
                    { tindakan: 'Pemeriksaan Umum', obat: 'Paracetamol', biaya: 50000 }
                ]
            },
            4: {
                nama: 'Deni',
                tagihan: [
                    { tindakan: 'Operasi Kecil', obat: 'Cetirizine', biaya: 250000 },
                    { tindakan: 'Pemeriksaan Gigi', obat: 'Amoxicillin', biaya: 100000 }
                ]
            },
            5: {
                nama: 'Dadan',
                tagihan: [
                    { tindakan: 'Pemeriksaan Umum', obat: 'Paracetamol', biaya: 50000 },
                    { tindakan: 'Pemeriksaan Gigi', obat: 'Ibuprofen', biaya: 120000 }
                ]
            }
        };

       
        function tampilkanTagihan(pasienId) {
            const tagihanPasienDiv = document.getElementById('tagihanPasien');
            const tagihanDetails = document.getElementById('tagihanDetails');
            const totalPembayaranDiv = document.getElementById('totalPembayaran');
            const pembayaranForm = document.getElementById('pembayaranForm');
            const totalAmount = document.getElementById('totalAmount');

            tagihanPasienDiv.classList.remove('hidden');
            totalPembayaranDiv.classList.remove('hidden');
            pembayaranForm.classList.remove('hidden');

            tagihanDetails.innerHTML = '';
            let totalBiaya = 0;

            if (pasienId) {
                const pasien = pasienData[pasienId];
                pasien.tagihan.forEach((item) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                                <td class="p-3">${item.tindakan}</td>
                                <td class="p-3">${item.obat}</td>
                                <td class="p-3">Rp. ${item.biaya.toLocaleString()}</td>
                            `;
                    tagihanDetails.appendChild(row);
                    totalBiaya += item.biaya;
                });
                totalAmount.textContent = `Rp. ${totalBiaya.toLocaleString()}`;
            }
        }

        function prosesPembayaran() {
            const bayar = parseInt(document.getElementById('bayar').value, 10);
            const total = parseInt(document.getElementById('totalAmount').textContent.replace('Rp. ', '').replace('.', ''), 10);

            if (bayar >= total) {
                const statusPembayaranDiv = document.getElementById('statusPembayaran');
                document.getElementById('status').textContent = 'Pembayaran selesai.';
                statusPembayaranDiv.classList.remove('hidden');
                resetForm();
            } else {
                alert('Jumlah bayar tidak cukup!');
            }
        }

        function resetForm() {
            document.getElementById('pasien').value = '';
            document.getElementById('bayar').value = '';
            document.getElementById('tagihanPasien').classList.add('hidden');
            document.getElementById('totalPembayaran').classList.add('hidden');
            document.getElementById('pembayaranForm').classList.add('hidden');
        }
    </script>
@endsection