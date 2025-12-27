<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class Guru extends CI_Controller {

    // ================== DAFTAR FIELD GURU ==================
    private $guru_fields = [
        'nip','nama','email','telp',
        'jenis_kelamin','tempat_lahir','tanggal_lahir','nama_ibu_kandung',
        'alamat_jalan','rt','rw','dusun','desa_kelurahan','kecamatan','kode_pos',
        'no_kk','nik','agama',
        'npwp','nama_wajib_pajak','kewarganegaraan',
        'status_perkawinan','nama_pasangan','nip_pasangan','pekerjaan_pasangan',
        'status_kepegawaian','nuptk','nrg',
        'sk_pengangkatan','tmt_pengangkatan','lembaga_pengangkat',
        'sk_cpns','tmt_cpns','tmt_pengangkatan_cpns',
        'pangkat_golongan','sumber_gaji',
        'kartu_pegawai','karis_karsu'
    ];

    public function __construct() {
        parent::__construct();
        $this->load->model('Guru_model');
        $this->load->library(['form_validation', 'pagination', 'Spreadsheet_Lib']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->userdata('logged_in')) {
            redirect('dashboard');
            exit;
        }
    }

    // ================== HELPER AMBIL POST ==================
    private function get_post_data()
    {
        $data = [];
        foreach ($this->guru_fields as $field) {
            $data[$field] = $this->input->post($field, TRUE);
        }
        return $data;
    }

    // ================== INDEX ==================
    public function index($offset = 0) {

        $config['base_url'] = site_url('guru/index');
        $config['total_rows'] = $this->Guru_model->count_all();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';

        $this->pagination->initialize($config);

        $data['title'] = 'Data Guru';
        $data['active'] = 'guru';
        $data['guru'] = $this->Guru_model->get_all($config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['start'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('guru/index', $data);
        $this->load->view('templates/footer');
    }

    // ================== ADD ==================
    public function add() {

        $data['title'] = 'Tambah Guru';
        $data['active'] = 'guru';

        if ($this->input->post()) {

            $this->form_validation->set_rules('nama', 'Nama', 'required|trim');

            if ($this->form_validation->run()) {
                $insert = $this->get_post_data();
                $this->Guru_model->insert($insert);
                $this->session->set_flashdata('success', 'Data guru berhasil ditambahkan');
                redirect('guru');
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('guru/add', $data);
        $this->load->view('templates/footer');
    }

    // ================== EDIT ==================
    public function edit($id) {

        $data['guru'] = $this->Guru_model->get_by_id($id);
        $data['title'] = 'Edit Guru';
        $data['active'] = 'guru';

        if ($this->input->post()) {

            $this->form_validation->set_rules('nama', 'Nama', 'required|trim');

            if ($this->form_validation->run()) {
                $update = $this->get_post_data();
                $this->Guru_model->update($id, $update);
                $this->session->set_flashdata('success', 'Data guru berhasil diperbarui');
                redirect('guru');
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('guru/edit', $data);
        $this->load->view('templates/footer');
    }

    // ================== DELETE ==================
    public function delete($id) {
        $this->Guru_model->delete($id);
        redirect('guru');
    }

    // ================== EXPORT EXCEL ==================
    public function export_excel() {

        @ob_end_clean();
        ob_start();

        $data = $this->Guru_model->get_all(10000, 0);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $col = 'A';
        $sheet->setCellValue($col++.'1', 'NO');
        foreach ($this->guru_fields as $field) {
            $sheet->setCellValue($col++.'1', strtoupper($field));
        }

        // Data
        $row = 2; $no = 1;
        foreach ($data as $g) {
            $col = 'A';
            $sheet->setCellValue($col++.$row, $no++);

            foreach ($this->guru_fields as $field) {
                $sheet->setCellValueExplicit(
                    $col++.$row,
                    $g->$field,
                    DataType::TYPE_STRING
                );
            }
            $row++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="data_guru.xls"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // ================== IMPORT EXCEL ==================
    public function import_excel()
{
    if (!empty($_FILES['file']['name'])) {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['file']['tmp_name']);
        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // ambil header + trim
        $header = array_map('trim', array_shift($sheet));

        foreach ($sheet as $row) {
            $data = [];

            foreach ($header as $col => $field) {
                // hanya kolom yg ada di DB
                if (in_array($field, $this->guru_fields)) {
                    $data[$field] = trim($row[$col]);
                }
            }

            // DEBUG: pastikan nama kebaca
            if (isset($data['nama']) && $data['nama'] !== '') {
                $this->Guru_model->insert($data);
            }
        }

        $this->session->set_flashdata('success', 'Import data guru berhasil');
    }

    redirect('guru');
}

}
