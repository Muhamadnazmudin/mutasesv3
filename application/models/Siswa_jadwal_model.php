<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_jadwal_model extends CI_Model {

    public function get_by_kelas($kelas_id)
    {
        return $this->db
            ->select('
                j.hari,
                js.nama_jam,
                js.jam_mulai,
                js.jam_selesai,
                m.nama_mapel,
                g.nama AS nama_guru
            ')
            ->from('jadwal_mengajar j')
            ->join('jam_sekolah js', 'js.id_jam = j.jam_id')
            ->join('mapel m', 'm.id_mapel = j.mapel_id')
            ->join('guru g', 'g.id = j.guru_id')
            ->where('j.rombel_id', $kelas_id)
            ->order_by('FIELD(j.hari,"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu")')
            ->order_by('js.urutan', 'ASC')
            ->get()
            ->result();
    }
    public function get_jadwal_hari_ini($kelas_id, $hari)
{
    return $this->db
        ->select('
            js.nama_jam,
            js.jam_mulai,
            js.jam_selesai,
            m.nama_mapel,
            g.nama AS nama_guru
        ')
        ->from('jadwal_mengajar j')
        ->join('jam_sekolah js', 'js.id_jam = j.jam_id')
        ->join('mapel m', 'm.id_mapel = j.mapel_id')
        ->join('guru g', 'g.id = j.guru_id')
        ->where('j.rombel_id', $kelas_id)
        ->where('j.hari', $hari)
        ->order_by('js.urutan', 'ASC')
        ->get()
        ->result();
}

}
