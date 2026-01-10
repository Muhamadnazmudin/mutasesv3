<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hari_libur_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('start','ASC')->get('hari_libur')->result();
    }

    public function insert($data) {
        return $this->db->insert('hari_libur', $data);
    }

    public function delete($id) {
        return $this->db->delete('hari_libur', ['id' => $id]);
    }

    public function get_all_dates() {
        $q = $this->db->query("SELECT start FROM hari_libur")->result();
        $arr = [];

        foreach ($q as $r) {
            $arr[] = $r->start;
        }
        return $arr;
    }
    public function is_hari_libur($tanggal = null)
{
    if (!$tanggal) {
        $tanggal = date('Y-m-d');
    }

    return $this->db
        ->where('start', $tanggal)
        ->get('hari_libur')
        ->row(); // object jika libur, null jika tidak
}
public function get_libur_hari_ini()
{
    return $this->db
        ->where('start', date('Y-m-d'))
        ->get('hari_libur')
        ->row(); // bisa null
}
public function update($id, $data)
{
    return $this->db->where('id', $id)->update('hari_libur', $data);
}
public function get_by_date($tanggal)
{
    return $this->db
        ->where('start', $tanggal)
        ->get('hari_libur')
        ->row();
}

}
