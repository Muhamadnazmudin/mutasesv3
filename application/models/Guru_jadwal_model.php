<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_jadwal_model extends CI_Model
{
    public function get_by_guru($guru_id)
    {
        return $this->db
            ->select('
                j.hari,
                js.nama_jam,
                js.jam_mulai,
                js.jam_selesai,
                r.nama AS nama_kelas,
                m.nama_mapel
            ')
            ->from('jadwal_mengajar j')
            ->join('jam_sekolah js', 'js.id_jam = j.jam_id')
            ->join('kelas r', 'r.id = j.rombel_id')
            ->join('mapel m', 'm.id_mapel = j.mapel_id')
            ->where('j.guru_id', $guru_id)
            ->order_by('FIELD(j.hari,"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu")')
            ->order_by('js.urutan', 'ASC')
            ->get()
            ->result();
    }
    public function get_jadwal_hari_ini($guru_id, $hari)
{
    return $this->db
        ->select('
            js.nama_jam,
            js.jam_mulai,
            js.jam_selesai,
            k.nama AS nama_kelas,
            m.nama_mapel
        ')
        ->from('jadwal_mengajar j')
        ->join('jam_sekolah js', 'js.id_jam = j.jam_id')
        ->join('kelas k', 'k.id = j.rombel_id')
        ->join('mapel m', 'm.id_mapel = j.mapel_id')
        ->where('j.guru_id', $guru_id)
        ->where('j.hari', $hari)
        ->order_by('js.urutan', 'ASC')
        ->get()
        ->result();
}

}
