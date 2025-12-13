<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Smalot\PdfParser\Parser;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ScrapIjazah extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'file']);
        $this->load->library('upload');
    }

    public function index()
    {
        $this->load->view('scrapijazah/upload');
    }

    public function process()
    {
        // Konfigurasi upload
        $config['upload_path']   = FCPATH . 'uploads/';
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 10240;
        $config['encrypt_name']  = TRUE;

        $this->upload->initialize($config);

        if (! $this->upload->do_upload('pdf_file')) {
            $error = $this->upload->display_errors();
            return $this->load->view('scrapijazah/upload', ['error' => $error]);
        }

        $u = $this->upload->data();
        $filepath = $u['full_path'];

        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filepath);
            $text = $pdf->getText();

            // ---------------------------------------
            //   REGEX FORMAT IJAZAH SMK (Ada Keahlian)
            // ---------------------------------------
            $pattern_smk = '/No\. Ijazah:\s*([0-9A-Za-z]+).*?'
                .'Program Keahlian:\s*(.*?)\s*'
                .'Konsentrasi Keahlian:\s*(.*?)\s*'
                .'Dengan ini menyatakan bahwa:\s*(.*?)\s*'
                .'tempat, tanggal lahir:\s*(.*?),\s*([0-9A-Za-z ]+)\s*'
                .'Nomor Induk Siswa Nasional:\s*([0-9A-Za-z]+).*?'
                .'satuan pendidikan:\s*(.*?)\s*'
                .'Nomor Pokok Sekolah Nasional:\s*([0-9A-Za-z]+)/is';

            // ---------------------------------------
            //   REGEX FORMAT IJAZAH UMUM (SMA/SMP/SD/SLB/MA/MTs)
            // ---------------------------------------
            $pattern_non_smk = '/No\. Ijazah:\s*([0-9A-Za-z]+).*?'
                .'menyatakan bahwa:\s*(.*?)\s*'
                .'tempat, tanggal lahir:\s*(.*?),\s*([0-9A-Za-z ]+)\s*'
                .'Nomor Induk Siswa Nasional:\s*([0-9A-Za-z]+).*?'
                .'satuan pendidikan:\s*(.*?)\s*'
                .'Nomor Pokok Sekolah Nasional:\s*([0-9A-Za-z]+)/is';

            $rows = [];

            // ---------------------------------------
            // 1️⃣ Coba cocokkan dulu pola SMK
            // ---------------------------------------
            if (preg_match_all($pattern_smk, $text, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $m) {
                    $rows[] = [
                        'jenis'             => 'SMK',
                        'no_ijazah'         => trim($m[1]),
                        'program_keahlian'  => trim($m[2]),
                        'konsentrasi'       => trim($m[3]),
                        'nama'              => trim($m[4]),
                        'tempat_lahir'      => trim($m[5]),
                        'tanggal_lahir'     => trim($m[6]),
                        'nisn'              => trim($m[7]),
                        'satuan_pendidikan' => trim($m[8]),
                        'npsn'              => trim($m[9]),
                    ];
                }

            // ---------------------------------------
            // 2️⃣ Jika bukan SMK → gunakan format umum (SMA/SMP/SD/SLB)
            // ---------------------------------------
            } elseif (preg_match_all($pattern_non_smk, $text, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $m) {

                    // Deteksi jenjang otomatis
                    $jenjang = 'UMUM';
                    if (stripos($text, 'SEKOLAH MENENGAH ATAS') !== false) $jenjang = 'SMA';
                    elseif (stripos($text, 'MADRASAH ALIYAH') !== false) $jenjang = 'MA';
                    elseif (stripos($text, 'SEKOLAH MENENGAH PERTAMA') !== false) $jenjang = 'SMP';
                    elseif (stripos($text, 'MADRASAH TSANAWIYAH') !== false) $jenjang = 'MTs';
                    elseif (stripos($text, 'SEKOLAH DASAR') !== false) $jenjang = 'SD';
                    elseif (stripos($text, 'MADRASAH IBTIDAIYAH') !== false) $jenjang = 'MI';
                    elseif (stripos($text, 'SEKOLAH LUAR BIASA') !== false) $jenjang = 'SLB';
                    elseif (stripos($text, 'PAKET A') !== false) $jenjang = 'Paket A';
                    elseif (stripos($text, 'PAKET B') !== false) $jenjang = 'Paket B';
                    elseif (stripos($text, 'PAKET C') !== false) $jenjang = 'Paket C';

                    $rows[] = [
                        'jenis'             => $jenjang,
                        'no_ijazah'         => trim($m[1]),
                        'program_keahlian'  => '',
                        'konsentrasi'       => '',
                        'nama'              => trim($m[2]),
                        'tempat_lahir'      => trim($m[3]),
                        'tanggal_lahir'     => trim($m[4]),
                        'nisn'              => trim($m[5]),
                        'satuan_pendidikan' => trim($m[6]),
                        'npsn'              => trim($m[7]),
                    ];
                }
            }

            // ---------------------------------------
            // Buat Excel
            // ---------------------------------------
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header kolom Excel
            // Tentukan apakah ada data SMK
