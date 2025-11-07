<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

  public function get_laporan($tahun, $kelas = null, $jenis = null, $search = null) {
    $this->db->from('v_mutasi_detail');
    $this->db->where('YEAR(tanggal)', $tahun);

    // Hanya ambil mutasi terakhir per siswa yang status_mutasi aktif
    $this->db->where('(status_mutasi IS NULL OR status_mutasi = "aktif")');

    if (!empty($kelas)) {
      $this->db->where('kelas_asal_id', $kelas);
    }
    if (!empty($jenis)) {
      $this->db->where('jenis', strtolower($jenis));
    }
    if (!empty($search)) {
      $this->db->group_start()
               ->like('nama_siswa', $search)
               ->or_like('nis', $search)
               ->or_like('nisn', $search)
               ->group_end();
    }

    $this->db->order_by('tanggal', 'DESC');
    return $this->db->get()->result();
  }

  public function get_kelas() {
    return $this->db->order_by('nama', 'ASC')->get('kelas')->result();
  }
}
