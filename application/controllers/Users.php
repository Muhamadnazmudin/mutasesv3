<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('User_model');
    $this->load->library('form_validation');
  }

  public function index() {
    $data['active'] = 'tahun';
    $data['title']  = 'Manajemen User';
    $data['active'] = 'users';
    $data['users']  = $this->User_model->get_all();
    $data['roles']  = $this->User_model->get_roles();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('users/index', $data);
    $this->load->view('templates/footer');
  }

  public function add() {
    if ($this->input->post()) {

      $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
      $this->form_validation->set_rules('nama', 'Nama', 'required');
      $this->form_validation->set_rules('role_id', 'Role', 'required');

      if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
      } else {
        $data = array(
          'username' => $this->input->post('username', TRUE),
          'password' => $this->input->post('password', TRUE),
          'nama'     => $this->input->post('nama', TRUE),
          'email'    => $this->input->post('email', TRUE),
          'role_id'  => $this->input->post('role_id', TRUE)
        );
        $this->User_model->insert($data);
        $this->session->set_flashdata('success', 'User baru berhasil ditambahkan.');
      }
      redirect('users');
    }
  }

  public function edit($id) {
    $user = $this->User_model->get_by_id($id);
    if (!$user) show_404();

    if ($this->input->post()) {
      $update_data = array(
        'nama'    => $this->input->post('nama', TRUE),
        'email'   => $this->input->post('email', TRUE),
        'role_id' => $this->input->post('role_id', TRUE)
      );

      $password = $this->input->post('password');
      if (!empty($password)) {
        $update_data['password'] = $password;
      }

      $this->User_model->update($id, $update_data);
      $this->session->set_flashdata('success', 'Data user berhasil diperbarui.');
      redirect('users');
    }
  }

  public function delete($id) {
    $this->User_model->delete($id);
    $this->session->set_flashdata('success', 'User berhasil dihapus.');
    redirect('users');
  }
}
