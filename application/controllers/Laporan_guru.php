<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        if ($this->session->userdata('role_id') != 3) {
            redirect('dashboard');
        }

        // helper wajib
        $this->load->helper('tanggal');
        $this->load->model('Laporan_guru_model');
    }

    public function index()
    {
        $data['title']  = 'Laporan Mengajar';
        $data['active'] = 'laporan_guru';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_guru', $data);
        $this->load->view('laporan_guru/index', $data);
        $this->load->view('templates/footer');
    }
private function hari_indo($hari)
{
    $map = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu',
    ];

    return $map[$hari] ?? $hari;
}

    public function export_pdf()
{
    $bulan   = (int)$this->input->get('bulan');
    $tahun   = (int)$this->input->get('tahun');
    $guru_id = $this->session->userdata('guru_id');

    $this->load->helper('tanggal');

    $data = $this->Laporan_guru_model
        ->get_laporan_bulanan($guru_id, $bulan, $tahun);

    $guru = $this->db->where('id', $guru_id)->get('guru')->row();
    if (!$guru) show_error('Data guru tidak ditemukan');

    /* ================= PDF ================= */
    $this->load->library('pdf');
    $pdf = new TCPDF('P','mm','A4',true,'UTF-8',false);
    $pdf->SetMargins(15,15,15);
    $pdf->SetAutoPageBreak(true,20);
    $pdf->AddPage();

    /* ================= JUDUL ================= */
    $pdf->SetFont('helvetica','B',13);
    $pdf->Cell(0,8,'JURNAL KEGIATAN MENGAJAR GURU',0,1,'C');

    $pdf->SetFont('helvetica','',10);
    $namaBulan = [
    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
    5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];

$pdf->Cell(
    0,6,
    'Periode : '.$namaBulan[$bulan].' '.$tahun,
    0,1,'C'
);

    $pdf->Ln(6);

    /* ================= HEADER TABEL ================= */
    $w = [10, 35, 25, 35, 30, 45];

    $pdf->SetFont('helvetica','B',9);
    $pdf->SetFillColor(230,230,230);

    $header = ['No','Hari / Tanggal','Kelas','Mapel','Jam','Materi'];
    foreach ($header as $i => $h) {
        $pdf->Cell($w[$i],8,$h,1,0,'C',true);
    }
    $pdf->Ln();

    /* ================= ISI ================= */
    $pdf->SetFont('helvetica','',9);
    $no = 1;

    foreach ($data['rekap'] as $r) {

        $hariTanggal =
    $this->hari_indo($r->hari).', '.tgl_indo_teks($r->tanggal);

        $jam =
            substr($r->jam_mulai,0,5).' – '.substr($r->jam_selesai,0,5);

        $cells = [
            $no++,
            $hariTanggal,
            $r->nama_kelas,
            $r->nama_mapel,
            $jam,
            $r->materi ?: '-'
        ];

        // hitung tinggi baris
        $h = 8;
        foreach ($cells as $i => $txt) {
            $h = max($h, $pdf->getStringHeight($w[$i], $txt));
        }

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        foreach ($cells as $i => $txt) {
            $pdf->MultiCell($w[$i], $h, $txt, 1, 'L', false, 0, $x, $y);
            $x += $w[$i];
        }

        $pdf->Ln($h);
    }

    /* ================= TTD ================= */
    $pdf->Ln(15);

    $pdf->SetFont('helvetica','',10);

    $pdf->Cell(90,6,'Mengetahui,',0,0,'C');
    $pdf->Cell(90,6,'Guru Yang Bersangkutan,',0,1,'C');

    $pdf->Ln(20);

    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(90,6,'KEPALA SEKOLAH',0,0,'C');
    $pdf->Cell(90,6,strtoupper($guru->nama),0,1,'C');

    $pdf->Ln(15);
/* ================= HALAMAN FOTO ================= */
if (!empty($data['selfie'])) {

    $pdf->AddPage();

    // Judul
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(0,8,'LAMPIRAN FOTO KEGIATAN MENGAJAR',0,1,'C');
    $pdf->Ln(6);

    // ukuran foto (LEBIH BESAR)
    $fotoWidth  = 90;   // besar foto
    $fotoGapY   = 65;   // jarak vertikal antar foto

    // posisi tengah halaman
    $pageWidth  = $pdf->getPageWidth();
    $xCenter    = ($pageWidth - $fotoWidth) / 2;
    $y          = $pdf->GetY();

    foreach ($data['selfie'] as $row) {

        $path = FCPATH.'uploads/selfie/'.$row->selfie;
        if (!file_exists($path)) continue;

        // kalau kepanjangan, buat halaman baru
        if ($y > 230) {
            $pdf->AddPage();
            $y = 30;
        }

        // FOTO (CENTER)
        $pdf->Image($path, $xCenter, $y, $fotoWidth, 0);

        // CAPTION TANGGAL
        $pdf->SetXY(15, $y + 73);
        $pdf->SetFont('helvetica','',9);
        $pdf->Cell(
            0,
            5,
            tgl_indo_teks($row->tanggal),
            0,
            1,
            'C'
        );

        $y += $fotoGapY;
    }
}

    $pdf->Output(
        'Jurnal_Mengajar_'.$bulan.'_'.$tahun.'.pdf',
        'I'
    );
    
}


}
