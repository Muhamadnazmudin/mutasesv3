<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_sertifikasi_model extends CI_Model {

    private $table = 'guru_sertifikasi';

    public function insert($data)
{
    return $this->db->insert('guru_sertifikasi', $data);
}

public function update($id, $data)
{
    return $this->db->where('id', $id)
                    ->update('guru_sertifikasi', $data);
}

public function delete($id)
{
    return $this->db->where('id', $id)
                    ->delete('guru_sertifikasi');
}

    public function get_all()
{
    return $this->db
        ->select('gs.*, g.nama AS nama_guru')
        ->from('guru_sertifikasi gs')
        ->join('guru g', 'g.id = gs.guru_id')
        ->order_by('g.nama', 'ASC')
        ->get()
        ->result();
}
public function get_by_guru($guru_id)
{
    return $this->db
        ->select('gs.*, g.nama AS nama_guru')
        ->from('guru_sertifikasi gs')
        ->join('guru g', 'g.id = gs.guru_id')
        ->where('gs.guru_id', $guru_id)
        ->order_by('gs.tgl_mulai_berlaku', 'DESC')
        ->get()
        ->result();
}

public function owned_by($sertifikasi_id, $guru_id)
{
    return $this->db
        ->where('id', $sertifikasi_id)
        ->where('guru_id', $guru_id)
        ->get('guru_sertifikasi')
        ->num_rows() > 0;
}


}
