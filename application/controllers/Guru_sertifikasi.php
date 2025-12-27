<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_sertifikasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Guru_sertifikasi_model','Guru_model']);
    }

    public function index()
    {
        $data['active'] = 'guru_sertifikasi';
        $data['mode']   = 'admin';
        $data['guru']   = $this->Guru_model->get_all();
        $data['sertifikasi'] = $this->Guru_sertifikasi_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('guru/sertifikasi', $data);
        $this->load->view('templates/footer', $data);
        
        
    }

    public function store()
{
    $data = $this->input->post();

    // kalau kosong → NULL
    if (empty($data['tgl_habis_berlaku'])) {
        $data['tgl_habis_berlaku'] = null;
    }

    $this->Guru_sertifikasi_model->insert($data);

    $this->session->set_flashdata('success', 'Data sertifikasi berhasil ditambahkan');
    redirect('guru_sertifikasi');
}


    public function update($id)
{
    $data = $this->input->post();

    if (empty($data['tgl_habis_berlaku'])) {
        $data['tgl_habis_berlaku'] = null;
    }

    $this->Guru_sertifikasi_model->update($id, $data);
    $this->session->set_flashdata('success', 'Data sertifikasi berhasil diperbarui');
    redirect('guru_sertifikasi');
}


    public function delete($id)
    {
        $this->Guru_sertifikasi_model->delete($id);
        redirect('guru_sertifikasi');
    }
}

