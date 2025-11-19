<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!class_exists('TCPDF')) {
    require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');
}

class Pdf_thermal extends TCPDF {

    function __construct() {

        // Lebar 80mm — Tinggi dibuat sangat panjang (2000mm)
        // TCPDF nanti akan otomatis memotong sesuai tinggi konten
        parent::__construct('P', 'mm', array(80, 130), true, 'UTF-8', false);

        $this->SetMargins(2, 2, 2);
        $this->SetAutoPageBreak(false, 0); // tidak ada auto page break
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);
        $this->SetFont('helvetica', '', 8);
    }

    function render($html, $filename = "izin") {
        $this->AddPage();

        // Buat HTML rapi di thermal
        $this->writeHTML($html, true, false, true, false, '');

        // Keluarkan PDF
        $this->Output($filename . ".pdf", "I");
    }
}
