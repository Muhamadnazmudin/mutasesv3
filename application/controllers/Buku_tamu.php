<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_tamu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Buku_tamu_model');
        $this->load->library('upload');
    }

    /* =====================================================
       FORM BUKU TAMU (PUBLIC)
       ===================================================== */
    public function tambah()
{
    if ($this->input->post()) {

        // ===============================
        // SIMPAN SELFIE DARI BASE64
        // ===============================
        $foto_selfie = null;
        $selfie_base64 = $this->input->post('selfie_base64');

        if ($selfie_base64) {

            $selfie_base64 = preg_replace(
                '#^data:image/\w+;base64,#i',
                '',
                $selfie_base64
            );

            $selfie_data = base64_decode($selfie_base64);

            if ($selfie_data !== false) {
                $filename = 'selfie_' . time() . '_' . rand(1000,9999) . '.jpg';
                $path = FCPATH . 'uploads/buku_tamu/selfie/' . $filename;

                file_put_contents($path, $selfie_data);
                $foto_selfie = $filename;
            }
        }

        // ===============================
        // SIMPAN DATA KE DATABASE
        // ===============================
        $data = [
            'tanggal'        => date('Y-m-d H:i:s'),
            'nama_tamu'      => $this->input->post('nama_tamu', TRUE),
            'instansi'       => $this->input->post('instansi', TRUE),
            'jumlah_orang'   => (int) $this->input->post('jumlah_orang'),
            'alamat'         => $this->input->post('alamat', TRUE),
            'no_hp'          => $this->input->post('no_hp', TRUE),
            'tujuan'         => $this->input->post('tujuan', TRUE),
            'keperluan'      => $this->input->post('keperluan', TRUE),
            'bertemu_dengan' => $this->input->post('bertemu_dengan', TRUE),
            'foto_selfie'    => $foto_selfie,
            'foto_identitas' => $this->_upload_foto('foto_identitas', 'identitas'),
            'status'         => 0
        ];

        $this->Buku_tamu_model->insert($data);

        $this->session->set_flashdata(
            'success',
            'Data buku tamu berhasil disimpan.'
        );

        // ===============================
        // REDIRECT SESUAI AKSES
        // ===============================
        if ($this->session->userdata('role_name') === 'admin') {
            // ADMIN input manual
            redirect('buku_tamu');
        } else {
            // TAMU PUBLIC
            redirect('buku_tamu/daftar_hari_ini');
        }
    }

    // jika GET (public buka form)
    $this->load->view('buku_tamu/tambah');
}


    /* =====================================================
       ADMIN AREA
       ===================================================== */
    public function index()
    {
        $this->_cek_admin();

        $data = [
            'active' => 'buku_tamu',
            'list'   => $this->Buku_tamu_model->get_all()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('buku_tamu/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id)
    {
        $this->_cek_admin();

        if ($this->input->post()) {

            $update = [
                'nama_tamu'      => $this->input->post('nama_tamu', TRUE),
                'instansi'       => $this->input->post('instansi', TRUE),
                'jumlah_orang'   => (int) $this->input->post('jumlah_orang'),
                'alamat'         => $this->input->post('alamat', TRUE),
                'no_hp'          => $this->input->post('no_hp', TRUE),
                'tujuan'         => $this->input->post('tujuan', TRUE),
                'keperluan'      => $this->input->post('keperluan', TRUE),
                'bertemu_dengan' => $this->input->post('bertemu_dengan', TRUE),
            ];

            $this->Buku_tamu_model->update($id, $update);
            redirect('buku_tamu');
        }

        $data = [
            'active' => 'buku_tamu',
            'row'    => $this->Buku_tamu_model->get_by_id($id)
        ];

        $this->load->view('buku_tamu/edit_modal', $data);
    }

    public function hapus($id)
    {
        $this->_cek_admin();
        $this->Buku_tamu_model->delete($id);
        redirect('buku_tamu');
    }

    /* =====================================================
       PRIVATE FUNCTIONS
       ===================================================== */

    private function _cek_admin()
    {
        if ($this->session->userdata('role_name') !== 'admin') {
            redirect('dashboard');
            exit;
        }
    }

    private function _upload_foto($field, $folder)
    {
        if (empty($_FILES[$field]['name'])) {
            return null;
        }

        $config = [
            'upload_path'   => './uploads/buku_tamu/' . $folder . '/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field)) {
            return $this->upload->data('file_name');
        }

        // debug hurungken mun gagal
        // log_message('error', $this->upload->display_errors());

        return null;
    }
    public function export_pdf()
{
    $this->_cek_admin();

    $data['list'] = $this->Buku_tamu_model->get_all();

    $this->load->library('pdf'); // TCPDF
    $this->pdf->SetTitle('Laporan Buku Tamu');
    $this->pdf->AddPage('P', 'A4');
    $this->pdf->SetFont('helvetica', '', 9);

    $html = $this->load->view('buku_tamu/export_pdf', $data, TRUE);

    $this->pdf->writeHTML($html, true, false, true, false, '');
    $this->pdf->Output('buku_tamu.pdf', 'I');
}
public function export_excel()
{
    $this->_cek_admin();

    $list = $this->Buku_tamu_model->get_all();

    $this->load->library('Spreadsheet_Lib');
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $header = [
        'No','Tanggal','Nama','Instansi','Jumlah Orang','No HP',
        'Tujuan','Keperluan','Bertemu Dengan'
    ];

    $col = 'A';
    foreach ($header as $h) {
        $sheet->setCellValue($col.'1', $h);
        $col++;
    }

    // Data
    $row = 2;
    $no = 1;
    foreach ($list as $r) {
        $sheet->setCellValue('A'.$row, $no++);
        $sheet->setCellValue('B'.$row, $r->tanggal);
        $sheet->setCellValue('C'.$row, $r->nama_tamu);
        $sheet->setCellValue('D'.$row, $r->instansi);
        $sheet->setCellValue('E'.$row, $r->jumlah_orang);
        $sheet->setCellValue('F'.$row, $r->no_hp);
        $sheet->setCellValue('G'.$row, $r->tujuan);
        $sheet->setCellValue('H'.$row, $r->keperluan);
        $sheet->setCellValue('I'.$row, $r->bertemu_dengan);
        $row++;
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="buku_tamu.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}

public function daftar_hari_ini($offset = 0)
{
    $limit = 10;
    $this->load->library('pagination');

    // hitung hari ini
    $total = $this->Buku_tamu_model->count_hari_ini();

    $config['base_url']   = site_url('buku_tamu/daftar_hari_ini');
    $config['total_rows'] = $total;
    $config['per_page']   = $limit;
    $config['uri_segment']= 3;

    // style pagination
    $config['full_tag_open']  = '<ul class="pagination justify-content-center mb-0">';
    $config['full_tag_close'] = '</ul>';
    $config['cur_tag_open']   = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']  = '</span></li>';
    $config['num_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']  = '</span></li>';
    $config['prev_link']      = '&laquo;';
    $config['next_link']      = '&raquo;';

    $this->pagination->initialize($config);

    $data['list']       = $this->Buku_tamu_model->get_hari_ini($limit, $offset);
    $data['pagination'] = $this->pagination->create_links();
    $data['start']      = $offset;

    // 🔥 WAJIB load view INI
    $this->load->view('buku_tamu/daftar_hari_ini', $data);
}


public function daftar_bulan_ini($offset = 0)
{
    $this->load->library('pagination');

    $limit = 10;

    // hitung total
    $this->db->where('MONTH(tanggal)', date('m'));
    $this->db->where('YEAR(tanggal)', date('Y'));
    $total = $this->db->count_all_results('buku_tamu');

    // config pagination
    $config['base_url']    = site_url('buku_tamu/daftar_bulan_ini');
    $config['total_rows']  = $total;
    $config['per_page']    = $limit;
    $config['uri_segment'] = 3;

    $config['full_tag_open']  = '<ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']  = '</span></li>';
    $config['cur_tag_open']   = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']  = '</span></li>';
    $config['next_link']      = '&raquo;';
    $config['prev_link']      = '&laquo;';

    $this->pagination->initialize($config);

    // ambil data
    $this->db->where('MONTH(tanggal)', date('m'));
    $this->db->where('YEAR(tanggal)', date('Y'));
    $this->db->order_by('tanggal', 'DESC');
    $data['list'] = $this->db->get('buku_tamu', $limit, $offset)->result();

    $data['pagination'] = $this->pagination->create_links();
    $data['start']      = $offset;
    $data['title']      = 'Daftar Tamu Bulan Ini';

    $this->load->view('buku_tamu/daftar_bulan_ini', $data);
}

public function set_selesai($id)
{
    // hanya admin
    if ($this->session->userdata('role_name') !== 'admin') {
        redirect('dashboard');
        exit;
    }

    $this->Buku_tamu_model->update($id, [
        'status' => 1
    ]);

    $this->session->set_flashdata(
        'success',
        'Status kunjungan ditandai selesai.'
    );

    redirect('buku_tamu');
}

}
