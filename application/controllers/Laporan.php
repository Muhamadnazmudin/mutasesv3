<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->library('pdf');               // TCPDF
        $this->load->library('Spreadsheet_Lib');   // Excel
        if (!$this->session->userdata('logged_in')) {
            redirect('dashboard');
            exit;
        }
    }

    // ======================================================
    // HALAMAN LAPORAN ADMIN
    // ======================================================
    public function index()
    {
        $tahun_id = $this->session->userdata('tahun_id');
        if (!$tahun_id) {
            show_error('Tahun ajaran belum diset.');
        }

        $tahun_row = $this->db->get_where('tahun_ajaran', ['id' => $tahun_id])->row();
        $tahun_label = $tahun_row ? $tahun_row->tahun : '-';

        $kelas  = $this->input->get('kelas');
        $jenis  = $this->input->get('jenis');
        $search = $this->input->get('search');

        $data = [
            'judul'       => 'Laporan Mutasi Siswa',
            'active'      => 'laporan',
            'tahun'       => $tahun_label,
            'kelas_list'  => $this->Laporan_model->get_kelas(),
            'mutasi'      => $this->Laporan_model->get_laporan(
                                $kelas,
                                $jenis,
                                $search
                            )
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    // ======================================================
    // EXPORT PDF (TCPDF)
    // ======================================================
    public function export_pdf()
    {
        $tahun_id = $this->session->userdata('tahun_id');
        if (!$tahun_id) show_error('Tahun ajaran tidak ditemukan.');

        $tahun_row = $this->db->get_where('tahun_ajaran', ['id'=>$tahun_id])->row();
        $tahun_label = $tahun_row ? $tahun_row->tahun : '-';

        $kelas  = $this->input->get('kelas');
        $jenis  = $this->input->get('jenis');
        $search = $this->input->get('search');

        $mutasi = $this->Laporan_model->get_laporan(
            $kelas,
            $jenis,
            $search
        );
        $this->pdf->SetTitle('Laporan Mutasi Siswa '.$tahun_label);
        $this->pdf->AddPage('L');
        $html = $this->load->view('laporan/laporan_pdf', [
            'mutasi' => $mutasi,
            'tahun'  => $tahun_label
        ], true);

        $this->pdf->writeHTML($html);
        $this->pdf->Output('Laporan_Mutasi_'.$tahun_label.'.pdf', 'I');
    }

    // ======================================================
    // EXPORT EXCEL
    // ======================================================
    public function export_excel()
    {
        $tahun_id = $this->session->userdata('tahun_id');
        if (!$tahun_id) show_error('Tahun ajaran tidak ditemukan.');

        $tahun_row = $this->db->get_where('tahun_ajaran', ['id'=>$tahun_id])->row();
        $tahun_label = $tahun_row ? $tahun_row->tahun : '-';

        $kelas  = $this->input->get('kelas');
        $jenis  = $this->input->get('jenis');
        $search = $this->input->get('search');

        $data = $this->Laporan_model->get_laporan(
            $kelas,
            $jenis,
            $search
        );

        $this->spreadsheet_lib->export_laporan_mutasi($data, $tahun_label);
    }
}
