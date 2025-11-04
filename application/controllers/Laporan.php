<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Laporan_model');
    $this->load->library('pdf'); // pastikan sudah punya library PDF
    $this->load->library('PHPExcel_lib'); // untuk export Excel
  }

  public function index() {
    $tahun_aktif = date('Y');
    $kelas = $this->input->get('kelas');
    $jenis = $this->input->get('jenis');
    $search = $this->input->get('search');

    $data['judul'] = 'Laporan Mutasi Siswa';
    $data['active'] = 'laporan'; // ✅ Tambahkan baris ini
    $data['tahun'] = $tahun_aktif;
    $data['kelas_list'] = $this->Laporan_model->get_kelas();
    $data['mutasi'] = $this->Laporan_model->get_laporan($tahun_aktif, $kelas, $jenis, $search);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('laporan/index', $data);
    $this->load->view('templates/footer');
}


  // ==========================================================
// 🔹 EXPORT PDF LAPORAN MUTASI (PAKAI TCPDF, PHP 5.6)
// ==========================================================
public function export_pdf()
{
    $tahun_id = $this->session->userdata('tahun_id');

    // 🔹 Ambil tahun aktif
    $tahun_row = $this->db->get_where('tahun_ajaran', ['id' => $tahun_id])->row();
    $tahun = isset($tahun_row->tahun) ? $tahun_row->tahun : date('Y');

    // 🔹 Ambil filter dari GET
    $kelas = $this->input->get('kelas');
    $jenis = $this->input->get('jenis');
    $search = $this->input->get('search');

    // 🔹 Ambil data mutasi
    $this->db->from('v_mutasi_detail');
    $this->db->where('tahun_ajaran', $tahun);

    if (!empty($kelas)) {
        $this->db->where('id_kelas', $kelas);
    }
    if (!empty($jenis)) {
        $this->db->where('jenis', strtolower($jenis));
    }
    if (!empty($search)) {
        $this->db->like('nama_siswa', $search);
    }

    $mutasi = $this->db->order_by('tanggal', 'DESC')->get()->result();

    // ======================================================
    // 🔹 Inisialisasi PDF
    // ======================================================
    $this->load->library('tcpdf');
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Mutases');
    $pdf->SetTitle('Laporan Mutasi Siswa Tahun ' . $tahun);
    $pdf->SetMargins(6, 8, 6);
    $pdf->AddPage('L');
    $pdf->SetFont('helvetica', '', 10);

    // ======================================================
    // 🔹 Header Dokumen
    // ======================================================
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 8, 'LAPORAN MUTASI SISWA TAHUN ' . $tahun, 0, 1, 'C');
    $pdf->Ln(3);

    // ======================================================
    // 🔹 Header Tabel
    // ======================================================
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);

    // Lebar kolom (total 297mm untuk A4 landscape)
    $widths = [10, 40, 20, 25, 18, 25, 40, 30, 25, 30];
    $headers = [
        'No', 'Nama Siswa', 'NIS', 'Kelas Asal', 'Jenis',
        'Tanggal', 'Alasan', 'Sekolah Tujuan', 'Tahun Ajaran', 'Dibuat Oleh'
    ];

    foreach ($headers as $i => $header) {
        $pdf->MultiCell($widths[$i], 10, $header, 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
    }
    $pdf->Ln();

    // ======================================================
    // 🔹 Isi Data
    // ======================================================
    $pdf->SetFont('helvetica', '', 9.5);
    $no = 1;

    if (!empty($mutasi)) {
        foreach ($mutasi as $m) {
            $row = [
                $no++,
                $m->nama_siswa,
                $m->nis,
                isset($m->kelas_asal) ? $m->kelas_asal : '-',
                ucfirst($m->jenis),
                date('d-m-Y', strtotime($m->tanggal)),
                $m->alasan,
                isset($m->kelas_tujuan) ? $m->kelas_tujuan : '-',
                $m->tahun_ajaran,
                $m->dibuat_oleh
            ];

            foreach ($row as $i => $cell) {
                $align = in_array($i, [0, 2, 4, 5, 8]) ? 'C' : 'L';
                $pdf->MultiCell($widths[$i], 8, $cell ?: '-', 1, $align, false, 0, '', '', true, 0, false, true, 8, 'M');
            }
            $pdf->Ln();
        }
    } else {
        $pdf->Cell(array_sum($widths), 10, 'Tidak ada data mutasi ditemukan.', 1, 1, 'C');
    }

    // ======================================================
    // 🔹 Footer
    // ======================================================
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'I', 9);
    $pdf->Cell(0, 7, 'Dicetak pada: ' . date('d/m/Y H:i') . ' | Sistem Mutasi Siswa', 0, 1, 'R');

    // ======================================================
    // 🔹 Output
    // ======================================================
    $pdf->Output('Laporan_Mutasi_' . $tahun . '.pdf', 'I');
}


public function export_excel()
{
    $tahun = $this->input->get('tahun');
    if (empty($tahun)) {
        $tahun = date('Y');
    }

    $kelas = $this->input->get('kelas');
    $jenis = $this->input->get('jenis');
    $search = $this->input->get('search');

    $data = $this->Laporan_model->get_laporan($tahun, $kelas, $jenis, $search);
    $this->load->library('PHPExcel_lib');
    $this->phpexcel_lib->export_laporan_mutasi($data, $tahun);
}



}
