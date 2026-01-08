<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_mengajar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Jadwal_mengajar_model');
    }

    public function index()
    {
        $data['title']  = 'Jadwal Mengajar Guru';
        $data['active'] = 'jadwal_mengajar';
        $data['jadwal'] = $this->Jadwal_mengajar_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jadwal_mengajar/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title']   = 'Tambah Jadwal Mengajar';
        $data['active']  = 'jadwal_mengajar';
        $data['guru']    = $this->db->get('guru')->result();
        $data['kelas']   = $this->db->get('kelas')->result();
        $data['mapel']   = $this->db->get('mapel')->result();
        $data['jam']     = $this->Jadwal_mengajar_model->jam_mengajar();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jadwal_mengajar/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function store()
    {
        $guru  = $this->input->post('guru_id');
        $kelas = $this->input->post('rombel_id');
        $hari  = $this->input->post('hari');
        $jam   = $this->input->post('jam_id');

        if ($this->Jadwal_mengajar_model->bentrok_guru($guru, $hari, $jam)) {
    $this->session->set_flashdata('error', 'Guru sudah mengajar di jam tersebut.');
    redirect('jadwal_mengajar/tambah');
}

if ($this->Jadwal_mengajar_model->bentrok_kelas($kelas, $hari, $jam)) {
    $this->session->set_flashdata('error', 'Kelas sudah digunakan di jam tersebut.');
    redirect('jadwal_mengajar/tambah');
}

        $this->Jadwal_mengajar_model->insert([
            'guru_id'   => $guru,
            'rombel_id' => $kelas,
            'mapel_id'  => $this->input->post('mapel_id'),
            'jam_id'    => $jam,
            'hari'      => $hari
        ]);

        redirect('jadwal_mengajar');
    }
}
