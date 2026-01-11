<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilairapor_siswa extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Nilai_rapor_model');

        // proteksi login siswa
        if (!$this->session->userdata('siswa_id')) {
            redirect('SiswaAuth');
        }
    }

   public function index()
{
    $siswa_id = $this->session->userdata('siswa_id');

    $data['active'] = 'nilai_rapor';
    $data['nilai']  = $this->Nilai_rapor_model->rekap_by_siswa_kelas($siswa_id);

    $this->load->view('siswa/layout/header', $data);
    $this->load->view('siswa/layout/sidebar', $data);
    $this->load->view('siswa/nilai_rapor/index', $data);
    $this->load->view('siswa/layout/footer');
}

}


