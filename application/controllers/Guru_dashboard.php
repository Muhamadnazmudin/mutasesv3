<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_dashboard extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('tanggal');
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

    // ===============================
    // 1️⃣ LOAD MODEL YANG DIPERLUKAN
    // ===============================
    $this->load->model('Hari_libur_model');
    $this->load->model('Guru_jadwal_model');
    $this->load->model('Log_mengajar_model');

    // ===============================
    // 2️⃣ CEK HARI LIBUR HARI INI
    // ===============================
    $libur = $this->Hari_libur_model->get_libur_hari_ini();

   
    if ($libur && empty($libur->jam_mulai)) {

        $data = [
            'is_libur'   => true,
            'libur_half' => false,
            'nama_libur' => $libur->nama,
            'title'      => 'Dashboard Guru',
            'active'     => 'guru_dashboard'
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_guru', $data);
        $this->load->view('guru_dashboard/index', $data);
        $this->load->view('templates/footer');
        return; 
    }

    // ===============================
    // 3️⃣ AMBIL JADWAL GURU HARI INI
    // ===============================
    $hari = $this->hari_ini();

    $jadwal = $this->Guru_jadwal_model
        ->get_jadwal_hari_ini($guru_id, $hari);

    // ===============================
    // 4️⃣ PROSES TIAP JADWAL
    // ===============================
    if (!empty($jadwal)) {
        foreach ($jadwal as &$j) {

            // default: bukan libur
            $j->is_libur = false;

            // 🟠 LIBUR SETENGAH HARI
            if ($libur && !empty($libur->jam_mulai)) {
                if (strtotime($j->jam_mulai) >= strtotime($libur->jam_mulai)) {
                    $j->is_libur = true;
                }
            }

            // ambil log HANYA kalau bukan libur
            if (!$j->is_libur) {
                $j->log = $this->Log_mengajar_model
                    ->get_log_hari_ini($j->jadwal_id, $guru_id);
            } else {
                $j->log = null;
            }
        }
        unset($j);
    }

    // ===============================
    // 5️⃣ KIRIM KE VIEW
    // ===============================
    $data = [
        'is_libur'        => false,
        'libur_half'      => ($libur && !empty($libur->jam_mulai)),
        'jam_libur'       => $libur->jam_mulai ?? null,
        'nama_libur'      => $libur->nama ?? null,
        'hari_ini'        => $hari,
        'jadwal_hari_ini' => $jadwal,
        'title'           => 'Dashboard Guru',
        'active'          => 'guru_dashboard'
    ];

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
