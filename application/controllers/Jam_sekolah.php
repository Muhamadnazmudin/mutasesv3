<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jam_sekolah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Jam_sekolah_model');
    }

    public function index()
    {
        $data['title']  = 'Jam Sekolah';
        $data['active'] = 'jam_sekolah';
        $data['jam']    = $this->Jam_sekolah_model->get_all();

         $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('jam_sekolah/index', $data);
    $this->load->view('templates/footer');
  }

    public function tambah()
    {
        $data['title']  = 'Tambah Jam Sekolah';
        $data['active'] = 'jam_sekolah';

         $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jam_sekolah/tambah', $data);
        $this->load->view('templates/footer');
  }
public function store()
{
    $hariInput = $this->input->post('hari', TRUE);

    $dataBase = [
        'nama_jam'    => $this->input->post('nama_jam', TRUE),
        'jam_mulai'   => $this->input->post('jam_mulai', TRUE),
        'jam_selesai' => $this->input->post('jam_selesai', TRUE),
        'jenis'       => $this->input->post('jenis', TRUE),
        'urutan'      => $this->input->post('urutan', TRUE),
        'target'      => $this->input->post('target', TRUE),
        'is_active'   => 1
    ];

    $hariValid = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

    // fungsi kecil untuk cek duplikat
    $exists = function($hari) use ($dataBase) {
        return $this->db
            ->where('hari', $hari)
            ->where('urutan', $dataBase['urutan'])
            ->where('target', $dataBase['target'])
            ->get('jam_sekolah')
            ->num_rows() > 0;
    };

    // =====================
    // SEMUA HARI
    // =====================
    if ($hariInput === 'ALL') {

        foreach ($hariValid as $hari) {

            if ($exists($hari)) {
                continue; // ⬅️ LEWATI JIKA SUDAH ADA
            }

            $data = $dataBase;
            $data['hari'] = $hari;
            $this->Jam_sekolah_model->insert($data);
        }

    }
    // =====================
    // SATU HARI
    // =====================
    elseif (in_array($hariInput, $hariValid)) {

        if (!$exists($hariInput)) {
            $dataBase['hari'] = $hariInput;
            $this->Jam_sekolah_model->insert($dataBase);
        }

    } else {
        $this->session->set_flashdata('error', 'Hari tidak valid');
        redirect('jam_sekolah/tambah');
        return;
    }

    redirect('jam_sekolah');
}

    public function delete($id)
    {
        $this->Jam_sekolah_model->delete($id);
        redirect('jam_sekolah');
    }
    public function edit($id)
{
    $data['title']  = 'Edit Jam Sekolah';
    $data['active'] = 'jam_sekolah';
    $data['jam']    = $this->db->get_where('jam_sekolah', ['id_jam' => $id])->row();

    if (!$data['jam']) {
        show_404();
    }

   $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jam_sekolah/edit', $data);
        $this->load->view('templates/footer');
  }
public function update()
{
    $id = $this->input->post('id_jam');

    $this->db->where('id_jam', $id)->update('jam_sekolah', [
        'hari'        => $this->input->post('hari', TRUE),
        'nama_jam'    => $this->input->post('nama_jam', TRUE),
        'jam_mulai'   => $this->input->post('jam_mulai', TRUE),
        'jam_selesai' => $this->input->post('jam_selesai', TRUE),
        'jenis'       => $this->input->post('jenis', TRUE),
        'urutan'      => $this->input->post('urutan', TRUE),
        'target'      => $this->input->post('target', TRUE)
    ]);

    redirect('jam_sekolah');
}

}
