<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_jjm extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // cek_login_guru(); // aktifkan kalau ada
        $this->load->model('Cek_jjm_model');
    }

    public function index()
    {
        // asumsi id guru tersimpan di session
        $guru_id = $this->session->userdata('guru_id');

        $data['title']  = 'Cek JJM';
        $data['active'] = 'cek_jjm';

        $data['jjm'] = $this->Cek_jjm_model->get_by_guru($guru_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar_guru', $data);
    $this->load->view('guru/cek_jjm', $data);
    $this->load->view('templates/footer');
    }
}
