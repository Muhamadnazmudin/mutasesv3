<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_model extends CI_Model {

  private $table = 'guru';

  public function get_all($limit = null, $offset = null)
{
    if ($limit !== null) {
        $this->db->limit($limit, $offset);
    }

    return $this->db->get('guru')->result();
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
  public function get($id)
{
    return $this->db->get_where('guru', ['id' => $id])->row();
}

}
