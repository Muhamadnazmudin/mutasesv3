<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_mengajar_model extends CI_Model {

    public function get_monitoring_hari_ini($guru_id = null, $kelas_id = null)
    {
        $mapHari = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
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

                js1.nama_jam AS jam_awal,
                js1.jam_mulai AS jam_mulai,

                js2.nama_jam AS jam_akhir,
                js2.jam_selesai AS jam_selesai,

                lm.jam_mulai AS log_mulai,
                lm.jam_selesai AS log_selesai,
                lm.status
            ')
            ->from('jadwal_mengajar j')
            ->join('guru g', 'g.id = j.guru_id')
            ->join('kelas k', 'k.id = j.rombel_id')
            ->join('mapel m', 'm.id_mapel = j.mapel_id')

            // ⬅️ JAM RANGE
            ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')
            ->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id')

            // ⬅️ LOG HARI INI (boleh belum ada)
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
            ->order_by('js1.urutan', 'ASC')
            ->order_by('g.nama', 'ASC');

        return $this->db->get()->result();
    }
}
