<?php

namespace App\Http\Controllers;

use FPDF;

class LaporanController extends Controller
{
    public function generatePDF()
    {
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Laporan Klinik', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Tanggal: ' . date('Y-m-d'), 0, 1);
        $pdf->Cell(0, 10, 'Jumlah Kunjungan: 30', 0, 1);
        $pdf->Cell(0, 10, 'Jenis Tindakan: Pemeriksaan Umum', 0, 1);
        $pdf->Cell(0, 10, 'Obat yang Diresepkan: Paracetamol', 0, 1);

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="laporan_klinik.pdf"');
    }

}
