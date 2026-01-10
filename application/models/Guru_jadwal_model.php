<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_jadwal_model extends CI_Model
{
    public function get_by_guru($guru_id)
    {
        return $this->db
            ->select('
                j.hari,
                k.nama AS nama_kelas,
                m.nama_mapel,

                js1.nama_jam AS jam_awal,
                js1.jam_mulai AS jam_mulai,

                js2.nama_jam AS jam_akhir,
                js2.jam_selesai AS jam_selesai
            ')
            ->from('jadwal_mengajar j')
            ->join('kelas k', 'k.id = j.rombel_id')
            ->join('mapel m', 'm.id_mapel = j.mapel_id')

            // ⬅️ JOIN JAM AWAL
            ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')

            // ⬅️ JOIN JAM AKHIR
            ->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id')

            ->where('j.guru_id', $guru_id)
            ->order_by('j.hari', 'ASC')
            ->order_by('js1.urutan', 'ASC')
            ->get()
            ->result();
    }
    public function get_jadwal_hari_ini($guru_id, $hari)
{
    return $this->db
        ->select('
            j.id_jadwal AS jadwal_id,
            j.hari,

            k.nama AS nama_kelas,
            m.nama_mapel,

            js1.nama_jam AS jam_awal,
            js1.jam_mulai AS jam_mulai,

            js2.nama_jam AS jam_akhir,
            js2.jam_selesai AS jam_selesai
        ')
        ->from('jadwal_mengajar j')
        ->join('kelas k', 'k.id = j.rombel_id')
        ->join('mapel m', 'm.id_mapel = j.mapel_id')

        // ⬅️ JOIN JAM AWAL
        ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')

        // ⬅️ JOIN JAM AKHIR
        ->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id')

        ->where('j.guru_id', $guru_id)
        ->where('j.hari', $hari)
        ->order_by('js1.urutan', 'ASC')
        ->get()
        ->result();
}
public function get_by_id($jadwal_id)
{
    return $this->db
        ->select('
            j.*,
            js1.jam_mulai,
            js2.jam_selesai
        ')
        ->from('jadwal_mengajar j')
        ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')
        ->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id')
        ->where('j.id_jadwal', $jadwal_id)
        ->get()
        ->row();
}

}
