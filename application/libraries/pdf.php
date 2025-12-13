<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');

class Pdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $this->SetCreator('Mutases');
        $this->SetAuthor('Admin');
        $this->SetTitle('Rekap Absensi Siswa');
        $this->SetMargins(10, 10, 10);
        $this->SetAutoPageBreak(TRUE, 10);
        $this->setCellHeightRatio(1.2);
        $this->setFontSubsetting(false);
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);
        $this->SetFont('helvetica', '', 9);
    }

    public function createPDF($html, $filename = 'laporan', $stream = true)
    {
        $this->AddPage('L');

        $this->setHtmlVSpace([
            'table' => [
                ['h' => 0, 'n' => 0],
                ['h' => 0, 'n' => 0]
            ]
        ]);

        $this->setCellPaddings(1, 1, 1, 1);
        $this->setCellMargins(0, 0, 0, 0);

        $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        if ($stream) {
            $this->Output($filename . '.pdf', 'I');
        } else {
            $this->Output(FCPATH . 'downloads/' . $filename . '.pdf', 'F');
        }
    }
}
