<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class Nilairapor_admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Nilai_rapor_model',
            'Siswa_model',
            'Mapel_model'
        ]);
    }

    /* =========================
     * INPUT NILAI (MANUAL)
     * ========================= */
    public function index()
    {
        $data['active'] = 'nilai_input';
        $data['siswa']  = $this->Siswa_model->get_all_simple();
        $data['mapel']  = $this->Mapel_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/nilai_rapor/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        $siswa_id = $this->input->post('siswa_id');
        $mapel_id = $this->input->post('mapel_id');
        $semester = $this->input->post('semester');
        $nilai    = $this->input->post('nilai_angka');

        $this->Nilai_rapor_model->insert_or_update([
            'siswa_id'    => $siswa_id,
            'mapel_id'    => $mapel_id,
            'semester'    => $semester,
            'nilai_angka' => $nilai
        ]);

        $this->session->set_flashdata(
            'success',
            'Nilai berhasil disimpan / diperbarui'
        );
        redirect('Nilairapor_admin');
    }

    /* =========================
     * REKAP NILAI (ADMIN)
     * ========================= */
    public function rekap()
{
    $this->load->library('pagination');

    $data['active'] = 'nilai_daftar';

    $kelas_id = $this->input->get('kelas');
    $mapel_id = $this->input->get('mapel');

    $per_page = 100;
    $page     = (int) $this->input->get('page');
    if ($page < 1) $page = 1;

    $offset = ($page - 1) * $per_page;

    // TOTAL DATA (WAJIB SESUAI GROUP BY)
    $total_rows = $this->Nilai_rapor_model
        ->count_rekap_nilai($kelas_id, $mapel_id);

    // CONFIG PAGINATION (QUERY STRING AMAN)
    $config['base_url'] = site_url('Nilairapor_admin/rekap');
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['page_query_string'] = true;
    $config['query_string_segment'] = 'page';
    $config['use_page_numbers'] = true;

    // styling bootstrap
    $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close'] = '</span></li>';
    $config['attributes'] = ['class' => 'page-link'];

    $this->pagination->initialize($config);

    // DATA
    $data['kelas'] = $this->db->get('kelas')->result();
    $data['mapel'] = $this->db->get('mapel')->result();

    $data['rekap'] = $this->Nilai_rapor_model
        ->rekap_nilai_paginated($kelas_id, $mapel_id, $per_page, $offset);

    $data['pagination'] = $this->pagination->create_links();
    $data['page'] = $page;

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('admin/nilai_rapor/rekap', $data);
    $this->load->view('templates/footer');
}

    /* =========================
     * IMPORT EXCEL (LEBAR)
     * ========================= */
    public function import()
    {
        $data['active'] = 'nilai_import';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/nilai_rapor/import', $data);
        $this->load->view('templates/footer');
    }

    public function import_proses_lebar()
    {
        require FCPATH . 'vendor/autoload.php';

        $semester = $this->input->post('semester');

        if (empty($_FILES['file']['name'])) {
            redirect('Nilairapor_admin/import');
        }

        $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
        $sheetData   = $spreadsheet->getActiveSheet()->toArray();

        // Header mapel
        $header   = $sheetData[0];
        $mapelMap = [];

        foreach ($header as $index => $nama_mapel) {
            if ($index == 0) continue;

            $mapel = $this->db->get_where('mapel', [
                'nama_mapel' => trim($nama_mapel)
            ])->row();

            if ($mapel) {
                $mapelMap[$index] = $mapel->id_mapel;
            }
        }

        $berhasil = 0;

        foreach ($sheetData as $rowIndex => $row) {

            if ($rowIndex == 0) continue;

            $nisn = trim($row[0]);
            if (!$nisn) continue;

            $siswa = $this->db->get_where('siswa', [
                'nisn'   => $nisn,
                'status' => 'aktif'
            ])->row();

            if (!$siswa) continue;

            foreach ($mapelMap as $colIndex => $mapel_id) {

                $nilai = trim($row[$colIndex]);
                if ($nilai === '') continue;

                // 🔁 REPLACE (TIMPA NILAI LAMA)
                $this->Nilai_rapor_model->insert_or_update([
                    'siswa_id'    => $siswa->id,
                    'mapel_id'    => $mapel_id,
                    'semester'    => $semester,
                    'nilai_angka' => $nilai
                ]);

                $berhasil++;
            }
        }

        $this->session->set_flashdata(
            'success',
            "Import selesai. Total nilai diproses: $berhasil"
        );

        redirect('Nilairapor_admin/import');
    }

    /* =========================
     * DOWNLOAD TEMPLATE
     * ========================= */
    public function download_template_lebar()
    {
        require FCPATH . 'vendor/autoload.php';

        $mapel = $this->db->order_by('nama_mapel', 'ASC')->get('mapel')->result();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Import Nilai');

        $sheet->setCellValue('A1', 'NISN');

        $col = 'B';
        foreach ($mapel as $m) {
            $sheet->setCellValue($col.'1', $m->nama_mapel);
            $sheet->getColumnDimension($col)->setWidth(25);
            $col++;
        }

        $sheet->getStyle('A1:'.$col.'1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(18);

        $sheet->setCellValue('A2', '0083666053');
        $sheet->setCellValue('B2', '80');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_import_nilai_lebar.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
