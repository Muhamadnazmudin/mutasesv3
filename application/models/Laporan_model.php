<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function get_laporan($kelas = null, $jenis = null, $search = null)
    {
        // ======================================
        // RESET QUERY (WAJIB)
        // ======================================
        $this->db->reset_query();

        // ======================================
        // AMBIL TAHUN AJARAN AKTIF (STRING)
        // ======================================
        $tahun_ajaran = null;
        $tahun_id = $this->session->userdata('tahun_id');

        if ($tahun_id) {
            $row = $this->db
                ->select('tahun')
                ->from('tahun_ajaran')
                ->where('tahun_ajaran.id', $tahun_id)
                ->get()
                ->row();

            if ($row) {
                $tahun_ajaran = $row->tahun;
            }
        }

        // ======================================
        // QUERY UTAMA: VIEW
        // ======================================
        $this->db->from('v_mutasi_detail');

        if ($tahun_ajaran) {
            $this->db->where('tahun_ajaran', $tahun_ajaran);
        }

        // hanya mutasi aktif
        $this->db->where('status_mutasi', 'aktif');

        // filter kelas
        if (!empty($kelas)) {
            $this->db->where('kelas_asal_id', $kelas);
        }

        // filter jenis
        if (!empty($jenis)) {
            $this->db->where('jenis', strtolower($jenis));
        }

        // pencarian
        if (!empty($search)) {
            $this->db->group_start()
                     ->like('nama_siswa', $search)
                     ->or_like('nis', $search)
                     ->or_like('nisn', $search)
                     ->group_end();
        }

        $this->db->order_by('tanggal', 'DESC');

        return $this->db->get()->result();
    }

    // dropdown kelas
    public function get_kelas()
    {
        return $this->db->order_by('nama', 'ASC')->get('kelas')->result();
    }
}
