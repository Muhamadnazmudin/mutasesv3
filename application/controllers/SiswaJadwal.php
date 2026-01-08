<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiswaJadwal extends CI_Controller {

    public function __construct()
{
    parent::__construct();
    $this->load->library('session');
    $this->load->database();
    $this->load->model('Siswa_jadwal_model');

    if (!$this->session->userdata('siswa_login')) {
        redirect('SiswaAuth');
    }
}


    public function index()
    
    {
        $kelas_id = $this->session->userdata('kelas_id');
        $data['title']  = 'Jadwal Pelajaran';
        $data['active'] = 'jadwal';

        $data['jadwal'] = $this->Siswa_jadwal_model
            ->get_by_kelas($kelas_id);

        $this->load->view('siswa/layout/header', $data);
        $this->load->view('siswa/layout/sidebar', $data);
        $this->load->view('siswa/jadwal/index', $data);
        $this->load->view('siswa/layout/footer');
    }
}
