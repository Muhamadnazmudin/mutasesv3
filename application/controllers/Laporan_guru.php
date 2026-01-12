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
 $namaBulan = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
        9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
    ];
    $this->load->helper('tanggal');

    $data = $this->Laporan_guru_model
        ->get_laporan_bulanan($guru_id, $bulan, $tahun);

    $guru = $this->db->where('id', $guru_id)->get('guru')->row();
    if (!$guru) show_error('Data guru tidak ditemukan');
    $sekolah = $this->db->get('sekolah')->row();
        // ambil mapel guru (unik)
// ambil mapel dari data laporan (unik)
$namaMapel = '-';
if (!empty($data['rekap'])) {
    $mapelUnik = [];

    foreach ($data['rekap'] as $r) {
        if (!empty($r->nama_mapel)) {
            $mapelUnik[$r->nama_mapel] = true;
        }
    }

    $namaMapel = implode(' dan ', array_keys($mapelUnik));
}

    /* ================= PDF ================= */
    $this->load->library('pdf');
    $pdf = new TCPDF('P','mm','A4',true,'UTF-8',false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(15,15,15);
    $pdf->SetAutoPageBreak(true,20);
    $pdf->AddPage();
    /* ================= COVER ================= */
$pdf->SetAutoPageBreak(false);

// ===== JUDUL ATAS =====
$pdf->SetFont('helvetica','B',16);
$pdf->Cell(
    0,
    10,
    'LAPORAN JURNAL KEGIATAN MENGAJAR GURU',
    0,
    1,
    'C'
);

$pdf->Ln(15);

// ===== LOGO =====
if (!empty($sekolah->logo) && file_exists(FCPATH.'uploads/logo/'.$sekolah->logo)) {
    $pdf->Image(
        FCPATH.'uploads/logo/'.$sekolah->logo,
        85, // tengah
        $pdf->GetY(),
        40
    );
}

$pdf->Ln(55);

// ===== NAMA SEKOLAH =====
$pdf->SetFont('helvetica','B',14);
$pdf->Cell(
    0,
    8,
    strtoupper($sekolah->nama_sekolah ?? 'NAMA SEKOLAH'),
    0,
    1,
    'C'
);

$pdf->Ln(10);

// ===== MAPEL =====
$pdf->SetFont('helvetica','',12);
$pdf->Cell(
    0,
    8,
    'Mata Pelajaran : '.$namaMapel,
    0,
    1,
    'C'
);

$pdf->Ln(8);

// ===== NAMA GURU =====
$pdf->Cell(
    0,
    8,
    'Nama Guru : '.$guru->nama,
    0,
    1,
    'C'
);

// ===== NIP =====
$pdf->Cell(
    0,
    8,
    'NIP : '.(!empty($guru->nip) ? $guru->nip : '-'),
    0,
    1,
    'C'
);

// ===== PERIODE =====
$pdf->Ln(8);
$pdf->Cell(
    0,
    8,
    'Periode : '.$namaBulan[$bulan].' '.$tahun,
    0,
    1,
    'C'
);
/* ===== INFORMASI INSTANSI (BAGIAN BAWAH COVER) ===== */

// geser ke bawah halaman
$pdf->SetY(-95);

// garis pemisah
// $pdf->SetLineWidth(0.6);
// $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(6);

// ===== INSTANSI ATAS =====
$pdf->SetFont('helvetica','',12);
$pdf->Cell(0,7,'PEMERINTAH DAERAH PROVINSI JAWA BARAT',0,1,'C');
$pdf->Cell(0,7,'DINAS PENDIDIKAN',0,1,'C');
$pdf->Cell(0,7,'CABANG DINAS PENDIDIKAN WILAYAH X',0,1,'C');

$pdf->Ln(6);

// ===== NAMA SEKOLAH =====
$pdf->SetFont('helvetica','B',14);
$pdf->Cell(
    0,
    8,
    strtoupper($sekolah->nama_sekolah ?? 'NAMA SEKOLAH'),
    0,
    1,
    'C'
);

// ===== ALAMAT & KONTAK =====
$pdf->Ln(3);
$pdf->SetFont('helvetica','',11);

$pdf->MultiCell(
    0,
    6,
    ($sekolah->alamat ?? 'Alamat sekolah')
    ."\nEmail : smkn_1cilimus@yahoo.com"
    ."\nWebsite : smkn1cilimus.sch.id"
    ."\nKab. Kuningan 45556",
    0,
    'C'
);

// ===== RESET =====
$pdf->SetAutoPageBreak(true,20);
$pdf->AddPage(); // halaman isi

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

    /* ===== HITUNG TINGGI BARIS ===== */
    $rowHeight = 8;
    foreach ($cells as $i => $txt) {
        $rowHeight = max(
            $rowHeight,
            $pdf->getStringHeight($w[$i], $txt)
        );
    }

    $x = $pdf->GetX();
    $y = $pdf->GetY();

    /* ===== GAMBAR BORDER ===== */
    foreach ($w as $i => $width) {
        $pdf->Rect($x, $y, $width, $rowHeight);
        $x += $width;
    }

    /* ===== ISI TEKS ===== */
    $x = $pdf->GetX();
    foreach ($cells as $i => $txt) {
        $pdf->MultiCell(
            $w[$i],
            $rowHeight,
            $txt,
            0,          // ⬅️ TANPA BORDER
            'L',
            false,
            0,
            $x,
            $y
        );
        $x += $w[$i];
    }

    /* ===== PINDAH BARIS ===== */
    $pdf->Ln($rowHeight);
}

 /* ================= TTD ================= */

// posisi awal
$pdf->Ln(15);

// ===== MENGETAHUI (TENGAH) =====
$pdf->SetFont('helvetica','',10);
$pdf->Cell(0,6,'Mengetahui,',0,1,'C');

$pdf->Ln(8);

// koordinat kolom
$xLeft  = 25;   // kolom kiri
$xRight = 115;  // kolom kanan
$yStart = $pdf->GetY();

// ===== JABATAN =====
$pdf->SetXY($xLeft, $yStart);
$pdf->Cell(70,6,'Kepala Sekolah',0,0,'L');

$pdf->SetXY($xRight, $yStart);
$pdf->Cell(67,6,'Guru yang bersangkutan',0,1,'R');

$pdf->Ln(20);

// ===== NAMA =====
$yName = $pdf->GetY();

$pdf->SetFont('helvetica','B',10);

$pdf->SetXY($xLeft, $yName);
$pdf->Cell(
    70,
    6,
    strtoupper($sekolah->nama_kepala_sekolah ?? '-'),
    0,
    0,
    'L'
);

$pdf->SetXY($xRight, $yName);
$pdf->Cell(
    58,
    6,
    strtoupper($guru->nama),
    0,
    1,
    'R'
);

// ===== NIP =====
$pdf->SetFont('helvetica','',10);

$pdf->SetXY($xLeft, $yName + 6);
$pdf->Cell(
    70,
    6,
    'NIP. '.(!empty($sekolah->nip_kepala_sekolah) ? $sekolah->nip_kepala_sekolah : '-'),
    0,
    0,
    'L'
);

$pdf->SetXY($xRight, $yName + 6);
$pdf->Cell(
    70,
    6,
    'NIP. '.(!empty($guru->nip) ? $guru->nip : '-'),
    0,
    1,
    'R'
);


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
