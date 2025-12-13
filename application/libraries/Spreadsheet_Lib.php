<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Spreadsheet_Lib
{
    public function __construct()
    {
        // Composer Autoload sudah di index.php
    }

    // =====================================================================
    // 1. EXPORT LAPORAN MUTASI
    // =====================================================================
    public function export_laporan_mutasi($data, $tahun)
    {
        $excel = new Spreadsheet();
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Laporan Mutasi Siswa');

        // Header kolom
        $headers = [
            'No', 'Nama Siswa', 'NIS', 'NISN', 'Kelas Asal', 'Jenis',
            'Jenis Keluar', 'Tanggal', 'Alasan', 'No. HP Ortu',
            'Tujuan', 'Tahun Ajaran', 'Dibuat Oleh'
        ];

        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }

        // Isi data
        $rowNum = 2;
        $no = 1;

        foreach ($data as $m) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, $m->nama_siswa);
            $sheet->setCellValue('C' . $rowNum, $m->nis);
            $sheet->setCellValue('D' . $rowNum, $m->nisn);
            $sheet->setCellValue('E' . $rowNum, $m->kelas_asal);
            $sheet->setCellValue('F' . $rowNum, ucfirst($m->jenis));
            $sheet->setCellValue('G' . $rowNum, $m->jenis == 'keluar' ? ($m->jenis_keluar ?: '-') : '-');
            $sheet->setCellValue('H' . $rowNum, !empty($m->tanggal) ? date('d-m-Y', strtotime($m->tanggal)) : '-');
            $sheet->setCellValue('I' . $rowNum, $m->alasan);
            $sheet->setCellValue('J' . $rowNum, $m->nohp_ortu);
            $sheet->setCellValue('K' . $rowNum, $m->jenis == 'keluar' ? ($m->tujuan_sekolah ?: '-') : ($m->kelas_tujuan ?: '-'));
            $sheet->setCellValue('L' . $rowNum, $m->tahun_ajaran);
            $sheet->setCellValue('M' . $rowNum, $m->dibuat_oleh);

            $rowNum++;
        }

        // Styling header
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font'      => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['style' => Border::BORDER_THIN]],
        ]);

        // Auto width
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="laporan_mutasi_' . $tahun . '.xls"');
        header('Cache-Control: max-age=0');

        $writer = new Xls($excel);
        $writer->save('php://output');
        exit();
    }

    // =====================================================================
    // 2. EXPORT SISWA PER KELAS
    // =====================================================================
    public function export_siswa_per_kelas($siswa, $kelas_nama)
    {
        $excel = new Spreadsheet();
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Siswa ' . $kelas_nama);

        // Header kolom
        $sheet->setCellValue('A1', 'No')
              ->setCellValue('B1', 'NIS')
              ->setCellValue('C1', 'Nama Siswa')
              ->setCellValue('D1', 'Jenis Kelamin')
              ->setCellValue('E1', 'Alamat');

        // Isi data
        $row = 2;
        $no  = 1;
        foreach ($siswa as $s) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $s->nis);
            $sheet->setCellValue('C' . $row, $s->nama);
            $sheet->setCellValue('D' . $row, $s->jk);
            $sheet->setCellValue('E' . $row, $s->alamat);
            $row++;
        }

        // Styling header
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font'      => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['style' => Border::BORDER_THIN]],
        ]);

        // Auto width
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output
        $filename = 'Daftar_Siswa_' . str_replace(' ', '_', $kelas_nama) . '.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xls($excel);
        $writer->save('php://output');
        exit();
    }
}
