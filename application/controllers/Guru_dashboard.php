<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_dashboard extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    if (
      !$this->session->userdata('logged_in') ||
      $this->session->userdata('role_id') != 3
    ) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $data['title'] = 'Dashboard Guru';
    $data['active'] = 'guru_dashboard';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar_guru', $data);
    $this->load->view('guru_dashboard/index', $data);
    $this->load->view('templates/footer');
  }
}
