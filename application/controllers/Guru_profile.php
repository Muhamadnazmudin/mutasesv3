<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role_id') != 3
        ) {
            redirect('auth/login');
        }

        // 🔥 TAMBAHKAN INI
        $this->load->model(['Guru_model','User_model']);
    }

    public function index()
    {
        $guru_id = $this->session->userdata('guru_id');
        $user_id = $this->session->userdata('user_id');

        // 🔥 INI KUNCI UTAMA
        $data['guru'] = $this->Guru_model->get_by_id($guru_id);
        $data['user'] = $this->User_model->get_by_id($user_id);

        $data['title']  = 'Data Guru';
        $data['active'] = 'guru_profile';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_guru', $data);
        $this->load->view('guru/profile', $data);
        $this->load->view('templates/footer');
    }
}
