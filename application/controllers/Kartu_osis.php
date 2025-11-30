<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kartu_osis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        // model untuk kelas (jika belum punya, ini aman)
        if (file_exists(APPPATH . "models/Kelas_model.php")) {
            $this->load->model("Kelas_model");
        }
    }


    // ===========================================================
    // INDEX → LIST SISWA + FILTER + PAGINATION
    // ===========================================================
    public function index()
    {
        // -------------------------
        // FILTER input
        // -------------------------
        $kelas_id = $this->input->get("kelas");
        $limit    = $this->input->get("limit");
        $page     = $this->input->get("page");

        if (!$limit) $limit = 25;
        if (!$page)  $page  = 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        // -------------------------
        // Query Filter
        // -------------------------
        $this->db->select("siswa.*, kelas.nama AS nama_kelas");
        $this->db->join("kelas", "kelas.id = siswa.id_kelas", "left");
        $this->db->where("siswa.status", "aktif");

        if ($kelas_id != "") {
            $this->db->where("siswa.id_kelas", $kelas_id);
        }

        // hitung total data
        $total_rows = $this->db->count_all_results("siswa", FALSE);

        // ambil data + pagination
        $this->db->limit($limit, $offset);
        $siswa = $this->db->get()->result();

        // -------------------------
        // Pagination Generator
        // -------------------------
        $base_url = site_url("kartu_osis?kelas=".$kelas_id."&limit=".$limit."&page=");

        $pagination = "<nav><ul class='pagination'>";

        $total_pages = ceil($total_rows / $limit);

        for ($i = 1; $i <= $total_pages; $i++) {
            $active = ($i == $page) ? "active" : "";
            $pagination .= "
                <li class='page-item $active'>
                    <a class='page-link' href='".$base_url.$i."'>$i</a>
                </li>";
        }

        $pagination .= "</ul></nav>";

        // -------------------------
        // Data kelas (dropdown)
        // -------------------------
        $kelas = array();
        if (file_exists(APPPATH."models/Kelas_model.php")) {
            $kelas = $this->db->get("kelas")->result();
        }

        // -------------------------
        // SEND TO VIEW
        // -------------------------
        $data['siswa']     = $siswa;
        $data['kelas']     = $kelas;
        $data['kelas_id']  = $kelas_id;
        $data['limit']     = $limit;
        $data['start']     = $offset;
        $data['pagination']= $pagination;

        // highlight menu
        $data['active'] = 'kartu_osis';
        $data['group_data'] = true;

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('kartu_osis/index',$data);
        $this->load->view('templates/footer');
    }


    // ===========================================================
    // NOTHING CHANGED BELOW — BIARKAN SAMA
    // (PDF / JPG lama tetap aman dipakai)
    // ===========================================================

    public function jpg_depan($id)
    {
        // biarkan sama seperti versi kamu sebelumnya
        echo "Gunakan controller Kartu_osis_template untuk generate.";
    }

    public function jpg_belakang($id)
    {
        echo "Gunakan controller Kartu_osis_template untuk generate.";
    }

    public function pdf($id)
    {
        echo "Gunakan controller Kartu_osis_template untuk generate.";
    }

}
