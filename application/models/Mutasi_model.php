<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_model extends CI_Model {

  private $table = 'mutasi';

  // Ambil semua data mutasi aktif (yang belum dibatalkan)
  public function get_all($limit, $offset) {
    $this->db->select('
      mutasi.*, 
      siswa.nama AS nama_siswa, 
      siswa.nis, 
      kelas.nama AS tujuan_kelas, 
      tahun_ajaran.tahun AS tahun_ajaran
    ');
    $this->db->join('siswa', 'siswa.id = mutasi.siswa_id', 'left');
    $this->db->join('kelas', 'kelas.id = mutasi.tujuan_kelas_id', 'left');
    $this->db->join('tahun_ajaran', 'tahun_ajaran.id = mutasi.tahun_id', 'left');

    // Hanya ambil mutasi aktif
    $this->db->where('mutasi.status_mutasi', 'aktif');

    $this->db->order_by('mutasi.id', 'DESC');
    return $this->db->get($this->table, $limit, $offset)->result();
  }

  public function count_all() {
    $this->db->where('status_mutasi', 'aktif');
    return $this->db->count_all_results($this->table);
  }

  public function get_siswa_aktif() {
    return $this->db->where('status', 'aktif')->get('siswa')->result();
  }

  public function get_kelas_list() {
    return $this->db->get('kelas')->result();
  }

  public function get_tahun_list() {
    return $this->db->order_by('id', 'DESC')->get('tahun_ajaran')->result();
  }
}
