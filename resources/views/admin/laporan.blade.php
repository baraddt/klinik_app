@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-semibold">Laporan Klinik</h1>
                <button onclick="window.open('{{ route('laporan.generatePDF') }}', '_blank')"
                    class="bg-red-500 text-white px-6 py-3 rounded hover:bg-blue-600">
                    Generate to PDF
                </button>
            </div>

            <div class="mb-6">
                <label for="periode" class="block text-gray-700">Pilih Periode</label>
                <select id="periode"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                    <option value="hari">Per Hari</option>
                    <option value="bulan">Per Bulan</option>
                </select>
            </div>

            <div class="mb-6">
                <h2 class="font-semibold text-lg mb-2">Jumlah Kunjungan Pasien</h2>
                <canvas id="kunjunganPasienChart" width="400" height="200"></canvas>
            </div>

            <div class="mb-6">
                <h2 class="font-semibold text-lg mb-2">Jenis Tindakan Terbanyak</h2>
                <canvas id="tindakanChart" width="400" height="200"></canvas>
            </div>

            <div class="mb-6">
                <h2 class="font-semibold text-lg mb-2">Obat yang Paling Sering Diresepkan</h2>
                <canvas id="obatChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        const dataKunjunganPasien = {
            hari: [5, 10, 15, 20, 25, 30, 35],
            bulan: [120, 150, 180, 200, 220, 250, 270], 
        };

        const dataTindakan = {
            'Pemeriksaan Umum': 50,
            'Operasi Kecil': 30,
            'Rontgen': 20,
            'Pemeriksaan Gigi': 40,
            'Pemeriksaan Mata': 25
        };

        const dataObat = {
            'Paracetamol': 70,
            'Ibuprofen': 50,
            'Amoxicillin': 40,
            'Cetirizine': 30,
            'Ibuprofen': 60
        };

        function renderKunjunganPasienChart(period) {
            const ctx = document.getElementById('kunjunganPasienChart').getContext('2d');
            const chartData = {
                labels: period === 'hari' ? ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Jumlah Kunjungan Pasien',
                    data: dataKunjunganPasien[period],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                });
        }

        function renderTindakanChart() {
            const ctx = document.getElementById('tindakanChart').getContext('2d');
            const chartData = {
                labels: Object.keys(dataTindakan),
                datasets: [{
                    label: 'Jenis Tindakan Terbanyak',
                    data: Object.values(dataTindakan),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            };

            new Chart(ctx, {
                type: 'pie',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        function renderObatChart() {
            const ctx = document.getElementById('obatChart').getContext('2d');
            const chartData = {
                labels: Object.keys(dataObat),
                datasets: [{
                    label: 'Obat yang Paling Sering Diresepkan',
                    data: Object.values(dataObat),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            };

            new Chart(ctx, {
                type: 'pie',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text("Laporan Klinik", 14, 10);
            doc.text("Jumlah Kunjungan Pasien", 14, 20);
            doc.addImage(document.getElementById('kunjunganPasienChart').toDataURL(), 'JPEG', 14, 25, 180, 90);

            doc.text("Jenis Tindakan Terbanyak", 14, 120);
            doc.addImage(document.getElementById('tindakanChart').toDataURL(), 'JPEG', 14, 125, 180, 90);

            doc.text("Obat yang Paling Sering Diresepkan", 14, 220);
            doc.addImage(document.getElementById('obatChart').toDataURL(), 'JPEG', 14, 225, 180, 90);

            doc.save('laporan_klinik.pdf');
        }

        document.getElementById('periode').addEventListener('change', function () {
            const periode = this.value;
            renderKunjunganPasienChart(periode);
        });

        renderKunjunganPasienChart('hari');
        renderTindakanChart();
        renderObatChart();
    </script>
@endsection