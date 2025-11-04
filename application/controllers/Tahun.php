<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Tahun_model');
    if(!$this->session->userdata('username')){
      redirect('auth');
    }
  }

  public function index(){
    $data['active'] = 'tahun';
    $data['tahun_list'] = $this->Tahun_model->get_all();
    $this->load->view('templates/header');
    $this->load->view('templates/sidebar', $data);
    $this->load->view('tahun/index', $data);
    $this->load->view('templates/footer');
  }

  public function add(){
    $tahun = $this->input->post('tahun');
    $aktif = $this->input->post('aktif') ? 1 : 0;

    if($aktif == 1){
      $this->Tahun_model->reset_active();
    }

    $data = ['tahun' => $tahun, 'aktif' => $aktif];
    $this->Tahun_model->insert($data);
    $this->session->set_flashdata('success', 'Tahun ajaran berhasil ditambahkan.');
    redirect('tahun');
  }

  public function edit($id){
    $tahun = $this->input->post('tahun');
    $aktif = $this->input->post('aktif') ? 1 : 0;

    if($aktif == 1){
      $this->Tahun_model->reset_active();
    }

    $data = ['tahun' => $tahun, 'aktif' => $aktif];
    $this->Tahun_model->update($id, $data);
    $this->session->set_flashdata('success', 'Tahun ajaran berhasil diperbarui.');
    redirect('tahun');
  }

  public function delete($id){
    $this->Tahun_model->delete($id);
    $this->session->set_flashdata('success', 'Tahun ajaran berhasil dihapus.');
    redirect('tahun');
  }
}
