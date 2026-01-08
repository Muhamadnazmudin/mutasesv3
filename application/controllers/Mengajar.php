<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mengajar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role_id') != 3
        ) {
            redirect('auth/login');
        }

        $this->load->database();
        $this->load->model('Log_mengajar_model');
    }

    // ===============================
    // MASUK KELAS
    // ===============================
    public function mulai($jadwal_id)
{
    $guru_id = $this->session->userdata('guru_id');

    // Ambil detail jadwal
    $jadwal = $this->db
        ->where('id_jadwal', $jadwal_id)
        ->get('jadwal_mengajar')
        ->row();

    if (!$jadwal) {
        redirect('guru_dashboard');
    }

    // Cegah dobel log
    $cek = $this->Log_mengajar_model
        ->get_log_hari_ini($jadwal_id, $guru_id);

    if ($cek) {
        redirect('guru_dashboard');
    }

    $this->db->insert('log_mengajar', [
        'jadwal_id'  => $jadwal_id,
        'guru_id'    => $guru_id,
        'rombel_id'  => $jadwal->rombel_id,
        'mapel_id'   => $jadwal->mapel_id,
        'tanggal'    => date('Y-m-d'),
        'jam_mulai'  => date('Y-m-d H:i:s'),
        'status'     => 'mulai'
    ]);

    redirect('guru_dashboard');
}

    public function selesai($log_id)
{
    $guru_id = $this->session->userdata('guru_id');

    $this->db
        ->where('id', $log_id)
        ->where('guru_id', $guru_id)
        ->update('log_mengajar', [
            'jam_selesai' => date('Y-m-d H:i:s'),
            'status'      => 'menunggu_selfie'
        ]);

    redirect('guru_dashboard');
}

public function selfie($log_id)
{
    $guru_id = $this->session->userdata('guru_id');

    $log = $this->db
        ->where('id', $log_id)
        ->where('guru_id', $guru_id)
        ->get('log_mengajar')
        ->row();

    if (!$log || $log->status !== 'menunggu_selfie') {
        redirect('guru_dashboard');
    }

    $data['log']    = $log;
$data['title']  = 'Selfie Mengajar';
$data['active'] = 'guru_dashboard';

$this->load->view('templates/header', $data);
$this->load->view('templates/sidebar_guru', $data);
$this->load->view('guru_dashboard/selfie', $data);
$this->load->view('templates/footer');

}

public function simpan_selfie()
{
    $guru_id = $this->session->userdata('guru_id');
    $log_id  = $this->input->post('log_id');

    if (empty($_FILES['selfie']['name'])) {
        echo json_encode(['status'=>'error','message'=>'Selfie kosong']);
        return;
    }

    $config['upload_path']   = './uploads/selfie/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name']     = 'selfie_'.$log_id.'_'.time();
    $config['overwrite']     = TRUE;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('selfie')) {
        echo json_encode([
            'status'=>'error',
            'message'=>$this->upload->display_errors()
        ]);
        return;
    }

    $file = $this->upload->data('file_name');

    $this->db->where('id', $log_id)
             ->where('guru_id', $guru_id)
             ->update('log_mengajar', [
                'selfie' => $file,
                'status' => 'selesai'
             ]);

    echo json_encode(['status'=>'ok']);
}


}
