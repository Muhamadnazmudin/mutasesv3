<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_guru_model extends CI_Model
{
    public function get_laporan_bulanan($guru_id, $bulan, $tahun)
    {
        $this->db
            ->select('
                lm.tanggal,
                DAYNAME(lm.tanggal) AS hari,
                k.nama AS nama_kelas,
                m.nama_mapel,
                js1.nama_jam AS jam_awal,
                TIME(lm.jam_mulai) AS jam_mulai,
                TIME(lm.jam_selesai) AS jam_selesai,
                lm.materi,
                lm.selfie
            ')
            ->from('log_mengajar lm')
            ->join('jadwal_mengajar j', 'j.id_jadwal = lm.jadwal_id')
            ->join('kelas k', 'k.id = j.rombel_id')
            ->join('mapel m', 'm.id_mapel = j.mapel_id')
            ->join('jam_sekolah js1', 'js1.id_jam = j.jam_mulai_id')
            ->where('lm.guru_id', $guru_id)
            ->where('MONTH(lm.tanggal)', $bulan)
            ->where('YEAR(lm.tanggal)', $tahun)
            ->where('lm.status', 'selesai')
            ->order_by('lm.tanggal','ASC')
            ->order_by('lm.jam_mulai','ASC');

        $data = $this->db->get()->result();

        return [
            'rekap'  => $data,
            'selfie' => array_filter($data, fn($d) => !empty($d->selfie))
        ];
    }
}
