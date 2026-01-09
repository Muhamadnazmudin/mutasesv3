<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_mengajar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Jadwal_mengajar_model');
         if (!$this->session->userdata('logged_in')) {
            redirect('dashboard');
            exit;
        }
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
    $jamAwal  = (int)$this->input->post('jam_mulai_id');
    $jamAkhir = (int)$this->input->post('jam_selesai_id');

    if (!$jamAwal || !$jamAkhir || $jamAkhir < $jamAwal) {
        $this->session->set_flashdata('error', 'Jam awal & akhir tidak valid');
        redirect('jadwal_mengajar/tambah');
        return;
    }

    $data = [
        'guru_id'        => $this->input->post('guru_id'),
        'rombel_id'      => $this->input->post('rombel_id'),
        'mapel_id'       => $this->input->post('mapel_id'),
        'hari'           => $this->input->post('hari'),
        'jam_mulai_id'   => $jamAwal,
        'jam_selesai_id' => $jamAkhir,
    ];

    $this->db->insert('jadwal_mengajar', $data);

    redirect('jadwal_mengajar');
}

    public function get_jam_by_hari()
{
    $hari = $this->input->get('hari', TRUE);

    if (!$hari) {
        echo json_encode([]);
        return;
    }

    $jam = $this->db
        ->where('hari', $hari)
        ->where('is_active', 1)
        ->order_by('urutan', 'ASC')
        ->get('jam_sekolah')
        ->result();

    echo json_encode($jam);
}

}
