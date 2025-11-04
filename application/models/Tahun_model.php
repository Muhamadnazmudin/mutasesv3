<?php
class Tahun_model extends CI_Model {

  public function get_all(){
    return $this->db->order_by('tahun','DESC')->get('tahun_ajaran')->result();
  }

  public function get_aktif(){
    return $this->db->get_where('tahun_ajaran',['aktif'=>1])->row();
  }

  // 🔹 Tambahkan Tahun Baru
  public function insert($data){
    return $this->db->insert('tahun_ajaran', $data);
  }

  // 🔹 Update Tahun
  public function update($id, $data){
    return $this->db->where('id', $id)->update('tahun_ajaran', $data);
  }

  // 🔹 Hapus Tahun
  public function delete($id){
    return $this->db->where('id', $id)->delete('tahun_ajaran');
  }

  // 🔹 Nonaktifkan semua tahun
  public function reset_active(){
    return $this->db->update('tahun_ajaran', ['aktif' => 0]);
  }
}
