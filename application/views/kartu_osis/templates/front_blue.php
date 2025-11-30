<?php
function render_front($pdf, $s)
{
    // ============================
    // LOAD FONTS
    // ============================
    $pdf->SetFont('helvetica','',9);

    // ============================
    // BACKGROUND FULL (BIRU)
    // ============================
    $pdf->SetFillColor(15, 55, 130); // biru gelap
    $pdf->Rect(0, 0, 86, 54, 'F');

    // ============================
    // HEADER PUTIH
    // ============================
    $pdf->SetFillColor(255,255,255);
    $pdf->Rect(0, 0, 86, 16, 'F');

    // Logo kiri
    if (file_exists(FCPATH.'assets/img/logobonti.png')) {
        $pdf->Image(FCPATH.'assets/img/logobonti.png', 3, 1.5, 13);
    }

    // Header text
    $pdf->SetXY(20, 3);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(66, 5, 'SMK NEGERI 1 CILIMUS', 0, 1, 'C');

    $pdf->SetFont('helvetica','',8);
    $pdf->SetX(20);
    $pdf->Cell(66, 4, 'Jl. Eyang Kyai Hasan Maolani Caracas - Cilimus', 0, 1, 'C');

    $pdf->SetFont('helvetica','B',10);
    $pdf->SetX(20);
    $pdf->Cell(66, 5, 'KARTU OSIS', 0, 1, 'C');

    // ============================
    // BACKGROUND BIODATA
    // ============================
    $pdf->SetFillColor(255,255,255);
    $pdf->Rect(2, 17, 82, 30, 'F');

    // ============================
    // FOTO
    // ============================
    $foto_path = FCPATH.'uploads/foto/'.$s->foto;
    if (!empty($s->foto) && file_exists($foto_path)) {
        $pdf->Image($foto_path, 4, 19, 18, 24);
    } else {
        $pdf->Rect(4,19,18,24,'D');
        $pdf->SetXY(4,30);
        $pdf->SetFont('helvetica','',6);
        $pdf->Cell(18,4,'No Photo',0,0,'C');
    }

    // ============================
    // BIODATA
    // ============================
    $labelX = 24;
    $valueX = 40;
    $y = 20;
    $gap = 4;

    $pdf->SetFont('helvetica','B',9);
    $pdf->SetXY($labelX, $y);
    $pdf->Cell(20,4,'Nama',0,0);
    $pdf->SetFont('helvetica','',9);
    $pdf->SetXY($valueX, $y);
    $pdf->Cell(40,4,': '.$s->nama,0,1);

    $y+=$gap;
    $pdf->SetXY($labelX, $y);
    $pdf->SetFont('helvetica','B',9);
    $pdf->Cell(20,4,'NIS',0,0);
    $pdf->SetFont('helvetica','',9);
    $pdf->SetXY($valueX, $y);
    $pdf->Cell(40,4,': '.$s->nis,0,1);

    $y+=$gap;
    $pdf->SetXY($labelX, $y);
    $pdf->SetFont('helvetica','B',9);
    $pdf->Cell(20,4,'NISN',0,0);
    $pdf->SetXY($valueX, $y);
    $pdf->SetFont('helvetica','',9);
    $pdf->Cell(40,4,': '.$s->nisn,0,1);

    $y+=$gap;
    $ttl = $s->tempat_lahir.', '.date('d-m-Y', strtotime($s->tgl_lahir));
    $pdf->SetXY($labelX, $y);
    $pdf->SetFont('helvetica','B',9);
    $pdf->Cell(20,4,'TTL',0,0);
    $pdf->SetFont('helvetica','',9);
    $pdf->SetXY($valueX, $y);
    $pdf->Cell(40,4,': '.$ttl,0,1);

    $y+=$gap;
    $pdf->SetXY($labelX, $y);
    $pdf->SetFont('helvetica','B',9);
    $pdf->Cell(20,4,'Agama',0,0);
    $pdf->SetFont('helvetica','',9);
    $pdf->SetXY($valueX, $y);
    $pdf->Cell(40,4,': '.$s->agama,0,1);

    $y+=$gap;
    $pdf->SetFont('helvetica','B',9);
    $pdf->SetXY($labelX, $y);
    $pdf->Cell(20,4,'Alamat',0,0);
    $pdf->SetFont('helvetica','',9);
    $pdf->SetXY($valueX, $y);
    $pdf->Cell(40,4,': '.$s->alamat,0,1);

    // ============================
    // FOOTER BIRU
    // ============================
    $pdf->SetFillColor(0,51,153);
    $pdf->Rect(0, 48, 86, 6, 'F');

    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('helvetica','B',8);
    $pdf->SetXY(0,48.5);
    $pdf->Cell(86,4,'BERLAKU SELAMA MENJADI SISWA DI SMK NEGERI 1 CILIMUS',0,1,'C');

    $pdf->SetTextColor(0,0,0); // reset
}
