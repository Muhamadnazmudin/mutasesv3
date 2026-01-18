<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun_belajar_model extends CI_Model
{
    public function list_siswa($nama=null, $kelas_id=null, $limit=20, $offset=0)
{
    $sql = "
        SELECT s.nisn, s.nama,
               k.nama AS nama_kelas,
               a.email_belajar,
               a.password_default,
               a.status,
               a.sudah_subscribe
        FROM siswa s
        LEFT JOIN kelas k ON k.id = s.id_kelas
        LEFT JOIN akun_belajar_siswa a
          ON a.nisn COLLATE utf8mb4_unicode_ci
           = s.nisn COLLATE utf8mb4_unicode_ci
        WHERE s.status = 'aktif'
    ";

    if ($nama) {
        $sql .= " AND s.nama LIKE '%".$this->db->escape_like_str($nama)."%' ";
    }

    if ($kelas_id) {
        $sql .= " AND s.id_kelas = ".$this->db->escape($kelas_id)." ";
    }

    $sql .= " ORDER BY s.nama LIMIT $limit OFFSET $offset";

    return $this->db->query($sql)->result();
}

    public function count_siswa($nama=null, $kelas_id=null)
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM siswa s
            WHERE s.status = 'aktif'
        ";

        if ($nama) {
            $sql .= " AND s.nama LIKE '%".$this->db->escape_like_str($nama)."%'";
        }

        if ($kelas_id) {
            $sql .= " AND s.id_kelas = ".$this->db->escape($kelas_id);
        }

        return $this->db->query($sql)->row()->total;
    }

    public function save($data)
    {
        $cek = $this->db->get_where(
            'akun_belajar_siswa',
            ['nisn' => $data['nisn']]
        )->row();

        if ($cek) {
            $this->db->where('nisn', $data['nisn'])
                     ->update('akun_belajar_siswa', $data);
        } else {
            $this->db->insert('akun_belajar_siswa', $data);
        }
    }

    public function delete($nisn)
    {
        $this->db->delete('akun_belajar_siswa', ['nisn' => $nisn]);
    }
}


