<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_mengajar_model extends CI_Model
{
    private $table = 'jadwal_mengajar';

    public function get_all()
{
    return $this->db
        ->select('
            j.hari,
            g.nama AS nama_guru,
            k.nama AS nama_kelas,
            m.nama_mapel,

            js1.nama_jam AS jam_awal,
            js1.jam_mulai AS jam_mulai,

            js2.nama_jam AS jam_akhir,
            js2.jam_selesai AS jam_selesai
        ')
        ->from('jadwal_mengajar j')
        ->join('guru g', 'g.id = j.guru_id')
        ->join('kelas k', 'k.id = j.rombel_id')
        ->join('mapel m', 'm.id_mapel = j.mapel_id')

        // ⬅️ JOIN JAM AWAL
        ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')

        // ⬅️ JOIN JAM AKHIR
        ->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id')

        ->order_by('j.hari', 'ASC')
        ->order_by('js1.urutan', 'ASC')
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
