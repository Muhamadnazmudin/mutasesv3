<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  /* ======================
     TAHUN AJARAN AKTIF
  ====================== */
  private function tahunAktif()
  {
    return $this->db
      ->where('aktif', 1)
      ->get('tahun_ajaran')
      ->row();
  }

  /* ======================
     REPLY CHATBOT
  ====================== */
  public function reply()
  {
    $text  = strtolower(trim($this->input->post('message')));
    $reply = "🙏 Maaf, saya belum memahami pertanyaan tersebut.";

    if (!$text) {
      echo json_encode(['reply' => 'Pesan tidak boleh kosong.']);
      return;
    }

    $tahun    = $this->tahunAktif();
    $tahun_id = $tahun ? $tahun->id : null;

    /* ======================
       SAPAAN & OBROLAN UMUM
    ====================== */
    if (in_array($text, ['halo','haloo','hai','hallo','assalamualaikum'])) {
      $reply =
        "👋 Halo! Selamat datang di *Chat Mutasi Siswa*.\n" .
        "Silakan ketik pertanyaan yang ingin Anda ketahui 😊";
    }

    elseif (strpos($text, 'apa kabar') !== false) {
      $reply = "Alhamdulillah baik 😊 Ada yang bisa saya bantu terkait data siswa atau mutasi?";
    }

    elseif (strpos($text, 'bantu') !== false || strpos($text, 'bingung') !== false) {
      $reply = $this->menuBantuan();
    }

    /* ======================
       JUMLAH SISWA
    ====================== */
    elseif (strpos($text, 'jumlah siswa') !== false) {
      $this->db->where('tahun_id', $tahun_id);
      $total = $this->db->count_all_results('siswa');
      $reply = "👨‍🎓 Jumlah siswa tahun ajaran *{$tahun->tahun}* adalah *{$total} siswa*.";
    }

    /* ======================
       SISWA AKTIF
    ====================== */
    elseif (strpos($text, 'siswa aktif') !== false) {
      $this->db->where(['tahun_id' => $tahun_id, 'status' => 'aktif']);
      $total = $this->db->count_all_results('siswa');
      $reply = "🟢 Jumlah siswa *aktif* saat ini ada *{$total} siswa*.";
    }

    /* ======================
       SISWA LULUS
    ====================== */
    elseif (strpos($text, 'siswa lulus') !== false) {
      $this->db->where('status', 'lulus');
      $total = $this->db->count_all_results('siswa');
      $reply = "🎓 Jumlah siswa yang sudah *lulus* adalah *{$total} siswa*.";
    }

    /* ======================
       MUTASI MASUK / KELUAR
    ====================== */
    elseif (strpos($text, 'mutasi keluar') !== false) {
      $this->db->where(['jenis' => 'keluar', 'status_mutasi' => 'aktif']);
      $total = $this->db->count_all_results('mutasi');
      $reply = "📤 Total *mutasi keluar* aktif: *{$total} siswa*.";
    }

    elseif (strpos($text, 'mutasi masuk') !== false) {
      $this->db->where(['jenis' => 'masuk', 'status_mutasi' => 'aktif']);
      $total = $this->db->count_all_results('mutasi');
      $reply = "📥 Total *mutasi masuk* aktif: *{$total} siswa*.";
    }

    /* ======================
       JUMLAH KELAS / GURU
    ====================== */
    elseif (strpos($text, 'jumlah kelas') !== false || strpos($text, 'jumlah rombel') !== false) {
      $total = $this->db->count_all('kelas');
      $reply = "🏫 Saat ini terdapat *{$total} rombongan belajar*.";
    }

    elseif (strpos($text, 'jumlah guru') !== false) {
      $total = $this->db->count_all('guru');
      $reply = "👨‍🏫 Jumlah guru terdaftar: *{$total} orang*.";
    }

    /* ======================
       SISWA PER KELAS
    ====================== */
    elseif (preg_match('/kelas\s+(.+)/', $text, $m)) {
      $kelasNama = strtoupper(trim($m[1]));

      $this->db
        ->join('kelas', 'kelas.id = siswa.id_kelas')
        ->where([
          'siswa.tahun_id' => $tahun_id,
          'siswa.status'   => 'aktif'
        ])
        ->where('UPPER(kelas.nama)', $kelasNama);

      $total = $this->db->count_all_results('siswa');

      $reply = $total > 0
        ? "🏫 Jumlah siswa *kelas {$kelasNama}* adalah *{$total} siswa*."
        : "⚠️ Kelas *{$kelasNama}* tidak ditemukan atau belum ada siswa aktif.";
    }

    /* ======================
       CEK NISN
    ====================== */
    elseif (preg_match('/cek\s+nisn\s+([0-9]+)/', $text, $m)) {
      $nisn = $m[1];

      $this->db
        ->select('s.nama, k.nama as kelas')
        ->from('siswa s')
        ->join('kelas k', 'k.id = s.id_kelas', 'left')
        ->where('s.nisn', $nisn)
        ->limit(1);

      $siswa = $this->db->get()->row();

      $reply = $siswa
        ? "✅ *NISN VALID*\n👤 Nama: *{$siswa->nama}*\n🏫 Kelas: *{$siswa->kelas}*"
        : "❌ *NISN tidak ditemukan* di database sekolah.";
    }

    /* ======================
       IZIN KELUAR HARI INI
    ====================== */
    elseif (strpos($text, 'izin hari ini') !== false) {
      $today = date('Y-m-d');
      $this->db->where('DATE(created_at)', $today);
      $total = $this->db->count_all_results('izin_keluar');
      $reply = "🚪 Jumlah izin keluar *hari ini*: *{$total} siswa*.";
    }

    /* ======================
       TIDAK DIPAHAMI → ARAHKAN
    ====================== */
    else {
      $reply =
        "🤔 Maaf, saya belum memahami pertanyaan tersebut.\n\n" .
        "Silakan pilih atau ketik salah satu contoh berikut:\n" .
        $this->menuBantuan();
    }

    echo json_encode(['reply' => $reply]);
  }

  /* ======================
     MENU BANTUAN
  ====================== */
  private function menuBantuan()
  {
    return
      "• jumlah siswa\n" .
      "• siswa aktif\n" .
      "• siswa lulus\n" .
      "• mutasi masuk\n" .
      "• mutasi keluar\n" .
      "• jumlah kelas\n" .
      "• jumlah guru\n" .
      "• kelas  \n" .
      "• cek nisn";
  }
}
