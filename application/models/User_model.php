<?php
class User_model extends CI_Model {

  // --- sudah ada ---
  public function get_by_username($username){
    return $this->db->get_where('users', ['username'=>$username])->row();
  }

  public function role_name($role_id){
    $r = $this->db->get_where('roles', ['id'=>$role_id])->row();
    return $r ? $r->name : null;
  }

  public function create($data){
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    $this->db->insert('users',$data);
    return $this->db->insert_id();
  }

  // --- tambahan untuk manajemen user ---
  public function get_all() {
    $this->db->select('users.*, roles.name as role_name');
    $this->db->join('roles', 'roles.id = users.role_id', 'left');
    $this->db->order_by('users.id', 'DESC');
    return $this->db->get('users')->result();
  }

  public function get_by_id($id) {
    return $this->db->get_where('users', ['id' => $id])->row();
  }

  public function insert($data) {
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    return $this->db->insert('users', $data);
  }

  public function update($id, $data) {
    if (!empty($data['password'])) {
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    } else {
      unset($data['password']);
    }
    return $this->db->where('id', $id)->update('users', $data);
  }

  public function delete($id) {
    return $this->db->delete('users', ['id' => $id]);
  }

  public function get_roles() {
    return $this->db->get('roles')->result();
  }
}
