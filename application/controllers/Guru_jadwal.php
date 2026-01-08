<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_jadwal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        
        // pastikan role guru
        if ($this->session->userdata('role_name') != 'guru') {
            redirect('dashboard');
        }

        $this->load->model('Guru_jadwal_model');
    }

    public function index()
    {
        $guru_id = $this->session->userdata('guru_id'); 
        // ⬅️ ini HARUS berisi guru.id

        $data['title']  = 'Jadwal Mengajar Saya';
        $data['active'] = 'guru_jadwal';
        $data['jadwal'] = $this->Guru_jadwal_model->get_by_guru($guru_id);

        $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar_guru', $data);
    $this->load->view('guru/jadwal', $data);
    $this->load->view('templates/footer');
  }
}
