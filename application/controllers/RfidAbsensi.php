<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RfidAbsensi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('AbsensiQR_model', 'qr');
        $this->load->database();
        $this->load->helper('wa_helper');
    }

    /* -----------------------------------------------
        Helper CSRF return
    ------------------------------------------------- */
    private function csrf()
    {
        return [
            "csrfName" => $this->security->get_csrf_token_name(),
            "csrfHash" => $this->security->get_csrf_hash()
        ];
    }

    /* ------------------------------------------------
        Scan HTM
    -------------------------------------------------- */
//     public function scan_real()
// {
//     // Ambil hari saat ini
//     $hariIndex = date('N');
//     $hariNamaMap = [
//         1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
//         4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'
//     ];
//     $hariNama = $hariNamaMap[$hariIndex];

//     // Ambil jadwal hari ini
//     $jadwal = $this->db->get_where('absensi_jadwal', ['hari' => $hariNama])->row();

//     $data['jam_masuk']  = $jadwal ? $jadwal->jam_masuk  : "07:00:00";
//     $data['jam_pulang'] = $jadwal ? $jadwal->jam_pulang : "14:00:00";
//     $data['hari'] = $hariNama;

//     $this->load->view('rfid/scan_real', $data);
// }

public function scan_real()
{
    date_default_timezone_set('Asia/Jakarta');

    // Hari index: 1=Senin, 7=Minggu
    $hariIndex = date('N');
    $hariNamaMap = [
        1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
        4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'
    ];
    $hariNama = $hariNamaMap[$hariIndex];

    $tanggal = date('Y-m-d');

    /* =============================================
        CEK WEEKEND (Sabtu/Minggu)
    ============================================== */
    if ($hariIndex >= 6) {

        $data['hari']        = $hariNama;
        $data['jam_masuk']   = "-";
        $data['jam_pulang']  = "-";
        $data['keterangan']  = "LIBUR (Weekend)";

        $this->load->view('rfid/scan_real', $data);
        return;
    }

    /* =============================================
        CEK LIBUR NASIONAL DARI TABLE hari_libur
    ============================================== */
    $cekLibur = $this->db->get_where('hari_libur', ['start' => $tanggal])->row();

    if ($cekLibur) {

        $data['hari']        = $hariNama;
        $data['jam_masuk']   = "-";
        $data['jam_pulang']  = "-";
        $data['keterangan']  = "LIBUR: " . $cekLibur->keterangan;

        $this->load->view('rfid/scan_real', $data);
        return;
    }

    /* =============================================
        HARI NORMAL → AMBIL JAM DARI JADWAL
    ============================================== */
    $jadwal = $this->db->get_where('absensi_jadwal', [
        'hari' => $hariNama
    ])->row();

    $data['hari']        = $hariNama;
    $data['jam_masuk']   = $jadwal ? $jadwal->jam_masuk   : "07:00:00";
    $data['jam_pulang']  = $jadwal ? $jadwal->jam_pulang  : "14:00:00";
    $data['keterangan']  = "Masuk";

    $this->load->view('rfid/scan_real', $data);
}

    /* ------------------------------------------------
        SCAN RFID (MAIN LOGIC)
    -------------------------------------------------- */
    public function scan()
    {
        $uid = $this->input->post('uid');
        if (!$uid) {
            echo json_encode(array_merge([
                "status" => false,
                "error"  => "empty_uid",
                "msg"    => "UID kosong."
            ], $this->csrf()));
            return;
        }

        /* =============================================
           1️⃣ CEK LIBUR / WEEKEND
        ==============================================*/
        $hariIndex = date('N'); // 1=Senin, 7=Minggu
        $hariNamaMap = [
            1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',
            5=>'Jumat',6=>'Sabtu',7=>'Minggu'
        ];
        $hariNama = $hariNamaMap[$hariIndex];
        $tanggal = date('Y-m-d');

        // Weekend
        if ($hariIndex >= 6) {
            echo json_encode(array_merge([
                "status" => false,
                "error"  => "libur",
                "msg"    => "Hari ini hari {$hariNama}, absensi libur."
            ], $this->csrf()));
            return;
        }

        // Libur nasional di DB
       // Libur nasional di DB
$cekLibur = $this->db
    ->where('tanggal', $tanggal)
    ->or_where('start', $tanggal)
    ->or_where('mulai', $tanggal)
    ->get('hari_libur')
    ->row();

if ($cekLibur) {
    echo json_encode(array_merge([
        "status" => false,
        "error"  => "libur",
        "msg"    => "Hari ini libur: {$cekLibur->keterangan}"
    ], $this->csrf()));
    return;
}


        /* =============================================
           2️⃣ CEK SISWA BY UID
        ==============================================*/
        $siswa = $this->db->get_where("siswa", ["rfid_uid" => $uid])->row();

        if (!$siswa) {
            echo json_encode(array_merge([
                "status" => false,
                "error"  => "unknown_uid",
                "msg"    => "Kartu tidak terdaftar."
            ], $this->csrf()));
            return;
        }

        $nis = $siswa->nis;
        $jamNow = date("H:i:s");

        /* =============================================
           3️⃣ AMBIL JADWAL HARI INI
        ==============================================*/
        $jadwal = $this->db->get_where("absensi_jadwal", ["hari" => $hariNama])->row();
        $jamMasukResmi  = $jadwal ? $jadwal->jam_masuk  : "07:00:00";
        $jamPulangResmi = $jadwal ? $jadwal->jam_pulang : "14:00:00";

        /* =============================================
           4️⃣ CEK ABSEN HARI INI (FIX BUG TANGGAL)
        ==============================================*/
        $absen = $this->qr->get_absen_hari_ini($nis, $tanggal);

        // FIX UTAMA: Jangan pernah pakai data absen kemarin!
        if ($absen && $absen->tanggal !== $tanggal) {
            $absen = null;
        }

        /* =============================================
           5️⃣ ABSEN MASUK
        ==============================================*/
        if (!$absen) {

            if (strtotime($jamNow) <= strtotime($jamMasukResmi)) {
                $status = "Tepat";
                $keterangan_telat = null;
            } else {
                $status = "Terlambat";
                $telat_detik = strtotime($jamNow) - strtotime($jamMasukResmi);
                $keterangan_telat = $this->format_telat($telat_detik);
            }

            $insert = [
                "nis"              => $nis,
                "tanggal"          => $tanggal,
                "jam_masuk"        => $jamNow,
                "status"           => $status,
                "kehadiran"        => "H",
                "keterangan_telat" => $keterangan_telat,
                "sumber"           => "scan_rfid"
            ];

            $this->qr->insert_absen_masuk($insert);

            // Kirim WA
            $this->kirim_wa_rfid($siswa, "masuk", $jamNow, $tanggal, $status, $keterangan_telat);

            echo json_encode(array_merge([
                "type"   => "masuk",
                "nama"   => $siswa->nama,
                "jam"    => $jamNow,
                "status" => $status
            ], $this->csrf()));
            return;
        }

        /* =============================================
           6️⃣ SUDAH PULANG (HARI INI)
        ==============================================*/
        if ($absen && $absen->jam_pulang != null) {
            echo json_encode(array_merge([
                "type" => "sudah_pulang",
                "nama" => $siswa->nama
            ], $this->csrf()));
            return;
        }

        /* =============================================
           7️⃣ BELUM WAKTU PULANG
        ==============================================*/
        if (strtotime($jamNow) < strtotime($jamPulangResmi)) {
            echo json_encode(array_merge([
                "type"          => "belum_waktu",
                "nama"          => $siswa->nama,
                "jam_now"       => $jamNow,
                "waktu_pulang"  => $jamPulangResmi
            ], $this->csrf()));
            return;
        }

        /* =============================================
           8️⃣ ABSEN PULANG
        ==============================================*/
        $this->qr->update_absen_pulang($absen->id, $jamNow);

        $this->kirim_wa_rfid($siswa, "pulang", $jamNow, $tanggal, null);

        echo json_encode(array_merge([
            "type"       => "pulang",
            "nama"       => $siswa->nama,
            "jam_pulang" => $jamNow
        ], $this->csrf()));
    }

    /* ==========================================================================
        Fungsi Kirim WA
    ========================================================================== */
    private function kirim_wa_rfid($siswa, $tipe, $jam, $tanggal, $status, $telat = null)
    {
        if (empty($siswa->no_hp_ortu)) return;

        $no = preg_replace('/\D/', '', $siswa->no_hp_ortu);
        if (substr($no,0,1) == "0") $no = "62".substr($no,1);

        if ($tipe == "masuk") {

            $pesan = 
            "Assalamualaikum, Orang tua/wali dari *{$siswa->nama}*.\n\n".
            "Ananda telah *HADIR* melalui *RFID*.\n".
            "⏰ Jam: *{$jam}*\n".
            "📅 Tanggal: *{$tanggal}*\n".
            "📌 Status: *{$status}*\n";

            if ($status == "Terlambat" && $telat) {
                $pesan .= "⏱️ Keterlambatan: _{$telat}_\n";
            }

            $pesan .= "\nTerima kasih.";

        } else {

            $pesan = 
            "Assalamualaikum, Orang tua/wali dari *{$siswa->nama}*.\n\n".
            "Ananda telah *PULANG* melalui *RFID*.\n".
            "⏰ Jam Pulang: *{$jam}*\n".
            "📅 Tanggal: *{$tanggal}*\n\n".
            "Terima kasih.";
        }

        send_wa($no, $pesan);
    }

    /* ==========================================================================
        Format telat
    ========================================================================== */
    private function format_telat($detik)
    {
        $jam = floor($detik / 3600);
        $menit = floor(($detik % 3600)/60);
        $sisa = $detik % 60;

        $hasil = [];
        if ($jam > 0)   $hasil[] = $jam." jam";
        if ($menit > 0) $hasil[] = $menit." menit";
        if ($sisa > 0)  $hasil[] = $sisa." detik";

        return implode(" ", $hasil);
    }
}
