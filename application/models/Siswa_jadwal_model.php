<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_jadwal_model extends CI_Model {

    public function get_jadwal_by_kelas($kelas_id)
    {
        return $this->db
            ->select('
                j.hari,

                js1.nama_jam AS nama_jam_awal,
                js2.nama_jam AS nama_jam_akhir,

                js1.jam_mulai   AS jam_mulai,
                js2.jam_selesai AS jam_selesai,

                m.nama_mapel,
                g.nama AS nama_guru
            ')
            ->from('jadwal_mengajar j')
            ->join('mapel m', 'm.id_mapel = j.mapel_id')
            ->join('guru g', 'g.id = j.guru_id')
            ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')
            ->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id')
            ->where('j.rombel_id', $kelas_id)
            ->order_by('FIELD(j.hari,"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu")')
            ->order_by('js1.urutan','ASC')
            ->get()
            ->result();
    }

    // ⬅️ INI YANG BIKIN ERROR HILANG
    public function get_by_kelas($kelas_id)
    {
        return $this->get_jadwal_by_kelas($kelas_id);
    }

    /* ⚠️ OPSIONAL (PERLU DIUPDATE JUGA) */
    public function get_jadwal_hari_ini($kelas_id, $hari)
    {
        return $this->db
            ->select('
                js1.nama_jam AS jam_awal,
                js2.nama_jam AS jam_akhir,
                js1.jam_mulai,
                js2.jam_selesai,
                m.nama_mapel,
                g.nama AS nama_guru
            ')
            ->from('jadwal_mengajar j')
            ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')
            ->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id')
            ->join('mapel m', 'm.id_mapel = j.mapel_id')
            ->join('guru g', 'g.id = j.guru_id')
            ->where('j.rombel_id', $kelas_id)
            ->where('j.hari', $hari)
            ->order_by('js1.urutan', 'ASC')
            ->get()
            ->result();
    }
}
