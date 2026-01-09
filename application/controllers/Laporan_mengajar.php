<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_mengajar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role_name') !== 'admin'
        ) {
            redirect('auth/login');
        }

        $this->load->model('Laporan_mengajar_model');
    }

    /* =======================
       INDEX
    ======================= */
    public function index()
    {
        $tanggal = $this->input->get('tanggal');
        $guru_id = $this->input->get('guru_id');

        $data['title']  = 'Laporan Mengajar Guru';
        $data['active'] = 'laporan_mengajar';

        $data['guru']   = $this->Laporan_mengajar_model->get_guru();
        $data['laporan'] = $this->Laporan_mengajar_model
            ->get_laporan($tanggal, $guru_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan_mengajar/index', $data);
        $this->load->view('templates/footer');
    }

    /* =======================
       EXPORT PDF
    ======================= */
    public function export_pdf()
    {
        ob_start(); // cegah output liar

        $tanggal = $this->input->get('tanggal');
        $guru_id = $this->input->get('guru_id');

        $laporan = $this->Laporan_mengajar_model
            ->get_laporan($tanggal, $guru_id);

        $this->load->library('pdf');

        $pdf = new TCPDF('P','mm','A4',true,'UTF-8',false);
        $pdf->SetCreator('SimSGTK');
        $pdf->SetAuthor('SimSGTK');
        $pdf->SetTitle('Laporan Mengajar Guru');
        $pdf->SetMargins(10,15,10);
        $pdf->SetAutoPageBreak(TRUE,15);
        $pdf->AddPage();

        /* ================= JUDUL ================= */
        $pdf->SetFont('helvetica','B',13);
        $pdf->Cell(0,8,'LAPORAN MENGAJAR GURU',0,1,'C');

        $pdf->Ln(2);
        $pdf->SetFont('helvetica','',10);
        $pdf->Cell(0,6,'Tanggal: '.($tanggal ?: 'Semua'),0,1,'C');
        $pdf->Ln(6);

        /* ================= HEADER TABEL ================= */
        $w = [
            'no'      => 8,
            'tgl'     => 22,
            'guru'    => 32,
            'kelas'   => 16,
            'mapel'   => 40,
            'masuk'   => 22,
            'keluar'  => 22
        ];

        $pdf->SetFont('helvetica','B',9);
        $pdf->SetFillColor(230,230,230);

        $header = ['No','Tanggal','Guru','Kelas','Mapel','Masuk','Keluar'];
        $i = 0;
        foreach ($w as $width) {
            $pdf->Cell($width,8,$header[$i++],1,0,'C',true);
        }
        $pdf->Ln();

        /* ================= ISI ================= */
        $pdf->SetFont('helvetica','',9);
        $no = 1;

        $rekapTelatMenit = [];

        foreach ($laporan as $row) {

            $tgl   = $row->tanggal ?? '-';
            $guru  = $row->nama_guru ?? '-';
            $kelas = $row->nama_kelas ?? '-';
            $mapel = $row->nama_mapel ?? '-';

            /* ===== JAM REAL ===== */
            $jamMasuk = !empty($row->jam_mulai)
                ? date('H:i', strtotime($row->jam_mulai))
                : '-';

            $jamKeluar = !empty($row->jam_selesai)
                ? date('H:i', strtotime($row->jam_selesai))
                : '-';

            /* ===== HITUNG TELAT ===== */
            $telatMenit = 0;
            $ketMasuk   = 'Tepat waktu';

            if (!empty($row->jam_mulai) && !empty($row->jam_mulai_jadwal)) {

                $jadwalMasuk = strtotime($row->tanggal.' '.$row->jam_mulai_jadwal);
                $realMasuk   = strtotime($row->jam_mulai);

                if ($realMasuk > $jadwalMasuk) {
                    $telatMenit = floor(($realMasuk - $jadwalMasuk) / 60);
                    $ketMasuk   = 'Telat '.$telatMenit.' menit';
                } else {
                    $ketMasuk = 'Tepat waktu';
                }
            }

            $rekapTelatMenit[$guru] =
                ($rekapTelatMenit[$guru] ?? 0) + $telatMenit;

            /* ===== CELL MASUK ===== */
            $cellMasuk = $jamMasuk;
            if ($jamMasuk !== '-') {
                $cellMasuk .= "\n".$ketMasuk;
            }

            /* ===== CELL KELUAR ===== */
            $cellKeluar = $jamKeluar;

            /* ===== TINGGI BARIS ===== */
            $height = max(
                $pdf->getStringHeight($w['guru'], $guru),
                $pdf->getStringHeight($w['mapel'], $mapel),
                $pdf->getStringHeight($w['masuk'], $cellMasuk)
            );

            /* ===== RENDER ===== */
            $pdf->MultiCell($w['no'], $height, $no++, 1, 'C', 0, 0);
            $pdf->MultiCell($w['tgl'], $height, $tgl, 1, 'C', 0, 0);
            $pdf->MultiCell($w['guru'], $height, $guru, 1, 'L', 0, 0);
            $pdf->MultiCell($w['kelas'], $height, $kelas, 1, 'C', 0, 0);
            $pdf->MultiCell($w['mapel'], $height, $mapel, 1, 'L', 0, 0);
            $pdf->MultiCell($w['masuk'], $height, $cellMasuk, 1, 'C', 0, 0);
            $pdf->MultiCell($w['keluar'], $height, $cellKeluar, 1, 'C', 0, 1);
        }

        /* ================= REKAP TELAT ================= */
        $pdf->Ln(8);
        $pdf->SetFont('helvetica','B',11);
        $pdf->Cell(0,8,'Rekap Keterlambatan Masuk Kelas',0,1);

        $pdf->SetFont('helvetica','B',9);
        $pdf->SetFillColor(230,230,230);
        $pdf->Cell(120,8,'Guru',1,0,'C',true);
        $pdf->Cell(40,8,'Total Telat (Menit)',1,1,'C',true);

        $pdf->SetFont('helvetica','',9);
        foreach ($rekapTelatMenit as $guru => $menit) {
            $pdf->Cell(120,8,$guru,1);
            $pdf->Cell(40,8,$menit.' menit',1,1,'C');
        }

        ob_end_clean();
        $pdf->Output('laporan_mengajar_'.date('Ymd').'.pdf','I');
    }
}
