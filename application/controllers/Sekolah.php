<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_admin();

        $this->load->model('Sekolah_model');
        $this->load->library('upload');
    }

    public function index()
    {
        $data['active'] = 'Sekolah';
        $data['title']  = 'Pengaturan Sekolah';

        // SINGLE DATA
        $data['sekolah'] = $this->Sekolah_model->get_single();
        $data['total']   = $this->Sekolah_model->count_all();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sekolah/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        // BLOK jika sudah ada data
        if ($this->Sekolah_model->count_all() > 0) {
            redirect('sekolah');
        }

        $data['active'] = 'Sekolah';
        $data['title']  = 'Tambah Data Sekolah';

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sekolah/form', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        // proteksi double insert
        if ($this->Sekolah_model->count_all() > 0) {
            redirect('sekolah');
        }

        $logo = '';

        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path']   = './uploads/logo/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = 'logo_' . time();
            $config['overwrite']     = true;

            $this->upload->initialize($config);
            if ($this->upload->do_upload('logo')) {
                $logo = $this->upload->data('file_name');
            }
        }

        $data = [
            'nama_sekolah' => $this->input->post('nama_sekolah', true),
            'npsn' => $this->input->post('npsn', true),
            'alamat' => $this->input->post('alamat', true),
            'desa' => $this->input->post('desa', true),
            'kecamatan' => $this->input->post('kecamatan', true),
            'kabupaten' => $this->input->post('kabupaten', true),
            'latitude' => $this->input->post('latitude', true),
            'longitude' => $this->input->post('longitude', true),
            'logo' => $logo,
            'nama_kepala_sekolah' => $this->input->post('nama_kepala_sekolah', true),
            'nip_kepala_sekolah' => $this->input->post('nip_kepala_sekolah', true)
        ];

        $this->Sekolah_model->insert($data);
        redirect('sekolah');
    }

    public function edit($id)
    {
        $data['active'] = 'Sekolah';
        $data['title']  = 'Edit Data Sekolah';
        $data['row']    = $this->Sekolah_model->get_by_id($id);

        if (!$data['row']) {
            redirect('sekolah');
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sekolah/form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        $row = $this->Sekolah_model->get_by_id($id);
        if (!$row) {
            redirect('sekolah');
        }

        $logo = $row->logo;

        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path']   = './uploads/logo/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = 'logo_' . time();
            $config['overwrite']     = true;

            $this->upload->initialize($config);
            if ($this->upload->do_upload('logo')) {
                $logo = $this->upload->data('file_name');
            }
        }

        $data = [
            'nama_sekolah' => $this->input->post('nama_sekolah', true),
            'npsn' => $this->input->post('npsn', true),
            'alamat' => $this->input->post('alamat', true),
            'desa' => $this->input->post('desa', true),
            'kecamatan' => $this->input->post('kecamatan', true),
            'kabupaten' => $this->input->post('kabupaten', true),
            'latitude' => $this->input->post('latitude', true),
            'longitude' => $this->input->post('longitude', true),
            'logo' => $logo,
            'nama_kepala_sekolah' => $this->input->post('nama_kepala_sekolah', true),
            'nip_kepala_sekolah' => $this->input->post('nip_kepala_sekolah', true)
        ];

        $this->Sekolah_model->update($id, $data);
        redirect('sekolah');
    }

    public function hapus($id)
    {
        $row = $this->Sekolah_model->get_by_id($id);
        if ($row && $row->logo && file_exists('./uploads/logo/'.$row->logo)) {
            unlink('./uploads/logo/'.$row->logo);
        }

        $this->Sekolah_model->delete($id);
        redirect('sekolah');
    }
}
