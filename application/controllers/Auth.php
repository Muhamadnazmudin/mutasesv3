<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model(['User_model','Tahun_model']);
  }

  public function login(){
    if($this->input->post()){
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $tahun_id = $this->input->post('tahun_id');
      print_r($this->input->post());
// $user = $this->User_model->get_by_username($username);
// var_dump($user);
// exit;


      $user = $this->User_model->get_by_username($username);
      if($user && password_verify($password, $user->password)){
        $this->session->set_userdata([
          'user_id' => $user->id,
          'username' => $user->username,
          'nama' => $user->nama,
          'role_id' => $user->role_id,
          'role_name' => $this->User_model->role_name($user->role_id),
          'tahun_id' => $tahun_id
        ]);
        redirect('dashboard');
      } else {
        $this->session->set_flashdata('error','Username atau password salah.');
        redirect('auth/login');
      }
    } else {
      $data['title'] = 'Login';
      $data['tahun'] = $this->Tahun_model->get_all();
      $this->load->view('auth/login',$data);
    }
  }

  public function logout(){
    $this->session->sess_destroy();
    redirect('auth/login');
  }
}
