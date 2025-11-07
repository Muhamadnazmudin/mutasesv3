<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

  public function index() {
    $data['title'] = 'Dashboard';
    $data['active'] = 'dashboard';

    // ==========================================================
    // 🏫 JUMLAH ROMBEL PER TINGKAT
    // ==========================================================
    $data['rombel'] = $this->get_kelas_by_tingkat();

    // ==========================================================
    // 👨‍🎓 SISWA AKTIF PER TINGKAT
    // ==========================================================
    $data['aktif'] = $this->get_siswa_by_tingkat('aktif');

    // ==========================================================
    // 🚪 SISWA KELUAR PER TINGKAT
    // ==========================================================
    $data['keluar'] = $this->get_siswa_by_tingkat(['mutasi_keluar', 'keluar']);

    // ==========================================================
    // 🎓 SISWA LULUS PER TAHUN AJARAN
    // ==========================================================
    $query = $this->db
      ->select('tahun_ajaran.tahun, COUNT(siswa.id) AS jumlah')
      ->join('tahun_ajaran', 'tahun_ajaran.id = siswa.tahun_id', 'left')
      ->where('siswa.status', 'lulus')
      ->group_by('tahun_ajaran.tahun')
      ->order_by('tahun_ajaran.tahun', 'ASC')
      ->get('siswa');

    $data['lulus'] = $query ? $query->result() : [];

    // ==========================================================
    // LOAD VIEW
    // ==========================================================
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('dashboard/index', $data);
    $this->load->view('templates/footer');
  }

  // ==========================================================
  // 🔹 JUMLAH KELAS PER TINGKAT
  // ==========================================================
  private function get_kelas_by_tingkat() {
    $result = [];

    // Kelas X → hanya yang dimulai dengan 'X ' atau '10'
    $this->db->where("(nama REGEXP '(^X($|[^I])|^10)')");
    $result['x'] = $this->db->count_all_results('kelas');

    // Kelas XI → hanya yang dimulai dengan 'XI' atau '11'
    $this->db->where("(nama REGEXP '(^XI($|[^I])|^11)')");
    $result['xi'] = $this->db->count_all_results('kelas');

    // Kelas XII → hanya yang dimulai dengan 'XII' atau '12'
    $this->db->where("(nama REGEXP '(^XII|^12)')");
    $result['xii'] = $this->db->count_all_results('kelas');

    $result['total'] = $result['x'] + $result['xi'] + $result['xii'];
    return $result;
}


  // ==========================================================
  // 🔹 JUMLAH SISWA PER TINGKAT (untuk aktif / keluar)
  // ==========================================================
  private function get_siswa_by_tingkat($status) {
    $result = [];

    // Kelas X
    $this->db->join('kelas', 'kelas.id = siswa.id_kelas', 'left');
    if (is_array($status)) $this->db->where_in('siswa.status', $status);
    else $this->db->where('siswa.status', $status);
    $this->db->where("(kelas.nama REGEXP '(^X($|[^I])|^10)')");
    $result['x'] = $this->db->count_all_results('siswa', TRUE); // 🔥 reset query builder

    // Kelas XI
    $this->db->join('kelas', 'kelas.id = siswa.id_kelas', 'left');
    if (is_array($status)) $this->db->where_in('siswa.status', $status);
    else $this->db->where('siswa.status', $status);
    $this->db->where("(kelas.nama REGEXP '(^XI($|[^I])|^11)')");
    $result['xi'] = $this->db->count_all_results('siswa', TRUE); // 🔥 reset

    // Kelas XII
    $this->db->join('kelas', 'kelas.id = siswa.id_kelas', 'left');
    if (is_array($status)) $this->db->where_in('siswa.status', $status);
    else $this->db->where('siswa.status', $status);
    $this->db->where("(kelas.nama REGEXP '(^XII|^12)')");
    $result['xii'] = $this->db->count_all_results('siswa', TRUE); // 🔥 reset

    $result['total'] = $result['x'] + $result['xi'] + $result['xii'];
    return $result;
}


}
