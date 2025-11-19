<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AbsensiQR_Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('AbsensiQR_model', 'qr');
        $this->load->model('Kelas_model');
        $this->load->model('Siswa_model');
    }

    public function index()
    {
        $data['judul']  = 'Laporan Absensi QR Siswa';
        $data['active'] = 'laporan_absensi_qr';
        $data['kelas']  = $this->Kelas_model->get_all();
        $data['hasil']  = [];

        // proses filter
        if ($this->input->post('submit') == 'tampil') {

            $kelas  = $this->input->post('kelas');
            $dari   = $this->input->post('dari');
            $sampai = $this->input->post('sampai');

            $data['hasil'] = $this->qr->filter_laporan($kelas, $dari, $sampai);

            $data['periode'] = $dari . " s/d " . $sampai;
        }

        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('absensiqr/admin_laporan', $data);
        $this->load->view('templates/footer');
    }
}
