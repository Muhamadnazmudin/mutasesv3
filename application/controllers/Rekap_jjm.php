<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_jjm extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // cek_login(); // aktifkan jika ada
        $this->load->model('Rekap_jjm_model');
    }

    public function index()
    {
        $data['title'] = 'Rekap JJM Guru';
        $data['active'] = 'rekap_jjm';
        $data['group_guru'] = true;

        $data['guru'] = $this->Rekap_jjm_model->get_all_guru();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('admin/rekap_jjm/index', $data);
    $this->load->view('templates/footer');
    }

    /* ================= UPLOAD ALL ZIP ================= */

    public function upload_all()
    {
        $zipPath  = './uploads/jjm/temp/';
        $destPath = './uploads/jjm/guru/';

        if (!is_dir($zipPath)) mkdir($zipPath, 0777, true);
        if (!is_dir($destPath)) mkdir($destPath, 0777, true);

        $config = [
            'upload_path'   => $zipPath,
            'allowed_types' => 'zip',
            'file_name'     => 'jjm_'.time()
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('zip_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('rekap_jjm');
        }

        $zipData = $this->upload->data();
        $zip = new ZipArchive;

        if ($zip->open($zipData['full_path']) === TRUE) {
            $zip->extractTo($zipPath);
            $zip->close();
        }

        unlink($zipData['full_path']);

        $files = glob($zipPath . '*.pdf');

        foreach ($files as $file) {

            $filename = basename($file);
            $guru_id = pathinfo($filename, PATHINFO_FILENAME);

            // validasi guru
            $guru = $this->db->get_where('guru', ['id' => $guru_id])->row();
            if (!$guru) continue;

            rename($file, $destPath.$filename);

            $cek = $this->Rekap_jjm_model->get_by_guru($guru_id);

            if ($cek) {
                $this->Rekap_jjm_model->update($guru_id, [
                    'file_jjm' => $filename
                ]);
            } else {
                $this->Rekap_jjm_model->insert([
                    'guru_id'  => $guru_id,
                    'file_jjm' => $filename
                ]);
            }
        }

        array_map('unlink', glob($zipPath.'*'));

        $this->session->set_flashdata('success', 'Upload massal JJM berhasil');
        redirect('rekap_jjm');
    }
    public function upload_single()
{
    $guru_id = $this->input->post('guru_id');

    if (empty($_FILES['file_jjm']['name'])) {
        redirect('rekap_jjm');
    }

    $path = './uploads/jjm/guru/';
    if (!is_dir($path)) mkdir($path, 0777, true);

    $config = [
        'upload_path'   => $path,
        'allowed_types' => 'pdf',
        'file_name'     => $guru_id.'.pdf',
        'overwrite'     => true
    ];

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('file_jjm')) {
        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect('rekap_jjm');
    }

    $file = $this->upload->data('file_name');

    $cek = $this->Rekap_jjm_model->get_by_guru($guru_id);

    if ($cek) {
        $this->Rekap_jjm_model->update($guru_id, [
            'file_jjm' => $file
        ]);
    } else {
        $this->Rekap_jjm_model->insert([
            'guru_id'  => $guru_id,
            'file_jjm' => $file
        ]);
    }

    $this->session->set_flashdata('success', 'File JJM berhasil diupload');
    redirect('rekap_jjm');
}
public function delete($guru_id)
{
    $data = $this->Rekap_jjm_model->get_by_guru($guru_id);
    if ($data && $data->file_jjm) {

        $file = './uploads/jjm/guru/'.$data->file_jjm;
        if (file_exists($file)) unlink($file);

        $this->db->where('guru_id', $guru_id)->delete('rekap_jjm');
    }

    $this->session->set_flashdata('success', 'File JJM berhasil dihapus');
    redirect('rekap_jjm');
}

}
