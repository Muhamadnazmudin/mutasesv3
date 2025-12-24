<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HasilVerval extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // role wali kelas (3)
        if ($this->session->userdata('role_id') != 3) {
            show_error('Akses ditolak', 403);
        }

        $this->load->model('Vervalpd_model');
    }

    public function index()
{
    $data['title']  = 'Hasil Verval PD';
    $data['active'] = 'wk_vervalpd';

    $kelas_id = $this->session->userdata('kelas_id');

    // REKAP
    $data['laporan'] = $this->Vervalpd_model->laporan_walikelas($kelas_id);

    // LIST SISWA
    $data['siswa'] = $this->Vervalpd_model->siswa_walikelas($kelas_id);

    $this->load->view('walikelas/templates/header', $data);
    $this->load->view('walikelas/templates/sidebar', $data);
    $this->load->view('walikelas/hasil_verval/index', $data);
    $this->load->view('walikelas/templates/footer');
}
public function export_excel()
{
    $kelas_id   = $this->session->userdata('kelas_id');
    $kelas_nama = $this->session->userdata('kelas_nama');

    $siswa = $this->Vervalpd_model->siswa_walikelas($kelas_id);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Hasil Verval');

    // HEADER
    $sheet->setCellValue('A1', 'Kelas');
    $sheet->setCellValue('B1', $kelas_nama);

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'NISN');
    $sheet->setCellValue('C3', 'Nama');
    $sheet->setCellValue('D3', 'Status');
    $sheet->setCellValue('E3', 'Catatan');

    $sheet->getStyle('A3:E3')->getFont()->setBold(true);

    // DATA
    $row = 4;
    $no  = 1;
    foreach ($siswa as $s) {

        if ($s->status_verval == 1) {
            $status = 'Valid';
        } elseif ($s->status_verval == 2) {
            $status = 'Perbaikan';
        } else {
            $status = 'Belum';
        }

        $sheet->setCellValue("A{$row}", $no++);
        $sheet->setCellValue("B{$row}", $s->nisn);
        $sheet->setCellValue("C{$row}", $s->nama);
        $sheet->setCellValue("D{$row}", $status);
        $sheet->setCellValue("E{$row}", $s->catatan_verval);
        $row++;
    }

    foreach (range('A','E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'Hasil_Verval_'.$kelas_nama.'.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"{$filename}\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
public function export_pdf()
{
    $kelas_id   = $this->session->userdata('kelas_id');
    $kelas_nama = $this->session->userdata('kelas_nama');

    $data['kelas_nama'] = $kelas_nama;
    $data['siswa']      = $this->Vervalpd_model->siswa_walikelas($kelas_id);

    // render view ke HTML
    $html = $this->load->view(
        'walikelas/hasil_verval/cetakpdf',
        $data,
        true
    );

    // panggil library TCPDF
    $this->load->library('pdf');

    // generate PDF
    $filename = 'Hasil_Verval_' . preg_replace('/\s+/', '_', $kelas_nama);

    $this->pdf->createPDF($html, $filename);
}

}
