<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_jjm_model extends CI_Model {

    public function get_all_guru()
    {
        $this->db->select('g.id, g.nama, g.email, g.status_kepegawaian, r.file_jjm');
        $this->db->from('guru g');
        $this->db->join('rekap_jjm r', 'r.guru_id = g.id', 'left');
        $this->db->order_by('g.nama', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_guru($guru_id)
    {
        return $this->db->get_where('rekap_jjm', ['guru_id' => $guru_id])->row();
    }

    public function insert($data)
    {
        $this->db->insert('rekap_jjm', $data);
    }

    public function update($guru_id, $data)
    {
        $this->db->where('guru_id', $guru_id)->update('rekap_jjm', $data);
    }
}
