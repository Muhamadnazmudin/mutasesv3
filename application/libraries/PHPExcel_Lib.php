<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// pastikan file PHPExcel utama tersedia di third_party
require_once APPPATH . "third_party/PHPExcel/Classes/PHPExcel.php";

class PHPExcel_lib
{
    public function __construct()
    {
        // biarkan kosong, cukup load otomatis PHPExcel di atas
    }

    public function export_laporan_mutasi($data, $tahun)
    {
        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Laporan Mutasi Siswa');

        // Header kolom
        $headers = array(
            'No', 'Nama Siswa', 'NIS', 'Kelas Asal', 'Jenis', 
            'Tanggal', 'Alasan', 'Kelas Tujuan', 'Tahun Ajaran', 'Dibuat Oleh'
        );

        // Tulis header ke baris 1
        $col = 0;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $col++;
        }

        // Tulis data mulai dari baris ke-2
        $row = 2;
        $no = 1;
        foreach ($data as $m) {
            $sheet->setCellValueByColumnAndRow(0, $row, $no++);
            $sheet->setCellValueByColumnAndRow(1, $row, $m->nama_siswa);
            $sheet->setCellValueByColumnAndRow(2, $row, $m->nis);
            $sheet->setCellValueByColumnAndRow(3, $row, isset($m->kelas_asal) ? $m->kelas_asal : '-');
            $sheet->setCellValueByColumnAndRow(4, $row, ucfirst($m->jenis));
            $sheet->setCellValueByColumnAndRow(5, $row, !empty($m->tanggal) ? date('d-m-Y', strtotime($m->tanggal)) : '-');
            $sheet->setCellValueByColumnAndRow(6, $row, $m->alasan);
            $sheet->setCellValueByColumnAndRow(7, $row, isset($m->kelas_tujuan) ? $m->kelas_tujuan : '-');
            $sheet->setCellValueByColumnAndRow(8, $row, $m->tahun_ajaran);
            $sheet->setCellValueByColumnAndRow(9, $row, $m->dibuat_oleh);
            $row++;
        }

        // Styling header
        $headerStyle = array(
            'font' => array('bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        );
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        // Auto width kolom
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output ke browser (download otomatis)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_mutasi_' . $tahun . '.xls"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $writer->save('php://output');
        exit();
    }
}
