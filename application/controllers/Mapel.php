<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
class Mapel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // asumsi sudah ada
        $this->load->model('Mapel_model');
    }

    public function index()
    {
        $data['title']  = 'Mata Pelajaran';
        $data['active'] = 'mapel';
        $data['mapel']  = $this->Mapel_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('mapel/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title']  = 'Tambah Mata Pelajaran';
        $data['active'] = 'mapel';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('mapel/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function store()
    {
        $this->Mapel_model->insert([
            'id_mapel'   => $this->input->post('id_mapel', TRUE),
            'nama_mapel' => $this->input->post('nama_mapel', TRUE),
            'kelompok'   => $this->input->post('kelompok', TRUE),
            'is_active'  => 1
        ]);

        redirect('mapel');
    }
    public function import()
{
    $data['title']  = 'Import Mata Pelajaran';
    $data['active'] = 'mapel';

    $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('mapel/import', $data);
        $this->load->view('templates/footer');
}
public function import_excel()
{
    if (empty($_FILES['file_excel']['name'])) {
        redirect('mapel/import');
    }

    $file = $_FILES['file_excel']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $sheetData   = $spreadsheet->getActiveSheet()->toArray();

    // mulai dari baris ke-2 (anggap baris 1 header)
    for ($i = 1; $i < count($sheetData); $i++) {

        $id_mapel   = trim($sheetData[$i][0]);
        $nama_mapel = trim($sheetData[$i][1]);
        $kelompok   = trim($sheetData[$i][2]);

        if ($id_mapel == '' || $nama_mapel == '') {
            continue;
        }

        // cek duplicate ID atau nama
        $exists = $this->db
            ->where('id_mapel', $id_mapel)
            ->or_where('nama_mapel', $nama_mapel)
            ->get('mapel')
            ->num_rows();

        if ($exists > 0) {
            continue; // skip jika sudah ada
        }

        $this->Mapel_model->insert([
            'id_mapel'   => $id_mapel,
            'nama_mapel' => $nama_mapel,
            'kelompok'   => $kelompok ?: NULL,
            'is_active'  => 1
        ]);
    }

    redirect('mapel');
}
public function export_excel()
{
    $mapel = $this->Mapel_model->get_all();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Judul Kolom
    $sheet->setCellValue('A1', 'ID MAPEL');
    $sheet->setCellValue('B1', 'NAMA MAPEL');
    $sheet->setCellValue('C1', 'KELOMPOK');
    $sheet->setCellValue('D1', 'STATUS');

    // Styling Header (simple)
    $sheet->getStyle('A1:D1')->getFont()->setBold(true);

    // Isi Data
    $row = 2;
    foreach ($mapel as $m) {
        $sheet->setCellValue('A' . $row, $m->id_mapel);
        $sheet->setCellValue('B' . $row, $m->nama_mapel);
        $sheet->setCellValue('C' . $row, $m->kelompok ?: '-');
        $sheet->setCellValue('D' . $row, $m->is_active ? 'Aktif' : 'Nonaktif');
        $row++;
    }

    // Auto width
    foreach (range('A', 'D') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Nama File
    $filename = 'Data_Mapel_' . date('Ymd_His') . '.xlsx';

    // Header Download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
}
