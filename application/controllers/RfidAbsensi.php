<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RfidAbsensi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('AbsensiQR_model', 'qr');
        $this->load->database();
        $this->load->helper('wa_helper');
    }

    /* =====================================================
        CSRF helper
    ====================================================== */
    private function csrf()
    {
        return [
            "csrfName" => $this->security->get_csrf_token_name(),
            "csrfHash" => $this->security->get_csrf_hash()
        ];
    }

    /* =====================================================
        HALAMAN SCAN RFID
    ====================================================== */
    public function scan_real()
{
    date_default_timezone_set('Asia/Jakarta');

    $hariIndex = date('N'); // 1=Senin
    $hariMap = [
        1=>'Senin',2=>'Selasa',3=>'Rabu',
        4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'
    ];
    $hariNama = $hariMap[$hariIndex];
    $tanggal  = date('Y-m-d');

    // default
    $data = [
        'hari'       => $hariNama,
        'jam_masuk'  => '-',
        'jam_pulang' => '-',
        'keterangan' => 'Masuk'
    ];

    // weekend
    if ($hariIndex >= 6) {
        $data['keterangan'] = 'LIBUR (Weekend)';
        $this->load->view('rfid/scan_real', $data);
        return;
    }

    // libur nasional
    $libur = $this->db
        ->get_where('hari_libur', ['start' => $tanggal])
        ->row();

    if ($libur) {
        $data['keterangan'] = 'LIBUR: '.$libur->nama;
        $this->load->view('rfid/scan_real', $data);
        return;
    }

    // jadwal normal
    $jadwal = $this->db
        ->get_where('absensi_jadwal', ['hari' => $hariNama])
        ->row();

    $data['jam_masuk']  = $jadwal ? $jadwal->jam_masuk  : '07:00:00';
    $data['jam_pulang'] = $jadwal ? $jadwal->jam_pulang : '14:00:00';

    $this->load->view('rfid/scan_real', $data);
}


    /* =====================================================
        PROSES SCAN RFID
    ====================================================== */
    public function scan()
{
    date_default_timezone_set('Asia/Jakarta');

    $uid = $this->input->post('uid');
    if (!$uid) {
        echo json_encode(array_merge([
            "status" => false,
            "error"  => "empty_uid",
            "msg"    => "UID kosong"
        ], $this->csrf()));
        return;
    }

    $tanggal = date('Y-m-d');
    $jamNow  = date('H:i:s');

    /* ================= CEK LIBUR ================= */
    if (date('N') >= 6) {
        echo json_encode(array_merge([
            "status" => false,
            "error"  => "libur",
            "msg"    => "Hari ini libur (Weekend)"
        ], $this->csrf()));
        return;
    }

    $libur = $this->db
        ->get_where('hari_libur', ['start' => $tanggal])
        ->row();

    if ($libur) {
        echo json_encode(array_merge([
            "status" => false,
            "error"  => "libur",
            "msg"    => "Hari ini libur: ".$libur->nama
        ], $this->csrf()));
        return;
    }

    /* ================= CEK SISWA ================= */
    $siswa = $this->db
        ->get_where('siswa', ['rfid_uid' => $uid])
        ->row();

    if (!$siswa) {
        echo json_encode(array_merge([
            "status" => false,
            "error"  => "unknown_uid",
            "msg"    => "Kartu tidak terdaftar"
        ], $this->csrf()));
        return;
    }

    $nis = $siswa->nis;

    /* ================= JADWAL ================= */
    $hariMap = [
        1=>'Senin',2=>'Selasa',3=>'Rabu',
        4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'
    ];
    $hariNama = $hariMap[date('N')];

    $jadwal = $this->db
        ->get_where('absensi_jadwal', ['hari' => $hariNama])
        ->row();

    $jamMasuk  = $jadwal ? $jadwal->jam_masuk  : '07:00:00';
    $jamPulang = $jadwal ? $jadwal->jam_pulang : '14:00:00';

    /* ================= ABSEN HARI INI ================= */
    $absen = $this->qr->get_absen_hari_ini($nis, $tanggal);

    /* ================= ABSEN MASUK ================= */
    if (!$absen) {

        if (strtotime($jamNow) <= strtotime($jamMasuk)) {
            $status = "Tepat";
            $telat  = null;
        } else {
            $status = "Terlambat";
            $telat  = $this->format_telat(strtotime($jamNow)-strtotime($jamMasuk));
        }

        $this->qr->insert_absen_masuk([
            'nis'              => $nis,
            'tanggal'          => $tanggal,
            'jam_masuk'        => $jamNow,
            'status'           => $status,
            'kehadiran'        => 'H',
            'keterangan_telat' => $telat,
            'sumber'           => 'scan_rfid'
        ]);

        $this->kirim_wa_rfid($siswa, 'masuk', $jamNow, $tanggal, $status, $telat);

        echo json_encode(array_merge([
            "type"   => "masuk",
            "nama"   => $siswa->nama,
            "jam"    => $jamNow,
            "status" => $status
        ], $this->csrf()));
        return;
    }

    /* ================= SUDAH PULANG ================= */
    if ($absen->jam_pulang) {
        echo json_encode(array_merge([
            "type" => "sudah_pulang",
            "nama" => $siswa->nama
        ], $this->csrf()));
        return;
    }

    /* ================= BELUM WAKTU ================= */
    if (strtotime($jamNow) < strtotime($jamPulang)) {
        echo json_encode(array_merge([
            "type"         => "belum_waktu",
            "nama"         => $siswa->nama,
            "jam_now"      => $jamNow,
            "waktu_pulang" => $jamPulang
        ], $this->csrf()));
        return;
    }

    /* ================= ABSEN PULANG ================= */
    $this->qr->update_absen_pulang($absen->id, $jamNow);
    $this->kirim_wa_rfid($siswa, 'pulang', $jamNow, $tanggal, null);

    echo json_encode(array_merge([
        "type"       => "pulang",
        "nama"       => $siswa->nama,
        "jam_pulang" => $jamNow
    ], $this->csrf()));
}


    /* =====================================================
        RESPONSE JSON
    ====================================================== */
    private function jsonError($code, $msg)
    {
        echo json_encode(array_merge([
            "status"=>false,
            "error"=>$code,
            "msg"=>$msg
        ], $this->csrf()));
        exit;
    }

    private function jsonOK($data)
    {
        echo json_encode(array_merge([
            "status"=>true
        ], $data, $this->csrf()));
        exit;
    }

    /* =====================================================
        FORMAT TELAT
    ====================================================== */
    private function format_telat($detik)
    {
        $jam = floor($detik/3600);
        $menit = floor(($detik%3600)/60);
        $sisa = $detik%60;

        $hasil=[];
        if($jam) $hasil[]=$jam." jam";
        if($menit) $hasil[]=$menit." menit";
        if($sisa) $hasil[]=$sisa." detik";

        return implode(" ",$hasil);
    }

    /* =====================================================
        KIRIM WHATSAPP
    ====================================================== */
    private function kirim_wa_rfid($siswa, $tipe, $jam, $tanggal, $status=null, $telat=null)
    {
        if (empty($siswa->no_hp_ortu)) return;

        $no = preg_replace('/\D/','',$siswa->no_hp_ortu);
        if(substr($no,0,1)=='0') $no='62'.substr($no,1);

        if ($tipe=='masuk') {
            $pesan =
            "Assalamualaikum.\n\n".
            "kepada yth. Orang Tua/Wali Murid\n".
            "Ananda *{$siswa->nama}* telah *HADIR* melalui RFID.\n".
            "⏰ Jam: {$jam}\n".
            "📅 Tanggal: {$tanggal}\n".
            "📌 Status: *{$status}*\n";

            if($status=='Terlambat' && $telat){
                $pesan.="⏱️ Terlambat: {$telat}\n";
            }
        } else {
            $pesan =
            "Assalamualaikum.\n\n".
            "Ananda *{$siswa->nama}* telah *PULANG*.\n".
            "⏰ Jam: {$jam}\n".
            "📅 Tanggal: {$tanggal}";
        }

        send_wa($no,$pesan);
    }
}
