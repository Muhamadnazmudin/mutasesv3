<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_mengajar_model extends CI_Model
{
    private $table = 'jadwal_mengajar';

    public function get_all()
{
    return $this->db
        ->select('
            j.*,
            g.nama AS nama_guru,
            m.nama_mapel,
            r.nama AS nama_kelas,
            js.nama_jam,
            js.jam_mulai,
            js.jam_selesai
        ')
        ->from('jadwal_mengajar j')
        ->join('guru g', 'g.id = j.guru_id')
        ->join('mapel m', 'm.id_mapel = j.mapel_id')
        ->join('kelas r', 'r.id = j.rombel_id')
        ->join('jam_sekolah js', 'js.id_jam = j.jam_id')
        ->order_by('j.hari', 'ASC')
        ->order_by('js.urutan', 'ASC')
        ->get()
        ->result();
}


    public function jam_mengajar()
    {
        return $this->db
            ->where('jenis', 'Mengajar')
            ->where('is_active', 1)
            ->order_by('urutan', 'ASC')
            ->get('jam_sekolah')
            ->result();
    }

    public function bentrok_guru($guru_id, $hari, $jam_id)
{
    return $this->db
        ->where('guru_id', $guru_id)
        ->where('hari', $hari)
        ->where('jam_id', $jam_id)
        ->get($this->table)
        ->num_rows() > 0;
}

public function bentrok_kelas($rombel_id, $hari, $jam_id)
{
    return $this->db
        ->where('rombel_id', $rombel_id)
        ->where('hari', $hari)
        ->where('jam_id', $jam_id)
        ->get($this->table)
        ->num_rows() > 0;
}


    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }
}
