<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;

class Akun_belajar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('dashboard');
            exit;
    }
        $this->load->model('Akun_belajar_model', 'akun');
    }

    public function index()
    {
        // ===== Ambil filter =====
        $nama     = $this->input->get('nama', true);
        $kelas_id = $this->input->get('kelas'); // id_kelas
        $page     = (int) $this->input->get('page');
        $limit    = 20;
        $offset   = ($page > 0) ? ($page * $limit) : 0;

        // ===== Data ke view =====
        $data = [
            'title'       => 'Distribusi Akun BelajarID',
            'active'      => 'akun_belajar',
            'nama'        => $nama,
            'kelas_id'    => $kelas_id,
            'siswa'       => $this->akun->list_siswa($nama, $kelas_id, $limit, $offset),
            'total'       => $this->akun->count_siswa($nama, $kelas_id),
            'limit'       => $limit,
            'page'        => $page,
            'list_kelas'  => $this->db->get('kelas')->result() // 🔥 sumber resmi kelas
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/akun_belajar/index', $data);
        $this->load->view('templates/footer');
    }
    public function import()
{
    $data = [
        'title'  => 'Import Akun BelajarID',
        'active' => 'akun_belajar'
    ];

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('admin/akun_belajar/import', $data);
    $this->load->view('templates/footer');
}
public function import_process()
{
    if (empty($_FILES['file']['name'])) {
        $this->session->set_flashdata('error', 'File Excel belum dipilih.');
        redirect('akun_belajar/import');
        return;
    }

    $path = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($path);
    $sheet = $spreadsheet->getActiveSheet();
    $rows  = $sheet->toArray(null, true, true, true);

    $insert = 0;
    $update = 0;
    $gagal  = [];

    foreach ($rows as $i => $row) {
        if ($i == 1) continue; // skip header

        $nisn     = trim($row['B']); // NISN
        $email    = trim($row['D']); // BelajarID
        $password = trim($row['E']); // Password default

        if ($nisn == '') {
            $gagal[] = "Baris $i: NISN kosong";
            continue;
        }

        // cek siswa
        $siswa = $this->db->get_where('siswa', ['nisn' => $nisn])->row();
        if (!$siswa) {
            $gagal[] = "Baris $i: NISN $nisn tidak ditemukan di data siswa";
            continue;
        }

        $data = [
            'nisn'             => $nisn,
            'email_belajar'    => $email,
            'password_default' => $password,
            'status'           => 'tersimpan'
        ];

        $cek = $this->db->get_where('akun_belajar_siswa', ['nisn' => $nisn])->row();
        if ($cek) {
            $this->db->where('nisn', $nisn)->update('akun_belajar_siswa', $data);
            $update++;
        } else {
            $this->db->insert('akun_belajar_siswa', $data);
            $insert++;
        }
    }

    if ($gagal) {
        $msg = "<b>Import selesai dengan catatan</b><br>
                Insert: $insert<br>
                Update: $update<br><ul>";
        foreach ($gagal as $e) $msg .= "<li>$e</li>";
        $msg .= "</ul>";
        $this->session->set_flashdata('error', $msg);
    } else {
        $this->session->set_flashdata(
            'success',
            "Import berhasil. Insert: <b>$insert</b>, Update: <b>$update</b>"
        );
    }

    redirect('akun_belajar');
}

    public function simpan()
    {
        $data = [
            'nisn'             => $this->input->post('nisn', true),
            'email_belajar'    => $this->input->post('email_belajar', true),
            'password_default' => $this->input->post('password_default', true),
            'status'           => 'tersimpan'
        ];

        $this->akun->save($data);
        redirect('akun_belajar');
    }

    public function hapus($nisn)
    {
        $this->akun->delete($nisn);
        redirect('akun_belajar');
    }
}
