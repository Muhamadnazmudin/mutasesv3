<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel_model extends CI_Model
{
    private $table = 'mapel';

    public function get_all()
    {
        return $this->db
            ->order_by('nama_mapel', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }
}
