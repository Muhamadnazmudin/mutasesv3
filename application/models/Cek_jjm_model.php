<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_jjm_model extends CI_Model {

    public function get_by_guru($guru_id)
    {
        $this->db->select('r.file_jjm, g.nama');
        $this->db->from('rekap_jjm r');
        $this->db->join('guru g', 'g.id = r.guru_id');
        $this->db->where('r.guru_id', $guru_id);
        return $this->db->get()->row();
    }
}
