<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_keluar extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Siswa_model');
    if (!$this->session->userdata('username')) redirect('auth');
  }

  public function index() {
    $data['active'] = 'siswa_keluar';

    // Subquery: ambil mutasi terakhir tiap siswa
    $subquery = "
      SELECT m1.siswa_id
      FROM mutasi m1
      INNER JOIN (
        SELECT siswa_id, MAX(id) AS max_id
        FROM mutasi
        GROUP BY siswa_id
      ) m2 ON m1.id = m2.max_id
      WHERE m1.status_mutasi = 'dibatalkan'
    ";

    // Ambil data siswa yang status keluar atau mutasi_keluar
    $this->db->select('siswa.*, kelas.nama AS nama_kelas, tahun_ajaran.tahun AS tahun_ajaran');
    $this->db->join('kelas', 'kelas.id = siswa.id_kelas', 'left');
    $this->db->join('tahun_ajaran', 'tahun_ajaran.id = siswa.tahun_id', 'left');
    $this->db->where_in('siswa.status', ['mutasi_keluar', 'keluar']);
    $this->db->where("siswa.id NOT IN ($subquery)", NULL, FALSE); // pastikan bukan yang dibatalkan terakhir
    $this->db->order_by('kelas.nama', 'ASC');

    $data['siswa'] = $this->db->get('siswa')->result();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar', $data);
    $this->load->view('siswa/keluar', $data);
    $this->load->view('templates/footer');
  }
}
