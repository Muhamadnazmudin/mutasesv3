<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jam_sekolah_model extends CI_Model
{
    private $table = 'jam_sekolah';

    public function get_all()
    {
        return $this->db
            ->order_by('hari', 'ASC')
            ->order_by('urutan', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id_jam' => $id]);
    }
}
