<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_mengajar_model extends CI_Model {

    public function get_monitoring_hari_ini($guru_id = null, $kelas_id = null)
{
    $mapHari = [
        'Monday'    => 'senin',
        'Tuesday'   => 'selasa',
        'Wednesday' => 'rabu',
        'Thursday'  => 'kamis',
        'Friday'    => 'jumat',
        'Saturday'  => 'sabtu',
        'Sunday'    => 'minggu',
    ];

    $hari = $mapHari[date('l')];

    $this->db
        ->select('
            j.id_jadwal,
            g.id AS guru_id,
            g.nama AS nama_guru,
            k.id AS kelas_id,
            k.nama AS nama_kelas,
            m.nama_mapel,
            js.nama_jam,
            lm.jam_mulai,
            lm.jam_selesai
        ')
        ->from('jadwal_mengajar j')
        ->join('guru g', 'g.id = j.guru_id')
        ->join('kelas k', 'k.id = j.rombel_id')
        ->join('mapel m', 'm.id_mapel = j.mapel_id')
        ->join('jam_sekolah js', 'js.id_jam = j.jam_id')
        ->join(
            'log_mengajar lm',
            'lm.jadwal_id = j.id_jadwal AND lm.tanggal = CURDATE()',
            'LEFT'
        )
        ->where('j.hari', $hari);

    // 🔎 FILTER GURU
    if ($guru_id) {
        $this->db->where('g.id', $guru_id);
    }

    // 🔎 FILTER KELAS
    if ($kelas_id) {
        $this->db->where('k.id', $kelas_id);
    }

    $this->db
        ->order_by('js.urutan', 'ASC')
        ->order_by('g.nama', 'ASC');

    return $this->db->get()->result();
}

}
