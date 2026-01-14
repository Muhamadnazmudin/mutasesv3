<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_mengajar_model extends CI_Model {

    public function get_guru()
    {
        return $this->db
            ->select('id, nama')
            ->order_by('nama', 'ASC')
            ->get('guru')
            ->result();
    }

    public function get_laporan($tanggal = null, $guru_id = null)
{
    if (!$tanggal) {
        $tanggal = date('Y-m-d');
    }

    // ===============================
    // KONVERSI HARI
    // ===============================
    $hariMap = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu'
    ];
    $hari = $hariMap[date('l', strtotime($tanggal))];

    // ===============================
    // QUERY UTAMA (BERBASIS JADWAL)
    // ===============================
    $this->db->select('
    "'.$tanggal.'" AS tanggal,

    g.nama AS nama_guru,
    m.nama_mapel,
    k.nama AS nama_kelas,

    js1.nama_jam AS jam_awal,
    js2.nama_jam AS jam_akhir,

    js1.jam_mulai   AS jam_mulai_jadwal,
    js2.jam_selesai AS jam_selesai_jadwal,

    lm.status,
    lm.jam_mulai,
    lm.jam_selesai,
    lm.selfie,
    lm.catatan_keluar,

    hl.jam_mulai AS jam_libur
');


    $this->db->from('jadwal_mengajar j');
    $this->db->join('guru g', 'g.id = j.guru_id');
    $this->db->join('mapel m', 'm.id_mapel = j.mapel_id');
    $this->db->join('kelas k', 'k.id = j.rombel_id');

    // JAM SEKOLAH
    $this->db->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id');
    $this->db->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id');

    // LOG (OPTIONAL)
    $this->db->join(
        'log_mengajar lm',
        "lm.jadwal_id = j.id_jadwal AND DATE(lm.tanggal) = '$tanggal'",
        'left'
    );

    // LIBUR (OPTIONAL)
    $this->db->join(
        'hari_libur hl',
        "hl.start = '$tanggal'",
        'left'
    );

    $this->db->where('j.hari', $hari);

    if ($guru_id) {
        $this->db->where('j.guru_id', $guru_id);
    }

    $this->db->order_by('g.nama', 'ASC');
    $this->db->order_by('js1.urutan', 'ASC');

    $data = $this->db->get()->result();

    // ===============================
    // 🧠 TENTUKAN STATUS LAPORAN
    // ===============================
    foreach ($data as &$d) {

        // default
$d->status_laporan = 'Tidak Mengajar';

// ✅ ADA LOG
if (!empty($d->status)) {

    switch ($d->status) {
        case 'mulai':
            $d->status_laporan = 'Sedang Mengajar';
            break;

        case 'selesai':
            $d->status_laporan = 'Selesai';
            break;

        case 'izin':
            $d->status_laporan = 'Izin';
            break;

        case 'sakit':
            $d->status_laporan = 'Sakit';
            break;

        case 'dinas':
            $d->status_laporan = 'Dinas';
            break;

        default:
            $d->status_laporan = ucfirst($d->status);
            break;
    }

    continue;
}

        // 🔴 LIBUR FULL
        if ($this->is_libur_full($tanggal)) {
            $d->status_laporan = 'Libur';
            continue;
        }

        // 🟠 LIBUR SETENGAH HARI
        if ($d->jam_libur && strtotime($d->jam_mulai_jadwal) >= strtotime($d->jam_libur)) {
            $d->status_laporan = 'Libur';
            continue;
        }

        // ✅ ADA LOG
        if (!empty($d->status)) {
            if ($d->status === 'selesai') {
                $d->status_laporan = 'Selesai';
            } elseif ($d->status === 'mulai') {
                $d->status_laporan = 'Sedang Mengajar';
            } else {
                $d->status_laporan = ucfirst($d->status);
            }
            continue;
        }

        // ⏳ BELUM WAKTU
        if (strtotime($d->jam_mulai_jadwal) > time()) {
            $d->status_laporan = 'Belum Waktu';
        }
    }
    unset($d);

    return $data;
}
private function is_libur_full($tanggal)
{
    return $this->db
        ->where('start', $tanggal)
        ->where('jam_mulai IS NULL', null, false)
        ->get('hari_libur')
        ->num_rows() > 0;
}

    public function get_rekap($tanggal = null, $guru_id = null)
{
    if ($tanggal) {
        $this->db->where('lm.tanggal', $tanggal);
    }

    if ($guru_id) {
        $this->db->where('lm.guru_id', $guru_id);
    }

    return $this->db
        ->select('
            g.nama AS nama_guru,
            COUNT(lm.id) AS total_mengajar
        ')
        ->from('log_mengajar lm')
        ->join('guru g', 'g.id = lm.guru_id')
        ->where('lm.status', 'selesai')
        ->group_by('lm.guru_id')
        ->order_by('g.nama', 'ASC')
        ->get()
        ->result();
}
public function get_laporan_range($awal = null, $akhir = null, $guru_id = null)
{
    if (!$awal || !$akhir) {
        $awal  = date('Y-m-d');
        $akhir = date('Y-m-d');
    }

    $hasil = [];

    $periode = new DatePeriod(
        new DateTime($awal),
        new DateInterval('P1D'),
        (new DateTime($akhir))->modify('+1 day')
    );

    foreach ($periode as $tgl) {
        $tanggal = $tgl->format('Y-m-d');

        // pakai method lama yang sudah BENAR
        $dataHarian = $this->get_laporan($tanggal, $guru_id);

        foreach ($dataHarian as $row) {
            $hasil[] = $row;
        }
    }

    return $hasil;
}

}
