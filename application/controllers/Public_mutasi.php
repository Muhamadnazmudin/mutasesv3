<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
class Public_mutasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mutasi_model');
        $this->load->library('pagination');
        $this->load->helper(['url','form']);
    }

    // ==========================================================
    // 🔹 HALAMAN PUBLIK: MUTASI
    // URL : /dashboard/mutasi  atau /mutasi
    // VIEW: dashboard/mutasi_public.php
    // ==========================================================
    public function index()
    {
        // ===============================
        // FILTER INPUT (GET)
        // ===============================
        $kelas  = $this->input->get('kelas', TRUE);
        $jenis  = $this->input->get('jenis', TRUE);
        $search = $this->input->get('search', TRUE);
        $tahun  = date('Y');

        // ===============================
        // PAGINATION CONFIG
        // ===============================
        $config['base_url'] = site_url('public_mutasi/index');
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        $page   = (int) $this->input->get('page');
        $offset = ($page > 0) ? $page : 0;

        // ===============================
        // AMBIL DATA MUTASI (SATU SUMBER)
        // ===============================
        // ambil semua dulu untuk hitung total
        $all_mutasi = $this->Mutasi_model->get_public([
            'kelas'  => $kelas,
            'jenis'  => $jenis,
            'search' => $search
        ]);

        $config['total_rows'] = count($all_mutasi);

        // ===============================
        // INIT PAGINATION
        // ===============================
        $config['full_tag_open']   = '<ul class="pagination justify-content-center">';
        $config['full_tag_close']  = '</ul>';

        $config['first_link']      = '&laquo;';
        $config['first_tag_open']  = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link']       = '&raquo;';
        $config['last_tag_open']   = '<li class="page-item">';
        $config['last_tag_close']  = '</li>';

        $config['next_link']       = '&rsaquo;';
        $config['next_tag_open']   = '<li class="page-item">';
        $config['next_tag_close']  = '</li>';

        $config['prev_link']       = '&lsaquo;';
        $config['prev_tag_open']   = '<li class="page-item">';
        $config['prev_tag_close']  = '</li>';

        $config['cur_tag_open']    = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']   = '</span></li>';

        $config['num_tag_open']    = '<li class="page-item">';
        $config['num_tag_close']   = '</li>';

        $config['attributes']      = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        // ===============================
        // DATA UNTUK VIEW
        // ===============================
        $data = [
            'judul'        => 'Data Siswa Mutasi',
            'tahun'        => $tahun,
            'mutasi'       => array_slice($all_mutasi, $offset, $config['per_page']),
            'kelas_list'   => $this->Mutasi_model->get_kelas_list(),
            'pagination'   => $this->pagination->create_links()
        ];

        // ===============================
        // LOAD VIEW PUBLIC
        // ===============================
        $this->load->view('dashboard/mutasi_public', $data);
    }
    public function export_excel()
{
    // ambil data sesuai filter
    $data = $this->Mutasi_model->get_public($this->input->get());

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Data Mutasi');

    // ================= HEADER =================
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama Siswa');
    $sheet->setCellValue('C1', 'NIS');
    $sheet->setCellValue('D1', 'NISN');
    $sheet->setCellValue('E1', 'Jenis Mutasi');
    $sheet->setCellValue('F1', 'Tanggal');
    $sheet->setCellValue('G1', 'Tujuan');
    $sheet->setCellValue('H1', 'Tahun Ajaran');

    // style header
    $sheet->getStyle('A1:H1')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        'borders' => [
            'allBorders' => [
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            ]
        ]
    ]);

    // ================= DATA =================
    $row = 2;
    $no  = 1;

    foreach ($data as $m) {

        $sheet->setCellValue("A{$row}", $no++);

        $sheet->setCellValue("B{$row}", $m->nama_siswa);

        // 🔥 PENTING: PAKSA STRING (0 TIDAK HILANG)
        $sheet->setCellValueExplicit(
            "C{$row}",
            (string)$m->nis,
            DataType::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            "D{$row}",
            (string)$m->nisn,
            DataType::TYPE_STRING
        );

        $sheet->setCellValue("E{$row}", ucfirst($m->jenis));

        $sheet->setCellValue(
            "F{$row}",
            $m->tanggal ? date('d-m-Y', strtotime($m->tanggal)) : '-'
        );

        $sheet->setCellValue(
            "G{$row}",
            $m->jenis == 'keluar'
                ? ($m->tujuan_sekolah ?: '-')
                : '-'
        );

        $sheet->setCellValue("H{$row}", $m->tahun_ajaran);

        $row++;
    }

    // ================= AUTOSIZE =================
    foreach (range('A','H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // ================= OUTPUT =================
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="data_mutasi_siswa.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
public function export_pdf()
{
    $this->load->library('pdf');

    // Ambil data sesuai filter
    $data['mutasi'] = $this->Mutasi_model->get_public($this->input->get());
    $data['tahun']  = date('Y');

    // Render view jadi HTML
    $html = $this->load->view('dashboard/mutasi_pdf', $data, true);

    // TCPDF FLOW
    $this->pdf->AddPage();
    $this->pdf->writeHTML($html, true, false, true, false, '');

    // Output
    $this->pdf->Output('laporan_mutasi_siswa.pdf', 'I'); // I = tampil di browser
    exit;
}

}
