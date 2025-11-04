<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_model extends CI_Model {

  private $table = 'mutasi';

  public function get_all($limit, $offset) {
    $this->db->select('mutasi.*, siswa.nama AS nama_siswa, siswa.nis, kelas.nama AS tujuan_kelas, tahun_ajaran.tahun AS tahun_ajaran');
    $this->db->join('siswa', 'siswa.id = mutasi.siswa_id', 'left');
    $this->db->join('kelas', 'kelas.id = mutasi.tujuan_kelas_id', 'left');
    $this->db->join('tahun_ajaran', 'tahun_ajaran.id = mutasi.tahun_id', 'left');
    $this->db->order_by('mutasi.id', 'DESC');
    return $this->db->get($this->table, $limit, $offset)->result();
  }

  public function count_all() {
    return $this->db->count_all($this->table);
  }

  public function insert($data) {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function get_by_id($id) {
    return $this->db->get_where($this->table, ['id' => $id])->row();
  }

  public function update($id, $data) {
    $this->db->where('id', $id);
    return $this->db->update($this->table, $data);
  }

  public function delete($id) {
    $this->db->where('id', $id);
    return $this->db->delete($this->table);
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
