<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model {

  private $table = 'kelas';

  public function get_all($limit, $offset) {
    $this->db->select('kelas.*, guru.nama AS wali_nama');
    $this->db->join('guru', 'guru.id = kelas.wali_kelas_id', 'left');
    $this->db->order_by('kelas.id', 'DESC');
    return $this->db->get($this->table, $limit, $offset)->result();
  }

  public function count_all() {
    return $this->db->count_all($this->table);
  }

  public function insert($data) {
    return $this->db->insert($this->table, $data);
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

  public function get_guru_list() {
    return $this->db->get('guru')->result();
  }
}
