<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminBacaan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // login wajib
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // admin & kesiswaan
        if (!in_array($this->session->userdata('role_id'), [1,2])) {
            show_error('Akses ditolak', 403);
        }

        $this->load->model('Bacaan_model');
    }

    public function index()
    {
        $data['active'] = 'buku';
        $data['group_kurikulum'] = true;

        $data['buku'] = $this->Bacaan_model->get_all_admin();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/bacaan/index', $data);
        $this->load->view('templates/footer');

    }

    public function edit($id)
    {
        $buku = $this->Bacaan_model->get_by_id($id);
        if (!$buku) show_404();

        $data['buku'] = $buku;
        $data['active'] = 'buku';
        $data['group_kurikulum'] = true;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/bacaan/edit', $data);
        $this->load->view('templates/footer');

    }

    
    public function update($id)
{
    $data = [
        'judul'  => $this->input->post('judul'),
        'kelas'  => $this->input->post('kelas'),
        'mapel'  => $this->input->post('mapel'),
        'status' => $this->input->post('status'),
    ];

    // ==== UPLOAD COVER (OPSIONAL) ====
    if (!empty($_FILES['cover']['name'])) {

        $config['upload_path']   = './assets/uploads/cover_buku/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('cover')) {
            $upload = $this->upload->data();
            $data['cover'] = $upload['file_name'];
        } else {
            $this->session->set_flashdata(
                'error',
                $this->upload->display_errors()
            );
            redirect('AdminBacaan/edit/'.$id);
        }
    }

    $this->Bacaan_model->update($id, $data);

    $this->session->set_flashdata('success','Buku berhasil diperbarui');
    redirect('AdminBacaan');
}


 
    public function delete($id)
    {
        $this->Bacaan_model->delete($id);
        $this->session->set_flashdata('success','Buku berhasil dihapus');
        redirect('AdminBacaan');
    }

    public function import()
    {
        $data['active'] = 'bacaan_import';
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/bacaan/import', $data);
        $this->load->view('templates/footer');
    }

    public function import_proses()
    {
        if (!isset($_FILES['file_csv']['tmp_name'])) {
            redirect('AdminBacaan/import');
        }

        $handle = fopen($_FILES['file_csv']['tmp_name'], "r");
        fgetcsv($handle); // skip header

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

            // extract FILE_ID dari link Drive
            preg_match('/\/d\/(.*?)\//', $row[3], $match);
            $file_id = $match[1] ?? null;

            if (!$file_id) continue;

            $data = [
                'judul'         => trim($row[0]),
                'kelas'         => trim($row[1]),
                'mapel'         => trim($row[2]),
                'drive_file_id' => $file_id,
                'status'        => trim($row[4]),
            ];

            $this->db->insert('tbl_bacaan', $data);
        }

        fclose($handle);

        $this->session->set_flashdata('success', 'Import bacaan berhasil');
        redirect('AdminBacaan/import');
    }
}
