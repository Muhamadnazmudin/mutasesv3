<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AbsensiQR_model extends CI_Model {

    public function get_siswa_by_token($token) {
        return $this->db->get_where('siswa', ['token_qr' => $token])->row();
    }

    public function get_absen_hari_ini($nis, $tanggal) {
        return $this->db->get_where('absensi_qr', [
            'nis' => $nis,
            'tanggal' => $tanggal
        ])->row();
    }

    public function insert_absen_masuk($data) {
        return $this->db->insert('absensi_qr', $data);
    }

    public function update_absen_pulang($id, $jam) {
        return $this->db->where('id', $id)->update('absensi_qr', [
            'jam_pulang' => $jam
        ]);
    }

    public function history_today() {
        $today = date('Y-m-d');
        return $this->db->order_by('id', 'DESC')
                        ->get_where('absensi_qr', ['tanggal' => $today])
                        ->result();
    }

    // ambil mode ulangan
    public function mode_ulangan() {
        $row = $this->db->get_where('system_config', ['config_key' => 'mode_ulangan'])->row();
        return ($row && $row->config_value == '1');
    }
    public function get_all_join()
{
    $this->db->select("a.*, s.nama AS nama_siswa, k.nama AS nama_kelas");
    $this->db->from("absensi_qr a");
    $this->db->join("siswa s", "s.nis = a.nis", "left");
    $this->db->join("kelas k", "k.id = s.id_kelas", "left");
    $this->db->order_by("a.tanggal", "DESC");
    $this->db->order_by("a.jam_masuk", "DESC");
    return $this->db->get()->result();
}

}
