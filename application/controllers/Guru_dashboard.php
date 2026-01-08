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
    $guru_id = $this->session->userdata('guru_id');
    $hari    = $this->hari_ini();

    $this->load->model('Guru_jadwal_model');
    $this->load->model('Log_mengajar_model');

    $data['jadwal_hari_ini'] = $this->Guru_jadwal_model
        ->get_jadwal_hari_ini($guru_id, $hari);

    if (!empty($data['jadwal_hari_ini'])) {
        foreach ($data['jadwal_hari_ini'] as &$j) {
    $j->log = $this->Log_mengajar_model
        ->get_log_hari_ini($j->jadwal_id, $guru_id);
}
unset($j);

    }

    $data['hari_ini'] = $hari;
    $data['title']   = 'Dashboard Guru';
    $data['active']  = 'guru_dashboard';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar_guru', $data);
    $this->load->view('guru_dashboard/index', $data);
    $this->load->view('templates/footer');
}


  private function hari_ini()
{
    $hari = date('l');
    $map = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu'
    ];
    return $map[$hari];
}

}
