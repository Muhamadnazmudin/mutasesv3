<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_mengajar_model extends CI_Model
{
    private $table = 'jadwal_mengajar';

    public function get_all($filter = [])
{
    $this->db
        ->select('
            j.id_jadwal,
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
        ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')
        ->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id');

    // ================= FILTER =================
    if (!empty($filter['hari'])) {
        $this->db->where('j.hari', $filter['hari']);
    }

    if (!empty($filter['guru_id'])) {
        $this->db->where('j.guru_id', $filter['guru_id']);
    }

    if (!empty($filter['kelas_id'])) {
        $this->db->where('j.rombel_id', $filter['kelas_id']);
    }

    return $this->db
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
   public function cek_bentrok($hari, $jam_mulai_id, $jam_selesai_id, $guru_id, $rombel_id)
{
    return $this->db
        ->where('hari', $hari)
        ->group_start()
            ->where('guru_id', $guru_id)
            ->or_where('rombel_id', $rombel_id)
        ->group_end()
        ->where('jam_mulai_id <=', $jam_selesai_id)
        ->where('jam_selesai_id >=', $jam_mulai_id)
        ->get('jadwal_mengajar')
        ->row();
}


public function get_bentrok_detail($hari, $jam_mulai_id, $jam_selesai_id, $guru_id, $rombel_id)
{
    return $this->db
        ->select('jm.*, g.nama AS nama_guru, k.nama AS nama_kelas')
        ->from('jadwal_mengajar jm')
        ->join('guru g', 'g.id = jm.guru_id')
        ->join('kelas k', 'k.id = jm.rombel_id')
        ->where('jm.hari', $hari)
        ->group_start()
            ->where('jm.guru_id', $guru_id)
            ->or_where('jm.rombel_id', $rombel_id)
        ->group_end()
        ->where('jm.jam_mulai_id <=', $jam_selesai_id)
        ->where('jm.jam_selesai_id >=', $jam_mulai_id)
        ->get()
        ->row();
}
public function get_by_id($id)
{
    return $this->db
        ->select('
            j.id_jadwal,
            j.hari,
            g.nama AS nama_guru,
            k.nama AS nama_kelas,
            m.nama_mapel,
            js1.nama_jam AS jam_awal,
            js2.nama_jam AS jam_akhir
        ')
        ->from('jadwal_mengajar j')
        ->join('guru g', 'g.id = j.guru_id')
        ->join('kelas k', 'k.id = j.rombel_id')
        ->join('mapel m', 'm.id_mapel = j.mapel_id')
        ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')
        ->join('jam_sekolah js2', 'js2.id_jam = j.jam_selesai_id')
        ->where('j.id_jadwal', $id)
        ->get()
        ->row();
}

public function cek_bentrok_edit(
    $hari,
    $jam_mulai_id,
    $jam_selesai_id,
    $guru_id,
    $rombel_id,
    $exclude_id
) {
    return $this->db
        ->select('j.*, g.nama AS nama_guru, k.nama AS nama_kelas')
        ->from('jadwal_mengajar j')
        ->join('guru g', 'g.id = j.guru_id')
        ->join('kelas k', 'k.id = j.rombel_id')
        ->where('j.hari', $hari)
        ->where('j.id_jadwal !=', $exclude_id)
        ->group_start()
            ->where('j.guru_id', $guru_id)
            ->or_where('j.rombel_id', $rombel_id)
        ->group_end()
        ->where('j.jam_mulai_id <=', $jam_selesai_id)
        ->where('j.jam_selesai_id >=', $jam_mulai_id)
        ->get()
        ->row();
}

public function delete($id)
{
    // pastikan pakai primary key yang benar
    $this->db->where('id_jadwal', $id);

    // 🔥 HARD DELETE
    $this->db->delete('jadwal_mengajar');

    // optional: cek hasil
    return $this->db->affected_rows() > 0;
}


}
