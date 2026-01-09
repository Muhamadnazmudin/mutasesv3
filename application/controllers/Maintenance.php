<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // OPTIONAL:
        // jika ingin admin tetap bisa akses
        // if ($this->session->userdata('role') == 'admin') {
        //     redirect('dashboard');
        // }
    }

    public function index()
    {
        $data['title'] = 'Maintenance | SimSGTK';
        $this->load->view('maintenance', $data);
    }
}
