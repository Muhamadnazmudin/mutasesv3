<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AbsensiQRAdmin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        // models yang dibutuhkan (pastikan ada)
        $this->load->model('Kelas_model');
        $this->load->model('Siswa_model');
        $this->load->model('Hari_libur_model');

        // coba load pdf library (jika ada wrapper). Jika tidak, controller akan fallback ke TCPDF di third_party.
        // Jangan hapus; wrapper sering ada di project CI
        @$this->load->library('pdf');

        // PHPExcel wrapper (jika tersedia)
        @$this->load->library('PHPExcel_Lib');
    }

    // 1) Halaman list absensi QR
    public function index() {

    $data['kelas']  = $this->Kelas_model->get_all();
    $data['judul']  = "Absensi QR Siswa";
    $data['active'] = "absensiqr_siswa";

    // === AMBIL SEMUA DATA ABSENSI QR ===
    $this->db->select("
        q.id,
        q.nis,
        q.tanggal,
        q.jam_masuk,
        q.jam_pulang,
        q.status,
        q.kehadiran,
        s.nama as nama_siswa,
        k.nama as nama_kelas
    ");
    $this->db->from("absensi_qr q");
    $this->db->join("siswa s", "s.nis = q.nis", "left");
    $this->db->join("kelas k", "k.id = s.id_kelas", "left");
    $this->db->order_by("q.id", "DESC");

    $data['absen'] = $this->db->get()->result();

    // === LOAD VIEW ===
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('absensiqr/admin_index', $data);
    $this->load->view('templates/footer');
}


    // 2) Halaman laporan (form filter)
    public function laporan() {
        $data['kelas']  = $this->Kelas_model->get_all();
        $data['judul']  = "Laporan Absensi QR";
        $data['active'] = "laporan_absensiqr";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('absensiqr/admin_laporan', $data);
        $this->load->view('templates/footer');
    }

    // 3) AJAX: ambil data filtered (untuk preview tabel)
    public function data()
    {
        $nama   = $this->input->post('nama');
        $kelas  = $this->input->post('kelas');
        $dari   = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $status = $this->input->post('status');

        $this->db->select("
            q.id,
            q.nis,
            q.tanggal,
            q.jam_masuk,
            q.jam_pulang,
            q.status,
            q.kehadiran,
            s.nama as nama_siswa,
            k.nama as nama_kelas
        ");
        $this->db->from("absensi_qr q");
        $this->db->join("siswa s", "s.nis = q.nis", "left");
        $this->db->join("kelas k", "k.id = s.id_kelas", "left");

        if ($nama != "") {
            $this->db->like("s.nama", $nama);
        }

        if ($kelas != "") {
            $this->db->where("s.id_kelas", $kelas);
        }

        if ($status != "") {
            // status filter expects kehadiran code: H, S, I, A
            $this->db->where("q.kehadiran", $status);
        }

        if ($dari != "" && $sampai != "") {
            $this->db->where("q.tanggal >=", $dari);
            $this->db->where("q.tanggal <=", $sampai);
        }

        $this->db->order_by("q.tanggal", "ASC");

        echo json_encode($this->db->get()->result());
    }

    // 4) PDF export: TCPDF, kalender per kelas per bulan
    public function pdf()
{
    ob_clean();
    $kelas  = $this->input->get('kelas');
    $dari   = $this->input->get('dari');
    $sampai = $this->input->get('sampai');

    if (!$dari || !$sampai) show_error("Tanggal wajib diisi");

    $this->load->library('pdf');
    $this->pdf->setPrintHeader(false);
    $this->pdf->setPrintFooter(false);
    $this->pdf->SetMargins(5, 5, 5);
    $this->pdf->SetFont('helvetica', '', 9);

    // -----------------------------
    // Ambil daftar tanggal
    // -----------------------------
    $tanggal = [];
    $start = strtotime($dari);
    $end   = strtotime($sampai);

    while ($start <= $end) {
        $tanggal[] = date("Y-m-d", $start);
        $start = strtotime("+1 day", $start);
    }

    // -----------------------------
    // Ambil siswa per kelas
    // -----------------------------
    $siswa = $this->db->query("
        SELECT nis, nama FROM siswa
        WHERE id_kelas = ?
        ORDER BY nama ASC
    ", [$kelas])->result();

    // -----------------------------
    // Ambil data QR
    // -----------------------------
    $q = $this->db->query("
        SELECT nis, tanggal, kehadiran
        FROM absensi_qr
        WHERE tanggal BETWEEN ? AND ?
    ", [$dari, $sampai])->result();

    // bentuk index
    $rekap = [];
    foreach ($q as $r) {
        $rekap[$r->nis][$r->tanggal] = strtoupper($r->kehadiran);
    }

    // tanggal merah
    $tanggalMerah = []; // jika sudah punya tabel libur isi di sini

    $data = [
        'tanggal'      => $tanggal,
        'rekap'        => $rekap,
        'siswa'        => $siswa,
        'bulan_label'  => date("F Y", strtotime($dari)),
        'tahun'        => date("Y"),
        'kelas_nama'   => $this->db->get_where("kelas", ["id" => $kelas])->row()->nama,
        'tanggalMerah' => $tanggalMerah
    ];

    $this->pdf->AddPage('L', array(330, 210)); // F4 landscape
    $html = "<div style='font-size:8px'>" .
        $this->load->view("absensiqr/pdf_rekap_bulan", $data, true) .
        "</div>";

    $this->pdf->writeHTML($html, true, false, true, false, '');

    $this->pdf->Output("Rekap_Absensi_QR.pdf", "I");
}



    // 5) Excel export (kalender style)
    public function excel()
{
    $kelas  = $this->input->get('kelas');
    $dari   = $this->input->get('dari');
    $sampai = $this->input->get('sampai');

    if (!$dari || !$sampai) show_error("Tanggal wajib diisi");

    $this->load->library('PHPExcel_Lib');
    $excel = new PHPExcel();
    $excel->setActiveSheetIndex(0);

    // daftar tanggal
    $tanggal = [];
    $start = strtotime($dari);
    $end   = strtotime($sampai);
    while ($start <= $end) {
        $tanggal[] = date("Y-m-d", $start);
        $start = strtotime("+1 day", $start);
    }

    // siswa
    $siswa = $this->db->query("
        SELECT nis, nama FROM siswa 
        WHERE id_kelas = ? ORDER BY nama ASC
    ", [$kelas])->result();

    // absensi qr
    $q = $this->db->query("
        SELECT nis, tanggal, kehadiran 
        FROM absensi_qr
        WHERE tanggal BETWEEN ? AND ?
    ", [$dari, $sampai])->result();

    $rekap = [];
    foreach ($q as $r) {
        $rekap[$r->nis][$r->tanggal] = strtoupper($r->kehadiran);
    }

    // HEADER
    $excel->getActiveSheet()->setCellValue("A1", "Rekap Absensi QR");
    $excel->getActiveSheet()->setCellValue("A2", "Periode $dari s/d $sampai");

    $excel->getActiveSheet()->setCellValue("A4", "Nama Siswa");

    // tanggal
    $col = "B";
    foreach ($tanggal as $tgl) {
        $excel->getActiveSheet()->setCellValue($col."4", date("d", strtotime($tgl)));
        $col++;
    }

    // summary
    $excel->getActiveSheet()->setCellValue($col."4", "H"); $col++;
    $excel->getActiveSheet()->setCellValue($col."4", "S"); $col++;
    $excel->getActiveSheet()->setCellValue($col."4", "I"); $col++;
    $excel->getActiveSheet()->setCellValue($col."4", "A");

    // BODY
    $row = 5;
    foreach ($siswa as $s) {
        $excel->getActiveSheet()->setCellValue("A$row", $s->nama);

        $h = $skt = $iz = $a = 0;

        $col = "B";
        foreach ($tanggal as $tgl) {

            $hari = date("N", strtotime($tgl));
            $is_libur = ($hari == 6 || $hari == 7);

            $val = $is_libur ? "L" : "A";

            if (isset($rekap[$s->nis][$tgl])) {
                $val = $rekap[$s->nis][$tgl];
            }

            if ($val == "H") $h++;
            if ($val == "S") $skt++;
            if ($val == "I") $iz++;
            if ($val == "A") $a++;

            $excel->getActiveSheet()->setCellValue($col.$row, $val);
            $col++;
        }

        // summary
        $excel->getActiveSheet()->setCellValue($col.$row, $h); $col++;
        $excel->getActiveSheet()->setCellValue($col.$row, $skt); $col++;
        $excel->getActiveSheet()->setCellValue($col.$row, $iz); $col++;
        $excel->getActiveSheet()->setCellValue($col.$row, $a);

        $row++;
    }

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Rekap_QR.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $writer->save('php://output');
}


    // internal helper kalau perlu (tidak wajib)
    private function _array_months_from_range($start, $end)
    {
        $months = [];
        $startDt = new DateTime($start);
        $endDt = new DateTime($end);
        for ($d = $startDt; $d <= $endDt; $d->modify('+1 month')) {
            $months[] = $d->format('Y-m');
        }
        return $months;
    }
}
