<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vervalpd_model extends CI_Model {

    public function laporan_walikelas($kelas_id)
    {
        $this->db->select('
            kelas.nama AS nama_kelas,
            COUNT(siswa.id) AS total_siswa,
            SUM(CASE WHEN siswa.status_verval = 1 THEN 1 ELSE 0 END) AS valid,
            SUM(CASE WHEN siswa.status_verval = 2 THEN 1 ELSE 0 END) AS perbaikan,
            SUM(CASE WHEN siswa.status_verval IN (1,2) THEN 1 ELSE 0 END) AS sudah_verval,
            SUM(CASE WHEN siswa.status_verval = 0 THEN 1 ELSE 0 END) AS belum_verval
        ');
        $this->db->from('kelas');
        $this->db->join(
            'siswa',
            'siswa.id_kelas = kelas.id AND siswa.status = "aktif"',
            'left'
        );
        $this->db->where('kelas.id', $kelas_id);
        $this->db->group_by('kelas.id');

        return $this->db->get()->row();
    }
    public function siswa_walikelas($kelas_id)
{
    return $this->db
        ->select('
            siswa.nisn,
            siswa.nama,
            siswa.status_verval,
            siswa.catatan_verval,
            kelas.nama AS nama_kelas
        ')
        ->from('siswa')
        ->join('kelas', 'kelas.id = siswa.id_kelas')
        ->where('siswa.id_kelas', $kelas_id)
        ->where('siswa.status', 'aktif')
        ->order_by('siswa.nama', 'ASC')
        ->get()
        ->result();
}

}
