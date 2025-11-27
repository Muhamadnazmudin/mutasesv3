<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfid extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    // halaman register kartu
    public function register()
    {
        $data['siswa'] = $this->db->order_by('nama','asc')->get('siswa')->result();
        $this->load->view('rfid/register', $data);
    }

    // simpan UID ke siswa
    public function save()
    {
        $uid = $this->input->post('uid', TRUE);
        $id_siswa = $this->input->post('id_siswa', TRUE);

        if (!$uid || !$id_siswa) {
            show_error("Data tidak valid.");
        }

        // simpan
        $this->db->where('id', $id_siswa)
                 ->update('siswa', ['rfid_uid' => $uid]);

        $this->session->set_flashdata('success', 'Kartu RFID berhasil ditautkan.');
        redirect('rfid/register');
    }
}
