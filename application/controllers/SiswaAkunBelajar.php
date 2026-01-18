<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiswaAkunBelajar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // pastikan login siswa
        // Proteksi login siswa
        if (!$this->session->userdata('siswa_id')) {
            redirect('SiswaAuth');
        }
    }

    public function index()
    {
        $nisn = $this->session->userdata('siswa_nisn');

        $akun = $this->db->get_where(
            'akun_belajar_siswa',
            ['nisn' => $nisn]
        )->row();

        $data = [
            'title'  => 'Akun BelajarID',
            'active' => 'akun_belajar',
            'akun'   => $akun
        ];

        $this->load->view('siswa/layout/header', $data);
    $this->load->view('siswa/layout/sidebar', $data);
    $this->load->view('siswa/akun_belajar', $data);
    $this->load->view('siswa/layout/footer');
    }
}
