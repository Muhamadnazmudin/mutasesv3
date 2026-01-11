<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_rapor_model extends CI_Model {

    private $table = 'nilai_rapor';

    /* ===============================
       INSERT NILAI (HANYA KOLOM VALID)
    ================================= */
    public function insert($data)
    {
        return $this->db->insert($this->table, [
            'siswa_id'    => $data['siswa_id'],
            'mapel_id'    => $data['mapel_id'],
            'semester'    => $data['semester'],
            'nilai_angka' => $data['nilai_angka']
        ]);
    }

    /* ===============================
       CEK DUPLIKAT NILAI
    ================================= */
    public function cek_nilai($siswa_id, $mapel_id, $semester)
    {
        return $this->db->get_where($this->table, [
            'siswa_id' => $siswa_id,
            'mapel_id' => $mapel_id,
            'semester' => $semester
        ])->row();
    }

    /* ===============================
       NILAI SISWA (VIEW SISWA)
    ================================= */
    public function get_by_siswa($siswa_id, $semester)
    {
        return $this->db
            ->select('nr.nilai_angka, m.nama_mapel')
            ->from('nilai_rapor nr')
            ->join('mapel m', 'm.id_mapel = nr.mapel_id', 'left')
            ->where('nr.siswa_id', $siswa_id)
            ->where('nr.semester', $semester)
            ->order_by('m.nama_mapel', 'ASC')
            ->get()
            ->result();
    }

    /* ===============================
       REKAP NILAI (ADMIN)
    ================================= */
    public function rekap_nilai($kelas_id = null, $mapel_id = null)
    {
        $this->db->select('
            s.id AS siswa_id,
            s.nama AS nama_siswa,
            k.nama AS nama_kelas,
            m.id_mapel,
            m.nama_mapel,

            COALESCE(SUM(CASE WHEN nr.semester = 1 THEN nr.nilai_angka END),0) AS smt1,
            COALESCE(SUM(CASE WHEN nr.semester = 2 THEN nr.nilai_angka END),0) AS smt2,
            COALESCE(SUM(CASE WHEN nr.semester = 3 THEN nr.nilai_angka END),0) AS smt3,
            COALESCE(SUM(CASE WHEN nr.semester = 4 THEN nr.nilai_angka END),0) AS smt4,
            COALESCE(SUM(CASE WHEN nr.semester = 5 THEN nr.nilai_angka END),0) AS smt5,
            COALESCE(SUM(CASE WHEN nr.semester = 6 THEN nr.nilai_angka END),0) AS smt6
        ');

        $this->db->from('siswa s');
        $this->db->join('kelas k', 'k.id = s.id_kelas', 'left');
        $this->db->join('nilai_rapor nr', 'nr.siswa_id = s.id', 'left');
        $this->db->join('mapel m', 'm.id_mapel = nr.mapel_id', 'left');

        $this->db->where('s.status', 'aktif');

        if (!empty($kelas_id)) {
            $this->db->where('s.id_kelas', $kelas_id);
        }

        if (!empty($mapel_id)) {
            $this->db->where('nr.mapel_id', $mapel_id);
        }

        $this->db->group_by('s.id, m.id_mapel');
        $this->db->order_by('s.nama', 'ASC');

        return $this->db->get()->result();
    }
    public function rekap_by_siswa($siswa_id)
{
    return $this->db
        ->select('
            m.nama_mapel,

            COALESCE(SUM(CASE WHEN nr.semester = 1 THEN nr.nilai_angka END), 0) AS smt1,
            COALESCE(SUM(CASE WHEN nr.semester = 2 THEN nr.nilai_angka END), 0) AS smt2,
            COALESCE(SUM(CASE WHEN nr.semester = 3 THEN nr.nilai_angka END), 0) AS smt3,
            COALESCE(SUM(CASE WHEN nr.semester = 4 THEN nr.nilai_angka END), 0) AS smt4,
            COALESCE(SUM(CASE WHEN nr.semester = 5 THEN nr.nilai_angka END), 0) AS smt5
        ')
        ->from('mapel m')
        ->join('nilai_rapor nr', 'nr.mapel_id = m.id_mapel AND nr.siswa_id = '.$this->db->escape($siswa_id), 'left')
        ->group_by('m.id_mapel')
        ->order_by('m.nama_mapel', 'ASC')
        ->get()
        ->result();
}
public function rekap_by_siswa_kelas($siswa_id)
{
    $kelas_id = $this->db
        ->select('id_kelas')
        ->from('siswa')
        ->where('id', $siswa_id)
        ->get()
        ->row()
        ->id_kelas;

    return $this->db
        ->select('
            m.nama_mapel,

            MAX(CASE WHEN nr.semester = 1 AND nr.siswa_id = '.$this->db->escape($siswa_id).' THEN nr.nilai_angka END) AS smt1,
            MAX(CASE WHEN nr.semester = 2 AND nr.siswa_id = '.$this->db->escape($siswa_id).' THEN nr.nilai_angka END) AS smt2,
            MAX(CASE WHEN nr.semester = 3 AND nr.siswa_id = '.$this->db->escape($siswa_id).' THEN nr.nilai_angka END) AS smt3,
            MAX(CASE WHEN nr.semester = 4 AND nr.siswa_id = '.$this->db->escape($siswa_id).' THEN nr.nilai_angka END) AS smt4,
            MAX(CASE WHEN nr.semester = 5 AND nr.siswa_id = '.$this->db->escape($siswa_id).' THEN nr.nilai_angka END) AS smt5
        ')
        ->from('nilai_rapor nr')
        ->join('mapel m', 'm.id_mapel = nr.mapel_id')
        ->join('siswa s', 's.id = nr.siswa_id')
        ->where('s.id_kelas', $kelas_id)
        ->group_by('m.id_mapel')
        ->order_by('m.nama_mapel', 'ASC')
        ->get()
        ->result();
}
public function insert_or_update($data)
{
    return $this->db->replace('nilai_rapor', $data);
}
public function rekap_nilai_paginated($kelas_id, $mapel_id, $limit, $offset)
{
    // SUBQUERY: pasangan siswa-mapel (INILAH YANG DIPAGINATE)
    $this->db->distinct();
    $this->db->select('s.id AS siswa_id, m.id_mapel');
    $this->db->from('nilai_rapor nr');
    $this->db->join('siswa s', 's.id = nr.siswa_id');
    $this->db->join('mapel m', 'm.id_mapel = nr.mapel_id');

    if ($kelas_id) {
        $this->db->where('s.id_kelas', $kelas_id);
    }

    if ($mapel_id) {
        $this->db->where('m.id_mapel', $mapel_id);
    }

    $subquery_sql = $this->db->get_compiled_select();

    // QUERY UTAMA
    return $this->db
        ->select('
            s.nama AS nama_siswa,
            k.nama AS nama_kelas,
            m.nama_mapel,

            MAX(CASE WHEN nr.semester = 1 THEN nr.nilai_angka END) AS smt1,
            MAX(CASE WHEN nr.semester = 2 THEN nr.nilai_angka END) AS smt2,
            MAX(CASE WHEN nr.semester = 3 THEN nr.nilai_angka END) AS smt3,
            MAX(CASE WHEN nr.semester = 4 THEN nr.nilai_angka END) AS smt4,
            MAX(CASE WHEN nr.semester = 5 THEN nr.nilai_angka END) AS smt5,
            MAX(CASE WHEN nr.semester = 6 THEN nr.nilai_angka END) AS smt6
        ', false)
        ->from("($subquery_sql) AS base")
        ->join('siswa s', 's.id = base.siswa_id')
        ->join('kelas k', 'k.id = s.id_kelas')
        ->join('mapel m', 'm.id_mapel = base.id_mapel')
        ->join(
            'nilai_rapor nr',
            'nr.siswa_id = base.siswa_id AND nr.mapel_id = base.id_mapel',
            'left'
        )
        ->group_by(['base.siswa_id', 'base.id_mapel'])
        ->order_by('s.nama', 'ASC')
        ->limit($limit, $offset)
        ->get()
        ->result();
}


public function count_rekap_nilai($kelas_id, $mapel_id)
{
    $this->db->select('COUNT(DISTINCT CONCAT(s.id,"-",m.id_mapel)) AS total');
    $this->db->from('nilai_rapor nr');
    $this->db->join('siswa s', 's.id = nr.siswa_id');
    $this->db->join('mapel m', 'm.id_mapel = nr.mapel_id');

    if ($kelas_id) {
        $this->db->where('s.id_kelas', $kelas_id);
    }

    if ($mapel_id) {
        $this->db->where('m.id_mapel', $mapel_id);
    }

    return (int) $this->db->get()->row()->total;
}


}
