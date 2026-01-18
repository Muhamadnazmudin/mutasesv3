<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiswaAkunBelajar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // proteksi login siswa
        if (!$this->session->userdata('siswa_id')) {
            redirect('SiswaAuth');
        }
    }

    public function index()
{
    $nisn = $this->session->userdata('siswa_nisn');

    // PROSES KLIK SUBSCRIBE (HANYA SEKALI)
    if ($this->input->post('confirm_subscribe') == '1') {

        $this->db->where('nisn', $nisn)
                 ->update('akun_belajar_siswa', [
                     'sudah_subscribe' => 1
                 ]);
    }

    // ambil data akun TERBARU
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
