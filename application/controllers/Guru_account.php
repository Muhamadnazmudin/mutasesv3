<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_account extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role_id') != 3
        ) {
            redirect('auth/login');
        }

        $this->load->model('User_model');
        $this->load->library(['form_validation','upload']);
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');

        $data['user']   = $this->User_model->get_by_id($user_id);
        $data['title']  = 'Profile';
        $data['active'] = 'guru_account';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_guru', $data);
        $this->load->view('guru/account', $data);
        $this->load->view('templates/footer');
    }

    public function update_password()
    {
        $this->form_validation->set_rules('password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('guru_account');
        }

        $this->User_model->update(
            $this->session->userdata('user_id'),
            ['password' => $this->input->post('password')]
        );

        $this->session->set_flashdata('success', 'Password berhasil diperbarui.');
        redirect('guru_account');
    }

    public function upload_foto()
    {
        $config = [
            'upload_path'   => './uploads/profile/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('foto')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('guru_account');
        }

        $file = $this->upload->data();

        $this->User_model->update(
            $this->session->userdata('user_id'),
            ['foto' => $file['file_name']]
        );

        $this->session->set_flashdata('success', 'Foto profil berhasil diperbarui.');
        redirect('guru_account');
    }
}
