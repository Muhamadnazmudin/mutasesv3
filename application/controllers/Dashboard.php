<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
  public function index(){
    $data['title'] = 'Dashboard';
    $data['active'] = 'dashboard';
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('dashboard/index',$data);
    $this->load->view('templates/footer');
  }
}
