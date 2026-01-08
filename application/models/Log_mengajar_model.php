<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_mengajar_model extends CI_Model
{
    public function get_log_hari_ini($jadwal_id, $guru_id)
{
    if (!$jadwal_id) return null;

    return $this->db
        ->where('jadwal_id', $jadwal_id)
        ->where('guru_id', $guru_id)
        ->where('tanggal', date('Y-m-d'))
        ->order_by('id', 'DESC')
        ->limit(1)
        ->get('log_mengajar')
        ->row();
}


}
