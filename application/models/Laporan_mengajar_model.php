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
        if ($tanggal) {
            $this->db->where('lm.tanggal', $tanggal);
        }

        if ($guru_id) {
            $this->db->where('lm.guru_id', $guru_id);
        }

        return $this->db
            ->select('
                lm.tanggal,
                lm.jam_mulai,
                lm.jam_selesai,
                lm.status,
                lm.selfie,
                g.nama AS nama_guru,
                m.nama_mapel,
                k.nama AS nama_kelas,
                js.nama_jam
            ')
            ->from('log_mengajar lm')
            ->join('guru g', 'g.id = lm.guru_id')
            ->join('jadwal_mengajar j', 'j.id_jadwal = lm.jadwal_id')
            ->join('mapel m', 'm.id_mapel = j.mapel_id')
            ->join('kelas k', 'k.id = j.rombel_id')
            ->join('jam_sekolah js', 'js.id_jam = j.jam_id')
            ->order_by('lm.tanggal', 'DESC')
            ->order_by('js.urutan', 'ASC')
            ->get()
            ->result();
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

}