$is_smk = false;
foreach ($rows as $r) {
    if ($r['jenis'] === 'SMK') {
        $is_smk = true;
        break;
    }
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Jika SMK → gunakan header lengkap
if ($is_smk) {
    $header = [
        'A1' => 'jenis',
        'B1' => 'no_ijazah',
        'C1' => 'program_keahlian',
        'D1' => 'konsentrasi',
        'E1' => 'nama',
        'F1' => 'tempat_lahir',
        'G1' => 'tanggal_lahir',
        'H1' => 'nisn',
        'I1' => 'satuan_pendidikan',
        'J1' => 'npsn',
    ];
} 
// Jika BUKAN SMK → hilangkan program & konsentrasi
else {
    $header = [
        'A1' => 'jenis',
        'B1' => 'no_ijazah',
        'C1' => 'nama',
        'D1' => 'tempat_lahir',
        'E1' => 'tanggal_lahir',
        'F1' => 'nisn',
        'G1' => 'satuan_pendidikan',
        'H1' => 'npsn',
    ];
}

// Tulis header
foreach ($header as $k => $v) {
    $sheet->setCellValue($k, $v);
}

// Isi data
$rowNum = 2;
foreach ($rows as $r) {

    if ($is_smk) {
        // FULL HEADER (untuk SMK)
        $sheet->setCellValue('A'.$rowNum, $r['jenis']);
        $sheet->setCellValueExplicit('B'.$rowNum, $r['no_ijazah'], DataType::TYPE_STRING);
        $sheet->setCellValue('C'.$rowNum, $r['program_keahlian']);
        $sheet->setCellValue('D'.$rowNum, $r['konsentrasi']);
        $sheet->setCellValue('E'.$rowNum, $r['nama']);
        $sheet->setCellValue('F'.$rowNum, $r['tempat_lahir']);
        $sheet->setCellValue('G'.$rowNum, $r['tanggal_lahir']);
        $sheet->setCellValueExplicit('H'.$rowNum, $r['nisn'], DataType::TYPE_STRING);
        $sheet->setCellValue('I'.$rowNum, $r['satuan_pendidikan']);
        $sheet->setCellValue('J'.$rowNum, $r['npsn']);
    } else {
        // HEADER SEDERHANA (untuk umum)
        $sheet->setCellValue('A'.$rowNum, $r['jenis']);
        $sheet->setCellValueExplicit('B'.$rowNum, $r['no_ijazah'], DataType::TYPE_STRING);
        $sheet->setCellValue('C'.$rowNum, $r['nama']);
        $sheet->setCellValue('D'.$rowNum, $r['tempat_lahir']);
        $sheet->setCellValue('E'.$rowNum, $r['tanggal_lahir']);
        $sheet->setCellValueExplicit('F'.$rowNum, $r['nisn'], DataType::TYPE_STRING);
        $sheet->setCellValue('G'.$rowNum, $r['satuan_pendidikan']);
        $sheet->setCellValue('H'.$rowNum, $r['npsn']);
    }

    $rowNum++;
}


            $filename = 'data_ijazah_'.date('Ymd_His').'.xlsx';
            $tmpPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.$filename;

            $writer = new Xlsx($spreadsheet);
            $writer->save($tmpPath);

            @unlink($filepath);

            // Download file Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Content-Length: ' . filesize($tmpPath));
            readfile($tmpPath);

            @unlink($tmpPath);
            exit;

        } catch (Exception $e) {
            @unlink($filepath);
            $err = 'Terjadi kesalahan: '.$e->getMessage();
            return $this->load->view('scrapijazah/upload', ['error' => $err]);
        }
    }
}
