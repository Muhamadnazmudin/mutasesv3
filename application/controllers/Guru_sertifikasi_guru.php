<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_sertifikasi_guru extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Guru_sertifikasi_model');
    }

    public function index()
    {
        $guru_id = $this->session->userdata('guru_id');

        $data['active'] = 'guru_sertifikasi';
        $data['mode']   = 'guru';
        $data['sertifikasi'] =
            $this->Guru_sertifikasi_model->get_by_guru($guru_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_guru', $data);
        $this->load->view('guru/sertifikasi', $data);
        $this->load->view('templates/footer', $data);
    }

    public function update($id)
    {
        $guru_id = $this->session->userdata('guru_id');

        // keamanan: pastikan data milik guru ini
        if (!$this->Guru_sertifikasi_model->owned_by($id, $guru_id)) {
            show_error('Akses ditolak', 403);
        }

        $this->Guru_sertifikasi_model->update($id, $this->input->post());
        $this->session->set_flashdata('success', 'Data berhasil diubah');
        redirect('guru_sertifikasi_guru');
    }

    public function delete($id)
    {
        $guru_id = $this->session->userdata('guru_id');

        if (!$this->Guru_sertifikasi_model->owned_by($id, $guru_id)) {
            show_error('Akses ditolak', 403);
        }

        $this->Guru_sertifikasi_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('guru_sertifikasi_guru');
    }
}
