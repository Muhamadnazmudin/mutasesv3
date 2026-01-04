<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_tamu_model extends CI_Model {

    private $table = 'buku_tamu';

    public function get_all()
    {
        return $this->db->order_by('tanggal','DESC')->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id'=>$id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id',$id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id'=>$id]);
    }
    /* ===== HARI INI (FIX TIMEZONE) ===== */
public function count_hari_ini()
{
    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    return $this->db
        ->where('tanggal >=', $start)
        ->where('tanggal <=', $end)
        ->count_all_results($this->table);
}

public function get_hari_ini($limit, $offset)
{
    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    return $this->db
        ->where('tanggal >=', $start)
        ->where('tanggal <=', $end)
        ->order_by('tanggal', 'DESC')
        ->limit($limit, $offset)
        ->get($this->table)
        ->result();
}

/* ===== BULAN INI ===== */
public function count_bulan_ini()
{
    $this->db->where('MONTH(tanggal)', date('m'));
    $this->db->where('YEAR(tanggal)', date('Y'));
    return $this->db->count_all_results('buku_tamu');
}

public function get_bulan_ini($limit, $offset)
{
    $this->db->where('MONTH(tanggal)', date('m'));
    $this->db->where('YEAR(tanggal)', date('Y'));
    $this->db->order_by('tanggal', 'DESC');
    return $this->db->get('buku_tamu', $limit, $offset)->result();
}

}
