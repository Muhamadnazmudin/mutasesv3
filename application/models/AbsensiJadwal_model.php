<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AbsensiJadwal_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('id','ASC')->get('absensi_jadwal')->result();
    }

    public function update_jadwal($id, $data) {
        return $this->db->where('id', $id)->update('absensi_jadwal', $data);
    }

    public function get_by_day($hari) {
        return $this->db->get_where('absensi_jadwal', ['hari' => $hari])->row();
    }
}
