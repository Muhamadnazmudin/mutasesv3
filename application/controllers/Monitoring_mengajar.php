<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_mengajar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role_name') !== 'admin'
        ) {
            redirect('auth/login');
        }

        $this->load->model('Monitoring_mengajar_model');
    }

    public function index()
    {
        $data['title']  = 'Monitoring Mengajar Guru';
        $data['active'] = 'monitoring_mengajar';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('monitoring_mengajar/index', $data);
        $this->load->view('templates/footer');
    }

    // dipanggil via AJAX
   public function load_data()
{
    $guru_id  = $this->input->get('guru_id');
    $kelas_id = $this->input->get('kelas_id');

    $rows = $this->Monitoring_mengajar_model
        ->get_monitoring_hari_ini($guru_id, $kelas_id);

    $data = [];

    foreach ($rows as $r) {

        if ($r->jam_mulai && !$r->jam_selesai) {
            $status = 'sedang';
        } elseif ($r->jam_selesai) {
            $status = 'selesai';
        } else {
            $status = 'belum';
        }

        $data[] = [
            'guru'   => $r->nama_guru,
            'kelas'  => $r->nama_kelas,
            'mapel'  => $r->nama_mapel,
            'jam'    => $r->nama_jam,
            'mulai'  => $r->jam_mulai
                ? date('H:i', strtotime($r->jam_mulai))
                : '-',
            'selesai'=> $r->jam_selesai
                ? date('H:i', strtotime($r->jam_selesai))
                : '-',
            'status' => $status
        ];
    }

    echo json_encode($data);
}
public function filter_data()
{
    $data['guru']  = $this->db->order_by('nama','ASC')->get('guru')->result();
    $data['kelas'] = $this->db->order_by('nama','ASC')->get('kelas')->result();

    echo json_encode($data);
}


}
