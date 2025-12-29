<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot extends CI_Controller {

  private function tahunAktif() {
    return $this->db
      ->where('aktif', 1)
      ->get('tahun_ajaran')
      ->row();
  }

  public function reply() {
    $text = strtolower(trim($this->input->post('message')));
    $reply = "🙏 Maaf, saya belum memahami pertanyaan tersebut.";

    $tahun = $this->tahunAktif();
    $tahun_id = $tahun ? $tahun->id : null;

    /* ======================
       JUMLAH SISWA
    ====================== */
    if (strpos($text, 'jumlah siswa') !== false) {
      $this->db->where('tahun_id', $tahun_id);
      $total = $this->db->count_all_results('siswa');

      $reply = "👨‍🎓 Jumlah siswa tahun ajaran *{$tahun->tahun}* adalah *$total siswa*.";
    }

    /* ======================
       SISWA AKTIF
    ====================== */
    elseif (strpos($text, 'siswa aktif') !== false) {
      $this->db->where([
        'tahun_id' => $tahun_id,
        'status'   => 'aktif'
      ]);
      $total = $this->db->count_all_results('siswa');

      $reply = "🟢 Jumlah siswa *aktif* saat ini ada *$total siswa*.";
    }

    /* ======================
       SISWA LULUS
    ====================== */
    elseif (strpos($text, 'siswa lulus') !== false) {
      $this->db->where('status', 'lulus');
      $total = $this->db->count_all_results('siswa');

      $reply = "🎓 Jumlah siswa yang sudah *lulus* adalah *$total siswa*.";
    }

    /* ======================
       MUTASI KELUAR
    ====================== */
    elseif (strpos($text, 'mutasi keluar') !== false) {
      $this->db->where([
        'jenis' => 'keluar',
        'status_mutasi' => 'aktif'
      ]);
      $total = $this->db->count_all_results('mutasi');

      $reply = "📤 Total *mutasi keluar* aktif tercatat sebanyak *$total siswa*.";
    }

    /* ======================
       MUTASI MASUK
    ====================== */
    elseif (strpos($text, 'mutasi masuk') !== false) {
      $this->db->where([
        'jenis' => 'masuk',
        'status_mutasi' => 'aktif'
      ]);
      $total = $this->db->count_all_results('mutasi');

      $reply = "📥 Total *mutasi masuk* aktif tercatat sebanyak *$total siswa*.";
    }

    /* ======================
       JUMLAH ROMBEL / KELAS
    ====================== */
    elseif (
      strpos($text, 'jumlah kelas') !== false ||
      strpos($text, 'jumlah rombel') !== false
    ) {
      $total = $this->db->count_all('kelas');
      $reply = "🏫 Saat ini terdapat *$total rombongan belajar (kelas)*.";
    }

    /* ======================
       JUMLAH GURU
    ====================== */
    elseif (strpos($text, 'jumlah guru') !== false) {
      $total = $this->db->count_all('guru');
      $reply = "👨‍🏫 Jumlah guru terdaftar saat ini sebanyak *$total orang*.";
    }

    /* ======================
   SISWA PER KELAS (AMAN SEMUA FORMAT)
   contoh:
   kelas 7a
   kelas XI KL1
   kelas xii ipa 2
====================== */
elseif (preg_match('/kelas\s+(.+)/', $text, $m)) {

  // ambil teks setelah kata "kelas"
  $kelasNama = strtoupper(trim($m[1]));

  $this->db
    ->join('kelas', 'kelas.id = siswa.id_kelas')
    ->where([
      'siswa.tahun_id' => $tahun_id,
      'siswa.status' => 'aktif'
    ])
    ->where('UPPER(kelas.nama)', $kelasNama);

  $total = $this->db->count_all_results('siswa');

  if ($total > 0) {
    $reply = "🏫 Jumlah siswa *kelas {$kelasNama}* (aktif) adalah *$total siswa*.";
  } else {
    $reply = "⚠️ Kelas *{$kelasNama}* tidak ditemukan atau belum ada siswa aktif.";
  }
}


    /* ======================
       CEK NISN
       contoh: cek nisn 1234567890
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

      if ($siswa) {
        $kelas = $siswa->kelas ?: '-';
        $reply =
          "✅ *NISN VALID*\n" .
          "👤 Nama: *{$siswa->nama}*\n" .
          "🏫 Kelas: *{$kelas}*";
      } else {
        $reply = "❌ *NISN tidak ditemukan* di database sekolah.";
      }
    }

    /* ======================
       IZIN KELUAR HARI INI
    ====================== */
    elseif (strpos($text, 'izin hari ini') !== false) {
      $today = date('Y-m-d');

      $this->db->where('DATE(created_at)', $today);
      $total = $this->db->count_all_results('izin_keluar');

      $reply = "🚪 Jumlah izin keluar *hari ini* tercatat *$total siswa*.";
    }

    /* ======================
       BANTUAN
    ====================== */
    else {
      $reply =
        "🤖 Saya bisa membantu:\n" .
        "• jumlah siswa\n" .
        "• siswa aktif\n" .
        "• jumlah kelas / rombel\n" .
        "• jumlah guru\n" .
        "• kelas 7a\n" .
        "• cek nisn 1234567890";
    }

    echo json_encode(['reply' => $reply]);

  }
}
